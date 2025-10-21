<?php //login
require 'config.php';

use Firebase\JWT\JWT;
//use Firebase\JWT\Key;

define('JWT_SECRET_KEY', 'eval');
define('JWT_EXPIRE_TIME', 3600);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if ($action === 'login') {

    $identifier = $data['email'] ?? '';  
    $password   = $data['password'] ?? '';

    $sql = "SELECT u.Email, 
    u.id AS user_id,
    u.password, 
    s.id AS st_id,
    s.firstname,
    s.lastname,
    s.grade,
    s.section,
    s.stud_id
    FROM Users u 
    INNER JOIN Students s
    ON s.usr_id = u.id
    WHERE u.Email = '$identifier' AND
    u.is_deleted = 0;";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0) {
        $dataLogin = $result->fetch_assoc();

        if(password_verify($password,$dataLogin['password'])){
            
            $tokenPayload=[
                'user_id' => $dataLogin['user_id'],
                'email' => $dataLogin['Email'],
                'iat' => time(),
                'exp' => time() + JWT_EXPIRE_TIME
            ];

            $token = JWT::encode($tokenPayload, JWT_SECRET_KEY, 'HS256');

            echo json_encode([ //ito yung meta data
                    "success"=> true,
                    "token"=> $token,
                    "userData" => [
                        "id" => $dataLogin['st_id'],
                        "email" => $dataLogin['Email'],
                        "fullname" => $dataLogin['firstname'],
                        "lastname" => $dataLogin['lastname'],
                        "grade" => $dataLogin['grade'],
                        "section" => $dataLogin['section']
                    ]]);
                exit;
        }else{
            echo json_encode(["success"=> false,"error" => "Password error"]);
        }
    }else{
        echo json_encode(["success"=> false,"error" => "Email not found"]);
    }
}
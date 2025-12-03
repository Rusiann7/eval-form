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
    t.id AS teachers_id, 
    t.firstname, 
    t.lastname, 
    t.subject, 
    t.quarter, 
    t.year 
    FROM Users u 
    INNER JOIN Teachers t ON t.usr_id = u.id 
    WHERE u.Email = '$identifier' AND u.is_teacher = 1 AND u.is_deleted = 0;";
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
                        "id" => $dataLogin['user_id'],
                        "email" => $dataLogin['Email'],
                        "fullname" => $dataLogin['firstname'],
                        "lastname" => $dataLogin['lastname'],
                        "subject" => $dataLogin['subject'],
                        "quarter" => $dataLogin['quarter'],
                        "year" => $dataLogin['year']
                    ]]);
                exit;
        }else{
            echo json_encode(["success"=> false,"error" => "Password error"]);
            http_response_code(400);
        }
    }else{
        echo json_encode(["success"=> false,"error" => "Email not found"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
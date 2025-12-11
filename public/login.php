<?php //login
require 'config.php';

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

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

    $cacheKey = "user:$identifier";
    $cached = $redis->get($cacheKey);

    if ($cached) {
        $cached = json_decode($cached, true);

        if (password_verify($password, $cached['password'])) {

            unset($cached['password']);

            $tokenPayload = [
                'user_id' => $cached['id'],
                'email'   => $cached['email'],
                'iat'     => time(),
                'exp'     => time() + JWT_EXPIRE_TIME
            ];

            $token = JWT::encode($tokenPayload, JWT_SECRET_KEY, 'HS256');

            echo json_encode([
                "success" => true,
                "token"   => $token,
                "userData"=> $cached
            ]);
            exit;
        }
    }

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

            // AFTER fetching from DB + password verify succeeds, BEFORE echo json
            $redis->setex(
                $cacheKey,
                3600, 
                json_encode([
                    "id" => $dataLogin['st_id'],
                    "email" => $dataLogin['Email'],
                    "firstname" => $dataLogin['firstname'],
                    "lastname" => $dataLogin['lastname'],
                    "grade" => $dataLogin['grade'],
                    "section" => $dataLogin['section'],
                    "password" => $dataLogin['password'] // yeah, hashed, calm down
                ])
            );


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
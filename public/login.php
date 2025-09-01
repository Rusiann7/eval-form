<?php //login
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if ($action === 'login') {

    $identifier = $data['id'] ?? '';  //email ito
    $password   = $data['ps'] ?? '';

    $sql = "SELECT * FROM Users WHERE Email = '$identifier';";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0) {
        $dataLogin = $result->fetch_assoc();

        if(password_verify($password,$dataLogin['password'])){
            
            $tokenPayload=[
                'user_id' => $dataLogin['id'],
                'email' => $dataLogin['Email'],
                'iat' => time(),
                'exp' => time() + JWT_EXPIRE_TIME
            ];

            $token = JWT::encode($tokenPayload, JWT_SECRET_KEY, 'HS256');

            echo json_encode([ //ito yung meta data
                "success"=> true,
                "token"=> $token,
                "userData" => [
                    "email" => $dataLogin['Email'],
                    "access" => $dataLogin['role']
                ]]);
            exit;
        }else{
            echo json_encode(["success"=> false,"error" => "Password error"]);
        }
    }else{
        echo json_encode(["success"=> false,"error" => "Email not found"]);
    }
}
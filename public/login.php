<?php //login
require 'config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define('JWT_SECRET_KEY', 'eval');
define('JWT_EXPIRE_TIME', 3600);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);

$iv = base64_decode($input["iv"]);
$ciphertext = base64_decode($input["ct"]);
$key = "projectevalprojecteval"; // 32 bytes ASCII

$plaintext = openssl_decrypt(
    $ciphertext,
    "AES-256-CBC",
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

if ($plaintext === false) {
    error_log("Decryption failed: " . openssl_error_string());
    echo json_encode(["success"=>false,"error"=>"Decryption failed"]);
    echo json_encode($plaintext);
    exit;
}
error_log("Decrypted: " . $plaintext);

$data = json_decode($plaintext, true) ?? [];
$action = $data['action'] ?? '';

if ($action === 'login') {

    $identifier = $data['email'] ?? '';  //email ito
    $password   = $data['password'] ?? '';

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
                    "access" => $dataLogin['role'],
                    "fullname" => $dataLogin['name']
                ]]);
            exit;
        }else{
            echo json_encode(["success"=> false,"error" => "Password error"]);
        }
    }else{
        echo json_encode(["success"=> false,"error" => "Email not found"]);
    }
}
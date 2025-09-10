<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$n = 10;
function getRandomString($n){

    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;

}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'password'){

    $password = $data['newPasswords'];
    $conpassword = $data['confirmPassword'];
    $email = $data['email'];

    if($password === $conpassword){

        $hash = password_hash(($password), PASSWORD_BCRYPT);
        $newCode = getRandomString($n);

        $sql = "UPDATE Users SET password = '$hash', code = '$newCode' WHERE email = '$email';";
        $result = $conn->query($sql);

        if($result === TRUE){
            echo json_encode(["success" => true,]);
        }else{
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    }else{
        echo json_encode((["success" => false, "message" => "Password mismatched"]));
    }
}
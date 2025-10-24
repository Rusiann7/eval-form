<?php //creates a new password

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'password'){

    $password = $data['passwordss'];
    $conpassword = $data['conpassword'];
    $email = $data['email'];

    if($password === $conpassword){

        $hash = password_hash(($password), PASSWORD_BCRYPT);
        $newCode = getRandomString($n);

        $sql = "UPDATE Users SET password = '$hash', reset = '$newCode' WHERE email = '$email';";
        $result = $conn->query($sql);

        if($conn->query($sql) === TRUE){
            echo json_encode(["success" => true,]);
        }else{
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    }else{
        echo json_encode((["success" => false, "message" => "Password mismatched"]));
    }
}
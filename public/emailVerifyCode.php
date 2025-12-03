<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "verifyCode"){

    $email = $data['email'];
    $code = $data['code'];

    $sql = "SELECT * FROM Users WHERE Email = '$email' AND verify_code = '$code'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){

        $sql = "UPDATE Users SET is_verified = 1 WHERE Email = '$email'";

        if($conn -> query($sql) === true){
            echo json_encode(["success" => true]);
        }else{
            echo json_encode(["success" => false, "message" => "Error"]);
        }
        
    }else{
        echo json_encode(["success" => false, "message" => "Error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
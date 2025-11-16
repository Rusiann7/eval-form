<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "verify"){

    $email = $data['email'];

    $sql = "SELECT is_verified FROM Users WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $verified = $row['is_verified'];

        echo json_encode(["success" => true, "verified" => $verified]);
    }else{
        echo json_encode(["success" => false, "message" => "error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'reset'){

    $email = $data['email'];

    $sql = "SELECT * FROM Users WHERE email = '$email';";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo json_encode(["success" => true,]);
    } else{
        echo json_encode(["success" => false]);
    }
}
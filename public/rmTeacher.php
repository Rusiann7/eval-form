<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'rmTeachers'){
    $id = (int)$data['id'];

    $sql = "DELETE FROM Teachers WHERE id = $id";

    if($conn->query($sql)){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
}

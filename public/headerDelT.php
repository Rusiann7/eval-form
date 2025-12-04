<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "deleteHeader"){
    $header_id = $data['header_id'];

    $sql = "UPDATE HeaderT SET is_deleted = 0 WHERE id = $header_id;";

    if($conn->query($sql) === true){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => true, "message" => "error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();

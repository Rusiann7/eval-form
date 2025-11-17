<?php 

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "changeHeaders"){

    $headerId = $data['id'];
    $newHeader = $data['newHeader'];

    $sql = "UPDATE HeaderT SET header = '$newHeader' WHERE id = $headerId;";

    if($conn->query($sql) === true){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false, "message" => "error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
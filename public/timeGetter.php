<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "getTime"){

    $sql = "SELECT * FROM Schedules WHERE is_deleted = 0 LIMIT 1;";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){

        $row = $result->fetch_assoc();

        echo json_encode(["success" => true, "times" => $row ]);
    }else{
        echo json_encode(["success" => false, "message" => "erro"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
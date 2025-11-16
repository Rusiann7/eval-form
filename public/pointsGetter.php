<?php //teachers data

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';
$id = $data['id'] ?? '';

if ($action === 'getPoints') {

    $sql = "SELECT points FROM Students WHERE id = $id";
    $result = $conn->query($sql);

    if($result){
        $row = $result->fetch_assoc();
        $points = $row['points'];

        echo json_encode(['success' => true, 'points' => $points]);
    }else {
        echo json_encode(['success' => false, 'message' => 'Failed to get points']);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'getteacherbyid'){

    $idd = $data['id'];

    $sql = "SELECT * FROM Teachers WHERE id = $idd";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $teachers = $result->fetch_assoc();

        $payload = [
            'firstnm' => $teachers['firstname'],
            'lastnm' => $teachers['lastname'],
            'sub' => $teachers['subject'],
        ];

        $now = new DateTime();
        $month = $now->format('F');

        echo json_encode([
            'success' =>true,
            'teacher' => $payload,
            'month' => $month
        ]);

    }else{
        echo json_encode([
            'success' => false,
            'message' => 'error teacher not found'
        ]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
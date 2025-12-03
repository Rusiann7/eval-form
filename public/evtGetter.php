<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'getstudentbyid'){

    $idd = $data['evt'];

    $sql = "SELECT firstname, lastname, stud_id FROM Students WHERE id = $idd";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $student = $result->fetch_assoc();

        $payload = [
            'firstname' => $student['firstname'],
            'lastname' => $student['lastname'],
            'stid' => $student['stud_id'],
        ];

        echo json_encode([
            'success' =>true,
            'student' => $payload,
        ]);

    }else{
        echo json_encode([
            'success' => false,
            'message' => 'error student not found'
        ]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
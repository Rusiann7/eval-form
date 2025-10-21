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

    $sql = "SELECT t.firstname, 
    t.lastname
    FROM Teachers t
    INNER JOIN Users u ON t.usr_id = u.id
    WHERE u.id = $idd;";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $teacher = $result->fetch_assoc();

        $payload = [
            'firstname' => $teacher['firstname'],
            'lastname' => $teacher['lastname'],
        ];

        echo json_encode([
            'success' =>true,
            'student' => $payload,
        ]);

    }else{
        echo json_encode([
            'success' => false,
            'message' => 'error teacher not found ' . $sql
        ]);
    }
}else{
    echo json_encode([
        "success" => false,
    ]);
}
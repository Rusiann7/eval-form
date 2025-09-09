<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'submits'){

    $teacherid = $data['id'];
    $feedback = $data['feedback'];
    $answers = $data['answers'];
    $studentid = $data['stid'];

    $sql = "INSERT INTO ";

    if($conn->query($sql) === TRUE){
        echo json_encode([
            'success' => true
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => "Error: " . $sql . "<br>" . $conn->error
        ]);
    }
}else{
    echo json_encode([
        "success" => false,
        "message" => $action, 
    ]);
}
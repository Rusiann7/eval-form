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

    $sql = "INSERT INTO Evaluations (tcr_id, evt_id, feedback) 
            VALUES ($teacherid, $studentid, '$feedback');";

    if($conn->query($sql) === TRUE){
        echo json_encode([
            'success' => true
        ]);

        $decoded = 

        $sql1 = "INSERT INTO EvaluationAnswer (Question_id, score) 
                VALUES ();";
    }else{
        echo json_encode([
            'success' => false,
            'message' => "Error: " . $conn->error,
        ]);
    }
}else{
    echo json_encode([
        "success" => false,
        "message" => $action, 
    ]);
}
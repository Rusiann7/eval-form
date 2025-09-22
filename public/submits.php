<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

$n = 10;
function getRandomString($n)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

if($action === 'submits'){

    $teacherid = $data['id'];
    $feedback  = $conn->real_escape_string($data['feedback']);
    $answers = $data['answers'];
    $studentid = $data['stid'];

    $identifier = getRandomString($n);

    $sql = "INSERT INTO Evaluation (tcr_id, evt_id, identifier, feedback) 
            VALUES ($teacherid, $studentid, '$identifier', '$feedback');";

    if($conn->query($sql) === TRUE){
        $session_id = $conn->insert_id; 

        $values = [];
        foreach ($answers as $questionId => $score) {
            $qid   = (int) $questionId;
            $score = (int) $score;
            $values[] = "($session_id, $qid, $score)";
        }

        $sql1 = "INSERT INTO EvaluationAnswer (session_id, question_id, score) 
                VALUES " . implode(', ', $values);

        if($conn->query($sql1) === TRUE){
            echo json_encode([
                'success' => true,
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => "Error: " . $conn->error,
            ]);
        }

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
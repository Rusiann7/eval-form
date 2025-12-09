<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'submits'){

    $teacherid = $data['id'];
    $feedback  = $conn->real_escape_string($data['feedback']);
    $answers = $data['answers'];
    $evaluatorsid = $data['stid'];

    $scores = array_map('intval', array_values($answers));
    $average = array_sum($scores) / count($scores);

    if ($average < 1.5) {
        $sentiment = "Very Poor";
    } elseif ($average < 2.5) {
        $sentiment = "Poor";
    } elseif ($average < 3.5) {
        $sentiment = "Average";
    } elseif ($average < 4.5) {
        $sentiment = "Good";
    } elseif ($average <= 5) {
        $sentiment = "Very Good";
    } else {
        $sentiment = "Out of range";
    }

    $identifier = getRandomString($n);

    $sql = "INSERT INTO EvaluationP (evt_id, tcr_id, identifier, feedback, avg, sentiment) 
            VALUES ($evaluatorsid, $teacherid, '$identifier', '$feedback', $average, '$sentiment');";

    if($conn->query($sql) === TRUE){
        $session_id = $conn->insert_id; 

        $values = [];
        foreach ($answers as $questionId => $score) {
            $qid   = (int) $questionId;
            $score = (int) $score;
            $values[] = "($session_id, $qid, $score)";
        }

        $sql1 = "INSERT INTO EvaluationAnsP (session_id, question_id, score) 
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
            http_response_code(500);
        }
    }else{
        echo json_encode([
            'success' => false,
            'message' => "Error: " . $conn->error,
        ]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
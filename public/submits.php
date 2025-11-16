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
    $studentid = $data['stid'];

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

    $sql = "INSERT INTO Evaluation (tcr_id, evt_id, identifier, feedback, avg, sentiment) 
            VALUES ($teacherid, $studentid, '$identifier', '$feedback', $average, '$sentiment');";

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

            $sql = "UPDATE Students SET points = points + 10 WHERE id = $studentid;";

            if($conn->query($sql) === TRUE){
                echo json_encode([
                    'success' => true,
                ]);
            }
            
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
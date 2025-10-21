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
    $evaluatorsid = $data['stid'];

    $scores = array_map('intval', array_values($answers));
    $average = array_sum($scores) / count($scores);

    switch($average){
        case "1":
            $sentiment = "Very Poor";
            break;
        case "2":
            $sentiment = "Poor";
            break;
        case "3":
            $sentiment = "Average";
            break;
        case "4":
            $sentiment = "Good";
            break;
        case "5":
            $sentiment = "Very Good";
            break;
        default:
            $sentiment = "Out of range";
    };

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
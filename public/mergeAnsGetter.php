<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if ($action === "student") {

    $id = intval($data['tcr']);

    $sql = "SELECT id, created_at, avg, feedback FROM Evaluation WHERE tcr_id = $id";
    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "No evaluation found"]);
        exit();
    }

    $all_contents = [];
    $session_ids = [];

    while ($row1 = $result->fetch_assoc()) {
        $sid = $row1['id'];
        $session_ids[] = $sid;

        $all_contents[$sid] = [
            "time"     => $row1['created_at'],
            "avg"      => $row1['avg'],
            "feedback" => $row1['feedback'],
            "answer"   => []
        ];
    }

    $session_id_list = implode(",", $session_ids);

    $sql2 = "SELECT session_id, question_id, score 
             FROM EvaluationAnswer 
             WHERE session_id IN ($session_id_list)";
    $result2 = $conn->query($sql2);

    if ($result2 && $result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $sid = $row2['session_id'];
            $all_contents[$sid]["answer"][] = [
                "question_id" => $row2['question_id'],
                "score"       => intval($row2['score'])
            ];
        }
    }

    // merge scores by question_id
    $qid = [];

    foreach ($all_contents as $sid => $session_data) {
        foreach ($session_data['answer'] as $answer) {
            $qid[$answer["question_id"]][] = $answer["score"];
        }
    }

    // compute averages
    $final_avg = [];

    foreach ($qid as $question_id => $scores) {
        $final_avg[] = [
            "question_id" => (string)$question_id,
            "score" => array_sum($scores) / count($scores)
        ];
    }

    echo json_encode([
        "success" => true,
        "answer"  => $final_avg,
        "sessions" => $session_id_list
    ]);
    exit();

} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
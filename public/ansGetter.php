<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'ansGetter'){

    $id = (int)($data['id']);
    $evt = (int)($data['evt']);
    $tcr = (int)($data['tcr']);

    $sql = "SELECT * FROM Evaluation WHERE id = $id AND evt_id = $evt AND tcr_id = $tcr;";
    $result = $conn->query($sql);

    $all_contents = [];
    $session_id = [];

    if($result && $result->num_rows > 0){
        while($row1 = $result->fetch_assoc()){
            $session_id[] = $row1['id'];

            $all_contents[$row1['id']] = [
                "feedback" => $row1["feedback"],
                "time"     => $row1['created_at'],
                "avg"      => $row1['avg'],
                "answer"   => []
            ];
        }

        $session_id_list = implode(",", $session_id);
        $sql2 = "SELECT session_id, question_id, score FROM EvaluationAnswer WHERE session_id IN ($session_id_list);";
        $result2 = $conn->query($sql2);

        if($result2 && $result2->num_rows > 0 ){
            while($row2 = $result2 -> fetch_assoc()){
                $all_contents[$row2['session_id']]["answer"][] = [
                    "question_id" => $row2['question_id'],
                    "score"       => $row2['score']
                ];
            }
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Error at second query"
            ]);
            http_response_code(500);
        }

        echo json_encode([
            "success" => true,
            "answer" => $all_contents
        ]);

    }else {
        echo json_encode([
            "success" => false,
            "message" => "Error at first query"
        ]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
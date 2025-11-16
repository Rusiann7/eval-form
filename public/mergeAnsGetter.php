<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "student"){

    $id = $data['tcr_id'];

    $sql = "SELECT * FROM Evaluation WHERE tcr_id = $id";
    $result = $conn->query($sql);

    $all_contents = [];
    $session_id = [];

    if($result && $result->num_rows > 0){
        while($orw1 = $result->fetch_assoc()){
            $session_id[] = $row1;

            $all_contents[$row1['id']] = [
                "time" => $row1['time'],
                "avg" => $row1['avg'],
                "answer" => []
            ];
        }

        $session_id_list = implode(",", $session_id);
        $sql2 = "SELECT session_id, question_id, score FROM EvaluaitonAnswer WHERE session_id IN ($session_id_list) GROUP BY session_id";
        $result2 = $conn->query($sql2);

        if($result2 && $result2->num_rows > 0){
            while($row2 = $result2->fetch_assoc()){

                $all_contents[$row2['session_id']]["answer"][] = [
                    "question_id" => $row2['question_id'],
                    "score"       => $row2['score']
                ];
            }

            $qid = [];

            foreach($all_contents as $session_id => $session_data){
                foreach($session_data as $answer){
                    $question_id = $answer["question_id"];
                    $score = $answer["score"];

                    $qid[$question_id][] = $score;
                }
            }
        }else{
            echo json_encode(["success" => false, "message" => "error".$sql]);
        }
    }
}
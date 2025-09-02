<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'getTeacherQuestions'){
    
    $sql1 = "SELECT id, header FROM HeaderT ORDER BY id ASC";
    $result1 = $conn -> query($sql1);

    $all_headers = [];

    if($result1 && $result1->num_rows > 0){
        while($row = $result1 ->fetch_assoc()){
            $header_id = $row['id'];

            $sql2 = "SELECT id, questions FROM QuestionsT WHERE header_id = $header_id ORDER BY id ASC";
            $result2 = $conn -> query($sql2);

            $questions = [];

            if($result2 && $result2->num_rows > 0){
                while($row2 = $result2 -> fetch_assoc()){
                    $questions[] = [
                        "question_id" => $row2['id'],
                        "question" => $row2['questions']
                    ];
                }
            }

            $all_headers[] = [
                "header_id" => $header_id,
                "header"    => $row1['header'],
                "questions" => $questions
            ];
        }

        echo json_encode([
            "success" => true,
            "headers" => $all_headers,
        ]);
    }else {
        echo json_encode([
            "success" => false,
            "message" => "no headers fetched"
        ]);
    }
}
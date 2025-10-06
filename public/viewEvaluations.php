<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'getEvaluations'){

    $sql = "SELECT * FROM Evaluation";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $evaluations = [];
        while($row = $result->fetch_assoc()){
            $teacher[] = $row['tcr_id'];

            $evaluations[] = [
                "id" => $row['id'],
                "teacher_id" => $row['tcr_id'],
                "eval_id" => $row['evt_id'],
                ""
            ];
        }
    }

}
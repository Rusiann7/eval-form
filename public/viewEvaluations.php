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
                "teacher" => [],
            ];
        }

        $teacher_id_list = implode(",", $teacher);
        $sql2 = "SELECT 
        t.firstname, 
        t.lastname, 
        t.quarter, 
        t.year, 
        t.id AS teacher_id,
        s.subjects,
        e.sentiment
        FROM 
        Teachers t 
        INNER JOIN 
        Subjects s ON t.subject = s.id
        LEFT JOIN 
        Evaluation e ON t.id = e.tcr_id
        WHERE t.id IN ($teacher_id_list);";

        $result2 = $conn->query($sql2);

        if($result2 && $result2->num_rows > 0){
            while($row2 = $result2->fetch_assoc()){
                foreach($evaluations as &$evaluation){
                    if($evaluation['teacher_id'] == $row2['teacher_id']){
                        $evaluation['teacher'] = [
                            "firstname" => $row2['firstname'],
                            "lastname" => $row2['lastname'],
                            "subject" => $row2['subjects'],
                            "quarter" => $row2['quarter'],
                            "year" => $row2['year'],
                            "sentiment" => $row2['sentiment']
                        ];
                    }
                }
            }

            $sql3 = "SELECT COUNT(*) AS total FROM Users;";
            $result3 = $conn->query($sql3);

            if($result3){
                $row = $result3->fetch_assoc();
                $total = $row['total'];

                echo json_encode(["success" => true, "evaluations" => $evaluations, "total" => $total]);
            }else{
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
                exit();
            }
        }else{
            echo json_encode(["success" => false, "message" => "It errored at the second part"]);
            http_response_code(500);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Failed"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
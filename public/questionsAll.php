<?php
//question getter

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if( $action === 'getQuestions'){

    $sql1 = "SELECT id, header, identifier FROM Headers ORDER BY id ASC";
    $result1 = $conn->query($sql1);

    $all_headers = [];
    $header_id = [];
    $questionCount = 0;

    if($result1 && $result1->num_rows > 0){
        while($row1 = $result1 ->fetch_assoc()){
            $header_id[] = $row1['id'];
            $identifiers[] = $row1['identifier'];

            $all_headers[] = [
                "header_id" => $row1['id'],
                "header"    => $row1['header'],
                "questions" => []
            ];
        }

            $header_id_list = implode(",", $header_id);
            $identifiers_list = "'" . implode("','", $identifiers) . "'";
            $sql2= "SELECT id, questions, header_id, header_version FROM Questions WHERE header_id IN ($header_id_list) AND header_version IN ($identifiers_list);";
            $result2 = $conn -> query($sql2);

            if($result2 && $result2->num_rows > 0){
                while($row2 = $result2 -> fetch_assoc()){
                    foreach($all_headers as &$header){
                        if($header['header_id'] == $row2['header_id']){
                            $header['questions'][] = [
                                "question_id" => $row2['id'],
                                "question" => $row2['questions'],
                            ];
                            break;
                        }
                    }
                }
                $questionCount += $result2->num_rows;
            }

         echo json_encode([
            "count" => $questionCount,
            "header_ver" => $identifiers[0],
            "success" => true,
            "headers" => $all_headers,
        ]);

    }else {
        echo json_encode([
            "success" => false, 
        ]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
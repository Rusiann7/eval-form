<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "getChartData"){

    $id = $data['tcr_id'];

    $sql = "SELECT avg FROM Evaluation WHERE tcr_id = $id;";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $avg [] = [
                "average" => $row['avg']
            ];
        }

        echo json_encode(["success" => true, "average" => $avg]);
    }else{
        echo json_encode(["success" => false, "message" => "error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'getSubjects'){

    $sql = "SELECT * FROM Subjects";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $subjects[] = [
                'id' => $row['id'],
                'subjects' => $row['subjects']
            ];
        }

        echo json_encode(["success" => true, "subjects" => $subjects]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
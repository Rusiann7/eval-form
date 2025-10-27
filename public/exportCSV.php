<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "export"){

    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if($result && $result->num_rows){

        while($row = $result->fetch_assoc()){
            $items .= implode(',', $row) . "\n";
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');

        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false, "message" => "error"]);
    }
}
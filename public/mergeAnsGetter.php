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

    $sql = "SELECT * FROM Evaluations WHERE tcr_id = $id";
    $result = $conn->query($sql);


    if($result && $result->num_rows === 0){
        while($result->fetch_assoc()){
            
        }

    }
}
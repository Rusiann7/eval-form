<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "editTeacher"){

    $id = $data['id'];
    $fn = $data['fn'];
    $ln = $data['ln'];
    $email = $data['email'];
    $qrt = $data['qrt'];
    $yr = $data['yr'];
    $subject = $data['sub'];

    $sql = "UPDATE Teachers SET firstname = '$fn', lastname = '$ln', subject = $subject, quarter = $qrt, year = $yr WHERE id = $id;";

    if($conn->query($sql) === true){

        $sql = "";
    }
}
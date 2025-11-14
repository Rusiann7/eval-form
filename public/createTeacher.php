<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'createTeachers'){
    $email = $data['email'];
    $firstname = $data['fn'];
    $lastname = $data['ln'];
    $password = $data['ps'];
    $conpassword = $data['cpas'];
    $subject = $data['sub'];
    $quarter = $data['qrt'];
    $year = $data['yr'];
    $id = $data['id'];

    if($password === $conpassword){

        $sql = "SELECT * FROM Users WHERE Email = '$email';";
        $result  = $conn->query($sql);

        if($result && $result->num_rows === 0){

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $randomString = getRandomString(10);
            $randomString1 = getRandomString(10);

            $sql1 = "INSERT INTO Users (Email, password, reset, verify_code, is_teacher)
            VALUES ('$email', '$hash', '$randomString', '$randomString1', 1);";

            if($conn->query($sql1) === true) {

                $last_id = $conn->insert_id;

                $sql2 = "INSERT INTO Teachers (firstname, lastname, subject, quarter, year, identifier, usr_id)
                VALUES ('$firstname', '$lastname', '$subject', '$quarter', '$year', '$randomString', '$last_id');";

                if($conn->query($sql2) === true) {
                    echo json_encode(["success" => true]);
                }else{
                    echo json_encode(["success" => false,"error" => "Error: " . $conn->error]);
                    http_response_code(500);
                }
            }else{
                echo json_encode(["success" => false,"error" => "Error: " . $conn->error]);
                http_response_code(500);
            }
        }else{
            echo json_encode(["success" => false,"error" => "Error", "message:" => "User already exist"]);
            http_response_code(400);
        }   
    }else{
        echo json_encode(["success" => false, "error" => "Passwords do not match"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
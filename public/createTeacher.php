<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

$n = 10;
function getRandomString($n)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

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

            $sql1 = "INSERT INTO Users (Email, password, reset, name, last_name, stid, role)
            VALUES ('$email', '$hash', '$randomString', '$firstname', '$lastname', '$id', 1);";

            if($conn->query($sql1) === true) {

                $sql2 = "INSERT INTO Teachers (firstname, lastname, subject, quarter, year, identifier)
                VALUES ('$firstname', '$lastname', '$subject', '$quarter', '$year', '$randomString');";

                if($conn->query($sql2) === true) {
                    echo json_encode(["success" => true]);
                }else{
                    echo json_encode(["success" => false,"error" => "Error: " . $conn->error]);
                }

            }else{
                echo json_encode(["success" => false,"error" => "Error: " . $conn->error]);
            }
        }else{
            echo json_encode(["success" => false,"error" => "Error", "message:" => "User already exist"]);
        }   
    }else{
        echo json_encode(["success" => false, "error" => "Passwords do not match"]);
    }
}
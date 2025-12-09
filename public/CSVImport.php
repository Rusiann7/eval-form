<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$action = $_POST['action'] ?? '';
$table = $_POST['role'] ?? '';

if($action === "uploadCSV"){
    if ($_FILES && isset($_FILES['file'])) {
       if (mime_content_type($_FILES['file']['tmp_name']) !== 'text/plain') {
            echo "Not a CSV file.";
            http_response_code(400);
            exit;
        }
        $csvFile = $_FILES['file']['tmp_name'];
    }

    if (file_exists($csvFile)) {
        $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        foreach ($lines as $line) {
            $row = str_getcsv($line);

            // new variables
            $email = $row[0] ?? null;
            $fname = $row[1] ?? null;
            $lname = $row[2] ?? null; 
            $id = $row[3] ?? null;

            // example output (remove if useless)
            echo "$email | $fname | $lname | $id<br>";

            $password = trim($lname) . trim($id);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $randomString = getRandomString(10);
            echo $password;
            echo $hash;

            $sql = "INSERT INTO Users (Email, password, reset) 
            VALUE ('$email', '$hash', '$randomString')";

            if($conn->query($sql) === true){

                $user_id = $conn->insert_id;

                $sql = "INSERT INTO Students (firstname, lastname, stud_id, usr_id, teacher)
                VALUE ('$fname', '$lname', $id, $user_id, 10)";

                if($conn->query($sql) === true){
                    echo json_encode(["success" => true]);
                }else{
                    echo json_encode(["success" => false, "message" => "error"]);
                    http_response_code(500);
                }
            }else{
                echo json_encode(["success" => false, "message" => "error"]);
                http_response_code(500);
            }
        }
    } else {
        echo "CSV file not found.";
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
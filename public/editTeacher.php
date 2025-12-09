<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "editTeacher"){

<<<<<<< HEAD
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
=======
    $users = $data['user'];

    $id = $users['id'];
    $fn = $users['fn'];
    $ln = $users['ln'];
    $email = $users['email'];
    $qrt = $users['qrt'];
    $yr = $users['yr'];
    $subject = $users['sub'];

    $sql1 = "SELECT usr_id FROM Teachers WHERE id = $id;";
    $result = $conn->query($sql1);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();

        $usr_id = $row['usr_id'];

        $sql = "UPDATE 
        Teachers 
        SET 
        firstname = '$fn', 
        lastname = '$ln', 
        subject = $subject, 
        quarter = $qrt, 
        year = $yr 
        WHERE 
        id = $id;";

        if($conn->query($sql) === true){

            $sql = "UPDATE Users SET Email = '$email' WHERE id = $usr_id;";

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
    }else{
        echo json_encode(["success" =>  false, "message" => "error"]);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
>>>>>>> Development

<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "addHeader"){

    $newHeader =  $data['header'];
    $hIdentifier = $data['identifier'];

    $sql = "INSERT INTO Headers (header, identifier) VALUES ('$newHeader', '$hIdentifier');";

    if($conn->query($sql) === true){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false, "message" => "error"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
<<<<<<< HEAD
}
=======
}

$conn->close();
>>>>>>> Development

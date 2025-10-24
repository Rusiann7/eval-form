<?php //check if the email exists

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'reset'){

    $email = $data['email'];

    $sql = "SELECT * FROM Users WHERE email = '$email';";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {

        $dataReset = $result->fetch_assoc();
        $reset = $dataReset['reset'];

        $body =
        '
        <br>
        <center>
        
        <br>
        <h2>Enter this code to reset your password<h2>
        <h1>' . htmlspecialchars($reset, ENT_QUOTES, 'UTF-8') . '</h1>
        <br>
        <p>Do not share with anyone</p>
        </center>
        <br>
        ';

        $altbody = 'Enter this code to reset your password: ' .$reset;

        $run = smtp($email, $body, $altbody);
        
        if($run){
            echo json_encode(["success" => true]);
        }else{
            echo json_encode(["success" => false, "message" => "Failed to send email"]);
        }
    } else{
        echo json_encode(["success" => false, "message" => "Email not found"]);
    }
}
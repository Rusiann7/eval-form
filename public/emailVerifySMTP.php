<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "verifySMTP"){

    $email = $data['email'];

    $sql = "SELECT verify_code FROM Users WHERE Email = '$email'";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $code = $row['verify_code'];

        $altbody = 'Enter this code to verify your account: ' .$code;

        $body = '
            <center style="font-family: Arial, sans-serif; background: #ffffff; padding: 40px 20px; margin: 0;">
                <div style="max-width: 500px; text-align: center;">
        
                    <h1 style="color: #2d3748; font-size: 24px; margin-bottom: 30px; font-weight: 600; line-height: 1.4;">
                        Enter this code to verify that the Email you provided is yours.
                    </h1>
        
                    <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; margin: 30px 0; border: 2px solid #e2e8f0; display: inline-block;">
                        <h1 style="color: #2d3748; font-size: 36px; font-weight: bold; letter-spacing: 10px; margin: 0; font-family: \"Courier New\", monospace;">
                            ' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '
                        </h1>
                    </div>
                    <br>

                    <p style="color: #e53e3e; font-size: 16px; font-weight: bold; background: #fed7d7; padding: 15px 25px; border-radius: 8px; border: 1px solid #e53e3e; display: inline-block;">
                        ⚠️ Do not share this code with anyone
                    </p>
                    <br>

                    <div style="margin-top: 30px; padding: 20px; background: #f7fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <p style="color: #4a5568; font-size: 14px; margin: 8px 0;">If you didn\'t request this, please ignore this message</p>
                    </div>
        
                </div>
            </center>
            <br>
        ';

        $smtp = smtp($email, $body, $altbody);

        if($smtp){
            echo json_encode(["success" => true]);
        }else{
            echo json_encode(["success" => false, "messsage" => "error"]);
            http_response_code(500);
        }
    }else{
        echo json_encode(["success" => false, "message" => "User not found"]);
        http_response_code(400);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}
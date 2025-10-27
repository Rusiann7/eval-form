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

        $body = '
            <center style="font-family: Arial, sans-serif; background: #ffffff; padding: 40px 20px; margin: 0;">
                <div style="max-width: 500px; text-align: center;">
                 <br>
                    <h2 style="color: #2d3748; font-size: 22px; margin-bottom: 25px; font-weight: 600;">Enter this code to reset your password</h2>
        
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 25px 0; border: 2px solid #e2e8f0; display: inline-block;">
                        <h1 style="color: #2d3748; font-size: 32px; font-weight: bold; letter-spacing: 8px; margin: 0; font-family: \"Courier New\", monospace;">
                            ' . htmlspecialchars($reset, ENT_QUOTES, 'UTF-8') . '
                        </h1>
                    </div>
                    <br>

                    <p style="color: #e53e3e; font-size: 16px; font-weight: bold; background: #fed7d7; padding: 12px 20px; border-radius: 8px; border: 1px solid #e53e3e; display: inline-block;">
                        ⚠️ Do not share this code with anyone
                    </p>
        
                    <div style="margin-top: 30px; padding: 15px; background: #f7fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <p style="color: #4a5568; font-size: 14px; margin: 5px 0;">If you didn\'t request this, please ignore this message</p>
                    </div>  
                </div>
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
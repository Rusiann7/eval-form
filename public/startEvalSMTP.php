<?php

require 'config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === "begin"){

    $time_start = $data['time_start'];
    $date_start = $data['date_start'];
    $time_end = $data['time_end'];
    $date_end = $data['date_end'];
    
    $sql = "INSERT INTO Schedules (time_start, date_start, time_end, date_end, is_deleted) 
    VALUES ($time_start, $date_start, $time_end, $date_end, 0)";

    if($conn->query($sql) === true){

        $body = '
            <center style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 40px 20px; margin: 0;">
                <div style="max-width: 600px; background-color: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h1 style="color: #2c3e50; margin-bottom: 30px; font-size: 28px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">Evaluations has now commence you may now evaluate</h1>
        
                    <div style="text-align: left; margin: 25px 0;">
                        <h3 style="color: #34495e; margin: 15px 0; font-size: 18px;"><strong style="color: #2c3e50;">Start Time:</strong>'. htmlspecialchars($time_start, ENT_QUOTES, 'UTF-8').'</h3>
                        <h3 style="color: #34495e; margin: 15px 0; font-size: 18px;"><strong style="color: #2c3e50;">Start Date:</strong>'. htmlspecialchars($date_start, ENT_QUOTES, 'UTF-8').'</h3>
                        <h3 style="color: #34495e; margin: 15px 0; font-size: 18px;"><strong style="color: #2c3e50;">End Time:</strong>'. htmlspecialchars($time_end, ENT_QUOTES, 'UTF-8').'</h3>
                        <h3 style="color: #34495e; margin: 15px 0; font-size: 18px;"><strong style="color: #2c3e50;">End Date:</strong>'. htmlspecialchars($date_end, ENT_QUOTES, 'UTF-8').'</h3>
                    </div>
                    <br>

                    <p style="color: #7f8c8d; font-size: 16px; line-height: 1.6; background-color: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #3498db;">
                        Be sure to evaluate with sincerity and honesty and please follow the designated time. <strong style="color: #e74c3c;">Thank You!</strong>
                    </p>
                    <br>
                </div>
            </center>
        ';

        $altbody = 'Evaluations has begun you may now evaluate Start: ' .$time_start; $date_start. 'End: '.$time_end; $date_end;

        $email = "";

        $maill = smtp($email, $body, $altbody);
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => true, "message" => "error"]);
    }
}
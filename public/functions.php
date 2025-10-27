<?php 

require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Gemini\GeminiClient;

function smtp($email, $body, $altbody){
    global $epass;
    
    $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'systemmailer678@gmail.com';                     //SMTP username
    $mail->Password   = $epass;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //$mail->addEmbeddedImage('Logo.png', 'logo','Logo.png');

    //Recipients
    $mail->setFrom('systemmailer678@gmail.com', 'School AutoMailer');
    $mail->addAddress($email);     //Add a recipient
    $mail->addAddress($email);     //Name is optional
    $mail->addReplyTo('systemmailer678@gmail.com', 'Information');
    $mail->addCC('systemmailer678@gmail.com');
    $mail->addBCC('systemmailer678@gmail.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body = $body;   
    $mail->AltBody = $altbody;

    if($mail->send()){
        return true;
    }
    else{
        return false;
    }
};

$n = 10;
function getRandomString($n){

    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

function AIsummarizer($call, $call1, $call2){
    
    global $yourApiKey;

    try {
        $client = Gemini::client($yourApiKey);
        $model = $client->generativeModel('gemini-2.0-flash');

        $prompt = "";

        $result = $model->generateContent($prompt);
        
        return $result->text();
    }catch(Exception $e){
        error_log("AI Summarizer Error: " . $e->getMessage());
    }
}
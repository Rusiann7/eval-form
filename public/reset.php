<?php //check if the email exists

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'reset'){

    $email = $data['email'];

    $sql = "SELECT * FROM Users WHERE email = '$email';";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {

        $dataReset = $result->fetch_assoc();
        $reset = $dataReset['reset'];

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
        $mail->Body    = //lagyan nlang ng img kung kailangan
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

        $mail->AltBody = 'Enter this code to reset your password: ' .$reset;

        if($mail->send()){
            echo json_encode(["success" => true]);
        }
        else{
            echo json_encode(["success" => false]);
        }
    } else{
        echo json_encode(["success" => false, "message" => "Email not found"]);
    }
}
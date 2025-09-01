<?php //login

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

if ($action === 'signup') {

    $identifier = $data['email'] ?? $data['em'] ?? '';
    $password = $data['password'] ?? $data['pass'] ?? '';
    $conpassword = $data['conpass'] ?? $data['cp'] ?? '';
    $fullname = $data['fn'] ?? '';
    $studentid = $data['id'] ?? '';

    if ($password !== $conpassword) {
        echo json_encode(["success" => false, "error" => "Passwords do not match"]);
        exit;
    }

    $sql = "SELECT * FROM Users WHERE Email = '$identifier';";
    $result  = $conn->query($sql);

    if($result && $result->num_rows === 0){

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $randomString = getRandomString(10);

        $sql ="INSERT INTO Users (Email, password, reset, name, stid) 
        VALUES ('$identifier', '$hash', '$randomString', '$fullname', '$studentid');";

        if($conn->query($sql) === true) {
            echo json_encode(["success" => true]);
        }else{
            echo json_encode(["success" => false,"error" => "Error: " . $sql . "<br>" . $conn->error]);
        }
    }else{
        echo json_encode(["success" => false,"error" => "Error", "message:" => "User already exist"]);
    }
}
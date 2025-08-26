<?php //login

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json');

$action = '';
$data = [];

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define('JWT_SECRET_KEY', 'eval');
define('JWT_EXPIRE_TIME', 3600);

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
    header('Content-Type: application/json');
}

$action = isset($data['action']) ? $data['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
    $action = $data['action'] ?? '';

    error_log("Received action: " . $action);
    error_log("Received data: " . json_encode($data));
} else {
    $action = '';
}

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

$host ="rusiann7.helioho.st";
$user ="rusiann7_rusiannn";
$password="";
$dbname="rusiann7_evaluation";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn -> connect_error) {
    die("Connection Failed" . $conn -> connect_error);
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
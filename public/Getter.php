<?php //taga kuha ito ng teachers data

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

$host ="rusiann7.helioho.st";
$user ="rusiann7_rusiannn";
$password="";
$dbname="rusiann7_evaluation";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn -> connect_error) {
    die("Connection Failed" . $conn -> connect_error);
}

if ($action === 'getTeachers') {

    $sql = "SELECT * FROM Teachers";
    $result = $conn->query($sql);

    if ($result) {
        $teachers = [];
        while ($row = $result->fetch_assoc()) {
            $teachers[] = [
                'id' => $row['id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'subject' => $row['subject'],
                'quarter' => $row['quarter'],
                'year' => $row['year']
            ];
        }
        echo json_encode(['success' => true, 'teachers' => $teachers]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
    }
}
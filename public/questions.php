<?php //question getter

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

if( $action === 'getQuestions'){

    $sql1 = "SELECT id, header FROM Headers ORDER BY id ASC";
    $result1 = $conn -> query($sql1);

    $all_headers = [];

    if($result1 && $result1->num_rows > 0){
        while($row1 = $result1 ->fetch_assoc()){
            $header_id = $row1['id'];

            $sql2= "SELECT id, questions FROM Questions WHERE header_id = $header_id ORDER BY id ASC";
            $result2 = $conn -> query($sql2);

            $questions = [];

            if($result2 && $result2->num_rows > 0){
                while($row2 = $result2 -> fetch_assoc()){
                    $questions[] = [
                        "question_id" => $row2['id'],
                        "question" => $row2['questions']
                    ];
                }
            }

            $all_headers[] = [
                "header_id" => $header_id,
                "header"    => $row1['header'],
                "questions" => $questions
            ];
        }

         echo json_encode([
            "success" => true,
            "headers" => $all_headers,
        ]);

    }else {
        echo json_encode([
            "success" => false, //walang headers
        ]);
    }
}
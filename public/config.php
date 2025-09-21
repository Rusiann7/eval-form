<?php //config file

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
    header('Content-Type: application/json; charset=utf-8');
}

$host ="sql.freedb.tech:3306";
$user ="freedb_rusiann";
$password="YbJY4z&%X&2TPyF";
$dbname="freedb_projecteval";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["success" => false, "error" => "DB Connection failed"]));
}

$conn->set_charset("utf8mb4");
$conn->query("SET NAMES 'utf8mb4'");

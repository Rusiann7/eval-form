<?php 

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'edit'){

    $data['id'];

    $sql = "SELECT
    t.*,
    s.subjects AS subjects,
    u.is_deleted
    FROM
        Teachers t
    INNER JOIN
        Users u ON t.usr_id = u.id
    LEFT JOIN
        Subjects s ON t.subject = s.id
    WHERE 
        u.is_deleted = 0 AND t.id = 17;";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
        
    }
}
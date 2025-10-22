<?php //teachers data

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';
$id = $data['id'] ?? '';

if ($action === 'getTeachers') {

    $sql = "SELECT t.* FROM Teachers t INNER JOIN Users u ON t.usr_id = u.id WHERE u.is_deleted = 0;";
    $result = $conn->query($sql);

    if ($result) {

        $rowCount = $result->num_rows;

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

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
    }
}
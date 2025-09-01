<?php //teachers data

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

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
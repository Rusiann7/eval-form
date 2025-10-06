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

        $sql2 = "SELECT COUNT(*) AS total FROM Teachers;";
        $result2 = $conn->query($sql2);

        if($result2){
            $row = $result2->fetch_assoc();
            $total = $row['total'];
            
            echo json_encode(['success' => true, 'teachers' => $teachers, 'total' => $total]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
            exit();
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
    }
}
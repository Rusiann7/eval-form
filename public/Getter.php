<?php //teachers data

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if ($action === 'getTeachers') {

    $id = $data['id'];

    $sql5 = "SELECT
    t.*,
    s.subjects AS subjects,
    u.is_deleted,
    u.email,
    CASE
        WHEN e.id IS NOT NULL THEN 'evaluated'
        ELSE 'not evaluated'
    END AS is_evaluated
    FROM
        Teachers t
    INNER JOIN
        Users u ON t.usr_id = u.id
    LEFT JOIN
        Evaluation e ON t.id = e.tcr_id AND e.evt_id = $id
    LEFT JOIN
        Subjects s ON t.subject = s.id
    WHERE 
        u.is_deleted = 0;";

    $result = $conn->query($sql5);

    if ($result) {

        $rowCount = $result->num_rows;

        $teachers = [];
        while ($row = $result->fetch_assoc()) {
            $teachers[] = [
                'id' => $row['id'],
                'firstname' => $row['firstname'],
                'email' => $row['email'],
                'lastname' => $row['lastname'],
                'subject' => $row['subjects'],
                'quarter' => $row['quarter'],
                'year' => $row['year'],
                'evaluated' => $row['is_evaluated']
            ];
        }
            echo json_encode(['success' => true, 'teachers' => $teachers, 'total' => $rowCount]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
        http_response_code(500);
    }
}else{
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    http_response_code(400);
}

$conn->close();
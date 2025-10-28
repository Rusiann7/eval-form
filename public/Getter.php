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

    $sql1 = "SELECT t.*, s.id AS student_id, e.id AS evaluation_id,
    CASE
        WHEN e.id IS NOT NULL THEN 'evaluated'
        ELSE 'not evaluated'
    END is_evaluated
    FROM Teachers t 
    INNER JOIN Users u ON t.usr_id = u.id 
    LEFT JOIN Evaluation e ON t.id = e.tcr_id
    INNER JOIN Students s ON s.id = e.evt_id
    WHERE e.evt_id = 4
    ";

    $sql4 = "SELECT
    t.*,
    e.*,
    CASE
        WHEN e.id IS NOT NULL THEN 'evaluated'
        ELSE 'not evaluated'
    END AS is_evaluated
    FROM
        Teachers t
    INNER JOIN
        Users u ON t.usr_id = u.id
    LEFT JOIN
        Evaluation e ON t.id = e.tcr_id
    WHERE e.evt_id = 4;
        ";

    $sql5 = "SELECT
    t.*,
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
    WHERE u.is_deleted = 0;";

    //$sql = "SELECT t.* FROM Teachers t INNER JOIN Users u ON t.usr_id = u.id WHERE u.is_deleted = 0;";
    $result = $conn->query($sql5);

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
                'year' => $row['year'],
                'evaluated' => $row['is_evaluated']
            ];
        }
            echo json_encode(['success' => true, 'teachers' => $teachers, 'total' => $rowCount]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to get teachers']);
    }
}
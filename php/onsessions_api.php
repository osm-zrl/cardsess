<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = [];
    if (isset($_GET['class_id'])) {
        $class_id = trim($_GET['class_id']);
        if ($class_id != '') {
            $sql =
            "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
            FROM sessions
            LEFT JOIN log_history ON sessions.id_session = log_history.session_id
            JOIN classe ON sessions.class_id = classe.class_id
            WHERE DATE(sessions.date_start) = CURDATE() AND TIME(sessions.date_start) <= CURTIME() AND TIME(sessions.date_end) > CURTIME() AND sessions.class_id='$class_id'
            GROUP BY sessions.id_session
            ORDER BY sessions.date_start;
        ";
            
        } else {
            $sql =
            "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
            FROM sessions
            LEFT JOIN log_history ON sessions.id_session = log_history.session_id
            JOIN classe ON sessions.class_id = classe.class_id
            WHERE DATE(sessions.date_start) = CURDATE() AND TIME(sessions.date_start) <= CURTIME() AND TIME(sessions.date_end) > CURTIME()
            GROUP BY sessions.id_session
            ORDER BY sessions.date_start;
        ";

        }
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();


}
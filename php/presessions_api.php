<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = [];

    if (isset($_GET['date']) && isset($_GET['class'])) {
        $date = trim($_GET['date']);
        $class = trim($_GET['class']);
        if ($date != '' && $class == '') {
            $date = date($date);
            $sql =
                "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
                FROM sessions
                LEFT JOIN log_history ON sessions.id_session = log_history.session_id
                JOIN classe ON sessions.class_id = classe.class_id
                WHERE DATE(sessions.date_start) = '$date' AND sessions.date_start<CURRENT_TIMESTAMP AND TIME(sessions.date_end) <= CURTIME()
                GROUP BY sessions.id_session
                ORDER BY sessions.date_start;
            ";
        } elseif ($date == '' && $class != '') {
            $sql =
                "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
                FROM sessions
                LEFT JOIN log_history ON sessions.id_session = log_history.session_id
                JOIN classe ON sessions.class_id = classe.class_id
                WHERE DATE(sessions.date_start) <= CURDATE() AND TIME(sessions.date_end) <= CURTIME() AND sessions.class_id='$class'
                GROUP BY sessions.id_session
                ORDER BY sessions.date_start;
            ";
        } elseif ($date != '' && $class != '') {
            $sql =
                "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
                FROM sessions
                LEFT JOIN log_history ON sessions.id_session = log_history.session_id
                JOIN classe ON sessions.class_id = classe.class_id
                WHERE DATE(sessions.date_start) = '$date' AND TIME(sessions.date_end) <= CURTIME() AND sessions.class_id='$class'
                GROUP BY sessions.id_session
                ORDER BY sessions.date_start;
            ";
        } else {
            $sql =
            "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
            FROM sessions
            LEFT JOIN log_history ON sessions.id_session = log_history.session_id
            JOIN classe ON sessions.class_id = classe.class_id
            WHERE DATE(sessions.date_start) <= CURDATE() AND TIME(sessions.date_end) <= CURTIME()
            GROUP BY sessions.id_session
            ORDER BY sessions.date_start;
            ";
        }
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        header('Content-Type: application/json');
        echo json_encode($data);
        $conn->close();
    }


}
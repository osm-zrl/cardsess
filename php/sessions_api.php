<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = [];
    if (isset($_GET['class_id']) && isset($_GET['date'])) {
        $class_id = trim($_GET['class_id']);
        $date = trim($_GET['date']);
        $sql = "SELECT * FROM sessions WHERE class_id='$class_id' AND DATE(date_start)='$date' order by date_start";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        $conn->close();
    }
}
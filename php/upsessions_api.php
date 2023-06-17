<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = [];
    if (isset($_GET['class_id'])) {
        $class_id = trim($_GET['class_id']);
        if ($class_id != '') {
            $sql = "SELECT sessions.*,concat(classe.name,' ',classe.level) as class_name FROM sessions JOIN classe ON sessions.class_id = classe.class_id WHERE DATE(date_start)>=CURRENT_TIMESTAMP AND sessions.class_id='$class_id' order by date_start";
            
        } else {
            $sql = "SELECT sessions.*,concat(classe.name,' ',classe.level) as class_name FROM sessions JOIN classe ON sessions.class_id = classe.class_id WHERE DATE(date_start)>=CURRENT_TIMESTAMP order by date_start";

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
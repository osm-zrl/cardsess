<?php
require("../dbconfig.php");
$data = [];
$class_liste = [];
$sql = "SELECT class_id from classe";
$result = $conn->query($sql);
while($row = $result->fetch_column()){
    $class_liste[] = $row;
}



foreach ($class_liste as $value) {
    $sql = "SELECT id_session FROM sessions WHERE class_id = '$value' LIMIT 10";
    $result = $conn->query($sql);
    $session_liste = [];

    /* getting liste of sessions */
    while($row = $result->fetch_column()){
        $session_liste[] = $row;
    }

    /* getting total number of students */
    $sql = "SELECT count(*) from student where class_id = '$value'";
    $total_students = $conn->query($sql)->fetch_column();


    /* getting percentage of attendences of each session */
    $total_percentage = 0;
    foreach ($session_liste as $s) {
        $sql = "SELECT count(*) from log_history WHERE session_id = '$s'";
        $total_percentage += $conn->query($sql)->fetch_column()/$total_students*100;
    }

    $total_percentage /= count($session_liste);
    $sql = "SELECT concat(name,' ',level) FROM classe WHERE class_id = '$value'";
    $class_name = $conn->query($sql)->fetch_column();
    $data[] = ['class'=>$class_name,'presence_rate'=>round($total_percentage,2)];
    

    
}

header('Content-Type: application/json');
echo json_encode($data);
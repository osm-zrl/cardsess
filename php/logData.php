<?php
require('../dbconfig.php');
if ($conn->connect_errno) {
    die('echec de connecter au serveur!');
}
if (isset($_GET['lastID'])) {
    $lastID = $_GET['lastID'];
    $sql = "SELECT log_history.scan_id,log_history.card_id ,concat(classe.name,' ',classe.level) as class_name, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON classe.class_id=student.class_id WHERE scan_id > $lastID";

    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    unset($lastID);
} else {

    $sql = "SELECT log_history.scan_id,log_history.card_id,concat(classe.name,' ',classe.level) as class_name, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON classe.class_id=student.class_id ORDER BY log_history.scan_time DESC; ";
    $result = $conn->query($sql);
    
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

}

unset($sql,$result);
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
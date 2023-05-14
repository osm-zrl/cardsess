<?php
require('../dbconfig.php');
$sql = "SELECT * FROM cards order by student_id";
$res = $conn->query($sql);
$data = array();
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
unset($sql,$res);
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
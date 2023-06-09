<?php
require('../dbconfig.php');
if (isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM cards where student_id='$id'";
    $res = $conn->query($sql);
    $data = array();
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    unset($sql,$res);
    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();
   
}
 ?>
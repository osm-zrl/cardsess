<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD']=='GET'){
    $data=[];
    if (isset($_GET['class_id'])){
        $class_id = trim($_GET['class_id']);
        if ($class_id != ''){
            $sql="SELECT * FROM `time_table` WHERE `class_id`='$class_id' order by `day`,`time_start`";
            $result = $conn->query($sql);
            while($row=$result->fetch_assoc()){
                $data[]=$row;
            }
            header('Content-Type: application/json');
            echo json_encode($data);
            $conn->close();
        }
    }
}

?>
<?php
require('../dbconfig.php');
if (isset($_POST['student_id'])){
    $student_id = $_POST['student_id'];
    $sql = "SELECT * FROM student WHERE student_id = '$student_id'";
    $res = $conn->query($sql);
    if ($res->num_rows>0){
        echo 'true';
    }else{
        echo 'false';
    }
}else{
    echo 'nah';
}

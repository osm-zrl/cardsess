<?php 
require('../dbconfig.php');

if (isset($_POST['student_id']) && isset($_POST['card_uid'])){
    $student_id = $_POST['student_id'];
    $card_uid = $_POST['card_uid'];
    $sql = "SELECT * from student where student_id = '$student_id'";
    $res= $conn->query($sql);

    if($res->num_rows < 0){
        exit();
    }
    $card_id = $card_uid.$student_id;
    
    $sql = "SELECT * from cards WHERE card_id = '$card_id'";
    
    $res= $conn->query($sql);
    if($res->num_rows > 0){
        echo 0;
        exit();
    }
    $sql = "SELECT * from cards WHERE student_id='$student_id' and card_active=1 ";
    $res= $conn->query($sql);
    if($res->num_rows > 0){
        echo 1;
        exit();
    }

    
}
$conn->close();

?>
<?php 
require('../dbconfig.php');
if (isset($_POST['card_id'])&& (isset($_POST['student_id']))){
    $card_id = $_POST['card_id'];
    $student_id = $_POST['student_id'];
    $sql = "INSERT INTO cards(card_id,student_id) VALUES('$card_id','$student_id')";
    if ($conn->query($sql)){
        echo 'true';
        exit();
    }
}
echo 'false';
$conn ->close();
?>
<?php 
require('../dbconfig.php');
if (isset($_POST['student_id'])){
    $student_id = $_POST['student_id'];
    $sql="UPDATE cards SET card_active=0 WHERE student_id = '$student_id'";
    if ($conn->query($sql)){
        echo 'true';
        exit();
    }
}
echo 'false';
$conn->close()
?>
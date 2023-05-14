<?php
require('../dbconfig.php');
if (isset($_POST['card_id'])){
    $card_id = $_POST['card_id'];
    $sql = "DELETE FROM cards WHERE card_id = '$card_id'";
    if ($conn->query($sql)){
        echo 'true';
    }
}
?>
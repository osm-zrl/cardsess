<?php
// PAGE BACH KANAKHDO DATA MN ESP8266
include('dbconfig.php');
if (isset($_POST['cardUID'])){
    $cardUID = $_POST['cardUID'];
    $CEF = $_POST['CEF'];
    $fullID = $cardUID.$CEF;
    $sql = "SELECT card_active from cards WHERE card_id = '$fullID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if ($row['card_active'] == 1) {
            $Stat = "Access Granted";
            $sql = "INSERT INTO log_history(card_id) VALUES('$fullID')";
            $conn->query($sql);
        } else {
            $Stat = "Card Desactivated";
        }
    }else{
        $Stat = "Access Denied";
    }
    echo $Stat;
}
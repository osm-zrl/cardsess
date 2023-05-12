<?php
// PAGE BACH KANAKHDO DATA MN ESP8266
include('dbconfig.php');
if (isset($_POST['cardUID'])){
    $cardUID = $_POST['cardUID'];
    $CEF = $_POST['CEF'];
    $fullID = strval($cardUID) + strval($CEF);
    $sql = "SELECT card_active from cards WHERE card_id = '$fullID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if ($row['cardActive'] == 1) {
            $Stat = "Access Granted";
            $sql = "INSERT INTO log_history(cardUID) VALUES('$fullID')";
            $conn->query($sql);
        } else {
            $Stat = "Card Desactivated";
        }
    }else{
        $Stat = "Access Denied";
    }
    echo $Stat;
}
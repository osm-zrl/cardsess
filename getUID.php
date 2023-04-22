<?php
include('dbconfig.php');
if (isset($_POST['cardUID'])) {
    $cardUID = $_POST['cardUID'];
    $sql = "SELECT cardActive from carte WHERE cardUID = '$cardUID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['cardActive'] == 1) {
            $Stat = "Access Granted";
            $sql = "INSERT INTO log_history(cardUID) VALUES('$cardUID')";
            $conn->query($sql);
        } else {
            $Stat = "Card Desactivated";
        }
    }else{
        $Stat = "Access Denied";
    }


    echo $Stat;
}
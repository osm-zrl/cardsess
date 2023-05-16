<?php
require('../dbconfig.php');
    if (isset($_POST['card_id']) && isset($_POST['card_stat'])){
        $card_id = $_POST['card_id'];
        $card_stat = $_POST['card_stat'];
        switch ($card_stat) {
            case '1':
                $card_stat = 0;
                break;
            case '0':
                $card_stat = 1;
                break;
        }
        $sql = "UPDATE cards SET card_active='$card_stat' WHERE card_id='$card_id'";
        if ($conn->query($sql)){
            echo "true";
        }else{
            echo "false";
        }
    }
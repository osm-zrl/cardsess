<?php
    require('../dbconfig.php');

    // prepare the SQL statement to count the total number of classes
    $sql = "SELECT COUNT(DISTINCT card_id) as total_cards FROM cards";
    $count_result = $conn->query($sql);
    $row = $count_result->fetch_assoc();
    $data[] = $row;
    $sql = "SELECT COUNT(DISTINCT card_id) as total_active_cards FROM cards WHERE card_active =1";
    $count_result = $conn->query($sql);
    $row = $count_result->fetch_assoc();
    $data[] = $row;

    $sql = "SELECT COUNT(DISTINCT card_id) as total_desactive_cards FROM cards WHERE card_active =0";
    $count_result = $conn->query($sql);
    $row = $count_result->fetch_assoc();
    $data[] = $row;
    
    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();
<?php
require('../dbconfig.php');
$data = [];
if (isset($_POST['date']) || isset($_POST['time'])){
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    
    if ($date != '' && $time != ''){
        $date = date($date);
        switch ($time) {
            case '1':
                $startTime = DateTime::createFromFormat('H:i','08:30')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','11:00')->format('H:i');
                break;
            case '2':
                $startTime = DateTime::createFromFormat('H:i','11:00')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','13:30')->format('H:i');
                break;
            case '3':
                $startTime = DateTime::createFromFormat('H:i','13:30')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','15:00')->format('H:i');
                break;
            case '4':
                $startTime = DateTime::createFromFormat('H:i','15:00')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','18:30')->format('H:i');
                break;
                
            default:
                break;
        }
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id WHERE DATE(log_history.scan_time)='$date' AND TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
        

    }elseif ($date != '' && $time == '') {
        $date = date($date);
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id WHERE DATE(log_history.scan_time)='$date' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }


    }elseif ($date == '' && $time != '') {
        switch ($time) {
            case '1':
                $startTime = DateTime::createFromFormat('H:i','08:30')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','11:00')->format('H:i');
                break;
            case '2':
                $startTime = DateTime::createFromFormat('H:i','11:00')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','13:30')->format('H:i');
                break;
            case '3':
                $startTime = DateTime::createFromFormat('H:i','13:30')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','15:00')->format('H:i');
                break;
            case '4':
                $startTime = DateTime::createFromFormat('H:i','15:00')->format('H:i');
                $endTime = DateTime::createFromFormat('H:i','18:30')->format('H:i');
                break;
                
            default:
                break;
        }
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id WHERE TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }

    }elseif($date == '' && $time == ''){
        $sql = "SELECT * FROM log_history";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
    }
}else{
    $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id ORDER BY log_history.scan_time DESC;";
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc()){
        $data[]=$row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
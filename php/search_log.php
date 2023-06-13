<?php
require('../dbconfig.php');
$data = [];
if (isset($_POST['date']) || isset($_POST['time']) || isset($_POST['class'])|| isset($_POST['student_id'])){
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $class = trim($_POST['class']);
    $student_id = trim($_POST['student_id']);

    if ($date != '' && $time != '' && $class!=''){
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
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE DATE(log_history.scan_time)='$date' AND TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' AND student.class_id = '$class' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
        

    }elseif ($date != '' && $time == '' && $class=='') {
        $date = date($date);
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE DATE(log_history.scan_time)='$date' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }


    }elseif ($date == '' && $time != '' && $class=='') {
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
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }

    }elseif($date == '' && $time == '' && $class!=''){
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE student.class_id = '$class' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
    }elseif($date != '' && $time != '' && $class==''){
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
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE DATE(log_history.scan_time)='$date' AND TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
        
    }elseif($date == '' && $time != '' && $class!=''){
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
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE TIME(log_history.scan_time)>='$startTime' AND TIME(log_history.scan_time)<'$endTime' AND student.class_id = '$class' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
    
    }elseif($date != '' && $time == '' && $class!=''){
        $date = date($date);
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id WHERE DATE(log_history.scan_time)='$date' AND student.class_id='$class' AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }

    }elseif($date == '' && $time == '' && $class==''){
        $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id AND student.student_id LIKE '$student_id%' ORDER BY log_history.scan_time DESC;";
        $res = $conn->query($sql);
        while($row = $res->fetch_assoc()){
            $data[]=$row;
        }
    }
}else{
    $sql = "SELECT log_history.scan_id,log_history.card_id, cards.student_id, concat(student.first_name,' ',student.last_name) as nom_complete,concat(classe.name,' ',classe.level) as class_name, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id JOIN classe ON student.class_id = classe.class_id  ORDER BY log_history.scan_time DESC;";
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc()){
        $data[]=$row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
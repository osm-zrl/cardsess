<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = [];
    if (isset($_GET['class_id']) && isset($_GET['date'])) {
        $class_id = trim($_GET['class_id']);
        $date = trim($_GET['date']);
        $sql = "SELECT * FROM sessions WHERE class_id='$class_id' AND DATE(date_start)='$date' order by date_start";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        $conn->close();
    }else{
        $data=[];
        $upcoming=[];
        $prev=[];
        $sql = "SELECT sessions.*,concat(classe.name,' ',classe.level) as class_name FROM sessions JOIN classe ON sessions.class_id = classe.class_id WHERE DATE(date_start)=CURDATE() AND TIME(date_start)>CURTIME() order by date_start";
        $result=$conn->query($sql);
        while($row=$result->fetch_assoc()){
            $upcoming[]=$row;
        }
        
/* SELECT sessions.*,concat(classe.name,' ',classe.level) as class_name,count(log_history.session_id)  FROM sessions JOIN classe ON sessions.class_id = classe.class_id JOIN log_history ON log_history.session_id=sessions.id_session WHERE DATE(date_start)=CURDATE() AND TIME(date_start)<=CURTIME() order by date_start */
        $sql = 
        "SELECT sessions.*, CONCAT(classe.name, ' ', classe.level) AS class_name, COUNT(log_history.session_id) AS present
        FROM sessions
        LEFT JOIN log_history ON sessions.id_session = log_history.session_id
        JOIN classe ON sessions.class_id = classe.class_id
        WHERE DATE(sessions.date_start) = CURDATE() AND TIME(sessions.date_start) <= CURTIME()
        GROUP BY sessions.id_session
        ORDER BY sessions.date_start;
         ";
        $result=$conn->query($sql);
        while($row=$result->fetch_assoc()){
            $prev[]=$row;
        }
        $data[]=$upcoming;
        $data[]=$prev;
        header('Content-Type: application/json');
        echo json_encode($data);
        $conn->close();

    }
}
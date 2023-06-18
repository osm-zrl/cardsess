<?php

// PAGE BACH KANAKHDO DATA MN ESP8266
include('dbconfig.php');
if (isset($_POST['cardUID'])) {
    $cardUID = $_POST['cardUID'];
    $CEF = $_POST['CEF'];
    $token = $_POST['token'];
    $hashed_token = 'bc260a013d84e4743f11533365b2dd93';
    if (md5($token) == $hashed_token) {
        
        $fullID = $cardUID . $CEF;
        $sql = "SELECT * from cards WHERE card_id = '$fullID'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['card_active'] == 1) {
                $student_id=$row['student_id'];
                $sql="SELECT class_id FROM student WHERE student_id='$student_id'";
                $result=$conn->query($sql);
                $row = $result->fetch_assoc();
                $class_id=$row['class_id'];

                $sql="SELECT * from sessions WHERE class_id='$class_id' AND DATE(date_start)=CURRENT_DATE  ORDER BY date_start";
                $result=$conn->query($sql);

                if ($result->num_rows>0){
                    $session_id = -1;
                    $currentTime = new DateTime();

                    $currentTime->format('H:i:s');
                    while($row=$result->fetch_assoc()){
                        $dateStart = new DateTime($row['date_start']);
                        
                        $difference = $dateStart->diff($currentTime);
                        $totalMinutes = ($difference->h * 60) + $difference->i;

                        if ($totalMinutes<=15){
                            $session_id = $row['id_session'];
                            break;
                        }
                    
                        
                    }
                    
                    
                    if($session_id!=-1){
                        $sql = "SELECT * FROM log_history WHERE card_id='$fullID' AND session_id='$session_id'";
                        $result = $conn->query($sql);
                        if ($result->num_rows>0){
                            $Stat = "0"; 
                        }else{
                            $sql = "INSERT INTO log_history(card_id,session_id) VALUES('$fullID','$session_id')";
                            if($conn->query($sql)){
                                $Stat = "0"; 
                            }
                        }
                        
                    }else{
                        $Stat="1";
                    }


                }else{
                    $Stat="1";
                }
            } else {
                $Stat = "2";
            }
        }
        echo $Stat;
    }

}


/* stat description: */
/* 0 will trigger green
1 will trigger orange 
2 will trigger red*/
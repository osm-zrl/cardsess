<?php
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD']=='GET'){
    $data=[];
    if (isset($_GET['class_id'])){
        $class_id = trim($_GET['class_id']);
        if ($class_id != ''){
            $sql="SELECT * FROM `time_table` WHERE `class_id`='$class_id' order by `day`,`time_start`";
            $result = $conn->query($sql);
            while($row=$result->fetch_assoc()){
                $data[]=$row;
            }
            header('Content-Type: application/json');
            echo json_encode($data);
            
        }
    }
}elseif($_SERVER['REQUEST_METHOD']=='POST'){
    $msg =[];
    if (isset($_POST['class_id']) && isset($_POST['t_module']) && isset($_POST['t_start'])&&isset($_POST['t_end']) && isset($_POST['weekday'])){
        $class_id=trim($_POST['class_id']);
        $title=trim($_POST['t_module']);
        $t_start =trim($_POST['t_start']);
        $t_end = trim($_POST['t_end']);
        $weekday = trim($_POST['weekday']);
        if ($title != '' && $t_start !='' && $t_end !='' && $weekday!=''){
            $sql = "SELECT * FROM time_table WHERE class_id='$class_id' AND `day`='$weekday' AND (time_start='$t_start' OR time_end='$t_end')";
            $result=$conn->query($sql);
            if($result->num_rows>0){
                $msg[]= ['msg'=>'other weekly session with same start time or end time found'];
                $msg[] = ['color'=>'warning'];
            }else{
                $sql = "INSERT INTO `time_table`(`class_id`, `module`, `time_start`, `time_end`, `day`) VALUES ('$class_id','$title','$t_start','$t_end','$weekday')";
                if ($conn->query($sql)){
                    $msg[]= ['msg'=>'weekly session added successfully'];
                    $msg[] = ['color'=>'success'];
                }else{
                    $msg[]= ['msg'=>'adding the new weekly session failed!'];
                    $msg[] = ['color'=>'danger'];
                }
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($msg);
}
$conn->close();
?>
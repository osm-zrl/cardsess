<?php
$data = [];
require('../dbconfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM classe";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['level'])) {
        $name = trim($_POST['name']);
        $level = trim($_POST['level']);
        if ($name != '' && $level != '') {
            $sql = "INSERT INTO classe(name,level) VALUES ('$name','$level')";
            try {
                if ($conn->query($sql)) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            } catch (Exception) {
                echo 'false';
            }

        } else {
            echo "Invalid parametre";
        }
    } else {
        echo 'missing parametre';
    }
} /* elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = file_get_contents("php://input");
    parse_str($input, $_PUT);


    if (isset($_PUT['class_id']) && isset($_PUT['name']) && isset($_PUT['level'])) {
        $class_id = trim($_PUT['class_id']);
        $name = trim($_PUT['name']);
        $level = trim($_PUT['level']);

        if ($class_id != '' && $name != '' && $level != '') {
            $sql = "SELECT * FROM classe where class_id='$class_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE classe SET name='$name',level='$level' WHERE class_id='$class_id'";
                if ($conn->query($sql)) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            }else {
                echo "unknown class id";
            }

        } else {
            echo "Invalid parametre";
        }
    } else {
        echo 'missing parametre';
    }
} */ elseif ($_SERVER['REQUEST_METHOD'] == 'DELET') {
    $input = file_get_contents("php://input");
    parse_str($input, $_DELET);
    if (isset($_DELET['class_id'])) {
        $class_id = $_DELET['class_id'];
        if ($class_id != '') {
            $class_id = $_DELET['class_id'];

            $sql = "SELECT * FROM classe where class_id='$class_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                
                

                $sql="SELECT * from student where class_id='$class_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    echo 'warning: can\'t delete classroom with existing student!';
                }else{
                    $sql = "DELETE FROM classe WHERE class_id='$class_id'";
                    if ($conn->query($sql)) {
                        echo "classroom deleted successfully!";
                    } else {
                        echo "failed to delet classroom";
                    }
                }
                
                
            } else {
                echo "unknown class id";
            }

        } else {
            echo "Invalid parametre";
        }
    } else {
        echo 'missing parametre';
    }

}

?>
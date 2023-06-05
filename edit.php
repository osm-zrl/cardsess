<?php

require('dbconfig.php');
if (isset($_GET['student_id'])) {

    // retrieve the student_id parameter from the URL
    $student_id = $_GET['student_id'];

    // retrieve the current student information from the database
// assuming you have a database connection already established
    $query = "SELECT * FROM student WHERE student_id = '$student_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        header('location:students.php');
    }
    $row = $result->fetch_assoc();

    // pre-populate the form fields with the student's current data
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $birthday = $row['birthday'];
    $gender = $row['gender'];
    $class_id = $row['class_id'];

    // handle the form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // retrieve the form data
        $student_id = $_POST['student_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $class_id = $_POST['class_id'];

        // prepare the SQL update statement
        $query = "UPDATE student SET first_name=?, last_name=?, birthday=?, gender=?, class_id=? WHERE student_id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssii", $first_name, $last_name, $birthday, $gender, $class_id, $student_id);

        // execute the update statement
        if (mysqli_stmt_execute($stmt)) {
            // if the update was successful, redirect to the student details page
            header("Location: students.php?student_id=$student_id");
        } else {
            // if there was an error, display an error message
            echo "Error updating student: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }

    

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php require('head.php'); ?>
        <title>Edit Student Info</title>
        <link rel="stylesheet" href="css/student.css">
    </head>

    <body>
        <?php require('aside.php'); ?>
        <!-- top main title + statics cards  -->
        <main>
            <div class="top-main">
                <div class="title">
                    <h2>Update Student</h2>
                    <h5>Here you can see all the student informations</h5>
                </div>
            </div>
            <form class="information" action="" method="POST">
                <div class="row">
                    <div class="col">
                        <h4>Student CEF :</h4>
                        <input type="number" name="student_id" value="<?php echo $student_id; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Student First Name :</h4>
                        <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="col">
                        <h4>Student Last Name :</h4>
                        <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Student Birthday :</h4>
                        <input type="date" name="birthday" value="<?php echo $birthday; ?>">
                    </div>
                    <div class="col">
                        <h4>Student Gender :</h4>
                        <select name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" <?php if ($gender == 'male')
                                echo ' selected'; ?>>Male</option>
                            <option value="female" <?php if ($gender == 'female')
                                echo ' selected'; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Student Class :</h4>
                        <select name="class_id" id="class_id">
                            
                            <?php 
                                $sql = "SELECT * FROM classe;";
                                $res = $conn->query($sql);
                                while($row = $res->fetch_assoc()){

                                
                            ?>
                                <option value="<?php echo $row['class_id']?>" <?php if ($class_id == 1)
                                    echo ' selected'; ?>><?php echo $row['name']." ".$row['level']?>
                                </option>
                                
                            <?php
                            }?>
                        </select>
                    </div>
                </div>
                <button type="submit">Update Student</button>
            </form>
        </main>
        <?php require('footer.php'); ?>
    </body>

    </html>

    <style>
        /* student edit */
        .information {
            background: white;
            height: fit-content;
            border-radius: 12px;
            margin: 0rem;
            padding: 2rem;
            color: black;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .information h4 {
            font-size: 1.3rem;
            margin: 0;
        }

        .col input {
            width: 100%;
        }

        .col select#gender,
        .col select#classe {
            width: 100%;
        }

        .information .col {
            display: flex;
            gap: 1rem;
            flex-direction: column;
        }
    </style>
    <?php
} else {
    header('location:students.php');
} ?>
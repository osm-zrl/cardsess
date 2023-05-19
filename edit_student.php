<?php

require('dbconfig.php');

// retrieve the student_id parameter from the URL
$student_id = $_GET['student_id'];

// retrieve the current student information from the database
// assuming you have a database connection already established
$query = "SELECT * FROM student WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

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

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');?>
    <title>main</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>
    <?php require('aside.php');?>
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
                    <h6><?php echo $student_id; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Student First Name :</h4>
                    <h6><?php echo $first_name; ?></h6>
                </div>
                <div class="col">
                    <h4>Student Last Name :</h4>
                    <h6><?php echo $last_name; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Student Birthday :</h4>
                    <h6><?php echo $birthday; ?></h6>
                </div>
                <div class="col">
                    <h4>Student Gender :</h4>
                    <h6><?php echo $gender; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Student Class :</h4>
                    <h6><?php echo $class_id; ?></h6>
                </div>
            </div>
        </form>

        <button type="submit" id="edit">Edit Infos</button>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/script.js"></script>
    <script>
         document.getElementById('edit').addEventListener('click', function() {
        location.href = 'edit.php?student_id=<?php echo $student_id; ?>';
    });
    </script>
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

.col select#gender,.col select#classe {
  width: 100%;
}

.information .col {
    display: flex;
    gap: 1rem;
    flex-direction: column;
}
</style>

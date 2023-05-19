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
                        <option value="male"<?php if ($gender == 'male') echo ' selected'; ?>>Male</option>
                        <option value="female"<?php if ($gender == 'female') echo ' selected'; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Student Class :</h4>
                    <select name="class_id" id="class_id">
                        <option value="">Select Student Group</option>
                        <option value="1"<?php if ($class_id == 1) echo ' selected'; ?>>Développement digital 101</option>
                        <option value="2"<?php if ($class_id == 2) echo ' selected'; ?>>Développement digital 102</option>
                        <option value="3"<?php if ($class_id == 3) echo ' selected'; ?>>gestion entreprise 101</option>
                        <option value="4"<?php if ($class_id == 4) echo ' selected'; ?>>gestion entreprise 102</option>
                        <option value="5"<?php if ($class_id == 5) echo ' selected'; ?>>infographie</option>
                    </select>
                </div>
            </div>
            <button type="submit">Update Student</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/script.js"></script>
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

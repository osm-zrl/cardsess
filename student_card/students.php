<?php
// Include the database connection file
require_once "connection.php";

// Execute a SQL query to count the number of students, classes, and cards
$sql_counts = "SELECT (SELECT COUNT(*) FROM student) AS num_students,
               (SELECT COUNT(*) FROM classe) AS num_classes,
               (SELECT COUNT(*) FROM cards) AS num_cards";
$result_counts = $conn->query($sql_counts);

// Check if the query was successful
if (!$result_counts) {
    echo "Error: " . $conn->error;
}

// Get the counts from the query result
$row_counts = $result_counts->fetch_assoc();
$num_students = $row_counts["num_students"];
$num_classes = $row_counts["num_classes"];
$num_cards = $row_counts["num_cards"];

// Execute a SQL query to retrieve all students and their class name
$sql_students = "SELECT student.*, classe.name AS class_name, classe.level AS class_level 
                 FROM student 
                 JOIN classe ON student.class_id = classe.class_id";
$result_students = $conn->query($sql_students);

// Check if the query was successful
if (!$result_students) {
    echo "Error: " . $conn->error;
}

// Check if the "cef" parameter is present in the GET request
if (isset($_GET['cef'])) {
  $cef = $_GET['cef'];

  // Execute a SQL query to delete the student with the given "cef" value
  $sql = "DELETE FROM student WHERE cef = '$cef'";
  $result = $conn->query($sql);

  // Check if the query was successful
  if (!$result) {
    echo "Error: " . $conn->error;
  } else {
    // Redirect the user back to the "students.php" page
    header("Location: students.php");
    exit();
  }
}

// Check if the form was submitted to update a student's information
if (isset($_POST['update_student'])) {
  $cef = $_POST['cef'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $birthday = $_POST['birthday'];
  $gender = $_POST['gender'];
  $class_id = $_POST['class_id'];

  $sql = "UPDATE student SET first_name='$first_name', last_name='$last_name', birthday='$birthday', gender='$gender', class_id='$class_id' WHERE cef='$cef'";
  $result = mysqli_query($conn, $sql);

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    // Redirect the user back to the students page
    header("Location: students.php");
    exit();
  } else {
    // Display an error message on the same page
    $error_message = "Error: " . $sql . "<br>" . $conn->error;
  }
}


// Check if the form was submitted to insert a new student's information
if (isset($_POST['cef']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthday']) && isset($_POST['gender']) && isset($_POST['classe'])) {
  // Get the values from the form
  $cef = $_POST['cef'];
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $birthday = $_POST['birthday'];
  $gender = $_POST['gender'];
  $class_id = $_POST['classe'];

  // Prepare a SQL query to insert the new student into the database
  $sql = "INSERT INTO student (cef, first_name, last_name, birthday, gender, class_id) 
          VALUES ('$cef', '$first_name', '$last_name', '$birthday', '$gender', '$class_id')";

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    // Redirect the user back to the students page
    header("Location: students.php");
    exit();
  } else {
    // Display an error message on the same page
    $error_message = "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/students.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <aside class="sidebar">
    <div class="side-logo">
      <h1>Educia.</h1>
    </div>
    <div class="principal-menu">
      <a href="main.php">
        <i class="fa-solid fa-table-columns"></i>
        Dashboard
      </a>
      <a href="#" class="active">
        <i class="fa-solid fa-users"></i>
        Students
      </a>
      <a href="cards.php">
        <i class="fa-solid fa-id-card"></i>
        Cards
      </a>
      <a href="#" class="active" id="entry">
        <i class="fa-solid fa-door-closed"></i>
        entry/exit
        <div class="live">
          <i class="fa-solid fa-wifi"></i>
        </div>
      </a>
    </div>
    <div class="seconde-menu">
      <a href="link.php">
        <i class="fa-solid fa-link"></i>
        Link card/student
      </a>
      <a href="#">
        <i class="fa-solid fa-list"></i>
        Classes
      </a>
      <a href="#">

      </a>
      <a href="#">

      </a>
    </div>
    <div class="bottom-menu">
      <a href="#">
        <i class="fa-solid fa-clock-rotate-left"></i>
        History
      </a>
    </div>
  </aside>
  <main>
    <div class="top-dashboard">
      <div class="text">
        <h2>Students Place</h2>
        <h5>Here’s you can see all the students</h5>
      </div>
      <div class="cards">
        <div class="card">
          <i class="fa-solid fa-users"></i>
          <div class="card-text">
            <span id='student'><?php echo $num_students; ?></span>
            <p>Students</p>
          </div>
        </div>
        <div class="card">
          <i class="fa-solid fa-address-book"></i>
          <div class="card-text">
            <span id="assignment"></span>
            <p>absent</p>
          </div>
        </div>
        <div class="card">
          <i class="fa-solid fa-chalkboard-user"></i>
          <div class="card-text">
            <span id="class">%</span>
            <p>attendance rate</p>
          </div>
        </div>
      </div>
    </div>
    <div class="addstudent">
      <a href="#" onclick="toggleAddStudent()" id="addstudentbtn">Add Student</a>
    </div>
    <table>
      <thead>
        <tr>
          <th scope="col">cef</th>
          <th scope="col">Name</th>
          <th scope="col">Age</th>
          <th scope="col">gender</th>
          <th scope="col">Classe</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
                // Loop through the result set and display each student in a table row
                while ($student = $result_students->fetch_assoc()) {
                    $dob = new DateTime($student['birthday']);
                    $today = new DateTime();
                    $age = $dob->diff($today)->y;
                    echo "<tr>";
                    echo "<td>" . $student['cef'] . "</td>";
                    echo "<td>" . $student['first_name'] . " " . $student['last_name'] . "</td>";
                    echo "<td>" . $age . "</td>";
                    echo "<td>" . $student['gender'] . "</td>";
                    echo "<td>" .  $student['class_name'] . " " . $student['class_level'] . "</td>";
                    echo'<td><a href="#" onclick="toggleEditStudent(' . $student['cef'] . ', \'' . $student['first_name'] . '\', \'' . $student['last_name'] . '\', \'' . $student['birthday'] . '\', \'' . $student['gender'] . '\', ' . $student['class_id'] . ')"><i class="fa-solid fa-pen-to-square" id="icontable"></i></a></td>';
                    echo '<td><a href="students.php?cef=' . $student["cef"] . '" onclick="return confirm(\'Are you sure you want to delete this student?\')"><i class="fa-solid fa-trash" id="icontable"></i></a></td>';
                    echo "</tr>";            
                }
                ?>
      </tbody>
    </table>
    <div id="addstudent" class="hidden">
      <div class="blocktitle">
        <h3> Add Student</h3>
        <i class="fa-solid fa-xmark" onclick="toggleAddStudent()"></i>
      </div>
      <form id="addstudentform" action="students.php" method="post">
        <div class="information">
          <div class="cef">
            <input type="number" id="cef" name="cef" placeholder="Enter CEF">
          </div>
          <div class="fullname">
            <input type="text" id="firstname" name="firstname" placeholder="Enter first-name">
            <input type="text" id="lastname" name="lastname" placeholder="Enter last-name ">
          </div>
          <div class="birthgen">
            <input type="date" name="birthday" id="birthday">
            <select name="gender" id="gender">
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="classe">
            <select name="classe" id="classe">
              <option value="">Select Student Group</option>
              <option value="1">Developpement digital 101</option>
              <option value="2">Developpement digital 102</option>
              <option value="3">gestion etreprise 101</option>
              <option value="4">gestion etreprise 102</option>
              <option value="5">infograpie</option>
            </select>
          </div>
          <button type="submit">Add Student</button>
        </div>
      </form>
    </div>
    <div id="editstudent" class="hidden">
  <div class="blocktitle">
    <h3>Edit Student</h3>
    <i class="fa-solid fa-xmark" onclick="toggleEditStudent()"></i>
  </div>
  <form id="edit-student-form" action="" method="post">
    <div class="information">
      <div class="cef">
        <input type="number" id="cef" name="cef" placeholder="Enter CEF" value="">
      </div>
      <div class="fullname">
        <input type="text" id="edit-firstname" name="first_name" placeholder="Enter First Name" required>
        <input type="text" id="edit-lastname" name="last_name" placeholder="Enter Last Name" required>   
      </div>
      <div class="birthgen">
        <input type="date" id="birthday" name="birthday" required>
        <select id="gender" name="gender" required>
          <option value="" selected disabled>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
      </div>
      <div class="classe">
        <select id="edit-classe" name="class_id" required>
          <option value="" selected disabled>Select Student Group</option>
          <option value="1">Developpement digital 101</option>
          <option value="2">Developpement digital 102</option>
          <option value="3">Gestion entreprise 101</option>
          <option value="4">Gestion entreprise 102</option>
          <option value="5">Infographie</option>
        </select>
      </div>
      <button type="submit" name="update_student">Save Changes</button>
    </div>
  </form>
</div>


  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="script.js"></script>
</body>

</html>
//testing edit
<?php
require('dbconfig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // retrieve the student data from the POST request
    $cef = $_POST['cef'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $class_id = $_POST['classe'];

    // prepare the SQL statement to insert the student data
    $stmt = $conn->prepare("INSERT INTO student (student_id, first_name, last_name, birthday, gender, class_id) 
                           VALUES (?, ?, ?, ?, ?, ?)");

    // bind the parameters to the SQL statement
    $stmt->bind_param("sssssi", $cef, $first_name, $last_name, $birthday, $gender, $class_id);

    // execute the SQL statement to insert the student data
    if (!($stmt->execute())) {
        echo "Error: " . $stmt->error;
    }
    // close the statement object
    $stmt->close();
}

// prepare the SQL statement to retrieve all students from the table
$sql = "SELECT s.student_id, s.first_name, s.last_name, s.birthday, s.gender, c.name AS class_name, c.level
        FROM student s
        JOIN classe c ON s.class_id = c.class_id";

// execute the SQL statement and store the result
$result = $conn->query($sql);

// prepare the SQL statement to count the total number of students
$count_sql = "SELECT COUNT(*) as total_students FROM student";

// execute the SQL statement to count the total number of students and store the result
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_students = $count_row['total_students'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>Students</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div id="black_layer" style="right:-100vw;"></div>
        <div class="top-main">
            <div class="title">
                <h2>Students Place</h2>
                <h5>Here you can see all the students</h5>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-users"></i>
                    <div class="card-text">
                        <span><?php echo $total_students; ?></span>
                        <p>Students</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-address-book"></i>
                    <div class="card-text">
                        <span>--</span>
                        <p>absent</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <div class="card-text">
                        <span>--%</span>
                        <p>attendance</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="link-div">
            <div class="search-box" id="search-box">
                <input type="text" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button"><i class="fa-solid fa-search"></i></button>
            </div>
            <div class="d-flex gap-3">
                <a href="#" onclick="togglecard()" id="addstudentbtn">Add Student</a>
                <a href="#" onclick="togglescancard()" id="scanstudentbtn">scan Student</a>
            </div>
                
        </div>
        <div class="filter">
            <select name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <select name="classe" id="classe">
                <option value="">Select Student Group</option>
                <option value="1">Développement digital 101</option>
                <option value="2">Développement digital 102</option>
                <option value="3">gestion entreprise 101</option>
                <option value="4">gestion entreprise 102</option>
                <option value="5">infographie</option>
            </select>
        </div>
        <!-- table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">cef</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">gender</th>
                    <th scope="col">Classe</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                    if ($result->num_rows > 0) {
                        // output data of each row as a table row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["student_id"] . "</td>";
                            echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                            echo "<td>" . date_diff(date_create($row["birthday"]), date_create('today'))->y . "</td>";
                            echo "<td>" . $row["gender"] . "</td>";
                            echo "<td>" . $row["class_name"] . " " . $row["level"] . "</td>";
                            echo "<td><a href='edit_student.php?student_id=" . $row["student_id"] . "'><i class='fa-solid fa-eye'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // output message if no rows are returned
                        echo "No students found.";
                    }            
                    $result->close();
                    $conn->close();    
                ?>
            </tbody>
        </table>
        <!-- forms -->
        <div id="addstudent" class="form hidden">
            <div class="blocktitle">
                <h3> Add Student</h3>
                <i class="fa-solid fa-xmark" onclick="togglecard()"></i>
            </div>

            <form id="form" action="" method="post">
                <div class="information">
                    <div class="col">
                        <input type="number" id="cef" name="cef" placeholder="Enter CEF">
                    </div>
                    <div class="col">
                        <input type="text" id="firstname" name="firstname" placeholder="Enter first-name">
                        <input type="text" id="lastname" name="lastname" placeholder="Enter last-name ">
                    </div>
                    <div class="col">
                        <input type="date" name="birthday" id="birthday">
                        <select name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="classe" id="classe">
                            <option value="">Select Student Group</option>
                            <option value="1">Développement digital 101</option>
                            <option value="2">Développement digital 102</option>
                            <option value="3">gestion entreprise 101</option>
                            <option value="4">gestion entreprise 102</option>
                            <option value="5">infographie</option>
                        </select>
                    </div>
                    <button type="submit">Add Student</button>
                
                </div>
            </form>
        </div>
        <div id="scanstudent" style="width: 300px; height:300px; d-flex justify-content-center align-items-center" class="form hidden">
            <div>
                <p>testing</p>
            </div>
        </div>
    </main>
    <?php require('footer.php') ?>
</body>
</html>

<script src='js/student.js'></script>

<script>
// filter function
$(document).ready(function() {
  $('.search-input').on('input', function() {
    var searchValue = $(this).val();
    var genderFilter = $('#gender').val();
    var classFilter = $('#classe').val();
    $.ajax({
      url: 'php/search_students.php',
      type: 'POST',
      data: { searchValue: searchValue, genderFilter: genderFilter, classFilter: classFilter },
      success: function(response) {
        $('#table-body').html(response);
      },
      error: function(xhr, status, error) {
        console.log('Error:', error);
      }
    });
  });
  $('#gender, #classe').on('change', function() {
    $('.search-input').trigger('input');
  });
});
</script>

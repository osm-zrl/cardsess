<?php
require('../dbconfig.php');

$searchValue = $_POST['searchValue'];
$genderFilter = $_POST['genderFilter'];
$classFilter = $_POST['classFilter'];

$sql = "SELECT s.student_id, s.first_name, s.last_name, s.birthday, s.gender, c.name AS class_name, c.level
        FROM student s
        JOIN classe c ON s.class_id = c.class_id
        WHERE (s.student_id LIKE '%$searchValue%' OR s.first_name LIKE '%$searchValue%' OR s.last_name LIKE '%$searchValue%') ";

if (!empty($genderFilter)) {
  $sql .= "AND s.gender = '$genderFilter' ";
}

if (!empty($classFilter)) {
  $sql .= "AND c.class_id = '$classFilter' ";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["student_id"] . "</td>";
    echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
    echo "<td>" . date_diff(date_create($row["birthday"]), date_create('today'))->y . "</td>";
    echo "<td>" . $row["gender"] . "</td>";
    echo "<td>" . $row["class_name"] . " " . $row["level"] . "</td>";
    echo "<td><a href='edit_student.php?student_id=" . $row["student_id"] . "'><i class='fa-regular fa-eye'></i></a></td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='6'>No results found.</td></tr>";
}

$result->close();
$conn->close();
?>
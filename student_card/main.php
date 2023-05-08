<!-- say hi to iSMAILAIB -->
<?php
// Include the database connection file
require_once "connection.php";

// Execute a SQL query to count the number of students
$sql_students = "SELECT COUNT(*) FROM student";
$result_students = $conn->query($sql_students);

// Execute a SQL query to count the number of classes
$sql_classes = "SELECT COUNT(*) FROM classe";
$result_classes = $conn->query($sql_classes);

// Execute a SQL query to count the number of cards
$sql_cards = "SELECT COUNT(*) FROM cards";
$result_cards = $conn->query($sql_cards);

// Check if the queries were successful
if ($result_students && $result_classes) {
    // Get the number of rows returned by the queries
    $row_students = $result_students->fetch_row();
    $num_students = $row_students[0];

    $row_classes = $result_classes->fetch_row();
    $num_classes = $row_classes[0];

    $row_cards = $result_cards->fetch_row();
    $num_cards = $row_cards[0];
} else {
    echo "Error: " . $conn->error;
}


// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <aside class="sidebar">
        <div class="side-logo">
            <h1>Educia.</h1>
        </div>
        <div class="principal-menu">
            <a href="#" class="active">
                <i class="fa-solid fa-table-columns"></i>
                Dashboard
            </a>
            <a href="students.php">
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
			<h2>Welcome Back, Ismail !</h2>
			<h5>Here’s your students overview</h5>
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
				<i class="fa-solid fa-id-card"></i>
				<div class="card-text">
					<span id="assignment"><?php echo $num_cards; ?></span>
					<p>Cards</p>
				</div>
			</div>
			<div class="card">
				<i class="fa-solid fa-chalkboard"></i>
				<div class="card-text">
					<span id="class"><?php echo $num_classes; ?></span>
					<p>Classes</p>
				</div>
			</div>
		</div>
	</div>
	<div class="statistics">
			<div class="block">
				<h4>Students Statistics</h4>
				<canvas id="Chart1"></canvas>
			</div>
		
		<div class="block" id="chart2">
			<h4>Cards Statistics</h4>
			<canvas id="Chart2"></canvas>
		</div>
	</div>

	<div class="container">
		<div class="general">
			<h4>General Statistics</h4>
			<div id='general'>
				<canvas id="Chart3"></canvas>
			</div>
		</div>
		<div class="tasks">
			<h4>Entry/Exit</h4>
			
		</div>
	</div>
    
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
</html>
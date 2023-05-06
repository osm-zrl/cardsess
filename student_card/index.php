<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	
	
    <div class="top-dashboard">
		<div class="text">
			<h2>Welcome Back, Ismail !</h2>
			<h5>Here’s your students overview</h5>
		</div>
		<div class="cards">
			<div class="card">
				<i class="fa-solid fa-users"></i>
				<div class="card-text">
					<span id="student">320</span>
					<p>Students</p>
				</div>
			</div>
			<div class="card">
				<i class="fa-solid fa-id-card"></i>
				<div class="card-text">
					<span id="assignment">143</span>
					<p>Cards</p>
				</div>
			</div>
			<div class="card">
				<i class="fa-solid fa-chalkboard"></i>
				<div class="card-text">
					<span id="class">15</span>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
</html>
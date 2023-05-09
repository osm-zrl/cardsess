<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>main</title>
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>Your title here</h2>
                <h5>Your description here</h5>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-users"></i>
                    <div class="card-text">
                        <span>320</span>
                        <p>Students</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="card-text">
                        <span>280</span>
                        <p>Cards</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-chalkboard"></i>
                    <div class="card-text">
                        <span>15</span>
                        <p>Classes</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="link-div">
            <a href="#" onclick="toggleAddStudent()" id="addstudentbtn">Add Student</a>
        </div>
        <!-- table -->
        <table>
            <thead>
                <tr>
                    <th class="col"> col 1 </th>
                    <th class="col"> col 2 </th>
                    <th class="col"> col 3 </th>
                    <th class="col"> col 4 </th>
                    <th class="col"> col 5 </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> item 1 </td>
                    <td> item 2 </td>
                    <td> item 3 </td>
                    <td> item 4 </td>
                    <td> item 5 </td>
                </tr>
            </tbody>
        </table>
        <!-- charts -->
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
        <!-- forms -->
        <div id="addstudent" class="form hidden">
            <div class="blocktitle">
                <h3> Add Student</h3>
                <i class="fa-solid fa-xmark" onclick="toggleAddStudent()"></i>
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
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>Dashboard</title>
</head>
<body>
    <?php require('aside.php');?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>Welcome Back, Admin !</h2>
                <h5>Here’s your students overview</h5>
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
        <!-- charts -->
        <div class="statistics">
			<div class="block">
				<h4>Students Statistics</h4>
				<canvas id="Chart1"></canvas>
			</div>

		    <div class="block" id="chart2">
			    <h4>Cards Statistics</h4>
                <canvas id="chart"></canvas>
		    </div>
	    </div>
        <div class="statistics_2">
		    <div class="block">
			    <h4>General Statistics</h4>
			    <div class="center">
				    <canvas id="Chart3"></canvas>
			    </div>
		    </div>
		    <div class="block">
			    <h4>Entry/Exit</h4>
		    </div>
	    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/script.js"></script>
</body>
</html>


<script>
$(document).ready(function () {
    getAllSessions();

    function getAllSessions() {
        $.ajax({
            url: 'php/presessions_api.php',
            method: 'GET',
            success: function (response) {
                console.log(response);

                if (response.length === 0) {
                    console.log('No data available.');
                    return;
                }

                createLineChart(response);
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    function createLineChart(response) {
        var labels = [];
        var presentData = [];

        response.forEach(el => {
            labels.push(el.date_start);
            presentData.push(el.present);
        });

        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Present',
                    data: presentData,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Present'
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    }
});

</script>
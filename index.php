<?php
require('dbconfig.php');

// prepare the SQL statement to count the total number of students
$count_students = "SELECT COUNT(*) as total_students FROM student";

// execute the SQL statement to count the total number of students and store the result
$count_result = $conn->query($count_students);
$count_row = $count_result->fetch_assoc();
$total_students = $count_row['total_students'];

// prepare the SQL statement to count the total number of classes
$count_classes = "SELECT COUNT(DISTINCT class_id) as total_classes FROM classe";

// execute the SQL statement to count the total number of classes and store the result
$count_result = $conn->query($count_classes);
$count_row = $count_result->fetch_assoc();
$total_classes = $count_row['total_classes'];

// prepare the SQL statement to count the total number of classes
$count_classes = "SELECT COUNT(DISTINCT card_id) as total_cards FROM cards";

// execute the SQL statement to count the total number of classes and store the result
$count_result = $conn->query($count_classes);
$count_row = $count_result->fetch_assoc();
$total_cards = $count_row['total_cards'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php'); ?>
    <title>Dashboard</title>
</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>Dashboard</h2>

            </div>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-users"></i>
                    <div class="card-text">
                        <span>
                            <?php echo $total_students; ?>
                        </span>
                        <p>Students</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="card-text">
                        <span>
                            <?php echo $total_cards; ?>
                        </span>
                        <p>Cards</p>
                    </div>
                </div>
                <div class="card">
                    <i class="fa-solid fa-chalkboard"></i>
                    <div class="card-text">
                        <span>
                            <?php echo $total_classes; ?>
                        </span>
                        <p>Classes</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- charts -->
        <div class="statistics">
            <div class="block">
                <h4>Cards Statistics</h4>
                <canvas id="Chart1"></canvas>
            </div>

            <div class="block" id="chart2">
                <h4>Students Statistics</h4>
                <canvas id="Chart2"></canvas>
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
                <div>
                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th class="col"> Card ID </th>

                                <th class="col"> student ID </th>

                                <th class="col"> Full Name </th>

                                <th class="col"> timestamp </th>

                            </tr>

                        </thead>

                        <tbody id="logTable">



                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php require('footer.php') ?>
    <script src="js/chart.js"></script>
</body>

</html>
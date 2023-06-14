<!DOCTYPE html>

<html lang="en">
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

<head>

    <?php require('head.php') ?>
    <title>Document</title>
    
</head>

<body>
    <?php require('aside.php') ?>
    <main>
        <div class="top-main">
            <div class="title">

                <h2>LIVE ENTRY</h2>

                <h5>Real time tracking of card scans</h5>

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

        <table class="table table-striped">

            <thead>

                <tr>
                    <th class="col"> Card ID </th>
                    <th class="col" style="text-transform:uppercase;"> session name </th>
                    <th class="col"> student ID </th>

                    <th class="col"> Full Name </th>

                    <th class="col"> timestamp </th>

                </tr>

            </thead>

            <tbody id="logTable">



            </tbody>

        </table>

    </main>





    <?php require('footer.php') ?>
    <script>
        const Tbody = document.getElementById('logTable');
        var lastID;
        function getall() {
            $.ajax({
                url: 'php/logData.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.length > 0) {
                        if (Tbody.querySelectorAll('tr').length == 0) {
                            Tbody.innerHTML = `<tr><td colspan='4'>No students found.</td></tr>`
                        } else {
                            Tbody.innerHTML = ''
                            for (let i = 0; i < data.length; i++) {
                                let row = `<tr>
                                <td>` + data[i].card_id + `</td>
                            <td>` + data[i].nom_session + `</td>
                            <td>` + data[i].student_id + `</td>
                            <td>` + data[i].nom_complete + `</td>
                            <td>` + data[i].scan_time + `</td>
                            </tr>`;

                                Tbody.innerHTML += row; // Add the new row to the top of the table

                                lastID = data[0].scan_id
                                if (Tbody.querySelectorAll('tr').length == 10) {
                                    break
                                }
                            }
                        }

                    }else{
                        Tbody.innerHTML = `<tr><td colspan='4'>No Entries found.</td></tr>`
                    }





                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Error: ' + textStatus);
                }
            });
        }
        getall();


        setInterval(function () {
            //console.log(Tbody.innerHTML)
            
            if (!(lastID == undefined)) {

                $.ajax({
                    url: 'php/logData.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        lastID: lastID,
                    },
                    success: function (data) {

                        
                        $.each(data, function (index, row) {
                            if (row.scan_id > lastID) {
                                let ro = `<tr>
                                <td>` + row.card_id + `</td>
                        <td>` + row.nom_session + `</td>
                        <td>` + row.student_id + `</td>
                        <td>` + row.nom_complete + `</td>
                        <td>` + row.scan_time + `</td>
                        </tr>`;

                                Tbody.innerHTML = ro + Tbody.innerHTML;
                                lastID = row.scan_id;



                            }

                            if (Tbody.querySelectorAll('tr').length > 10) {
                                Tbody.querySelectorAll('tr')[10].remove()
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus);
                    }
                });
            } else {
                getall()
            }

        }, 250);

    </script>



</body>

</html>
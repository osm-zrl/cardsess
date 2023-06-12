<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>Presence Log</title>

    <style>
        .filter {
            display: flex;
            align-items: center;
            width: 80%;
            gap: 2rem;
        }

        .filter select,
        .filter input {
            width: 49.5%;
        }
    </style>
</head>

<body>
    <aside>
        <?php include('aside.php'); ?>
    </aside>

    <main>

        <div class="top-main">
            <div class="title">
                <h2>Presence Log</h2>
                <h5>All time Card Scans</h5>
            </div>
        </div>


        </div>
        <div class="filter">
            <input type="text" placeholder="Search..." class="search-input">
            <input type='date' id="date" name="date">
            <select name="time" id="time">
                <option selected value="">Select Time Period</option>
                <option value="1">08:30 - 11:00</option>
                <option value="2">11:00 - 13:30</option>
                <option value="3">13:30 - 15:00</option>
                <option value="4">15:00 - 18:30</option>
            </select>
            <select name="class" id="class">
                <option selected value="">Select Class</option>

                <?php
                    $sql = "SELECT * FROM classe";
                    $res = $conn->query($sql);
                    while($row = $res->fetch_assoc()){

                ?>
                    <option value="<?php echo $row['class_id'] ?>"><?php echo $row['name'].' '.$row['level'] ?></option>
                

                <?php 
                }?>
            </select>

        </div>

        <!--Table--->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col">CARD'S ID</th>
                    <th class="col">STUDENT'S ID</th>
                    <th class="col">STUDENT'S FULLNAME</th>
                    <th class="col">CLASS NAME</th>
                    <th class="col">TIMESTAMP</th>
                </tr>
            </thead>
            <tbody id="logTable">

            </tbody>
        </table>
    </main>
    <?php require('footer.php') ?>

    <script>
        $.ajax({
            url: 'php/search_log.php',
            type: 'POST',
            success: function (response) {
                if (response.length == 0) {
                    $('#logTable').html(
                        `<tr>
                                <td colspan="5">No Log Data Detected</td>
                                </tr>`
                    )
                } else {
                    $('#logTable').html("")
                    response.forEach(e => {
                        $('#logTable').append(
                            `<tr>
                                <td>`+ e.card_id + `</td>
                                <td>`+ e.student_id + `</td>
                                <td>`+ e.nom_complete + `</td>
                                <td>`+ e.class_name + `</td>
                                <td>`+ e.scan_time + `</td>
                            </tr>`
                        )
                    })
                }
            },
            error: function (xhr, status, error) {

            }
        });
        $(document).ready(function () {

            $('#date, #time, #class').on('change', function () {
                var dateFilter = $('#date').val();
                var timeFilter = $('#time').val();
                var classFilter = $('#class').val();
                console.log(classFilter)
                $.ajax({
                    url: 'php/search_log.php',
                    type: 'POST',
                    data: { 'date': dateFilter,
                         'time': timeFilter ,
                         'class':classFilter
                        },
                    success: function (response) {
                        console.log(response)
                        
                        if (response.length == 0) {
                            $('#logTable').html(
                                `<tr>
                                <td colspan="5">No Log Data Detected</td>
                                </tr>`
                            )
                        } else {
                            $('#logTable').html("")
                            response.forEach(e => {
                                $('#logTable').append(
                                    `<tr>
                                <td>`+ e.card_id + `</td>
                                <td>`+ e.student_id + `</td>
                                <td>`+ e.nom_complete + `</td>
                                <td>`+ e.class_name + `</td>
                                <td>`+ e.scan_time + `</td>
                            </tr>`
                                )
                            })
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });

            });
        });
    </script>

</body>

</html>
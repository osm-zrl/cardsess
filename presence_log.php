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

        .loader {
            position: relative;
            width: 54px;
            height: 54px;
            border-radius: 10px;
        }

        .loader div {
            width: 8%;
            height: 24%;
            background: rgb(128, 128, 128);
            position: absolute;
            left: 50%;
            top: 30%;
            opacity: 0;
            border-radius: 50px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            animation: fade458 1s linear infinite;
        }

        @keyframes fade458 {
            from {
                opacity: 1;
            }

            to {
                opacity: 0.25;
            }
        }

        .loader .bar1 {
            transform: rotate(0deg) translate(0, -130%);
            animation-delay: 0s;
        }

        .loader .bar2 {
            transform: rotate(30deg) translate(0, -130%);
            animation-delay: -1.1s;
        }

        .loader .bar3 {
            transform: rotate(60deg) translate(0, -130%);
            animation-delay: -1s;
        }

        .loader .bar4 {
            transform: rotate(90deg) translate(0, -130%);
            animation-delay: -0.9s;
        }

        .loader .bar5 {
            transform: rotate(120deg) translate(0, -130%);
            animation-delay: -0.8s;
        }

        .loader .bar6 {
            transform: rotate(150deg) translate(0, -130%);
            animation-delay: -0.7s;
        }

        .loader .bar7 {
            transform: rotate(180deg) translate(0, -130%);
            animation-delay: -0.6s;
        }

        .loader .bar8 {
            transform: rotate(210deg) translate(0, -130%);
            animation-delay: -0.5s;
        }

        .loader .bar9 {
            transform: rotate(240deg) translate(0, -130%);
            animation-delay: -0.4s;
        }

        .loader .bar10 {
            transform: rotate(270deg) translate(0, -130%);
            animation-delay: -0.3s;
        }

        .loader .bar11 {
            transform: rotate(300deg) translate(0, -130%);
            animation-delay: -0.2s;
        }

        .loader .bar12 {
            transform: rotate(330deg) translate(0, -130%);
            animation-delay: -0.1s;
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
            <input type="search" placeholder="Search by CEF..." id="student_id" class="search-input">
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
                while ($row = $res->fetch_assoc()) {

                    ?>
                    <option value="<?php echo $row['class_id'] ?>"><?php echo $row['name'] . ' ' . $row['level'] ?></option>


                    <?php
                } ?>
            </select>
            <div class="loader">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
                <div class="bar5"></div>
                <div class="bar6"></div>
                <div class="bar7"></div>
                <div class="bar8"></div>
                <div class="bar9"></div>
                <div class="bar10"></div>
                <div class="bar11"></div>
                <div class="bar12"></div>
            </div>

        </div>

        <!--Table--->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col">CARD'S ID</th>
                    <th class="col">STUDENT'S ID</th>
                    <th class="col">STUDENT'S FULLNAME</th>
                    <th class="col">CLASSROOM</th>
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
            $('.loader').hide()
            let Ajevent = $('#date, #time, #class').on('change', function () {

                var student_id = $('#student_id').val()

                var dateFilter = $('#date').val();
                var timeFilter = $('#time').val();
                var classFilter = $('#class').val();
                $.ajax({
                    url: 'php/search_log.php',
                    type: 'POST',
                    data: {
                        'student_id': student_id,
                        'date': dateFilter,
                        'time': timeFilter,
                        'class': classFilter
                    },
                    beforeSend:function(){
                        $('.loader').show()
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

                    },
                    complete:function(){
                        $('.loader').hide()
                    }
                });

            });
            $('#student_id').bind('input', function () {
                $('#date, #time, #class').trigger('change')
            });
        });



    </script>

</body>

</html>
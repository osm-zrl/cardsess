<!DOCTYPE html>
<html lang="en">

<?php
require('dbconfig.php');
if (isset($_GET['class_id'])) {
    define('class_id', $_GET['class_id']);
    $sql = "SELECT * FROM classe WHERE class_id=" . class_id;
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        header('location:class.php');
    }
    $row = $result->fetch_assoc();

} else {
    header('location:class.php');
}
?>

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>
        <?= $row['name'] . ' ' . $row['level'] ?> time table
    </title>

</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
    <main>
        <div class="top-main">
            <div class="title">
                <h2>
                    <?= $row['name'] . ' ' . $row['level'] ?>
                </h2>
            </div>
            <div class="cards d-flex justify-content-end">
                <div class="card" style="max-width:300px;">
                    <i class="fa-solid fa-clock"></i>
                    <div class="card-text">
                        <span id="weekly_seasons">

                        </span>
                        <p>Weekly Sessions</p>
                    </div>
                </div>

            </div>
        </div>
        </div>

        <div class="link-div">
            <a href="#" id="modifyWS">Modify weekly Sessions</a>
        </div>
        <!-- table -->

        <table class="table table-bordered shadow">
            <thead>
                <tr>
                    <th colspan="5">weekly sessions</th>
                </tr>
                <tr class="bg-dark text-light">
                    <th class="col">days</th>
                    <th class="col"> 08:30 - 10:50 </th>
                    <th class="col"> 10:50 - 13:30 </th>
                    <th class="col"> 13-30 - 15:50 </th>
                    <th class="col"> 16:10 - 18:30 </th>
                </tr>
            </thead>
            <tbody id="Tbody">
                <tr class="day_table">
                    <td>Monday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="day_table">
                    <td>Tuesday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="day_table">
                    <td>Wednesday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="day_table">
                    <td>Thursday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="day_table">
                    <td>Friday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="day_table">
                    <td>Saturday</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </tbody>
        </table>

        <table class="table table-bordered shadow">
            <thead>
                <tr>
                    <th colspan="4">today's open sessions</th>
                </tr>
                <tr class="bg-dark text-light">
                    <th class="col"> 08:30 - 10:50 </th>
                    <th class="col"> 10:50 - 13:30 </th>
                    <th class="col"> 13-30 - 15:50 </th>
                    <th class="col"> 16:10 - 18:30 </th>
                </tr>
            </thead>
            <tbody id="Tbody2" style="height:40px;">
                <tr id="todaysSessions">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <script>


            function getTimeTables() {
                $.ajax({
                    url: "php/time_table_api.php",
                    data: {
                        'class_id': <?= class_id ?>,
                    },
                    beforeSend: function () {

                    }, success: function (response) {
                        $('#weekly_seasons').html(response.length)
                        for (let i = 0; i < 6; i++) {
                            let days_schedule = []

                            response.forEach(function (el) {

                                if (el.day == i) {
                                    let columns = $('.day_table')[i].children

                                    if (el.time_start == '08:30:00') {
                                        if (el.time_end == '10:50:00') {
                                            columns[1].innerHTML = el.module
                                        } else if (el.time_end == '13:30:00') {
                                            columns[1].innerHTML = el.module
                                            columns[1].setAttribute('colspan', 2)
                                            columns[2].remove()
                                        }
                                    } else if (el.time_start == '10:50:00') {
                                        columns[2].innerHTML = el.module
                                    } else if (el.time_start == '13:30:00' && columns.length == 4) {
                                        if (el.time_end == '15:50:00') {
                                            columns[2].innerHTML = el.module
                                        } else if (el.time_end == '18:30:00') {
                                            columns[2].innerHTML = el.module
                                            columns[2].setAttribute('colspan', 2)
                                            columns[3].remove()
                                        }
                                    } else if (el.time_start == '13:30:00' && columns.length == 5) {
                                        if (el.time_end == '15:50:00') {
                                            columns[3].innerHTML = el.module
                                        } else if (el.time_end == '18:30:00') {
                                            columns[3].innerHTML = el.module
                                            columns[3].setAttribute('colspan', 2)
                                            columns[4].remove()
                                        }
                                    } else if (el.time_start == '15:50:00') {
                                        columns[columns.length - 1].innerHTML = el.module
                                    }
                                }
                            })



                        }
                        $('.day_table').each(function () {
                            let element = this
                            if (element.children.length == 1) {
                                $(element).append(`<td></td><td></td><td></td><td></td>`)
                            }
                        })
                    }, error: function (err) {
                        console.log(err)
                    }, complete: function () {

                    }
                })
            }
            function formatTime(date) {
                var hours = date.getHours().toString().padStart(2, '0');
                var minutes = date.getMinutes().toString().padStart(2, '0');
                var seconds = date.getSeconds().toString().padStart(2, '0');
                return hours + ':' + minutes + ':' + seconds;
            }

            function getTodaysSessions() {
                $.ajax({
                    url: "php/sessions_api.php",
                    data: {
                        'class_id': <?= class_id ?>,
                        'date': '2023-06-14',
                    },
                    beforeSend: function () {

                    }, success: function (response) {
                        let columns = $('#todaysSessions td')

                        response.forEach(function (el) {

                            let date_start = new Date(el.date_start)
                            el.time_start = formatTime(date_start)

                            let date_end = new Date(el.date_end)
                            el.time_end = formatTime(date_end)

                            if (el.time_start == '08:30:00') {
                                if (el.time_end == '10:50:00') {
                                    columns[0].innerHTML = el.nom_session
                                } else if (el.time_end == '13:30:00') {
                                    columns[0].innerHTML = el.nom_session
                                    columns[0].setAttribute('colspan', 2)
                                    columns[1].remove()
                                }
                            } else if (el.time_start == '10:50:00') {
                                columns[1].innerHTML = el.nom_session
                            } else if (el.time_start == '13:30:00' && columns.length == 3) {
                                if (el.time_end == '15:50:00') {
                                    columns[1].innerHTML = el.nom_session
                                } else if (el.time_end == '18:30:00') {
                                    columns[1].innerHTML = el.nom_session
                                    columns[1].setAttribute('colspan', 2)
                                    columns[2].remove()
                                }
                            } else if (el.time_start == '13:30:00' && columns.length == 4) {
                                if (el.time_end == '15:50:00') {
                                    columns[2].innerHTML = el.nom_session
                                } else if (el.time_end == '18:30:00') {
                                    columns[2].innerHTML = el.nom_session
                                    columns[2].setAttribute('colspan', 2)
                                    columns[3].remove()
                                }
                            } else if (el.time_start == '15:50:00') {
                                columns[columns.length - 1].innerHTML = el.nom_session
                            }
                        })

                    }, error: function (err) {
                        console.log(err)
                    }, complete: function () {

                    }
                })
            }
            $(document).ready(function () {
                getTimeTables()
                getTodaysSessions()
            })
        </script>
    </main>
    <?php require('footer.php'); ?>
</body>

</html>
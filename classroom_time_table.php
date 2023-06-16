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
    ?>
    <title>
        <?= $row['name'] . ' ' . $row['level'] ?> time table
    </title>
    <style>
        
    </style>

</head>

<body>
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
    <div id="black_layer" style="right:-100vw;"></div>
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
            <a href="#" id="modifyWS" onclick="togglecard()">ADD weekly Sessions</a>
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
                    <th class="col"> 13:30 - 15:50 </th>
                    <th class="col"> 15:50 - 18:30 </th>
                </tr>
            </thead>
            <tbody id="Tbody" class="text-capitalize">
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
                    <th class="col"> 13:30 - 15:50 </th>
                    <th class="col"> 15:50 - 18:30 </th>
                </tr>
            </thead>
            <tbody id="Tbody2" class="text-capitalize" style="height:40px;">
                <tr id="todaysSessions">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>


        <!-- MODIFY WEEKLY SESSIONS MODAL -->
        <div id="addstudent" style="min-width:400px!important;" class="form hidden">
            <div class="blocktitle">
                <h4>Add weekly session</h4>
                <i class="fa-solid fa-xmark" onclick="togglecard()"></i>
            </div>
            <div style="box-sizing:border-box;">
                <div id="addWS_msg"></div>
                <label class="form-label">module:</label>
                <input type="text" class="form-control" placeholder="module title ..." name="module_title">

                <label class="form-label">week day:</label>
                <select name="weekday" class="form-select">
                    <option selected hidden disabled>select week day</option>
                    <option value="0">Monday</option>
                    <option value="1">Tuesday</option>
                    <option value="2">Wednesday</option>
                    <option value="3">Thursday</option>
                    <option value="4">Friday</option>
                    <option value="5">Saturday</option>
                </select>

                <label class="form-label">start time</label>
                <select class="form-select" name="t_start">
                    <option selected hidden disabled>select start hour</option>
                    <option value="08:30:00"> 08:30 </option>
                    <option value="10:50:00"> 10:50 </option>
                    <option value="13:30:00"> 13:30 </option>
                    <option value="15:50:00"> 15:50 </option>
                </select>
                <label class="form-label">end time</label>
                <select class="form-select" name="t_end" class="border border-danger">
                    <option selected hidden disabled>select end hour</option>
                    <option value="10:50:00"> 10:50 </option>
                    <option value="13:30:00"> 13:30 </option>
                    <option value="15:50:00"> 15:50 </option>
                    <option value="18:30:00"> 18:30 </option>
                </select>

                <button class="d-block mx-auto my-2" type="button" style="min-width:150px;"
                    id="submitBTN">SUBMIT</button>
            </div>


        </div>
    </main>

    <script>
        $('#submitBTN').click(function () {

            $('#addWS_msg').html(' ')
            let weekday = $('select[name="weekday"]').val()
            let m_title = $('input[name="module_title"]').val()
            let t_start = $('select[name="t_start"]').val()
            let t_end = $('select[name="t_end"]').val()

            if (m_title.trim() == '' || m_title.trim() == null || t_start == null || t_end == null || weekday == null) {
                $('#addWS_msg').html(
                    `
                    <div class="alert alert-info" role="alert">
                    all info must be filled correctly
</div>

                    
                    `

                )
            } else if (String(t_start) == String(t_end)) {
                $('#addWS_msg').html(
                    `
                    <div class="alert alert-warning" role="alert">
                    <strong>start</strong> time and <strong>end</strong> time must be different!
</div>

                    
                    `)
            } else {
                $.ajax({
                    url: 'php/time_table_api.php',
                    method: 'POST',
                    data: {
                        'class_id':<?= class_id ?>,
                        't_module': m_title,
                        't_start': t_start,
                        't_end': t_end,
                        'weekday': weekday,
                    },
                    beforeSend: function () {

                    },
                    success: function (response) {
                        console.log(response)
                        $('#addWS_msg').html(
                            `
                    <div class="alert alert-`+ response[1].color + `" role="alert">
                    `+ response[0].msg + `
</div>

                    
                    `)
                        if (response[1].color == 'success') {
                            $('#Tbody').html(
                                `<tr class="day_table">
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
                </tr>`
                            )
                            getTimeTables()
                            $('select[name="weekday"]').val('')
                            $('input[name="module_title"]').val('')
                            $('select[name="t_start"]').val('')
                            $('select[name="t_end"]').val('')
                            togglecard()
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }, complete: function () {

                    }
                })
            }


        })
    </script>

    <!-- AJAX SCRIPTS -->
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
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;
            $.ajax({
                url: "php/sessions_api.php",
                data: {
                    'class_id': <?= class_id ?>,
                    'date': formattedDate,
                },
                beforeSend: function () {

                }, success: function (response) {
                    let columns = $('#todaysSessions td')

                    if (response.length > 0) {
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
                    } else {
                        $('#todaysSessions').html(`<td colspan="4">No sessions today</td>`)
                    }

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
    <?php require('footer.php'); ?>
</body>

</html>
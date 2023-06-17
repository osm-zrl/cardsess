<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('head.php');
    require('dbconfig.php'); ?>
    <title>Manage Sessions</title>
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
    <?php require('aside.php'); ?>
    <!-- top main title + statics cards  -->
    <main>

        <div class="top-main">
            <div class="title">
                <h2>Sessions history</h2>
                <h5>manage all previous sessions</h5>
            </div>
            <!-- <div class="cards">
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
            </div> -->
        </div>
        <div class="link-div">
            <!--             <a href="#" class="d-block mx-auto me-0" onclick="toggleAddStudent()" id="addstudentbtn">Add Student</a>
 -->
        </div>

        <div class="filter">
            <input type='date' id="date" name="date">
            <select name="class_id" id="class">
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

        <table class="table table-bordered table-hover shadow">
            <thead>

                <tr class="bg-dark text-light">
                    <th class="col"> nom session </th>
                    <th class="col"> classroom name </th>
                    <th class="col"> date started </th>
                    <th class="col"> date end </th>
                    <th class="col"> Presence Rate </th>

                </tr>
            </thead>
            <tbody id="prev_Tbody">

            </tbody>
        </table>

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
    <script>
        $('searchBtn').click(function () {

        })


        $(document).ready(function () {
            setMaxDate()
            $('#date, #class').on('change', function () {
                getAllSessions()
            })
            function getAllSessions() {
                $('.loader').hide()
                var dateFilter = $('#date').val();
                var classFilter = $('#class').val();
                $.ajax({
                    url: 'php/presessions_api.php',
                    method: 'GET',
                    data: {
                        'date': dateFilter,
                        'class': classFilter,
                    },
                    beforeSend: function () {
                        //$('.loader').show()
                    },
                    success: function (response) {
                        console.log(response)
                        $('#prev_Tbody').html('')

                        if (response.length == 0) {
                            $('#prev_Tbody').html(
                                `<tr><td colspan="5"> No Previous Sessions</td></tr>`
                            )
                        } else {
                            response.forEach(el => {
                                $('#prev_Tbody').append(
                                    `
                                    <tr id_session="`+ el.id_session + `">
                                    <td>`+ el.nom_session + `</td>
                                    <td>`+ el.class_name + `</td>
                                    <td>`+ el.date_start + `</td>
                                    <td>`+ el.date_end + `</td>
                                    <td>`+ el.present + `</td>
                                    
                                    </tr>
                                    `
                                )
                            })
                        }

                    }, error: function (err) {
                        console.log(err)
                    }, complete: function () {
                        //$('.loader').hide()
                    }
                })
            }
            getAllSessions()
        })
    </script>
    <script>
        // Get today's date in the format "YYYY-MM-DD"
        function getTodayDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var day = String(today.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        // Set the max attribute of the date input to today's date
        function setMaxDate() {
            var todayDate = getTodayDate();
            document.getElementById('date').setAttribute('max', todayDate);
        }
    </script>
    <?php require('footer.php') ?>
</body>

</html>
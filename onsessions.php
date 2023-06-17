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
                    <th class="col"> date ending </th>
                    <th class="col"> Presence Rate </th>

                </tr>
            </thead>
            <tbody id="prev_Tbody">

            </tbody>
        </table>

        
    </main>
    <script>
        $('searchBtn').click(function () {

        })


        $(document).ready(function () {
            $(' #class').on('change', function () {
                getAllSessions()
            })
            function getAllSessions() {
                $('.loader').hide()
                var dateFilter = $('#date').val();
                var classFilter = $('#class').val();
                $.ajax({
                    url: 'php/onsessions_api.php',
                    method: 'GET',
                    data: {
                        'class_id': classFilter,
                    },
                    beforeSend: function () {
                        $('.loader').show()
                    },
                    success: function (response) {
                        console.log(response)
                        $('#prev_Tbody').html('')

                        if (response.length == 0) {
                            $('#prev_Tbody').html(
                                `<tr><td colspan="5"> No Ongoing Sessions</td></tr>`
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
                        $('#prev_Tbody').html(
                                `<tr><td colspan="5"> failed to load sessions</td></tr>`
                            )
                    }, complete: function () {
                        $('.loader').hide()
                    }
                })
            }
            getAllSessions()
        })
    </script>
    
    <?php require('footer.php') ?>
</body>

</html>
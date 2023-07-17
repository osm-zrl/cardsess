<?php

require('dbconfig.php');
if (isset($_GET['session_id'])) {


    // retrieve the student_id parameter from the URL
    $session_id = trim($_GET['session_id']);
    if ($session_id == '') {

        //header('location:presessions.php');
    }
    // retrieve the current student information from the database
    $query = "SELECT sessions.*,concat(classe.name,' ',classe.level) as class_name FROM sessions JOIN classe ON sessions.class_id = classe.class_id WHERE id_session='$session_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        header('location:students.php');
    }
    $row = $result->fetch_assoc();

    // pre-populate the form fields with the student's current data
    $nom_session = $row['nom_session'];
    $date_s = $row['date_start'];
    $date_e = $row['date_end'];
    $class_name = $row['class_name'];
    $class_id = $row['class_id'];



    

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php require('head.php'); ?>
        <title>main</title>
        <link rel="stylesheet" href="css/student.css">
        <style>
            /* student edit */
            .information {
                background: white;
                height: fit-content;
                border-radius: 12px;
                margin: 0rem;
                padding: 2rem;
                color: black;
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .information h4 {
                font-size: 1rem;
                margin: 0;
                font-weight: lighter;
                color: var(--grey-color);
                padding: 10px 0;
                background-color: var(--third-color);
                padding-left: 5px;
            }

            .information h6 {
                margin: auto;
                padding: 10px 0;

            }

            .col input {
                width: 100%;
            }

            .col select#gender,
            .col select#classe {
                width: 100%;
            }

            .information .col {
                display: flex;
                flex-direction: column;
                padding: 0;
                background-color: var(--grey-color);

            }

            #edit {
                font-weight: bold;
            }

            .student_card {
                height: 80px;
                font-size:20px;

            }
        </style>
    </head>

    <body>
        <?php require('aside.php'); ?>
        <!-- top main title + statics cards  -->
        <main>
            <div id="black_layer" style="right:-100vw;"></div>
            <h2 class="text-uppercase py-4">
                        <?= $nom_session ?>
                    </h2>
            <div class="information">
                <div class="row">
                    <div class="col">
                        <h4 class="text-uppercase">class room :</h4>
                        <h6>
                        <?= $class_name ?>
                        </h6>
                    </div>
                </div>
                <div class="row gap-3">
                    <div class="col">
                        <h4 class="text-uppercase">date started :</h4>
                        <h6>
                        <?= $date_s ?>
                        </h6>
                    </div>
                    <div class="col">
                        <h4 class="text-uppercase">date ended :</h4>
                        <h6>
                        <?= $date_e ?>
                        </h6>
                    </div>
                </div>


            </div>
            <div class='row' style="margin: 0rem;gap: 2rem;">
                <?php 
                $sql = "SELECT * FROM student WHERE class_id ='$class_id'";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $student_id = $row['student_id'];
                    $sql = "SELECT log_history.card_id FROM log_history JOIN cards ON log_history.card_id = cards.card_id JOIN student ON student.student_id = cards.student_id WHERE student.student_id = '$student_id' AND session_id = '$session_id'";
                    $res = $conn->query($sql);
                    if ($res->num_rows>0){
                        $stat = '<span class="badge text-bg-success">Present</span>';
                    }else{
                        $stat = '<span class="badge text-bg-danger">Absent</span>';
                    }
                ?>
                    <div style="cursor:pointer;" onclick="redirect_sess(this)" id_student="<?= $student_id ?>" class="rounded shadow col-12 bg-light student_card p-4">
                        <div class="d-flex flex-row justify-content-evenly">
                            <p><?= $student_id ?></p>
                            <p style="width:40%;" class="text-center"><?= $row['first_name'].' '.$row['last_name']  ?></p>
                            <?= $stat?>
                        </div>
                    </div>

                <?php
                }?>
            </div>
            <!-- modal -->
            <!-- <div id="disableCard" class="form hidden">
                <div class="blocktitle">
                    <i class="fa-solid fa-xmark" onclick="toggleDisablecard()"></i>
                </div>

                <div style="box-sizing:border-box;">
                    <p class="text-capitalize">are you sure you want to desactivate/activate this card?</p>
                    <div class="d-flex justify-content-end gap-2 pt-3">
                        <button class="btn btn-secondary" onclick="toggleDisablecard()">No</button>
                        <button class="btn btn-warning" id="disableBtn" onclick="disableCard(this)" card_id=""
                            card_stat="">Yes</button>
                    </div>

                </div>


            </div> -->

        </main>
        <script>
        function redirect_sess(card){
            let id = $(card).attr("id_student")
            
            location.assign("student_info.php?student_id="+id)
        }
        </script>
        <?php require('footer.php'); ?>
                

    </body>

    </html>


    <?php
    $conn->close();
} else {
    //header('location:presessions.php');
} 
$conn->close();?>
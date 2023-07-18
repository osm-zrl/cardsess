<?php

require('dbconfig.php');
if (isset($_GET['student_id'])) {


    // retrieve the student_id parameter from the URL
    $student_id = trim($_GET['student_id']);
    if ($student_id == '') {
        
        header('location:students.php');
    }
    // retrieve the current student information from the database
    $query = "SELECT student.*,concat(classe.name,' ',classe.level) as class_name FROM student JOIN classe ON student.class_id=classe.class_id WHERE student_id = '$student_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 0) {
        header('location:students.php');
    }
    $row = $result->fetch_assoc();

    // pre-populate the form fields with the student's current data
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $birthday = $row['birthday'];
    $gender = $row['gender'];
    $class_id = $row['class_name'];

    $sql = "SELECT sessions.id_session from sessions JOIN classe ON sessions.class_id = classe.class_id JOIN student ON student.class_id = classe.class_id WHERE student.student_id = '$student_id'";
    $ros = $conn->query($sql);
    $all_sessions = [];
    while($r = $ros->fetch_column()){
        $all_sessions[]=$r;
    }
    
    $sql = "SELECT log_history.session_id FROM log_history JOIN cards ON log_history.card_id = cards.card_id WHERE cards.student_id = '$student_id'";
    $ros = $conn->query($sql);
    $attended_sessions = [];
    while($r = $ros->fetch_column()){
        $attended_sessions[]=$r;
    }
    $unattended = array_diff($all_sessions,$attended_sessions);
    unset($all_sessions,$attended_sessions);

    

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php require('head.php'); ?>
        <title><?= $last_name . " ".$first_name?></title>
        <link rel="stylesheet" href="css/student.css">
    </head>

    <body>
        <?php require('aside.php'); ?>
        <!-- top main title + statics cards  -->
        <main>
            <div id="black_layer" style="right:-100vw;"></div>
            <div class="top-main">
                <div class="title">
                    <h2 class="text-capitalize">
                        <?php echo $first_name . " " . $last_name; ?>
                    </h2>
                </div>
            </div>
            <button class="d-block mx-auto me-0" type="submit" id="edit">Edit Infos</button>
            <div class="information">
                <div class="row">
                    <div class="col">
                        <h4>CEF :</h4>
                        <h6>
                            <?php echo $student_id; ?>
                        </h6>
                    </div>
                </div>
                <div class="row gap-3">
                    <div class="col">
                        <h4>First Name :</h4>
                        <h6>
                            <?php echo $first_name; ?>
                        </h6>
                    </div>
                    <div class="col">
                        <h4>Last Name :</h4>
                        <h6>
                            <?php echo $last_name; ?>
                        </h6>
                    </div>
                </div>
                <div class="row gap-3">
                    <div class="col">
                        <h4>Birthday :</h4>
                        <h6>
                            <?php echo $birthday; ?>
                        </h6>
                    </div>
                    <div class="col">
                        <h4>Gender :</h4>
                        <h6>
                            <?php echo $gender; ?>
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Classroom :</h4>
                        <h6>
                            <?php echo $class_id; ?>
                        </h6>
                    </div>
                </div>
                <div class="row table-responsive">
                    <h4>Associated Cards :</h4>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">CARD ID</th>
                                <th scope="col">CARD ACTIVE</th>
                            </tr>
                        </thead>
                        <tbody id="cardsTableB">

                        </tbody>
                    </table>
                </div>
                <div class="row table-responsive">
                    <h4>Missed Sessions (<?= count($unattended)?>) :</h4>
                    <table class="table table-bordered table-hover">
                        <tbody id="cardsTable">
                            <?php 
                            
                            if (count($unattended)!=0){

                            
                                foreach($unattended as $s){
                                    $sql = "SELECT id_session,nom_session,DATE(date_start) as d FROM sessions WHERE id_session = '$s'";
                                    $ros = $conn->query($sql);
                                    while($r = $ros->fetch_assoc()){
                                ?>
                                    <tr id_session ="<?= $r['id_session'] ?>"  onclick="redirect_session(this)" style="cursor:pointer;">
                                        <td class="text-capitalize"><?= $r["nom_session"];?></td>
                                        <td><?= $r["d"];?></td> 
                                    </tr>
                                <?php
                                }
                                }
                            }else{
                            ?>
                            <tr>
                                <td colspan = '2' class="text-capitalize">No missed sessions</td>
                            </tr>
                            <?php
                            }?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div id="disableCard" class="form hidden">
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


            </div>

        </main>
        <?php require('footer.php'); ?>
        <script>
            document.getElementById('edit').addEventListener('click', function () {
                location.href = 'edit.php?student_id=<?php echo $student_id; ?>';
            });
        </script>
        <script>
            let Tbody = document.getElementById("cardsTableB")
            function getAllCardsTable() {
                $.ajax({
                    url: 'php/getCardsTableSpecified.php',
                    type: 'POST',
                    data:{'id':<?php echo $student_id?>},
                    success: function (data) {
                        Tbody.innerHTML = ''
                        if (data.length != 0) {
                            for (let i = 0; i < data.length; i++) {
                                switch (data[i].card_active) {
                                    case '0':
                                        card_state = `<i onclick="desCard(this)" style="cursor:pointer; color: #97111e;" card_stat="` + data[i].card_active + `" card_id="` + data[i].card_id + `" class="fa-solid fa-circle-xmark" ></i>`
                                        break
                                    case '1':
                                        card_state = `<i onclick="desCard(this)" style="cursor:pointer; color: #1a7020;" card_stat="` + data[i].card_active + `" card_id="` + data[i].card_id + `" class="fa-solid fa-circle-check" ></i>`
                                        break
                                    default:
                                        card_state = 'default'
                                }
                                let row = `<tr>
                                <td>` + data[i].card_id + `</td>
                                <td>` + card_state + `</td>
                                </tr>`;
                                Tbody.innerHTML += row; // Add the new row to the top of the table

                            }
                        } else {
                            Tbody.innerHTML = `<tr><td colspan="2">No cards found</td></tr>`
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Error: ' + textStatus);
                    }

                })
            }
            getAllCardsTable()
            function desCard(cell) {
                let C_id = cell.getAttribute('card_id')
                let C_stat = cell.getAttribute('card_stat')
                toggleDisablecard()
                $('#disableBtn').attr("card_id", C_id)
                $('#disableBtn').attr("card_stat", C_stat)

            }
            function disableCard(Btn) {
                let C_id = Btn.getAttribute('card_id')
                let C_stat = Btn.getAttribute('card_stat')
                $.ajax({
                    url: 'php/desAndActCard.php',
                    type: 'POST',
                    crossDomain: true,
                    data: {
                        'card_id': C_id,
                        'card_stat': C_stat,

                    },
                    success: function (response) {
                        getAllCardsTable()
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error);
                    }, complete: function () {
                        toggleDisablecard()
                    }

                });
            }
        </script>
        <script>
            function redirect_session(row){
                let id = $(row).attr("id_session")
                location.assign("session.php?session_id="+id)
            }
        </script>
    </body>

    </html>

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
    </style>
    <?php
    $conn->close();
} else {
    header('location:students.php');
} ?>
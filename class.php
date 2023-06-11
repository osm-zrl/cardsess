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
    <?php require('head.php');
    require('dbconfig.php');
    ?>

    <title>classrooms</title>
</head>

<body>
    <aside>
        <?php require('aside.php') ?>
    </aside>

    <main>
        <div id="black_layer" style="right:-100vw;"></div>
        <div class="top-main">
            <div class="title">
                <h2>Manage classes</h2>
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
                        <p>Classrooms</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="link-div">
            <a onclick="toggleAddClass()" href="#">Add Class</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="col">Branche</th>
                    <th class="col">Number</th>
                    <th class="col">Action</th>
                </tr>
            </thead>
            <tbody id="classTableBody">

            </tbody>
        </table>


        <!-- ADD CLASS MODAL -->
        <div id="addClass" class="form hidden">
            <div class="blocktitle">
                <h3> Add Classroom</h3>
                <i class="fa-solid fa-xmark" onclick="toggleAddClass()"></i>
            </div>

            <div class="p-3 d-flex flex-column gap-2" style="box-sizing:border-box;">
                <div id="addclass_popup_msgArea">
                </div>
                <label class="form-label mt-2">classroom branche:</label>
                <select class="form-select" name="name">
                    <option value="" disabled hidden selected>Select branche</option>
                    <option value="Developpement digital">Developpement digital</option>
                    <option value="Gestion des entreprises">Gestion des entreprises</option>
                    <option value="infographie">infographie</option>
                </select>
                <label class="form-label mt-2">class number:</label>
                <input class="form-control" value="101" min="101" name='level' type="number">
                <button class="d-block mx-auto my-2" type="button" style="min-width:150px;" id="submitBTN"
                    onclick="Insert()">SUBMIT</button>

            </div>


        </div>

    </main>
    <?php require('footer.php')?>
    <script>
        function addAlertaddclass(text, color) {
            $('#addclass_popup_msgArea').html(
                `
                <div class="alert alert-`+ color + ` alert-dismissible fade show m-0" role="alert">
                    `+ text + `
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                `
            )
        }
        // Fonction pour charger les données du tableau
        function loadTableData() {
            $.ajax({
                url: 'php/class_api.php',
                method: 'GET',
                success: function (data) {
                    var tableBody = $('#classTableBody');
                    tableBody.empty(); // Efface les données existantes du tableau
                    data.forEach(function (el) {
                        tableBody.append(
                            `<tr>
                            <td>`+ el.name + `</td>
                            <td>`+ el.level + `</td>
                            <td>
                                <button class="btn" id="`+ el.class_id + `" onclick="deleteColumn(this)" ><i style="font-size:1em!important;" class="fa-solid text-secondary fa-trash"></i></button>
                            </td>
                            `
                        )
                    })
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }

        function deleteColumn(btn) {
            let classId = btn.getAttribute('id')
            $.ajax({
                url: 'php/class_api.php',
                method: 'DELET',
                data: { class_id: classId },
                success: function (response) {
                    $('table').before(
                        `
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            `+response+`
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        `
                    )
                    loadTableData();
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }





        function toggleAddClass() {
            $('select[name="name"]').val('')
            $('input[name="level"]').val('')
            let addClass = document.getElementById('addClass');
            if (addClass.classList.contains('hidden')) {
                addClass.classList.remove('hidden');
                addClass.classList.add('displayed');
                black_layer.style.right = 0
            } else {
                addClass.classList.add('hidden');
                addClass.classList.remove('displayed');
                black_layer.style.right = '-100vw'
            }
        }
        function Insert() {
            let name = $('select[name="name"]').val()
            let level = $('input[name="level"]').val()
            name = String(name).trim()
            level = String(level).trim()
            let x = 'sds'.trim()
            if (name == 'null' || level == 'null') {
                addAlertaddclass('empty inputs are not allowed!', 'warning')
            } else {
                $.ajax({
                    url: 'php/class_api.php',
                    method: "POST",
                    data: {
                        'name': name,
                        'level': level,
                    },
                    success: function (res) {
                        console.log(res)
                        if (res.trim() == 'true') {
                            addAlertaddclass('Classroom added successfully', 'success')

                        } else if (res.trim() == 'false') {
                            addAlertaddclass('Classroom already exists', 'danger')
                        }

                    }, error: function (err) {
                        console.log(err)
                    },
                    complete: function () {
                        loadTableData();
                    }
                })
            }

            console.log(name + " " + level)
        }
        $(document).ready(function () {
            loadTableData();
        });
    </script>

</body>

</html>
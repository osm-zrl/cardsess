<?php

require('dbconfig.php');
if (isset($_GET['student_id'])){


    // retrieve the student_id parameter from the URL
    $student_id = trim($_GET['student_id']);
    if ($student_id==''){
        header('location:students.php');
    }
    // retrieve the current student information from the database
    $query = "SELECT student.*,concat(classe.name,' ',classe.level) as class_name FROM student JOIN classe ON student.class_id=classe.class_id WHERE student_id = '$student_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 0){
        header('location:students.php');
    }
    $row = $result->fetch_assoc();

    // pre-populate the form fields with the student's current data
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $birthday = $row['birthday'];
    $gender = $row['gender'];
    $class_id = $row['class_name'];



    $conn->close();

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php require('head.php');?>
        <title>main</title>
        <link rel="stylesheet" href="css/student.css">
    </head>
    <body>
        <?php require('aside.php');?>
        <!-- top main title + statics cards  -->
        <main>

            <div class="top-main">
                <div class="title">
                    <h2>Update Student</h2>
                    <h5>Here you can see all the student informations</h5>
                </div>
            </div>
            <button type="submit" id="edit">Edit Infos</button>
            <div class="information">
                <div class="row">
                    <div class="col">
                        <h4>Student CEF :</h4>
                        <h6><?php echo $student_id; ?></h6>
                    </div>
                </div>
                <div class="row gap-3">
                    <div class="col">
                        <h4>Student First Name :</h4>
                        <h6><?php echo $first_name; ?></h6>
                    </div>
                    <div class="col">
                        <h4>Student Last Name :</h4>
                        <h6><?php echo $last_name; ?></h6>
                    </div>
                </div>
                <div class="row gap-3">
                    <div class="col">
                        <h4>Student Birthday :</h4>
                        <h6><?php echo $birthday; ?></h6>
                    </div>
                    <div class="col">
                        <h4>Student Gender :</h4>
                        <h6><?php echo $gender; ?></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Student Class :</h4>
                        <h6><?php echo $class_id; ?></h6>
                    </div>
                </div>
        </div>

            
        </main>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="js/chart.js"></script>
        <script src="js/script.js"></script>
        <script>
            document.getElementById('edit').addEventListener('click', function() {
            location.href = 'edit.php?student_id=<?php echo $student_id; ?>';
        });
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
    color:var(--grey-color);
    padding:10px 0;
    background-color: var(--third-color);
    padding-left: 5px;
    }
    .information h6{
        margin:auto;
        padding:10px 0;

    }

    .col input {
    width: 100%;
    }

    .col select#gender,.col select#classe {
    width: 100%;
    }

    .information .col {
        display: flex;
        flex-direction: column;
        padding:0;
        background-color: var(--grey-color);
    
    }
    #edit{
        font-weight: bold;
    }
    </style>
<?php
}else{
    header('location:students.php');
  }  ?>
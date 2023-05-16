<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>main</title>

    <style>
        .search-box {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        }

        .search-input {
        padding-right: 40px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        height: 40px;
        outline: none;
        width: 250px;
        }

        .search-button {
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        height: 40px;
        padding: 0;
        margin: 0;
        border: none;
        background: none;
        cursor: pointer;
        }

        .search-button i {
        font-size: 16px;
        color: #aaa;
        }

        .search-button:hover i {
        color: #666;
        }
        .search-box  button:hover {
            color: none;
            background: none;
        }

        .filter {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 80%;
            gap: 2rem;
        }
         select#gender ,select#classe {
        width: 49.5%;
        }

        .filter select#gender ,.filter select#classe {
        width: 35%;
        }

    </style>
</head>
<body>
    <aside>
        <?php include('aside.php'); ?>
    </aside>

    <main>
        <?php require('head.php');
        require('dbconfig.php');?>
        <div class="top-main">
            <div class="title">
                <h2>History</h2>
                <h5>Votre description ici</h5>
            </div>
        </div>

        <!-- <div class="link-div">
            <div class="search-box" id="search-box">
                <input type="text" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button"><i class="fa-solid fa-search"></i></button>
            </div> -->
        </div>
        <div class="filter">
            <select name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <select name="classe" id="classe">
                <option value="">Select Student Group</option>
                <option value="1">Développement digital 101</option>
                <option value="2">Développement digital 102</option>
                <option value="3">gestion entreprise 101</option>
                <option value="4">gestion entreprise 102</option>
                <option value="5">infographie</option>
            </select>
            <div class="search-box" id="search-box">
                <input type="text" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button"><i class="fa-solid fa-search"></i></button>
            </div>
        </div>

        <!--Table--->
        <table>
            <thead>
                <tr>
                    <th class="col">CARD'S ID</th>
                    <th class="col">STUDENT'S ID</th>
                    <th class="col">STUDENT'S FULLNAME</th>
                    <th class="col">TIMESTAMP</th>
                </tr>
            </thead>
            <tbody id="logTable">
                <?php
                require('dbconfig.php');
                if ($conn->connect_errno) {
                    die('Échec de la connexion au serveur!');
                }
                $sql = "SELECT log_history.scan_id, log_history.card_id, cards.student_id, CONCAT(student.first_name, ' ', student.last_name) as nom_complet, log_history.scan_time FROM log_history JOIN cards ON cards.card_id = log_history.card_id JOIN student ON cards.student_id = student.student_id ORDER BY log_history.scan_time DESC;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row as a table row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['card_id'] . "</td>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['nom_complet'] . "</td>";
                        echo "<td>" . $row['scan_time'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // output message if no rows are returned
                    echo "<tr><td colspan='4'>No students found.</td></tr>";
                }
                $result->free();
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
<?php require('footer.php')?>

<script>
    $(document).ready(function() {
    $('.search-input').on('input', function() {
        var searchValue = $(this).val();
        var genderFilter = $('#gender').val();
        var classFilter = $('#classe').val();
        $.ajax({
        url: 'php/search_students.php',
        type: 'POST',
        data: { searchValue: searchValue, genderFilter: genderFilter, classFilter: classFilter },
        success: function(response) {
            $('#table-body').html(response);
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
        }
        });
    });
    $('#gender, #classe').on('change', function() {
        $('.search-input').trigger('input');
    });
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php');
    require('dbconfig.php');?>
    <title>main</title>
</head>
<body>
<aside>
<?php include('aside.php'); ?>
</aside>
<main>
    <div class="top-main">
            <div class="title">
                <h2>History</h2>
                <h5>Votre description ici</h5>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="col">ID du scan</th>
                    <th class="col">ID de la carte</th>
                    <th class="col">ID de l'étudiant</th>
                    <th class="col">Nom complet de l'étudiant</th>
                    <th class="col">Date et heure du scan</th>
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
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['scan_id'] . "</td>";
                        echo "<td>" . $row['card_id'] . "</td>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['nom_complet'] . "</td>";
                        echo "<td>" . $row['scan_time'] . "</td>";
                        echo "</tr>";
                    }
                    $result->free();
                    $conn->close();
                ?>
            </tbody>
        </table>
    </main>
    <? require('footer.php')?>
</body>
</html>
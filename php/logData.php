<?php
require('dbconfig.php');
if ($conn->connect_errno) {
    die('echec de connecter au serveur!');
}
if (isset($_GET['lastID'])) {
    $lastID = $_GET['lastID'];
    $sql = "SELECT log_history.logID,log_history.cardUID, carte.etuCEF, concat(etudiant.etuNom,' ',etudiant.etuPrenom) as nom_complete, log_history.datetime FROM log_history JOIN carte ON carte.cardUID = log_history.cardUID JOIN etudiant ON carte.etuCEF = etudiant.etuCEF WHERE logID > $lastID";

    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    unset($lastID);
} else {

    $sql = "SELECT log_history.logID,log_history.cardUID, carte.etuCEF, concat(etudiant.etuNom,' ',etudiant.etuPrenom) as nom_complete, log_history.datetime FROM log_history JOIN carte ON carte.cardUID = log_history.cardUID JOIN etudiant ON carte.etuCEF = etudiant.etuCEF ORDER BY log_history.datetime DESC;";
    $result = $conn->query($sql);
    
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

}

unset($sql,$result);
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
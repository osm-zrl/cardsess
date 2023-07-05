<?php
require("../dbconfig.php");

$sql = "SELECT * FROM log_history";

$res = $conn->query($sql);

$tasks = array();
while ($rows = $res->fetch_assoc()) {
    $tasks[] = $rows;
}
print_r($tasks);

$filename = "phpflow_data_export_" . date('Ymd') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
ExportFile($tasks);
//$_POST["ExportType"] = '';
exit();

function ExportFile($records)
{
    $heading = false;
    if (!empty($records))
        foreach ($records as $row) {
            if (!$heading) {
                // display field/column names as a first row
                echo implode("\t", array_keys($row)) . "\n";
                $heading = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    exit;
}



/* if (isset($_POST["ExportType"])) {

    switch ($_POST["ExportType"]) {
        case "export-to-excel":
        // Submission from

        default:
            die("Unknown action : " . $_POST["action"]);
            break;
    }
}
 */
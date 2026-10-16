<?php 
include '../connection.php';

$sid = $_GET['sid'];

echo" <option disabled selected> -- Select Sub-Section -- </option>";
$sql = "SELECT * FROM `tbl_micortrend1` WHERE sid='$sid'";
$results = $con->query($sql);
foreach($results as $rowsub) {
    echo "<option value='" . $rowsub['id'] . "'>" . $rowsub['name'] . "</option>";
    
}



?>
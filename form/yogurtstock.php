<?php
include '../connection.php';
$id = $_GET['q'];
$result = mysqli_query($con, "SELECT ct1, ct2, ct3 FROM tblyogurt WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
echo json_encode($row);
?>

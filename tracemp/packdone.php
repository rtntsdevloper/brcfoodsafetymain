<?php
include '../connection.php';
$btch =  $_POST['btch'];
$prid = $_POST['prid'];

$prx = mysqli_query($con, "SELECT * FROM tblouter3 where batch='$btch'");
foreach ($prx as $prdata) {
    $pedid = $prdata['id'];
    $pedqty = $prdata['qty'];

    $ped = mysqli_query($con, "SELECT * FROM `tbllabel` WHERE id='$pedid'");
    $ped2 = mysqli_fetch_array($ped);

    $ped3 = $ped2['produceleft'];

    $tlft = (int)$ped3 - (int)$pedqty;
    echo $tlft;
    $sql = "UPDATE `tbllabel` SET `produceleft`='$tlft' WHERE id='$pedid'";
    $sqlx = mysqli_query($con, $sql);
} ?>


<script>
    window.location.href = '../admin.php?id=addouter1&eid=<?php echo $prid; ?>&pdrb=<?php echo $btch; ?>';
</script>
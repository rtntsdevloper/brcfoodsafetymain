<?php
include '../connection.php';

$batch = $_POST['batch'];


$btch = mysqli_query($con, "SELECT * FROM `tblpusage1` WHERE batch='$batch'");
foreach ($btch as $bdata) {
    $bqty = $bdata['qty'];
    $total = $bdata['gtotal'];
    $tleft = (int)$total - (int)$bqty;
    $qrid = $bdata['grid'];

    $qs = mysqli_query($con, "UPDATE `tblgrn1` SET leftqty ='0' WHERE id='$qrid'");
}

?>
<script>
    document.location.href = '../admin.php?id=potatousage';
</script>

<?php


?>
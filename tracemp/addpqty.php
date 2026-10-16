<?php
include '../connection.php';

$batch = $_POST['batch'];


$btch = mysqli_query($con, "SELECT * FROM `tblfryinfo1` WHERE batch='$batch'and mark='P'");
foreach ($btch as $bdata) {
    $bqty = $bdata['qty'];
 
    $total = $bdata['gtotal'];
    
    $tleft = (int)$total - (int)$bqty;
   
    $qrid = $bdata['grncode'];

    $qs = mysqli_query($con, "UPDATE `tblpusage` SET qtyleft ='$tleft' WHERE batchcode='$qrid'");
}

?>
<script>
    document.location.href = '../admin.php?id=addfryinfo3&batch=<?php echo $batch;?>';
</script>

<?php


?>
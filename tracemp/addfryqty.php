<?php
include '../connection.php';

$batch = $_POST['batch'];


$btch = mysqli_query($con, "SELECT * FROM tblflavourmix1 WHERE batch='$batch'and mark='P'");
foreach ($btch as $bdata) {
    $bqty = $bdata['qty'];
 
    $total = $bdata['gtotal'];
    
    $tleft = (int)$total - (int)$bqty;
   
    $qrid = $bdata['grncode'];

    $qs = mysqli_query($con, "UPDATE `tblfryinfo` SET totalqty ='$tleft' WHERE batchcode='$qrid'");
}

?>
<script>
    document.location.href = '../admin.php?id=flavouradd2&batch=<?php echo $batch;?>';
</script>

<?php


?>
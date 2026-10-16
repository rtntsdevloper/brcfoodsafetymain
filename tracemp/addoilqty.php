<?php
include '../connection.php';

$batch = $_POST['batch'];

$oilbth = mysqli_query($con,"SELECT * FROM `tblfrybatch` WHERE status='Active'");

$oilbthn = mysqli_num_rows($oilbth);
$crtdate = date('Y-m-d');
if($oilbthn == 0){

    $sbtch = mysqli_query($con,"SELECT * FROM `tblfrybatch`");
   $sbtchn = mysqli_num_rows($sbtch);
   $sbtchn1 = $sbtchn + 1;
   $ckbatch = "COOK".date('dmy')."00".$sbtchn1;
   
   

   $cnbtch = mysqli_query($con,"INSERT INTO `tblfrybatch`(`name`, `date`) VALUES ('$ckbatch','$crtdate')");
}

$btch = mysqli_query($con, "SELECT * FROM `tblfryinfo1` WHERE batch='$batch'");
$i=0;
foreach ($btch as $bdata) {
    $i++;
    $bqty = $bdata['qty'];
    $total = $bdata['gtotal'];
    $tleft = (int)$total - (int)$bqty;
    $qrid = $bdata['grid'];
    $grncode = $bdata['grncode'];

    $qs = mysqli_query($con, "UPDATE `tblgrn1` SET leftqty ='$tleft' WHERE id='$qrid'");

    $oilinbatch = mysqli_query($con,"SELECT * FROM `tblfrybatch` WHERE status='Active'");
    $oilinbatch1 = mysqli_fetch_array($oilinbatch);

    $oilcbatch = $oilinbatch1['name'];
    $oilcid = $oilinbatch1['id'];

    $newcbatch = $oilcbatch;
    // print_r("INSERT INTO `tblfrybatch1`(`name`, `date`, `quantity`, `batchp`, `cid`,`grnoil`) VALUES ('$newcbatch','$crtdate','$bqty','$batch','$oilcid','$grncode')");

    $subc = mysqli_query($con,"INSERT INTO `tblfrybatch1`(`name`, `date`, `quantity`, `batchp`, `cid`,`grnoil`) VALUES ('$newcbatch','$crtdate','$bqty','$batch','$oilcid','$grncode')");

}

?>
<script>
    document.location.href = '../admin.php?id=addfryinfo2&batch=<?php echo $batch; ?>';
</script>

<?php


?>
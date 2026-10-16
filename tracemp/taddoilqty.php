<?php
include '../connection.php';

$batch = $_POST['batch'];
$topup = $_POST['tpbtch'];




$oilbth = mysqli_query($con, "SELECT * FROM `tblfrybatch` WHERE status='Active'");

$oilbthn = mysqli_num_rows($oilbth);
$crtdate = date('Y-m-d');
if ($oilbthn == 0) {

    $sbtch = mysqli_query($con, "SELECT * FROM `tblfrybatch`");
    $sbtchn = mysqli_num_rows($sbtch);
    $sbtchn1 = $sbtchn + 1;
    $ckbatch = "COOK" . date('dmy') . "00" . $sbtchn1;



    $cnbtch = mysqli_query($con, "INSERT INTO `tblfrybatch`(`name`, `date`) VALUES ('$ckbatch','$crtdate')");
}

$btch = mysqli_query($con, "SELECT * FROM `tblfryinfo1` WHERE batch='$batch' and mark ='topup'");
$i = 0;
$tqtyn = 0;
foreach ($btch as $bdata) {
    $i++;

    $bqty = $bdata['qty'];

    $tqtyn = $bqty + $tqtyn;
    $total = $bdata['gtotal'];
    $tleft = (int)$total - (int)$bqty;
    $qrid = $bdata['grid'];
    $grncode = $bdata['grncode'];


    $qs = mysqli_query($con, "UPDATE `tblgrn1` SET leftqty ='$tleft' WHERE id='$qrid'");

    $oilinbatch = mysqli_query($con, "SELECT * FROM `tblfrybatch` WHERE status='Active'");
    $oilinbatch1 = mysqli_fetch_array($oilinbatch);

    $oilcbatch = $oilinbatch1['name'];
    $oilcid = $oilinbatch1['id'];

    $newcbatch = $oilcbatch;

    $subc = mysqli_query($con, "INSERT INTO `tblfrybatch1`(`name`, `date`, `quantity`, `batchp`, `cid`, `mark`,`grnoil`) VALUES ('$newcbatch','$crtdate','$bqty','$batch','$oilcid','topup','$grncode')");
}

$topupoil = mysqli_query($con, "UPDATE `tblfryinfo` SET `topup`='$tqtyn' WHERE batchcode='$batch'");



?>
<script>
    document.location.href = '../admin.php?id=fryrecord';
</script>

<?php


?>
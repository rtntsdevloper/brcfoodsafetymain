<?php
include '../connection.php';

$ans = $_GET['quantity'];
$pid = $_GET['sno'];
$qid = $_GET['qid'];
$str = $_GET['str'];


$rwap = mysqli_query($con, "select * from tblgrn1 where id='$qid'");

$rwap1 = mysqli_fetch_array($rwap);

$grc = $rwap1['grn'];
$grctotal = $rwap1['leftqty'];
$batchc2 = $rwap1['batchcode'];

$batch = $_GET['batch'];





if ($qst1 > 0) {
  $qstid = $qsta['id'];

  $qstin = mysqli_query($con, "UPDATE `tblpusage1` SET `batch`='$batch',`grncode`='$grc',`qty`='$ans',`pid`='$pid',`grid`='$qid',`gtotal`='$grctotal' WHERE id='$qstid'");
} else {
  $qstin = mysqli_query($con, "INSERT INTO `tblpusage1`(`batch`, `grncode`, `qty`, `pid`,`grid`,`gtotal`) VALUES ('$batch','$grc','$ans','$pid','$qid','$grctotal')");
}

$tst = "SELECT SUM(qty) as tqty FROM `tblpusage1` WHERE batch='$batch'";
$tst1 = mysqli_query($con, $tst);
$tst2 = mysqli_fetch_array($tst1);
$tsum = $tst2['tqty'];

if ($str == $tsum) {
?>
  <button class="btn btn-danger" type="submit" name="check" id="sbtn">Verify</button>
<?php
}


?>
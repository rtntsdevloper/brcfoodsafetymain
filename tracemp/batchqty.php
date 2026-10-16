<?php
include '../connection.php';

$ans = $_GET['quantity'];
$pid = $_GET['sno'];
$qid = $_GET['qid'];
$str = $_GET['str'];


$rwap = mysqli_query($con, "select * from tblpusage where id='$qid'");

$rwap1 = mysqli_fetch_array($rwap);

$grc = $rwap1['batchcode'];
$grctotal = $rwap1['qtyleft'];


$batch = $_GET['batch'];



$qst = mysqli_query($con, "SELECT * FROM `tblfryinfo1` WHERE batch='$batch' and grncode='$grc' and pid='$pid'");
$qst1 = mysqli_num_rows($qst);

$qsta = mysqli_fetch_array($qst);


if ($qst1 > 0) {
  $qstid = $qsta['id'];

  $qstin = mysqli_query($con, "UPDATE `tblfryinfo1` SET `batch`='$batch',`grncode`='$grc',`qty`='$ans',`pid`='$pid',`grid`='$qid',`gtotal`='$grctotal' WHERE id='$qstid'");
} else {
  $qstin = mysqli_query($con, "INSERT INTO `tblfryinfo1`(`batch`, `grncode`, `qty`, `pid`,`grid`,`gtotal`,mark) VALUES ('$batch','$grc','$ans','$pid','$qid','$grctotal','P')");
}

$tst = "SELECT SUM(qty) as tqty FROM `tblfryinfo1` WHERE batch='$batch' and mark='P'";
$tst1 = mysqli_query($con, $tst);
$tst2 = mysqli_fetch_array($tst1);
$tsum = $tst2['tqty'];


if ($str == $tsum) {
?>
  <button class="btn btn-danger" type="submit" name="check" id="sbtn">Verify</button>
<?php
}


?>
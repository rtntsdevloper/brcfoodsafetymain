<?php
include '../connection.php';

$ans = $_GET['ans'];
$qid = $_GET['qid'];
$pid = $_GET['pid'];
$batchid = $_GET['batch'];
$sno = $_GET['sno'];
$supid = $_GET['supid'];


$sqq = mysqli_query($con, "select * from frozenmarination where id='$batchid'");
$rowq = mysqli_fetch_array($sqq);

$batch = $rowq['batchcode'];

$y3 = mysqli_query($con, "select * from frozenmarination1 where pid='$pid' and batchcode='$batch' and supplier='$supid' ");
$fg3 = mysqli_fetch_array($y3);



$sql = mysqli_query($con, "update frozenmarination1 set totalqty='$ans' where id='$qid' ");


$y2 = mysqli_query($con, "select * from frozenmarination1 where pid='$pid' and batchcode='$batch' and supplier='$supid' ");
$fg2 = mysqli_num_rows($y2);


$y1 = mysqli_query($con, "select SUM(totalqty) AS totals, qty AS totalqt  from frozenmarination1 where pid='$pid' and batchcode='$batch' and supplier='$supid' ");
$fg = mysqli_fetch_array($y1);

$total = $fg['totalqt'];



if ($fg['totals'] > $total) {
  echo "Quantity is greater then required ";
?>
  <input type="hidden" name="cmnt<?php echo $sno; ?>" id="cmnt<?php echo $sno; ?>" value="2" />
<?php
} else if ($fg['totals'] < $total) {
  echo "Quantity is less then required ";
?>
  <input type="hidden" name="cmnt<?php echo $sno; ?>" id="cmnt<?php echo $sno; ?>" value="1" />
<?php
} else if ($fg['totals'] == $total) {
?>
  <input type="hidden" name="cmnt<?php echo $sno; ?>" id="cmnt<?php echo $sno; ?>" value="0" />
<?php
}

?>
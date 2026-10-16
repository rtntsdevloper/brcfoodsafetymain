<?php
include '../connection.php';
session_start();
$batch = $_GET['batch'];


$ghj = mysqli_query($con, "delete from frozenmarination1 where batchcode='$batch' and (totalqty='0' or totalqty='')");



$sq = mysqli_query($con, "select * from frozenmarination1 where batchcode='$batch'");
while ($row = mysqli_fetch_array($sq)) {


	$gh2 = mysqli_query($con, "select * from tblgrn1 where id='$row[grnid]'");
	$sq2 = mysqli_fetch_array($gh2);

	$useby = $sq2["useby"];

	$qty = $row['totalqty'];

	$totalqty = $row['totalqty'];

	if ($row['qty1'] == "G") { 
		$leftqty = $totalqty / 1000;
		$leftqty1 = round($sq2["leftqty"] - $leftqty, 3);
	} else if ($row['qty1'] == "Kg") {
		$totalqty;
		$leftqty1 = round($sq2["leftqty"] - $totalqty, 3);
	}




	$sf = mysqli_query($con, "update tblgrn1 set leftqty='$leftqty1' where id='$row[grnid]'");
}


$water = $_GET['water'];

$sf1 = mysqli_query($con, "update frozenmarination set status='Done' ,water='$water' where batchcode='$batch'");

?>

<script language="javascript">
	window.open('../admin.php?id=fmarination', '_self');
</script>
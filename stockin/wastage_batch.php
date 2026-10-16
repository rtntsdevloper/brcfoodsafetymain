<?php
include '../connection.php';
 $rid = $_GET['rid'];

 $rawdata = mysqli_query($con,"SELECT id, batchcode,useby FROM `stock_in` WHERE prodid='$rid' and storedleftqty > 0") ;
foreach($rawdata as $rawd) {
?>

<option value="<?=  $rawd['id'] ?>"><?=  $rawd['batchcode'] ." ( ". date('d-m-Y',strtotime($rawd['useby'])) ." )"?></option>

<?php
}

?>
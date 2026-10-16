<?php 
include 'connection.php';

$ans=$_GET['ans'];
$qid=$_GET['qid'];
 $pid=$_GET['pid'];
 $batch=$_GET['batch'];
 $sno=$_GET['sno'];

$sql=mysqli_query($con,"update tblmarination1 set totalqty='$ans' where id='$qid' ");


$y2=mysqli_query($con,"select * from tblmarination1 where pid='$pid' and batchcode='$batch' ");
 $fg2=mysqli_num_rows($y2);
 
 
 $y1=mysqli_query($con,"select SUM(totalqty) AS totals, SUM(qty) AS totalqt  from tblmarination1 where pid='$pid' and batchcode='$batch' ");
 $fg=mysqli_fetch_array($y1);
 
   $total= $fg['totalqt']/$fg2;
 
  
 
 
 if($fg['totals'] > $total )
 {
  echo "Quantity is greater then required for input".$sno;
  ?>
  <input type="text" name="thevalue" id="thevalue" value="1" />
 
  <?php
 }
else if($fg['totals'] < $total )
{
 echo "Quantity is less then required input".$sno;
 ?>
  <input type="text" name="thevalue" id="thevalue" value="1" />
  <?php
}
else if($fg['totals'] == $total )
{
 ?>
  <input type="text" name="thevalue" id="thevalue" value="0" />
  <?php
}

?>
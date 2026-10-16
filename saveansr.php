<?php
include 'connection.php';

 $ans=$_GET['ans'];
  $qid=$_GET['qid'];
 $sid=$_GET['sid'];
 

$qury=mysqli_query($con,"update tblgmpaudit3 set stype='$ans'  where id='$qid'");

?>

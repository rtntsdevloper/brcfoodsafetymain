<?php
include 'connection.php';

 $ans=$_GET['ans'];
 $qid=$_GET['qid'];
 $sid=$_GET['sid'];
 
 $gh=mysqli_query($con,"select * from tblauditsection3 where ans='$ans' and qid='$sid'");
 $gh1=mysqli_fetch_array($gh);

$qury=mysqli_query($con,"update tblgmpaudit3 set ans='$ans' , status='$gh1[status]' where id='$qid'");

?>

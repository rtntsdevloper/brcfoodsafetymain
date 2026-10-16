<?php
include 'connection.php';

 $ans=$_GET['ans'];
 $qid=$_GET['qid'];

$qury=mysqli_query($con,"update tblgmpaudit3 set cmnt='$ans' where id='$qid'");

?>

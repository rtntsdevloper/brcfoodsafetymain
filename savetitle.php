
<?php
include 'connection.php';
 $note= mysqli_real_escape_string($con,$_GET['ans']);
   $fid=$_GET['fid'];
 $qid=$_GET['qid'];
   $rid=$_GET['rid'];

$date=date("Y-m-d h:i");


$sql=mysqli_query($con,"update saveaudit set title='$note' where fid='$fid' and ques='$qid' and sno='$rid'");

 ?>

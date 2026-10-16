
<?php
include 'connection.php';
 $note= $_GET['ans'];
   $fid=$_GET['fid'];
 $qid=$_GET['qid'];
  $rid=$_GET['rid'];

$date=date("Y-m-d h:i");
// print_r("update saveaudit set deliver='$note' where fid='$fid' and ques='$qid' and sno='$rid'");die;

$sql=mysqli_query($con,"update saveaudit set deliver='$note' where fid='$fid' and ques='$qid' and sno='$rid'");


 ?>

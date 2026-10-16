<?php
include 'connection.php';

 $fid=$_GET['fid'];
 $qid=$_GET['qid'];
  $ans=$_GET['ans'];
  $rid=$_GET['rid'];

if($ans=="Compliant" )
{
  $sql=mysqli_query($con,"update saveaudit set ans='$ans',status='Completed'  where fid='$fid' and ques='$qid' and sno='$rid'"); // old code
// $sql=mysqli_query($con,"update saveaudit set ans='$ans',status='Completed',deliver='',title='',action=''  where fid='$fid' and ques='$qid' and sno='$rid'");
}
else if($ans=="Not Applicable")
{
$sql=mysqli_query($con,"update saveaudit set ans='$ans',status='Not Applicable'  where fid='$fid' and ques='$qid' and sno='$rid'"); // old code
// $sql=mysqli_query($con,"update saveaudit set ans='$ans',status='Not Applicable',deliver='',title='',action=''  where fid='$fid' and ques='$qid' and sno='$rid'");
}
else
{
  // $sql=mysqli_query($con,"update saveaudit set ans='$ans', status='waiting',notes='' where fid='$fid' and ques='$qid' and sno='$rid'");
$sql=mysqli_query($con,"update saveaudit set ans='$ans', status='waiting' where fid='$fid' and ques='$qid' and sno='$rid'"); //old code
}

?>


<?php
include 'connection.php';
$note= mysql_real_escape_string($_POST['ans']);
  $fid=$_POST['fid'];
 $qid=$_POST['qid'];
  $rid=$_POST['rid'];

$date=date("Y-m-d h:i");


$sql=mysql_query("update saveaudit set notes='$note' where fid='$fid' and ques='$qid' and sno='$rid'");

 ?>

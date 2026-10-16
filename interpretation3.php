
<?php
session_start();
$user=$_SESSION['user'];
include 'connection.php';
$formname=$_POST['formname'];
$namee=$_POST['name'];
$name= mysqli_real_escape_string($con,$namee);
  $fid=$_POST['fid'];
 $sid=$_POST['sid'];
  

$date=date("Y-m-d h:i");

$dd=mysqli_query($con,"select * from subtest1 where fid='$fid' and sid='$sid'");
$match=mysqli_num_rows($dd);

if($match>=1)
{
$sql=mysqli_query($con,"update subtest1 set inter='$name' where fid='$fid' and sid='$sid'");

}
 ?>
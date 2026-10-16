
<?php
session_start();
$user=$_SESSION['user'];
include 'connection.php';
$name= $_POST['name'];
  $tid=$_POST['tid'];
 $sid=$_POST['sid'];

$date=date("Y-m-d h:i");

$dd=mysqli_query($con,"select * from tblinterpretation where tid='$tid' and sid='$sid'");
$match=mysqli_num_rows($dd);

if($match>=1)
{
$sql=mysqli_query($con,"update tblinterpretation set tid='$tid',sid='$sid',name='$name',user='$user' where tid='$tid' and sid='$sid'");

}
else
{

$sql=mysqli_query($con,"insert into tblinterpretation(tid,sid,name,user)values('$tid','$sid','$name','$user')");

}
 ?>
<?php
include 'connection.php';

$tid=$_GET['tid'];
$sid=$_GET['sid'];
$ssid=$_GET['ssid'];

 $ans=$_GET['ans'];
//echo $fid."</br>".$qid."</br>".$ans."</br>";
$date=date("Y-m-d");

$dd=mysqli_query($con,"select * from tblcmp where tid='$tid' and sid='$sid' and ssid='$ssid'");
$match=mysqli_num_rows($dd);

$sqld=mysqli_query($con,"update subtest1 set status='$ans'  where tid='$tid' and sid='$sid' and fid='$ssid'");

$ghj=mysqli_query($con,"select * from subtest1 where tid='$tid'");
$ghj1=mysqli_fetch_array($ghj);
$matchh=mysqli_num_rows($ghj);

$pending=mysqli_query($con,"select * from subtest1 where tid='$tid' and status='0'");
$pending1=mysqli_num_rows($pending);

$progres=mysqli_query($con,"select * from subtest1 where tid='$tid' and status='1'");
$progres1=mysqli_num_rows($progres);


$complete=mysqli_query($con,"select * from subtest1 where tid='$tid' and status='2'");
$complete1=mysqli_num_rows($complete);

if($matchh==$pending1)
{
$fg=mysqli_query($con,"update addtest1 set status='0' where testid='$tid'");
}
else if($matchh==$progres1)
{
$fg=mysqli_query($con,"update addtest1 set status='1' where testid='$tid'");
}
else if($matchh==$complete1)
{
$fg=mysqli_query($con,"update addtest1 set status='2' where testid='$tid'");
}
else
{
}
if($match>=1)
{
$sql=mysqli_query($con,"update tblcmp set status='$ans',date='$date'  where tid='$tid' and sid='$sid' and ssid='$ssid'");
}
else
{
$sql=mysqli_query($con,"insert into tblcmp(tid,sid,ssid,status,date)values('$tid','$sid','$ssid','$ans','$date')");
}
echo "Data Updated Successfully!";

?>

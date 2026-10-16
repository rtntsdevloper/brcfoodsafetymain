
<?php
include '../connection.php';
 $pid=$_POST['pid'];
$staffid=$_POST['staffid'];
$date=date("Y-m-d");

$sql=mysqli_query($con,"select * from user_anss1 where sessionid='$staffid' and testid='$pid' and correctans=yourans");
echo $match=mysqli_num_rows($sql);


if($match>=4)
{
$sq=mysqli_query($con,"INSERT INTO tblresult1 (tid, staffid, score, curdate, result) VALUES ( '$pid', '$staffid', '$match', '$date', 'Pass')");
}
else if($match<=3)
{
$sq=mysqli_query($con,"INSERT INTO tblresult1 (tid, staffid, score, curdate, result) VALUES ( '$pid', '$staffid', '$match', '$date', 'Fail')");
}

?>

<script language="javascript">
window.open('admin.php?id=proceduretest3','_self');
</script>
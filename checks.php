<?php
include 'connection.php';
date_default_timezone_set('Europe/London');
$tid = $_GET['tid'];
session_start();
$user = $_SESSION['user'];
$access = $_SESSION['access'];
$date = date("Y-m-d");

echo "select * from dailychecks where id='$tid'";
$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);


$insert = mysqli_query($con, "insert into dailycheckss(name,date,user)values('$tid','$date','$user')");
$cid = mysqli_insert_id($con);
$sql = mysqli_query($con, "select * from dailychecks1 where tid='$tid'");
while ($q1 = mysqli_fetch_array($sql)) {
    $q = $q1['ques'];
// echo "insert into dailychecks2(cid,ques,date,user)values('$cid','$q','$date','$user')";
    $insert1 = mysqli_query($con, "insert into dailychecks2(cid,ques,date,user)values('$cid','$q','$date','$user')");

}



?>
<script>
    window.location.href = "admin.php?id=dailychecks1&tid=<?php echo $tid; ?>&cid=<?php echo $cid; ?>";
</script>
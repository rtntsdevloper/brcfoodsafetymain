<?php
include 'connection.php';
session_start();
$user=$_SESSION['user'];

$tid=$_POST['tid'];
$sid=$_POST['sid'];
$fm1=$_POST['fm1'];
$cmnt=$_POST['cmnt'];

$sql=mysqli_query($con,"insert into tblcheckinfo (user,tid,sid,cmnt,ans)values('$user','$tid','$sid','$cmnt','$fm1')");


?>
<script language="javascript">
window.open('admin.php?id=brccompliance','_self');

</script>

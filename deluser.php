<?php
include 'connection.php';
$sno=$_GET['id'];
$status=$_GET['status'];

$sql=mysqli_query($con,"update tblstaff set status='$status' where id='$sno'");
?>
<script language="javascript">
window.open('admin.php?id=umgmt','_self');
</script>
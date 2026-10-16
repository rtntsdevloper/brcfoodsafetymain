<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tbldept  where id='$sno'");
?>
<script language="javascript">
window.open('admin.php?id=deptmgmt','_self');
</script>
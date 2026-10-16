<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tbladmin  where id='$sno'");

?>
<script language="javascript">
window.open('admin.php?id=adminmgmt','_self');
</script>

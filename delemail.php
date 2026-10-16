<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tblemail  where id='$sno'");

?>
<script language="javascript">
window.open('admin.php?id=emailmgmt','_self');
</script>

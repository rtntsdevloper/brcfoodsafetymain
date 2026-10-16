<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tblauditsection2  where id='$sno'");

?>
<script language="javascript">
window.open('admin.php?id=addaudit','_self');
</script>

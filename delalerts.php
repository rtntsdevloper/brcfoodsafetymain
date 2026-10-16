<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tblalerts  where id='$sno'");

?>
<script language="javascript">
window.open('admin.php?id=alertsmgmt','_self');
</script>

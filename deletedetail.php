<?php
include 'connection.php';
$id=$_GET['sno'];

$row=mysqli_query($con,"delete from tblroster where id='$id'");
?>
<script>
window.open('admin.php?id=auditorassign','_self');
</script>

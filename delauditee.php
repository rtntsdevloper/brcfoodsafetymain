<?php
include 'connection.php';
$id=$_GET['sno'];

$row=mysqli_query($con,"update tblauditee set status='dactive' where id='$id'");
?>
<script>
window.open('admin.php?id=auditeemgmt','_self');
</script>

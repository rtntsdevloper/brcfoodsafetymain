<?php
include 'connection.php';
$id=$_GET['id'];

$row=mysqli_query($con,"update tblauditor set status='dactive' where id='$id'");
?>
<script>
window.open('admin.php?id=auditor','_self');
</script>

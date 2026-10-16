<?php 
include 'connection.php';

$dd=mysqli_query($con,"update tbldetail set typee='' where  id='$_GET[id]' ");


?>
<script language="javascript">
window.open('admin.php?id=additionalmgmt','_self');
</script>

<?php 
include 'connection.php';

$dd=mysqli_query($con,"delete  from tbldetail where  id='$_GET[id]' ");


?>
<script language="javascript">
window.open('admin.php?id=brccompliance1&sno=<?php echo $_GET['sno'];?>&sid=<?php echo $_GET['sid'];?>','_self');
</script>

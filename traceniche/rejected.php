<?php

include '../connection.php';
$sno=$_GET['id'];

$sq=mysqli_query($con,"update tblgdn set status='dactive' where id='$sno'");

?>
<script language="javascript">

window.open('../admin.php?id=goodsoutt&id2=<?php echo $_GET['id2'];?>','_self');

</script>
<?php
include 'connection.php';
$pid=$_POST['pid'];

$sql3=mysqli_query($con,"select * from tblproductdetail where pid='$pid' and sid='18'");
 $row1=mysqli_fetch_array($sql3);
	$sno=$row1['id']; 
			 
$itemCount1 = count($_POST["chk"]);

for($j=0;$j<$itemCount1;$j++)
{
$chk = $_POST["chk"][$j];
$sql1=mysqli_query($con,"delete from tblmicro where qid='$chk' and pid='$pid'");
$sql2=mysqli_query($con,"delete from tblsaveans1 where sno='$sno' and qid='$chk'");

}

?>
  <script language="javascript">
  alert("Deleted Successfully! ");
  window.open('admin.php?id=ps1&pid=<?php echo $pid;?>&id2=<?php echo $_POST['id2'];?>','_self');
  </script>


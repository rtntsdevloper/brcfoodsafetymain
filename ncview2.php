<?php
include 'connection.php';


$sql=mysqli_query($con,"select * from saveaudit where sno='$_GET[sno]' and (status='Rejected' || status='waiting') ");
$match=mysqli_num_rows($sql);

if($match<=0)
{
 $jk=mysqli_query($con,"update tblroster set status='Done',status1='Done',bgcolor='#669900' where id='$_GET[sno]'");
}
?>

<script language="javascript">
							  window.open('admin.php?id=ncview&sno=<?php echo $_GET['sno'];?>','_self');
							   </script>
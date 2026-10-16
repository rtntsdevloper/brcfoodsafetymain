<?php
session_start();
include 'connection.php';
$consname=$_POST['consname'];
$category=$_POST['category'];
$user=$_SESSION['user'];
$today = date("Y-m-d");

for ($i=0; $i < count($_POST['product']);$i++) 
	{
	$product=$_POST['product'][$i];
	 $ans=$_POST['ans'.$i];
	 
	 if($ans<=0)
	 {}
	 else
	 {
	 $sql=mysql_query("insert into tbldemo(product,category,date,user,quantity,cid)values('$product','$category','$today','$user','$ans','$consname')");
	 }
	 }
	 ?>
	 
	 <script language="javascript">
	 window.open('admin.php?id=despatch4&consname=<?php echo $consname;?>','_self');
	 </script>
	 
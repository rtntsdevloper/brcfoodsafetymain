<?php
date_default_timezone_set("Europe/London");
 include'connection.php';
 session_start();
$user=$_SESSION['user'];
$cate1=$_POST['cate'];
 $name=$_POST['name'];
$qty=$_POST['qty'];
$useby=$_POST['useby'];
$batch=$_POST['batch'];
$weight=$_POST['weight'];
$cmnt=mysqli_real_escape_string($con,$_POST['cmnt']);

 $sql2=mysqli_query($con,"select * from tblsnclproduct where cate1='$cate1'");
 $row2=mysqli_fetch_array($sql2);
	$cate=$row2['cate'];
						  
									  
$date=date('Y-m-d H:i:s');
$img1="";
for ($i = 0; $i < count($_FILES['img']['name']); $i++) 
{
$img=$i.$name.$_FILES['img']['name'][$i];
$img1.=$i.$name.$_FILES['img']['name'][$i].";";
move_uploaded_file($_FILES['img']['tmp_name'][$i],"productlist/".$img);
}


$sg=mysqli_query($con,"update tblsnclproduct set qty='$qty',useby='$useby',batchcode='$batch',img='$img1',user='$user',date='$date',cmnt='$cmnt',weight='$weight' where id='$name'");


$sg1=mysqli_query($con,"insert into tblsnclproduct1(cate,name,qty,useby,batchcode,img,user,date,weight)values('$cate','$name','$qty','$useby','$batch','$img1','$user','$date','$weight')");


?>
<script language="javascript">
window.open('snclproduct.php','_self');

</script>
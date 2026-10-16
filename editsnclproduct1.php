								<?php
						include 'connection.php';
								$name=$_POST['qid'];
date_default_timezone_set("Europe/London");
$user=$_SESSION['user'];
$cate=$_POST['cate'];
$qty=$_POST['qty'];
$useby=$_POST['useby'];
$batch=$_POST['batch'];
$weight=$_POST['weight'];
$cmnt=mysqli_real_escape_string($con,$_POST['cmnt']);


$date=date('Y-m-d H:i:s');
$img1="";


for ($i = 0; $i < count($_FILES['img']['name']); $i++) 
{
$img=$i.$name.$_FILES['img']['name'][$i];
$img1.=$i.$name.$_FILES['img']['name'][$i].";";
move_uploaded_file($_FILES['img']['tmp_name'][$i],"productlist/".$img);
}

$sg=mysqli_query($con,"update tblsnclproduct set qty='$qty',useby='$useby',batchcode='$batch',user='$user',date='$date',cmnt='$cmnt',weight='$weight' where id='$name'");

$sg1=mysqli_query($con,"insert into tblsnclproduct1(cate,name,qty,useby,batchcode,user,date)values('$cate','$name','$qty','$useby','$batch','$user','$date')");

?>


<script language="javascript">
window.open('snclproduct.php','_self');
</script>


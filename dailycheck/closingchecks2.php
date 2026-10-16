<?php
session_start();
include 'connection.php';
date_default_timezone_set('Europe/London');
$date=date("Y-m-d");
$tid=$_POST['tid'];
$sno=$_POST['sno'];
$user=$_SESSION['user'];

$gh=mysqli_query($con,"update dailycheckss set name1='2' where id='$sno'");


 if(!empty($_POST['ques']))
     {
      for ($i=0; $i < count($_POST['ques']);$i++) 
	{
    $q= mysqli_real_escape_string($con,$_POST['ques'][$i]);
	$section= mysqli_real_escape_string($con,$_POST['section'][$i]);
 
    $ans=$_POST['r1'.$i];
	$cmnt=$_POST['cmnt'.$i];
	

     $file=$_FILES['img'.$i]['name'];
	 
$file=$_FILES['img'.$i]['name'];
move_uploaded_file($_FILES["img".$i]["tmp_name"],"upl1/".$file);

$gh1=mysqli_query($con,"insert into dailychecks3(cid,ques,ans,pic,cmnt,date,user,section)values('$sno','$q','$ans','$file','$cmnt','$date','$user','$section')");
}
}
?>

<script language="javascript">
window.open('admin.php?id=dailychecks&tid=<?php echo $tid;?>','_self');
</script>


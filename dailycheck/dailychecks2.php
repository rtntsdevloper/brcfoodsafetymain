<?php
session_start();
include 'connection.php';
date_default_timezone_set('Europe/London');
$date=$_POST['date'];
$cname = $_POST['cname'];
$ctime = $_POST['ctime'];
$tid=$_POST['tid'];
$user=$_SESSION['user'];

$gh=mysqli_query($con,"insert into dailycheckss(name,date,user,ouser,otime)values('$tid','$date','$user','$cname','$ctime')");
$ghj=mysqli_query($con,"select * from dailycheckss where name='$tid' and date='$date' and user='$user' order by id desc limit 1");
$ghj1=mysqli_fetch_array($ghj);
$cid=$ghj1['id'];


 if(!empty($_POST['ques']))
     {
      for ($i=0; $i < count($_POST['ques']);$i++) 
	{
    $q= mysqli_real_escape_string($con,$_POST['ques'][$i]);
	$section= mysqli_real_escape_string($con,$_POST['section'][$i]);
 
    $ans=$_POST['r1'.$i];
	$cmnt=$_POST['cmnt'.$i];
	


     $file=$_FILES['img'.$i]['name'];
	 
	 
	 if($file!="")
	 {
$file=$i.date('dmy').$_FILES['img'.$i]['name'];
move_uploaded_file($_FILES["img".$i]["tmp_name"],"upl1/".$file);

}

$gh1=mysqli_query($con,"insert into dailychecks2(cid,ques,ans,pic,cmnt,date,user,section)values('$cid','$q','$ans','$file','$cmnt','$date','$user','$section')");
}
}
?>

<script language="javascript">
window.open('admin.php?id=dailychecks&tid=<?php echo $tid;?>','_self');
</script>


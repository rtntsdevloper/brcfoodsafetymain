<?php
session_start();
include 'connection.php';
date_default_timezone_set('Europe/London');
$date=date("Y-m-d");
$cid=$_POST['cid'];
$user=$_SESSION['user'];

 if(!empty($_POST['ques']))
     {
      for ($i=0; $i < count($_POST['ques']);$i++) 
	{
	 $name=$_POST['name'];
     $q=$_POST['ques'][$i];
     $ans=$_POST['ans'.$i];
	 $ans1=$_POST['ans1'.$i];
	 $cmnt=$_POST['cmnt'.$i];
	 $anss=$ans.";".$ans1;
$gh1=mysqli_query($con,"insert into tbltemprature1(cid,ques,ans,cmnt,name)values('$cid','$q','$anss','$cmnt','$name')");
}
}


if(!empty($_POST['ques1']))
     {
      for ($j=0; $j < count($_POST['ques1']);$j++) 
	{
	$name1=$_POST['name1'];
     $q1=$_POST['ques1'][$j];
     $ans2=$_POST['ans2'.$j];
	 $ans3=$_POST['ans3'.$j];
	 $cmnt1=$_POST['cmnt1'.$j];
	 $anss1=$ans2.";".$ans3;
$gh2=mysqli_query($con,"insert into tbltemprature1(cid,ques,ans,cmnt,name)values('$cid','$q1','$anss1','$cmnt1','$name1')");
}
}



if(!empty($_POST['ques2']))
     {
      for ($k=0; $k < count($_POST['ques2']);$k++) 
	{
	$name2=$_POST['name2'];
     $q2=$_POST['ques2'][$k];
     $ans4=$_POST['ans4'.$k];
	 $ans5=$_POST['ans5'.$k];
	 $cmnt2=$_POST['cmnt2'.$k];
	 $anss2=$ans4.";".$ans5;
$gh5=mysqli_query($con,"insert into tbltemprature1(cid,ques,ans,cmnt,name)values('$cid','$q2','$anss2','$cmnt2','$name2')");
}
}



?>

<script language="javascript">
window.open('admin.php?id=dailychecks','_self');
</script>


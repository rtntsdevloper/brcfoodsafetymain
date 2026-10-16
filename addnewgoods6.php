<?php
session_start();

$opt=rand(10,1000);
include 'connection.php';
date_default_timezone_set('Europe/London');
$user=$_SESSION['user'];
$date=date('Y-m-d');

 
	$vtemp=$_POST['vtemp'];
	$ptemp=$_POST['ptemp'];
	$truck=$_POST['truck'];

 $ansc=count($_POST['ans']);
 
 
 $img=$_FILES['img']['name'];
 
 $g=move_uploaded_file($_FILES['img']['tmp_name'],"invoice/".$img);
 $tp="";
for($i=0;$i< $ansc;$i++)
 {
 $tp.=mysqli_real_escape_string($con,$_POST["ans"][$i].";");
 }

 $cmntc=count($_POST["cmntt"]);
 $tp1="";
for($i1=0;$i1<$cmntc;$i1++)
{
$tp1.=mysqli_real_escape_string($con,$_POST["cmntc"][$i1].";");
}

$hjk=mysqli_query($con,"INSERT INTO tblgrn ( date,trucknumber,ptemp,vtemp,ans,cmnt,img,user) VALUES ( '$date','$truck','$ptemp','$vtemp','$tp','$tp1','$img','$user')");


    
	//$qtype=$_POST['qtype'];
    
	// $ub=$_POST['ub'.$i];
	 //$useby=$_POST['useby'.$i];
	// $killdate=$_POST['killdate'.$i];
	 
	
	
	


 $ty=mysqli_query($con,"select * from  tblgrn where  date='$date' and trucknumber='$truck' and ptemp='$ptemp' and vtemp='$vtemp' and img='$img' and user='$user' order by id desc limit 1");
 $ty1=mysqli_fetch_array($ty);
   $cid=$ty1['id'];
	

?>

<script language="javascript">
window.open('admin.php?id=addnewgoods&cid=<?php echo $cid;?>','_self');
</script>
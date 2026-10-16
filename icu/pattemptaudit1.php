<?php
 session_start();
 $user=$_SESSION['name'];
 
include '../connection.php';
date_default_timezone_set('Europe/London');
$date=date("Y-m-d");

  $sid=$_POST['sid'];
 $pid=$_POST['pid'];

 
    $gh=mysqli_query($con,"select * from tblproductdetail where sid='$sid' and pid='$pid' and date='$date' ");
    $gh1=mysqli_fetch_array($gh);
    $match=mysqli_num_rows($gh);

    $sno=$gh1['id'];
 
 if($match>=1)
 {
 }
 else
 {
   
   $sql=mysqli_query($con,"insert into tblproductdetail(sid,date,user,pid)values('$sid','$date','$user','$pid')");
 }
 
  $gh2=mysqli_query($con,"select * from tblproductdetail where sid='$sid' and date='$date' and pid='$pid'");
  $gh3=mysqli_fetch_array($gh2);

   $sno=$gh3['id'];
  
 
 for ($i=0; $i < count($_POST['qid']);$i++) 
 
 {
 
 
  $qid=$_POST['qid'][$i];
 $ques=mysqli_real_escape_string($con,$_POST['ques'][$i]);
 

  $cmnt=mysqli_real_escape_string($con,$_POST['cmnt'.$i]);
 $pic=mysqli_real_escape_string($con,$_FILES['pic'.$i]['name']);
 
if($pic!="")
{
move_uploaded_file($_FILES['pic'.$i]['tmp_name'],"productdoc/".$pic);
}

  
  
    if($sid=="5" || $sid=="6")
  {
  $ans=mysqli_real_escape_string($con,$_POST['j'.$i][0].";".$_POST['j'.$i][1].";");
   }
   
   else if($sid=="4")
  {
   echo $ans =mysqli_real_escape_string($con,$_POST['j'.$i.'0'].";".$_POST['j'.$i.'1'].";".$_POST['j'.$i.'2'].";");
   } 
   else
  {

    $ans=mysqli_real_escape_string($con,$_POST['r1'.$i]);

   }
  
  
  
   $sql1=mysqli_query($con,"insert into tblsaveans1 (sno,qid,ques,cmnt,pic,ans)values('$sno','$qid','$ques','$cmnt','$pic','$ans')");
   $qry=mysqli_query($con,"update tblproductdetail set status1='waiting' where id='$sno'");
 
  }
  
?>

<script language="javascript">
window.open('../admin.php?id=ps1&pid=<?php echo $pid;?>&id2=<?php echo $_POST['id2'];?>','_self');
</script>
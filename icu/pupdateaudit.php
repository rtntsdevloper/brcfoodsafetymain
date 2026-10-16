    <?php
    session_start();
    $user=$_SESSION['name'];
   
   
     include '../connection.php';
    date_default_timezone_set('Europe/London');
    $date=date("Y-m-d");

    $sid=$_POST['sid'];
   $sno1=$_POST['sno1'];
    $pid=$_POST['pid'];
 
  $gh2=mysqli_query($con,"select * from tblproductdetail where sid='$sid' and pid='$pid'");
  $gh3=mysqli_fetch_array($gh2);
   $sno=$gh3['id'];

 for ($i=0; $i < count($_POST['qid']);$i++) 
 {
 $qid=$_POST['qid'][$i];
 $ques=mysqli_real_escape_string($con,$_POST['ques'][$i]);
 
 $cmnt=mysqli_real_escape_string($con,$_POST['cmnt'.$i]);
$pic=mysqli_real_escape_string($con,$_FILES['pic'.$i]['name']);
 
 
  
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
  
  
   
  
   
   
   
if($pic!="")
{
move_uploaded_file($_FILES['pic'.$i]['tmp_name'],"productdoc/".$pic);
$qr=mysqli_query($con,"update tblsaveans1 set cmnt='$cmnt',pic='$pic',ans='$ans' where sno='$sno' and qid='$qid'");
}
else 
{
$qr=mysqli_query($con,"update tblsaveans1 set cmnt='$cmnt',ans='$ans'  where sno='$sno' and qid='$qid'");
}

$jk=mysqli_query($con,"update tblproductdetail set status1='waiting', status='Completed' where id='$sno' ");
}
  
?>

<script language="javascript">
window.open('../admin.php?id=ps1&pid=<?php echo $pid;?>&id2=<?php echo $_POST['id2'];?>','_self');
</script>


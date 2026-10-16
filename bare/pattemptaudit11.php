<?php
session_start();
$user=$_SESSION['user'];
include '../connection.php';
date_default_timezone_set('Europe/London');
$date=date("Y-m-d");

    $sno=$_POST['sno'];
    $sno1=$_POST['sno1'];
 
     $pid=$_POST['pid'];
 
      $fresponse=mysqli_real_escape_string($con,$_POST['fcmnt']);
      $fcmnt=$_POST['ra1'];
 
     $query=mysqli_query($con,"update tblproductdetail set fresponse='$fresponse' , fname='$user' , status='$fcmnt' ,status1='$fcmnt', fdate='$date' where id='$sno1'");
     $query1=mysqli_query($con,"select * from tblproductdetail where pid='$pid' and status='Rejected'");
	 $match=mysqli_num_rows($query1);
	 
	  if($match>=1)
	  {
	   $query2=mysqli_query($con,"update tblproduct1 set status1='Rejected' where prodid='$pid'");
	  }
	  
	  $query2=mysqli_query($con,"select * from tblproductdetail where pid='$pid' and status='Accepted'");
	 $match2=mysqli_num_rows($query2);
	 
	  if($match2>=9)
	  {
	   $query2=mysqli_query($con,"update tblproduct1 set status1='Accepted' where prodid='$pid'");
	  }
	  
  
?>

<script language="javascript">
 window.open('../admin.php?id=pss1&pid=<?php echo $pid;?>','_self');
</script>


<?php
session_start();

$opt=rand(10,1000);
include 'connection.php';
date_default_timezone_set('Europe/London');
$user=$_SESSION['user'];
$date=date('Y-m-d');

    $sno=$_POST['sno'];
    $sno1=$_POST['sno1'];
	$cid=$_POST['cid'];
	$status=$_POST['status'];
	
	$suppcode=$_POST['suppcode'];
											   $vb=mysqli_query($con,"select * from tblgrnno where supid='$suppcode' and cdate='$date' and img='$sno' ");
											   $lastrow=mysqli_num_rows($vb);
											   
											   $num=$lastrow+1;
											   $grn="S".$suppcode.date('dmy')."00".$num;
											   
											   
					$cs=mysqli_query($con,"select * from tblcsv  where id='$sno'");
					$cs1=mysqli_fetch_array($cs);			    


$hjk=mysqli_query($con,"INSERT INTO tblgrnno ( grnno, supid,cdate,user,cid,img,ordernum,orderdate) VALUES ( '$grn','$suppcode','$date','$user','$cid','$sno','$cs1[po]','$cs1[date]')");


    
	//$qtype=$_POST['qtype'];
    
	// $ub=$_POST['ub'.$i];
	 //$useby=$_POST['useby'.$i];
	// $killdate=$_POST['killdate'.$i];
	
	
 for ($i=0; $i < count($_POST['item']);$i++) 
{
	 $q= mysqli_real_escape_string($con,$_POST['item'][$i]);
	 $ans=$_POST['r1'.$i];
	 $cmnt=mysqli_real_escape_string($con,$_POST['cmnt'.$i]);
	 $yu=mysqli_query($con,"insert into tblgrnno1(product,ans,cmnt,user,date,grn)values('$q','$ans','$cmnt','$user','$date','$grn')");
}

 $yu1=mysqli_query($con,"update tblcsv set status='Done' where id='$sno'");
	
if($status=="Yes")
{
?>
<script language="javascript">
window.open('admin.php?id=addnewgoods&cid=<?php echo $cid;?>','_self');
</script>
<?php
}
else
{
?>
<script language="javascript">
window.open('admin.php?id=goodsin','_self');
</script>
<?php
}
?>



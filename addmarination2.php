<?php
include 'connection.php';
session_start();
$user=$_SESSION['name'];
 $cid=$_SESSION['cid'];
	$cname="ADM";
	$result = substr($cname, 0, 3);
											  $sno=$_POST['sno'];
											  $qty=$_POST['qt'];

			$temp=$_POST["temp"];
			$tray=$_POST["tray"];
			$wrap=$_POST["wrap"];
			$stime=$_POST["stime"];
			$etime=$_POST["etime"];
								  $date=date('Y-m-d');
											      
												 
											   $vb=mysqli_query($con,"select * from frozenmarination where date='$date' and cname='$cname' ");
											   $lastrow=mysqli_num_rows($vb);
											   
											    $num=$lastrow+1;
											   $grn=$result.date('dmy')."00".$num;
											   
											   
											   $tp="";
			$ansc=count($_POST['anss']);
for($i=0;$i< $ansc;$i++)
{
$tp.=mysqli_real_escape_string($con,$_POST["anss"][$i].";");
}

 $cmntc=count($_POST["cmnt"]);
 $tp1="";
for($i1=0;$i1<$cmntc;$i1++)
{
$tp1.=mysqli_real_escape_string($con,$_POST["cmnt"][$i1].";");
}

	$qury=mysqli_query($con,"INSERT INTO frozenmarination (date,batchcode, name, quantity, temperature,  user, tray, wrap, anss, cmnt,cname,stime,etime) VALUES ('$date',
			'$grn', '$sno', '$qty', '$temp', '$user', '$tray', '$wrap', '$tp', '$tp1','$cname','$stime','$etime') ");
			
			
			$gh=mysqli_query($con,"select * from frozenmarination where batchcode='$grn' order by id desc limit 1 ");
			$gh1=mysqli_fetch_array($gh);
											    
 $ans=count($_POST["ans"]);
for($i2=0;$i2<$ans;$i2++)
{
 
 $totalqty=$_POST["totalqty"][$i2];
  $qtyr=$_POST["qtyr"][$i2];
 
$ingredient1=$_POST["ingredient1"][$i2];
			$ub=$_POST["ub".$i2];
			$day=$_POST["day".$i2];
			$qtyy=$_POST["qtyy".$i2];
			
			$qury1=mysqli_query($con,"INSERT INTO frozenmarination1 ( batchcode, product, qty, useby,  useby1, totalqty,cid,qty1) VALUES ( '$grn',
			'$ingredient1', '$totalqty', '$ub', '$day', '$qtyy', '$gh1[id]','$qtyr') ");
		
			
}


$ghr=mysqli_query($con,"SELECT MAX(useby1),MIN(useby1) FROM frozenmarination1 where cid='$gh1[id]'");
	$gh1r=mysqli_fetch_array($ghr);
	$datee=$gh1r['MIN(useby1)'];
	
	$date1 = new DateTime($date);
    $date2 = new DateTime($datee);
    $interval = $date1->diff($date2);
   $diff=$interval->days;
 
 if($diff>=7)
 {
 $dates = $date;
 $useby= date('Y-m-d', strtotime($dates. ' + 7 days'));
 }
 else
 {
 $useby=$datee;
 }
 $ghj=mysqli_query($con,"update frozenmarination set useby='$useby' where batchcode='$grn' and id='$gh1[id]' ");
 
?>


<script language="javascript">
window.open('admin.php?id=fmarination','_self');

</script>
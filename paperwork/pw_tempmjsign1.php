<?php
 
 include '../connection.php';
 $sno=$_POST['sno'];
 $date=date("Y-m-d");
 $sname=$_POST['sname'];
 $signx=$_POST['signx'];
 
 
 
 //$hj=mysqli_query($con,"delete from tblfeedback1 where sno='$sno'");
 
//print_r($_POST);
$uniid="qms".uniqid()."_".$sno;
$folderPath = "sign/";
 
 $image_parts = explode(";base64,", $_POST['signature_image']);
 
$image_type_aux = explode("image/", $image_parts[0]);
 
 $image_type = $image_type_aux[1];
 
$image_base64 = base64_decode($image_parts[1]);
 
 if($image_type=="png")
 {
 $file = $folderPath . $uniid . '.'.$image_type;
 
 file_put_contents($file, $image_base64);

 if($signx==1)
 {
	 $sgh=mysqli_query($con,"UPDATE `oven_temperature_monitoring` SET `operator`='$uniid',`opname`='$sname' WHERE pdate = '$sno'");

 }else if($signx==2){
	 $sgh=mysqli_query($con,"UPDATE `oven_temperature_monitoring` SET `manager`='$uniid',`mname`='$sname' WHERE pdate = '$sno'");

 }

		 
 }
echo $image_type = preg_replace('/\s+/', '', $image_type);
 

 ?>
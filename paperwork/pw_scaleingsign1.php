<?php
 
 include '../connection.php';
 $sno=$_POST['sno'];
 $date=date("Y-m-d");
 $signx=$_POST['signx'];
 $remark=$_POST['remark'];
 
 
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
	 $sgh=mysqli_query($con,"UPDATE `pw_scaleing` SET `supervisor`='$uniid',`sremark`='$remark' WHERE id = '$sno'");

 }else if($signx==2){
	 $sgh=mysqli_query($con,"UPDATE `pw_scaleing` SET `manager`='$uniid',`mremark`='$remark' WHERE id = '$sno'");

 }

		 
 }
echo $image_type = preg_replace('/\s+/', '', $image_type);
 

 ?>
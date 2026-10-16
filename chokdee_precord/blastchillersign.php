<?php
date_default_timezone_set('Europe/London');
include '../connection.php';
$date = $_POST['date'];
$product = $_POST['product'];
 $pid=$_POST['pid'];

$ddate = date("Y-m-d");

//$hj=mysqli_query($con,"delete from tblfeedback1 where sno='$sno'");

//print_r($_POST);
$uniid = uniqid();
$folderPath = "sign/";

$image_parts = explode(";base64,", $_POST['signature_image']);

$image_type_aux = explode("image/", $image_parts[0]);

$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);

if ($image_type == "png") {
  $file = $folderPath . $uniid . '.' . $image_type;

  file_put_contents($file, $image_base64);

  $picid = $uniid . ".png";

  $ddate = date("d-m-Y");


  $sgh = mysqli_query($con, "UPDATE `tblblastchiller` SET `status`='Verified',`vdate`='$ddate',`sign`='$picid' WHERE pdate='$date' AND pname='$product' and pid='$pid'");
  // $sgh1 = mysqli_query($con, "UPDATE `tblsavoury` SET `blastchiller`='Done' WHERE product='$product' and date='$date'");
  $sgh1 = mysqli_query($con, "UPDATE `tblsavoury` SET `blastchiller`='Done' WHERE `product`='$product' AND `date`='$date' and pid='$pid'");
  //$ghj=mysqli_query($con,"insert into tblncverify(sno,img,name)values('$sno','$uniid','$name')");

}
echo $image_type = preg_replace('/\s+/', '', $image_type);


?>
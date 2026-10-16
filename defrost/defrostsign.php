<?php

include '../connection.php';
 $sno = $_POST['sno'];



//$hj=mysqli_query($con,"delete from tblfeedback1 where sno='$sno'");

//print_r($_POST);
$uniid = uniqid();
$folderPath = "../upl1/";

$image_parts = explode(";base64,", $_POST['signature_image']);

$image_type_aux = explode("image/", $image_parts[0]);

$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);

if ($image_type == "png") {
  $file = $folderPath . $uniid . '.' . $image_type;

  file_put_contents($file, $image_base64);

  $picid = $uniid . ".png";
  // print_r("UPDATE `tbldefrost` SET `signature`='$picid' WHERE id ='$sno'");die;
  $sgh = mysqli_query($con, "UPDATE `tbldefrost` SET `signature`='$picid' WHERE id ='$sno'");

  //$ghj=mysqli_query($con,"insert into tblncverify(sno,img,name)values('$sno','$uniid','$name')");

}
 $image_type = preg_replace('/\s+/', '', $image_type);


?>
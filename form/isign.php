<?php
include '../connection.php';

$rid   = mysqli_real_escape_string($con, $_POST['rid']);
$aid   = mysqli_real_escape_string($con, $_POST['aid']);
// $vname = mysqli_real_escape_string($con, $_POST['vname']); 
$date  = date("Y-m-d");


$uniid = uniqid() . "_" . $rid;
$folderPath = "sign/";

$image_parts = explode(";base64,", $_POST['signature_image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

if ($image_type == "png") { 
    $file = $folderPath . $uniid . '.' . $image_type;
 file_put_contents($file, $image_base64);
// echo "UPDATE `tblscales1`  SET `sign` = '$uniid' WHERE  rid ='$rid' " ;die;

    $sql = "UPDATE `tblscales1`  SET `sign` = '$uniid' WHERE  rid ='$rid'  ";

    $sgh = mysqli_query($con, $sql);

    // Check for errors
    if(!$sgh) {
        die("Error updating record: " . mysqli_error($con));
    }
}
 
echo preg_replace('/\s+/', '', $image_type);
?>
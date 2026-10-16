<?php
include '../connection.php';
$sno = $_POST['sno']; 
$date = date("Y-m-d");

$uniid = uniqid()."_".$sno;
$folderPath = "sign/";

$image_parts = explode(";base64,", $_POST['signature_image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

if($image_type == "png") {
    $file = $folderPath . $uniid . '.'.$image_type;
    file_put_contents($file, $image_base64);
    
    // echo "UPDATE `dough1` SET `sign`='$uniid' where recordid= '$sno'";die;
    // Update only the record with matching sno
    $sgh = mysqli_query($con, "UPDATE `dough1` SET `sign`='$uniid' where recordid= '$sno'");
    
    // Check for errors
    if(!$sgh) {
        die("Error updating record: " . mysqli_error($con));
    }
}

echo preg_replace('/\s+/', '', $image_type);
?>
<?php
include 'connection.php';

$sno = $_POST['sno'];
$vname=$_POST['vname'];
// $signer_name =$_POST['sign'];
$uniid = uniqid().date('his');
$folderPath = "sign/";

$image_parts = explode(";base64,", $_POST['signature_image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

if ($image_type == "png") {
    $file = $folderPath . $uniid . '.' . $image_type;
    file_put_contents($file, $image_base64);

    $sgh = mysqli_query($con, "UPDATE `machineverify` SET `vname` ='$vname' ,`sign`='$uniid'  WHERE sno='$sno'");
    
    if ($sgh) {
        $update=mysqli_query($con,"UPDATE `tblequipment1` SET `mverify` = 'done' WHERE `id` ='$sno'");
    }
}

    echo preg_replace('/\s+/', '', $image_type);
    

?>
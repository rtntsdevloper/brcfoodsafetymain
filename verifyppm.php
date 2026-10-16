<?php
include 'connection.php';

$sno = $_POST['sno'];
$uniid = uniqid();
$folderPath = "signature/";

$image_parts = explode(";base64,", $_POST['signature_image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = strtolower(trim($image_type_aux[1]));
$image_base64 = base64_decode($image_parts[1]);

if ($image_type === "png") {
    $file = $folderPath . $uniid . '.' . $image_type;
    file_put_contents($file, $image_base64);
// echo "UPDATE tblequipment1 SET verifysign='$uniid' WHERE id='$sno'";die;
    // Run the update query
    $sgh = mysqli_query($con, "UPDATE tblequipment1 SET verifysign='$uniid' WHERE id='$sno'");

    if ($sgh) {
        echo "Signature saved and record updated successfully.";
    } else {
        echo "Database update failed: " . mysqli_error($con);
    }
} else {
    echo "Unsupported file type.";  
} 
?>

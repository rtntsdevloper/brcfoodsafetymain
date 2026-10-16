
 <?php
 include '../connection.php';
 $sid=$_POST['sid']; 
 $sno=$_POST['sno'];
//  $name = $_POST['check'];
//  $date=date("Y-m-d");
 
 //$hj=mysqli_query($con,"delete from tblfeedback1 where sno='$sno'");
 
//print_r($_POST);
$uniid=uniqid()."_".$sid;
$folderPath = "sign/";
 
 $image_parts = explode(";base64,", $_POST['signature_image']);
 
$image_type_aux = explode("image/", $image_parts[0]);
 
 $image_type = $image_type_aux[1];
 
$image_base64 = base64_decode($image_parts[1]);
 
 if($image_type=="png")
 {
 $file = $folderPath . $uniid . '.'.$image_type;
 
 file_put_contents($file, $image_base64);
 $sgh=mysqli_query($con,"update `weightcontrol1` SET `sign`='$uniid' WHERE id = '$sid' and sno='$sno' ");
 }
 
echo $image_type = preg_replace('/\s+/', '', $image_type);
 

 ?>

</script>

 <?php
 include '../connection.php';
 $rid=$_POST['rid']; 
 
$uniid=uniqid()."_".$rid;
$folderPath = "sign/";
 
 $image_parts = explode(";base64,", $_POST['signature_image']);
 
$image_type_aux = explode("image/", $image_parts[0]);
 
 $image_type = $image_type_aux[1];
 
$image_base64 = base64_decode($image_parts[1]);
 
 if($image_type=="png")
 {
 $file = $folderPath . $uniid . '.'.$image_type;
 
 file_put_contents($file, $image_base64);
//  print_r("update `tblweight1` SET `sign`='$uniid' WHERE recordid = '$rid'");die;
 $sgh=mysqli_query($con,"update `tblweight1` SET `sign`='$uniid' WHERE rid = '$rid'");
 
 
//  $ghj=mysqli_query($con,"insert into tblncverify(sno,img,name)values('$sno','$uniid','$name')");
		 
 }
echo $image_type = preg_replace('/\s+/', '', $image_type);
 

 ?>

</script>
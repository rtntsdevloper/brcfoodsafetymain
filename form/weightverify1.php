
 <?php
 include '../connection.php';
 $sno=$_POST['sno']; 
 $manager=$_POST['manager'];
 
$uniid=uniqid()."_".$sno;
$folderPath = "sign/";
 
 $image_parts = explode(";base64,", $_POST['signature_image']);
 
$image_type_aux = explode("image/", $image_parts[0]);
 
 $image_type = $image_type_aux[1];
 
$image_base64 = base64_decode($image_parts[1]);
 
 if($image_type=="png")
 {
 $file = $folderPath . $uniid . '.'.$image_type;
 
 file_put_contents($file, $image_base64);
//  print_r("update `tblweight` SET `msign`='$uniid', manager='$manager' WHERE id = '$sno'");die;
 $sgh=mysqli_query($con,"update `tblweight` SET `msign`='$uniid',manager='$manager' WHERE id = '$sno'");
 
 
//  $ghj=mysqli_query($con,"insert into tblncverify(sno,img,name)values('$sno','$uniid','$name')");
		 
 }
echo $image_type = preg_replace('/\s+/', '', $image_type);
 

 ?>

</script>
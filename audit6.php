<?php
session_start();
include('functions.php');
include 'connection.php';
ini_set("memory_limit", "99M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
define('IMAGE_MEDIUM_DIR', 'auditpic/');
define('IMAGE_MEDIUM_SIZE', 500);
$y=$_POST['y'];
$sno=$_POST['sn'];
$rt="";
 
 $total = count($_FILES['userImage']['name']);
 
 for( $h=0 ; $h < $total ; $h++ )
 {
 $output['status']=FALSE;
 set_time_limit(0);
 $allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
 createDir(IMAGE_MEDIUM_DIR);
/*create directory with 777 permission if not exist - end by webtechball*/
$path[0] = $_FILES['userImage']['tmp_name'][$h];
$file = pathinfo($_FILES['userImage']['name'][$h]);
$fileType = $file["extension"];

if($fileType=="jpg" || $fileType=="png" || $fileType=="jpeg" || $fileType=="gif")
{

$desiredExt='jpg';
$sourcePath = rand(333, 999) . time() . ".$desiredExt";
$path[1] = IMAGE_MEDIUM_DIR . $sourcePath;
//$path[2] = IMAGE_SMALL_DIR . $sourcePath;
if (createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE,IMAGE_MEDIUM_SIZE)) 
{
$output['status']=TRUE;
$output['image_medium']= $path[1];
}
}
else
{
$sourcePath = $_FILES['userImage']['name'][$h];
move_uploaded_file($_FILES['userImage']['tmp_name'][$h],"auditpic/".$sourcePath);
}
?>
<img src="auditpic/<?php echo $sourcePath;?>"  width="100" />
<?php
 $rt.=$sourcePath.";";
  }

 $y1=mysqli_query($con,"select * from tblgmpaudit3 where id='$sno'");
 $fg=mysqli_fetch_array($y1);
 
 if($fg['img']=="")
 {
 $rt=$rt;
 }
 else if($fg['img']!="")
 {
 $rt=$fg['img'].$rt;
 }

 $dfgg=mysqli_query($con,"update tblgmpaudit3 set img='$rt' where   id='$sno' ");

?>


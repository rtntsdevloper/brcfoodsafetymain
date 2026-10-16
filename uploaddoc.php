<?php
session_start();

include 'connection.php';


$y=$_POST['y'];
   $sno=$_POST['sn'];
  $rt="";
 
 $total = count($_FILES['userImage']['name']);
 
 for( $h=0 ; $h < $total ; $h++ )
	 {
   $sourcePath = $_FILES['userImage']['name'][$h];
  move_uploaded_file($_FILES['userImage']['tmp_name'][$h],"auditpic/".$sourcePath);



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


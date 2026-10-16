<?php  

session_start();

include 'connection.php';

$y=$_GET['y'];
 
 $sno=$_GET['sno'];
 
  $imgname=$_GET['img'].";";
 
 $sqll=mysqli_query($con,"select * from tblgmpaudit3 where id='$sno'");
 $fg=mysqli_fetch_array( $sqll);
 $imgn=$fg['img'];
 
 $strr=str_replace($imgname,"",$imgn);
 
 
 $ui=mysqli_query($con,"update tblgmpaudit3 set img='$strr' where id='$sno'");
 
 $tagsd = explode(';' , $strr);
foreach($tagsd as $keyd)
  {
   $infod= new SplFileInfo($keyd);
  $tped=$infod->getExtension();
  
  if($tped=="jpg" || $tped=="jpeg" || $tped=="png" || $tped=="PNG")
    {
  ?>
 <img src="auditpic/<?php echo $keyd;?>" width="100" /><a href"#" class="notificationn" id="ghjk<?php echo $y;?>" onclick="return bnm('<?php echo $keyd;?>','<?php echo $sno;?>','<?php echo $y;?>')" style="cursor:pointer"> <span class="badge">X</span></a>
  <?php
  }
  }
 ?>  
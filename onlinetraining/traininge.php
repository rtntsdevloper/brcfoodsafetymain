<?php
session_start();
$sno=$_GET['sno'];
$modid=$_GET['modid'];
$scrsid=$_GET['scrsid'];
$curdate=date('Y-m-d');
include '../connection.php';


$query=mysqli_query($con,"select * from tblonlinetraining where id='$scrsid'");
$query1=mysqli_fetch_array($query);

$name=$query1['name'];


$sql0=mysqli_query($con,"select * from tbltrainingrecord where modid='$modid' and staffid='$_SESSION[staffid]'");
$num0=mysqli_num_rows($sql0);

   if($num0 == 0)
   { 
   $sql1=mysqli_query($con,"insert into  tbltrainingrecord(staffid,subcrsid,modid,imgno,curdate,status)values
   ('$_SESSION[staffid]','$scrsid','$modid','$sno','$curdate','Incomplete')");
   }
 $sql=mysqli_query($con,"select * from tblppt where modid='$modid' and imgno='$sno'");
 $r=mysqli_fetch_array($sql);
 $imgpath=$r['name'];
 $vidpath=$r['vidpath'];

  ?>
<?php
$s0=mysqli_query($con,"select * from tblppt where modid='$modid' order by imgno DESC limit 1");
$t0=mysqli_fetch_array($s0);
$timg=$t0['imgno'];
$tprcnt=round((($sno/$timg)* 100));
$sql3=mysqli_query($con,"select * from tbltrainingrecord where modid='$modid'  and staffid='$_SESSION[staffid]'");
$r3=mysqli_fetch_array($sql3);
$limgno=$r3['imgno'];
if($sno > $limgno && $sno < $timg)
{
$sql4=mysqli_query($con,"update tbltrainingrecord set imgno='$sno',status='Incomplete' where modid='$modid' and staffid='$_SESSION[staffid]'");
}
else if($sno == $timg)
{
$sql4=mysqli_query($con,"update tbltrainingrecord set imgno='$sno',status='Completed' where modid='$modid'  and staffid='$_SESSION[staffid]'");
}
?>
 
		
	 
	 <?php
	 if($imgpath!="")
	 {
	 ?>
	<div class="col-7">  
	 <img  src="../slider/<?php echo $imgpath;?>" name="img1" id="img1" height="500" style="width:100%"  />
	 </div>
	 <div class="col-4" >
	  <video  id="myVideo"   onloadstart="chkk1()" poster="aunty.jpg" height="500" > 
	   <source  src="../videos/<?php echo  $vidpath;?>"  >
	</video>
	</div>
	 <?php
	 }
	 else
	 {
	 ?>
	
	 <div class="col-11" name="img1" id="img1">
	  <video  id="myVideo"   onloadstart="chkk1()" poster="aunty.jpg" height="500" > 
	   <source  src="../videos/<?php echo  $vidpath;?>"  >
	</video>
	</div>
	
       <?php
	   }
	   ?>
	
      <div class="col-1">
	  <?php
	  if($sno == 1)
	  {
	  ?>
	 <button type="button" rel="tooltip" title="<?php echo ($sno + 1);?>,<?php echo $modid;?>" class="btn btn-danger" onclick="showNext(<?php echo ($sno + 1);?>,<?php echo $modid;?>)" style="width:100px; margin:2px;">
	<?php echo $query1['p5'];?></button>
	 <?php
	 }
     else if($sno == $timg)
     { 
     ?>
	 <button type="button" rel="tooltip" title="Next" class="btn btn-gfg" style="width:100px; margin:2px;"> <?php echo $query1['p5'];?>  </button>
	 <?php
	 }
     else
     {
	 ?> 
	 <button type="button" rel="tooltip" title="<?php echo ($sno + 1);?>,<?php echo $modid;?>" class="btn btn-danger" onclick="showNext(<?php echo ($sno + 1);?>,<?php echo $modid;?>)" style="width:100px; margin:2px;">
	 <?php echo $query1['p5'];?> </button>
	 <?php
	 }
	 ?>
	   
	  <button type="button" rel="tooltip" title="Pause" class="btn btn-success" onClick="chkk()" id="pause" style="width:100px; margin:2px;">
	  <?php echo $query1['p7'];?> </button>
	  <button type="button" rel="tooltip" title="Pause" class="btn btn-success" onClick="chkk1()" id="play" style="display:none;width:100px; margin:2px;">
	  
	  <?php echo $query1['p8'];?> </button>
	  <?php
	  if($sno == 1)
	  {
	  ?>													
	  <button type="button" rel="tooltip" title="Previous" class="btn btn-ss" style="width:100px; margin:2px;">
	<?php echo $query1['p6'];?>
	  </button>
      
	   <?php
       }
       else if($sno == $timg)
       { 
       ?>
	 <button type="button" rel="tooltip" title="Previous" class="btn btn-danger" onclick="showNext(<?php echo ($sno - 1);?>,<?php echo $modid;?>)" style="width:100px; margin:2px;">
	 <?php echo $query1['p6'];?>
	  </button>
	     <?php
	     }
         else
         {
	     ?> 
    	 <button type="button" rel="tooltip" title="Previous" class="btn btn-danger" onclick="showNext(<?php echo ($sno - 1);?>,<?php echo $modid;?>)" style="width:100px; margin:2px;">
	    <?php echo $query1['p6'];?>
	     </button>
      	<?php
     	}
	    ?>
	</div>
	
	
     <div class="col-12">
	 <div style="text-align:left; background:#CCCCCC;border:#000000 1px solid; height:10px; border-radius:5px;"> 	
	 <div style="width:<?php echo $tprcnt;?>%;background:#FF9900;height:8px; border-radius:5px;"> </div>	 
	 </div>
     </div>
 
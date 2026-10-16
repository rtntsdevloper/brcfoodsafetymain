<?php
include('functions.php');
include 'connection.php';
ini_set("memory_limit", "99M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
define('IMAGE_MEDIUM_DIR', 'documents/');
define('IMAGE_MEDIUM_SIZE', 500);

$output['status']=FALSE;
set_time_limit(0);
$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
createDir(IMAGE_MEDIUM_DIR);
/*create directory with 777 permission if not exist - end by webtechball*/
$path[0] = $_FILES['userImage']['tmp_name'];
$file = pathinfo($_FILES['userImage']['name']);
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
$sourcePath = $_FILES['userImage']['name'];
move_uploaded_file($_FILES['userImage']['tmp_name'],"documents/".$sourcePath);

}


  $sid=$_POST['sid'];
  $qid=$_POST['qid'];
   $rid=$_POST['rid'];
$rt="";


  $rt.=$sourcePath.";";
 $y1=mysqli_query($con,"select * from saveaudit where sno='$rid' and ques='$qid' and fid='$sid'");
 $fg=mysqli_fetch_array($y1);
 
 if($fg['document']=="")
 {
 $rt=$rt;
 }
 else if($fg['document']!="")
 {
 $rt=$fg['document'].$rt;
 }


$sql=mysqli_query($con,"update saveaudit set document='$rt' where sno='$rid' and ques='$qid' and fid='$sid'");
?>
  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Id</th>
                                          
                                            <th>Document</th>
											 <th>Delete</th>
                                            
                                        </thead>
                                        <tbody>
										
										

										<?php
					$query=mysqli_query($con,"select * from saveaudit where sno='$rid' and ques='$qid' and fid='$sid' ");
							$rows=mysqli_fetch_array($query)
                                   ?>  
								   <?php
					$string = $rows['document'];
$tags1 = explode(';' , $string);
$i=0;
foreach($tags1 as $key1)
  {
  $i++;
   $info5= new SplFileInfo($key1);
  $tpe5=$info5->getExtension();
  if($tpe5!="")
  {
  ?>       
								   <tr>
                                    <td><?php echo $i;?></td>
                    <td>
					<a href="documents/<?php echo $key1;?>" target="_blank" style="color:#0066FF"> 
					<?php echo $key1;?></a>
					 </td>
					
					<td><a href="#" onclick="return bnm(<?php echo $rows['id'];?>,'<?php echo $key1;?>');"><i class="fa fa-trash" ></i></a></td>
                                 
                                            </tr>
                                            <?php
					}
					}
					?>             
											
                                        </tbody></table>
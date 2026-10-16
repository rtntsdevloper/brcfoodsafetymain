<?php
include 'connection.php';
$id=$_GET['q'];

$tid=$_GET['tid'];


$fid="";

?>

                                            <label for="validationTooltip03"> Select Clause</label>
                                          <select class="form-control" required name="p3[]" multiple="multiple">
										
										  <?php
										  
  $gh=mysqli_query($con,"select * from subtest1 where tid='$tid' and sid='$id'");
  while($rows=mysqli_fetch_array($gh))
  {
  
  
							  
							   if($rows['ssid']!="")
							   {
							  
							   $fid=$rows['ssid'];
							   }
							   else
							   {
							     
							    $fid=$rows['fid'];
							   }
							   
							   
							   
  ?>
										  <option value="<?php echo $fid;?>"><?php echo $rows['fid'];?></option>
										  
										  <?php
										  }
										  ?>
										  </select>
                                         

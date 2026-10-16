



<?php
include 'connection.php';
$auditor=$_GET['q'];

$sh=mysqli_query($con,"select * from tblauditor where id='$auditor'");
$hj=mysqli_fetch_array($sh);



?>

<div class="col-md-4 mb-3">
                                            <label for="validationTooltip03"> Select Requirements</label>
                                          <select class="form-control" required name="s2" onchange="return showHint1(this.value,'<?php echo $auditor;?>')">
										   <option>Please Select</option>
										  <?php
										  $string = $hj['tid'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
  $gh=mysqli_query($con,"select * from addtest1 where testid='$key1'");
  while($rows=mysqli_fetch_array($gh))
  {
  ?>
  <option value="<?php echo $rows['testid'];?>"><?php echo $rows['testid'];?>. <?php echo $rows['subject'];?></option>
										  
										  <?php
										  }}
										  ?>
										  </select>
                                            <div class="invalid-tooltip">
                                              
                                            </div>
                                        </div>
										
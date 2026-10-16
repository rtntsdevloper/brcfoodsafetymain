<?php
include 'connection.php';
$id=$_GET['q'];

$auditor=$_GET['auditor'];


$sh=mysqli_query($con,"select * from tblauditor where id='$auditor'");
$hj=mysqli_fetch_array($sh);



?>

<div class="col-md-4 mb-3">
                                            <label for="validationTooltip03"> Select Requirements</label>
                                          <select class="form-control" required name="s3[]" multiple="multiple">
										   <option>Please Select</option>
										  <?php
										  $string = $hj['sid'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
  $gh=mysqli_query($con,"select distinct sid from subtest where tid='$id' and sid='$key1'");
  while($rows=mysqli_fetch_array($gh))
  {
  
  $gh1=mysqli_query($con,"select * from subtest where sid='$rows[sid]'");
  $rows1=mysqli_fetch_array($gh1);
  ?>
										  <option value="<?php echo $rows['sid'];?>"><?php echo $rows['sid'];?>. <?php echo $rows1['subtest'];?></option>
										  
										  <?php
										  }}
										  ?>
										  </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid password.
                                            </div>
                                        </div>
										
										
										

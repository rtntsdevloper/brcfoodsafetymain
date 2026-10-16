<?php
include 'connection.php';
$q=$_GET['q'];
?>

                                            <label for="validationTooltip03"> Select Sub-Section</label>
                                          <select class="form-control" required name="p2" onchange="return showHint1(this.value,'<?php echo $q;?>')">
										   <option>Please Select</option>
										  <?php
										
  $gh=mysqli_query($con,"select * from subtest where tid='$q'");
  while($rows=mysqli_fetch_array($gh))
  {
  ?>
  <option value="<?php echo $rows['sid'];?>"><?php echo $rows['sid'];?>.<?php echo $rows['subtest'];?></option>
										  
										  <?php
										  }
										  ?>
										  </select>
                                           
<?php
include '../connection.php';

$str=$_GET['q'];


$sql2=mysqli_query($con,"select * from tblrecipe where id='$str'");
$row2=mysqli_fetch_array($sql2);
											
?>

                                              <label for="validationTooltip02">Select Batchcode</label>
                                            <select class="form-control" name="batchcode"  id="batchcode">
											<option value="">Please Select</option>
											<?php
											$sqli=mysqli_query($con,"select * from tblmarination where name='$str' and  status='Done' and oxygen ='done' order by date DESC ");
											while($row=mysqli_fetch_array($sqli))
											{
											?>
											
											<option value="<?php echo $row['batchcode'];?>"><?php echo $row['batchcode'];?></option>
											<?php
											}
											?>
											</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
											
											
											<input type="hidden" name="productname" id="productname" value="<?php echo  $row2['name'];?>"  />
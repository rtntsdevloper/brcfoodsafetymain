 <?php 
 include '../connection.php';
   $sno=$_GET['q'];
?>
                                            <option value="">Please Select</option>
										    <?php
											$sql3=mysqli_query($con,"select * from tblrawmaterial where supid='$sno' order by pcode ASC");
											while($rows3=mysqli_fetch_array($sql3))
											{
											?>
											<option value="<?php echo $rows3['id'];?>"> <?php echo $rows3['pcode'];?> - <?php echo $rows3['pname'];?></option>
											
											<?php
											}
											
											?>
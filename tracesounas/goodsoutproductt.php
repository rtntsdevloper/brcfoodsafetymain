 <?php 
 include '../connection.php';
 $sno=$_GET['q'];
  $sno1=$_GET['sno'];
?>
									<div class="col-12">
                                                      <label for="x_card_code" class="control-label mb-1">Select Product</label>
                                                      <div class="input-group" >
                                                       <select class="form-control" id="product"  onchange="prod(this.value)">
													   <option value="">Please Select</option>
                                            
										    <?php
											$sql3=mysqli_query($con,"select * from tblgoodsoutproduct where cid='$sno1' and catg='$sno' order by prodname ASC");
											while($rows3=mysqli_fetch_array($sql3))
											{
											?>
											<option value="<?php echo $rows3['id'];?>">  <?php echo $rows3['prodname'];?></option>
											
											<?php
											}
											
											?>
											</select></div></div>
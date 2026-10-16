	<?php 
 include '../connection.php';
 $sno=$_GET['q'];
 $sql=mysqli_query($con,"select * from tblbrand where id='$sno'");
  $row=mysqli_fetch_array($sql);
														
?> 
<?php
if($row['contact']=="NA")
{
?>
<div class="row">
<div class="col-12">
                                                      <label for="x_card_code" class="control-label mb-1">Select Product</label>
                                                      <div class="input-group" >
                                                       <select class="form-control" id="product"  onchange="prod(this.value)">
													   <option value="">Please Select</option>
											<?php
											$sql3=mysqli_query($con,"select * from tblgoodsoutproduct where cid='$sno' order by prodname ASC");
											while($rows3=mysqli_fetch_array($sql3))
											{
											?>
											<option value="<?php echo $rows3['id'];?>">  <?php echo $rows3['prodname'];?></option>
											<?php
											}
											
											?>
													 
													   </select>
													
                                                        </div>
                                                    </div>
<?php
}
else
{

?>
                                                      <div class="col-12">
                                                      <label for="x_card_code" class="control-label mb-1">Select Category</label>
                                                      <div class="input-group" >
                                                       <select class="form-control" id="catg" onchange="getsupplier1(this.value,'<?php echo $sno;?>')" required>
													   <option value="">Please Select</option>
													   <?php
													   $string = $row['contact'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
  ?>
													 <option value="<?php echo $key1;?>"><?php echo $key1;?></option>
													 <?php
													 }
													 ?>
													   </select>
													  
                                                        </div>
                                                    </div>
													
													
													
													<?php
													}
													?></div>
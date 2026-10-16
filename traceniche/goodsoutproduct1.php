 <?php 
 include '../connection.php';
 $sno=$_GET['q'];
 $sql=mysqli_query($con,"select * from tblgoodsoutproduct where id='$sno'");
 $row=mysqli_fetch_array($sql);
 
  $sql1=mysqli_query($con,"select * from tblbrand where id='$row[cid]'");
  $row1=mysqli_fetch_array($sql1);
 
 ?>
<input type="hidden" name="prodname" id="prodname" value="<?php echo $row['prodname'];?>" />
<input type="hidden" name="bid" id="bid" value="<?php echo $row['cid'];?>" />
<input type="hidden" name="brandname" id="brandname" value="<?php echo $row1['name'];?>" />

                                           
										    
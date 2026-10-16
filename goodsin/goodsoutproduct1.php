 <?php 
 include '../connection.php';
 $sno=$_GET['q'];
 $sql=mysqli_query($con,"select * from tblrawmaterial where id='$sno'");
 $row=mysqli_fetch_array($sql);
 

 ?>
 
<input type="hidden" name="prodname" id="prodname" value="<?php echo $row['pname'];?>" />

                                           
										    
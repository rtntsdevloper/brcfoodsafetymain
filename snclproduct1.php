<?php
include 'connection.php';
 $q= $_GET['q'];

?>
<label id="error">Select Product</label>


<select type="text" class="form-control border-input"  name="name" required  >
									  <option value=""> Select Product</option>
									  <?php
									  $sql=mysqli_query($con,"select *   from tblsnclproduct where cate1='$q'");
									  while($row=mysqli_fetch_array($sql))
									  {
									  ?>
									   <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
									   <?php
									   }
									   ?>
									  </select>
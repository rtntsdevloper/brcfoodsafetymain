  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Weight Check - (Add New) </a></li>
  				</ul>

  			</div>
  		</div>
  	</div>
  </div>

  <div class="col-xl-12" style="margin-bottom:20px">

  	<a href="admin.php?id=addpusage"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

  </div>


  <div class="col-sm-12">
  	<div class="card">

  		<div class="card-body">
  			<h4 style="color:#3399FF">Add Weight Check</h4>






  			<form name="form1" method="post" action="" enctype="multipart/form-data">
  				<div class="row">


  					<div class="col-md-6">
  						<label for="cc-exp" class="control-label mb-1"> Date</label>
  						<div class="input-group">
  							<input type="date" name="date" id="date" class="form-control" required />

  						</div>
  					</div>
  					<div class="col-md-6">
  						<label for="cc-exp" class="control-label mb-1"> Operator Name</label>
  						<input type="text" name="opnm" class="form-control" required>
  					</div>
  					<div class="col-md-6">
  						<label for="cc-exp" class="control-label mb-1"> Machine Number</label>
  						<input type="text" name="mcn" class="form-control" required>
  					</div>



  					<div class="col-6 mt-3">
  						<label for="cc-exp" class="control-label mb-1">Select Product</label>
  						<div class="input-group">
  							<select name="prodnm" id="pdnm" class="form-control">
  								<option>Select Product</option>
  								<?php

									$pd = mysqli_query($con, "Select * from tblflavourmix");
									foreach ($pd as $pdata) {
									?>
  									<option value="<?php echo $pdata['productname']; ?>" data-name="<?php echo $pdata['batch']; ?>" data-date="<?php echo $pdata['useby1']; ?>"><?php echo $pdata['productname']; ?> (<?php echo $pdata['batch']; ?>)</option>
  								<?php
									}



									?>


  							</select>

  						</div>
  					</div>
  				</div>
  				<div class="row mt-3">
  					<script>
  						document.getElementById('pdnm').addEventListener('change', function() {
  							const selectedOption = this.options[this.selectedIndex];
  							const dataName = selectedOption.getAttribute('data-name');
  							const dataDate = selectedOption.getAttribute('data-date');

  							document.getElementById('ubd').value = dataDate;
  							document.getElementById('btcode').value = dataName;

  						});
  					</script>


  					<div class="col-6">
  						<label for="cc-exp" class="control-label mb-1">Batchcode</label>
  						<div class="input-group">



  							<input type="text" name="btch" class="form-control" id="btcode" placeholder="Enter in kg" required />
  						</div>
  					</div>
  					<div class="col-6">
  						<label for="cc-exp" class="control-label mb-1">Use By/Best Before Date</label>
  						<div class="input-group">



  							<input type="date" name="ubdate" class="form-control" id="ubd" placeholder="Enter in kg" required />
  						</div>
  					</div>
  					
  					<div class="col-6">
  						<label for="cc-exp" class="control-label mb-1"></label>
  						<div class="input-group">

  							<button class="btn btn-info" type="submit" name="submit">Save & Next</button>
  						</div>
  					</div>
  					<br />

  				</div>
  			</form>
  		</div>
  	</div>
  </div>

  <?php
	if (isset($_POST['submit'])) {
		// Basic input sanitization
		$opname = $_POST['opnm'];
		$date = $_POST['date'];
		$machine = $_POST['mcn'];
		$product = $_POST['prodnm'];
		$batch = $_POST['btch'];
		$useb = $_POST['ubdate'];


		$result = mysqli_query($con, "INSERT INTO `tblweight`(`name`, `serial`, `date`, `product`, `batch`, `useby`) VALUES ('$opname','$machine','$date','$product','$batch','$useb')");


		if ($result) {

			echo '<script>window.location.href = "admin.php?id=weightcheck";</script>';
		} else {
			echo "<script>alert('Error adding Delivery Log: " . addslashes(mysqli_error($con)) . "');</script>";
		}

	?>

  
  <?php
	}
	?>
  <?php

	$batch = $_GET['batch'];
	$qs = mysqli_query($con, "SELECT * FROM `tblflavourmix` WHERE batch='$batch'");
	$qs1 = mysqli_fetch_array($qs);
	$bid = $qs1['id'];


	$fid = $qs1['flavourid'];
	$fnm = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id= $fid");
	$fnm1 = mysqli_fetch_array($fnm);
	$flnm = $fnm1['pname'];


	// print_r("SELECT * FROM `tblgrn1` WHERE product='$fid'");


	?>


  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Frying Record - (Add New) </a></li>
  				</ul>

  			</div>
  		</div>
  	</div>
  </div>

  <div class="col-xl-12" style="margin-bottom:20px">

  	<!-- <a href="admin.php?id=addmarination&id2= ?>"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a> -->

  </div>




  <div class="col-sm-12">
  	<div class="card">

  		<div class="card-body">





  			<form method="post" enctype="multipart/form-data">
  				<div class="row">




  					<div class="col-md-12">
  						<h4 class="text-primary mt-5 mb-3">Flavour Records </h4>
  						<h4 class="text-primary mt-5 mb-3">Flavour : <?php echo $flnm; ?> </h4>
  						<div class="row">



  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Select Flavour Batch</label>
  								<select name="flvb" class="form-control" id="flvid">
  									<option>Select Grn Batch</option>

  									<?php

										$sg = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE product='$fid'");
										foreach ($sg as $sgdata) {
										?>
  										<option value="<?php echo $sgdata['grn']; ?>" data-name="<?php echo $sgdata['leftqty']; ?>" data-date="<?php echo $sgdata['useby']; ?>"><?php echo $sgdata['grn']; ?></option>
  									<?php
										}

										?>

  								</select>
  							</div>
  							<script>
  								document.getElementById('flvid').addEventListener('change', function() {
  									const selectedOption = this.options[this.selectedIndex];
  									const dataName = selectedOption.getAttribute('data-name');
  									const dataDate = selectedOption.getAttribute('data-date');

  									document.getElementById('stw').value = dataName;
  								
  								});
  							</script>
  							
  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Start Weight</label>
  								<input type="text" class="form-control" name="stw" id="stw" required />
  							</div>







  						</div>
  					</div>


  					<div class="row ml-3 mt-3">

  						<button type="submit" class="btn btn-primary" name="btn">Submit</button>
  					</div>


  				</div>
  			</form>
  		</div>
  	</div>
  </div>


  <?php

	if (isset($_POST['btn'])) {
		$flbb = $_POST['flvb'];
		$flbw = $_POST['stw'];

		//  print_r("UPDATE `tblflavourmix` SET `flvbatch`='$flbb',`flavourtotal`='$flbw' WHERE batchcode ='$batch'");die;

		$oiadd = mysqli_query($con, "UPDATE `tblflavourmix` SET `flvbatch`='$flbb',`flavourtotal`='$flbw' WHERE batch ='$batch'");
		if ($oiadd) {
	?>
  		<script>
  			document.location.href = 'admin.php?id=flavourmix';
  		</script>
  <?php
		}
	}


	?>
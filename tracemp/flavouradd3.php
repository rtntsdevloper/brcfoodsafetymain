  <?php

	$fid = $_GET['fid'];
	$qs = mysqli_query($con, "SELECT * FROM `tblflavourmix` WHERE id ='$fid'");
	$qs1 = mysqli_fetch_array($qs);
	$batch = $qs1['batch'];
	$bid = $qs1['id'];
	$flbt = $qs1['flvbatch'];
	$fid = $qs1['flavourid'];

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






  <div class="col-sm-12">
  	<div class="card">

  		<div class="card-body">





  			<form method="post" enctype="multipart/form-data">
  				<div class="row">




  					<div class="col-md-12">
  						<h4 class="text-primary mt-5 mb-3">Flavour Records </h4>
  						<h4 class="text-primary mt-5 mb-3">Flavour : <?php echo $flnm; ?> (GRN: <?php echo $flbt; ?> ) </h4>
  						<div class="row">



  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Start Weight (In Kg )</label>
  								<input type="text" class="form-control" value="<?php echo $qs1['flavourtotal']; ?> Kg" name="strw" readonly />
  							</div>

  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">End Weight (In Kg ) </label>
  								<input type="text" class="form-control" name="endw" id="stw" required />
  							</div>

  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Enter Useby/Best Before Date</label>
  								<input type="date" class="form-control" name="bstdate" required />
  							</div>


  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Any Additional Batch Used</label>
  								<select name="adbatch"  class="form-control">
  									<option>-- Please Select --</option>
  									<option value="Yes">Yes</option>
  									<option value="No">No</option>
  								</select>
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
		$strlw = $_POST['strw'];
		$flbb = $_POST['endw'];
		$bstdate = $_POST['bstdate'];

		$totaluse = (float)$strlw - (float)$flbb;

		$adbatch = $_POST['adbatch'];


		$oiadd = mysqli_query($con, "UPDATE `tblflavourmix` SET `flavouruse`='$totaluse',`flavourleft`='$flbb',`useby1`='$bstdate',`adbatch`='$adbatch' WHERE batch ='$batch'");


		$qstin = mysqli_query($con, "INSERT INTO `tblflavourmix1`(`batch`, `grncode`,`pid`, `qty`,`gtotal`,mark) VALUES ('$batch','$flbt','$fid','$totaluse','$strlw','F')");

		$updt = mysqli_query($con, "UPDATE `tblgrn1` SET `leftqty`='$flbb' WHERE grn ='$flbt'");



		if ($oiadd and $qstin and $updt) {
			if ($adbatch == "Yes") {

	?>
  			<script>
  				document.location.href = 'admin.php?id=flavouradd4&batch=<?php echo $batch; ?>&fid=<?php echo $fid; ?>';
  			</script>

  		<?php
			} else {
			?>
  			<script>
  				document.location.href = 'admin.php?id=flavourmix';
  			</script>
  <?php
			}
		}
	}


	?>
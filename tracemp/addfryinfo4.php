  <?php

	$fid = $_GET['fid'];

	$fst = mysqli_query($con, "SELECT * FROM `tblfryinfo` WHERE id= $fid");
	$fst1 = mysqli_fetch_array($fst);

	$batch = $fst1['batchcode'];





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
  					<input type="hidden" name="batch" value="<?php echo $batch; ?>">



  					<div class="col-md-12">
  						<h4 class="text-primary mt-5 mb-3">Frying Records </h4>
  						<div class="row">

  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Gas off Time</label>
  								<input type="time" class="form-control" name="oiltime" required />
  							</div>

  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Oil Take Out Temperature</label>
  								<div class="input-group mb-2">

  									<input type="number" class="form-control" id="inlineFormInputGroup" name="oiltemp" placeholder="temperature" required>
  									<div class="input-group-prepend">
  										<div class="input-group-text"><sup>o</sup>C</div>
  									</div>
  								</div>
  							</div>
  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Total Quantity after Frying (In Kg)</label>
  								<div class="input-group mb-2">

  									<input type="number" class="form-control" id="inlineFormInputGroup" name="tqty" placeholder="Quantity" required>
  									<div class="input-group-prepend">
  										<div class="input-group-text">Kg</div>
  									</div>
  								</div>
  							</div>
							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Enter Use By/ Best Before Date</label>
  								<div class="input-group mb-2">

  									<input type="date" class="form-control" id="inlineFormInputGroup" name="ubdate" required>
  									
  								</div>
  							</div>
							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Enter Wastage</label>
  								<div class="input-group mb-2">

  									<input type="text" class="form-control" id="inlineFormInputGroup" name="pwastage">
  									<div class="input-group-prepend">
  										<div class="input-group-text">Kg</div>
  									</div>
  								</div>
  							</div>





  						</div>
  					</div>


  					<div class="row ml-3 mt-3">

  						<button type="submit" class="btn btn-primary" name="btn">Save & Next</button>
  					</div>


  				</div>
  			</form>
  		</div>
  	</div>
  </div>


  <?php

	if (isset($_POST['btn'])) {
		$oiltemp = $_POST['oiltemp'];
		$oiltime = $_POST['oiltime'];
		$totalqty = $_POST['tqty'];
		$ubdate = $_POST['ubdate'];
		$pwastage = $_POST['pwastage'];


		$cbt = mysqli_query($con,"SELECT * FROM `tblfrybatch` WHERE status='Active'");
		$cbt1 = mysqli_fetch_array($cbt);
		$cbtnm = $cbt1['name'];
		// print_r("UPDATE `tblfryinfo` SET `stime`='$oiltime',`stemp`='$oiltemp' WHERE batchcode ='$batch'");die;
		if (empty($fst1['topup'])) {
			$oiadd = mysqli_query($con, "UPDATE `tblfryinfo` SET `taketime`='$oiltime',`totalall`= '$totalqty',`taketemp`='$oiltemp',`totalqty`= '$totalqty',`topup`= 'No',`useby`= '$ubdate',`cookbatch`='$cbtnm',`wastage`='$pwastage' WHERE id ='$fid'");
		} else {
	
			$oiadd = mysqli_query($con, "UPDATE `tblfryinfo` SET `taketime`='$oiltime',`taketemp`='$oiltemp',`totalqty`= '$totalqty',`totalall`= '$totalqty',`useby`= '$ubdate',`cookbatch` ='$cbtnm',`wastage`='$pwastage' WHERE id ='$fid'");
		}



		if ($oiadd) {
			echo 'go';
	?>
  		<script>
  			document.location.href = 'admin.php?id=fryrecord';
  		</script>
  <?php
		}
	}


	?>
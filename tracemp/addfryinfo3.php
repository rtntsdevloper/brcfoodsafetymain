  <?php

	$batch = $_GET['batch'];





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





  			<form method="post"  enctype="multipart/form-data">
  				<div class="row">
  					<input type="hidden" name="batch" value="<?php echo $batch; ?>">



  					<div class="col-md-12">
  						<h4 class="text-primary mt-5 mb-3">Frying Records </h4>
  						<div class="row">



  							<div class="col-md-6 col-sm-12">
								<label for="cc-exp" class="control-label mb-1">Oil Input Temperature</label>
  								<div class="input-group mb-2">

                                    <input type="number" class="form-control" id="inlineFormInputGroup" name="oiltemp" placeholder="temperature" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
  							</div>

  							<div class="col-md-6 col-sm-12">
  								<label for="cc-exp" class="control-label mb-1">Gas On Time</label>
  								<input type="time" class="form-control" name="oiltime"  required />
  							</div>

  							

  						</div>
  					</div>


  					<div class="row ml-3 mt-3">

					<button type="submit" class="btn btn-primary" name="btn" >Submit</button>
					</div>


  				</div>
  			</form>
  		</div>
  	</div>
  </div>


  <?php

  if(isset($_POST['btn'])){
	$oiltemp = $_POST['oiltemp'];
	$oiltime = $_POST['oiltime'];

	// print_r("UPDATE `tblfryinfo` SET `stime`='$oiltime',`stemp`='$oiltemp' WHERE batchcode ='$batch'");die;

	$oiadd = mysqli_query($con,"UPDATE `tblfryinfo` SET `stime`='$oiltime',`stemp`='$oiltemp' WHERE batchcode ='$batch'");
	if($oiadd){
		?>
<script>
    document.location.href = 'admin.php?id=fryrecord';
</script>
		<?php
	}
  }


?>
  <?php

	$batch = $_GET['batch'];
	$sqq = mysqli_query($con, "select * from `tblflavourmix` where batch='$batch'");
	$rowq = mysqli_fetch_array($sqq);

	$rowid = $rowq['id'];
	$str = $rowq['quantity'];





	?>


  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Flavour mixing record - (Add New) </a></li>
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
  			<h4 style="color:#3399FF">Product: Fried Potatos</h4>
  			<div class="row">
  				<div class="col-md-4 col-sm-6"><input type="text" class="form-control" value="<?php echo $str; ?> Kg" readonly></div>
  				<div class="col-md-6"></div>
  			</div>




  			<form method="post" action="tracemp/addfryqty" enctype="multipart/form-data">
  				<div class="row">
  					<input type="hidden" name="batch" value="<?php echo $batch; ?>">



  					<div class="col-md-12">
  						<h4 class="text-primary mt-5 mb-3">All Available Batches : </h4>
  						<div class="row">



  							<?php
								$sqlp = mysqli_query($con, "SELECT *  FROM `tblfryinfo` where totalqty != 0;");
								$i = 1;
								foreach ($sqlp as $pdata) {
								?>

  								<div class="col-md-4">
  									<label for="cc-exp" class="control-label mb-1">Left Quantity (In Kg)</label>
  									<input type="text" class="form-control" name="day<?php echo $i; ?>" value="<?php echo htmlspecialchars($pdata['totalqty']); ?>" disabled="disabled" />
  								</div>

  								<div class="col-md-4">
  									<label for="cc-exp" class="control-label mb-1">Use By (Batchcode :<?php echo $pdata['batchcode'];?> ):</label>
  									<input type="date" class="form-control" name="day<?php echo $i; ?>" value="<?php echo htmlspecialchars($pdata['useby']); ?>" disabled="disabled" />
  								</div>

  								<div class="col-md-4">
  									<label for="x_card_code" class="control-label mb-1" id="qused<?php echo $i; ?>"> Quantity Used (In Kg) </label>
  									<input type="number"
  										class="form-control"
  										name="qty<?php echo $i; ?>"
  										id="qty<?php echo $i; ?>"
  										min="0"
  										step="0.001"
  										max="<?php echo $pdata['totalqty']; ?>"
  										oninput="calculateQuantity(this.value, <?php echo $pdata['id']; ?>,<?php echo $i; ?>)" />
  								</div>
  							<?php
									$i++;
								}



								?>
  						</div>
  					</div>


  					<div class="col-md-6 mt-3 " id="newk">


  					</div>


  				</div>
  			</form>
  			<script>
  				function calculateQuantity(quantity, qid, index) {

  					// Basic validation
  					const batch = <?php echo json_encode($batch); ?>;
  					const str = <?php echo json_encode($str); ?>;
  					if (isNaN(quantity) || quantity < 0) {
  						document.getElementById('qused' + index).innerHTML = "Please enter a valid quantity";
  						return;
  					}


  					// Make the AJAX request
  					const xhr = new XMLHttpRequest();
  					xhr.onreadystatechange = function() {
  						if (this.readyState === 4) {
  							if (this.status === 200) {
  								// Update the label with the response


  								document.getElementById('newk').innerHTML = this.responseText;
  							} else {
  								console.error("Request failed with status:", this.status);
  								document.getElementById('qused' + index).innerHTML = "Error updating quantity";
  							}
  						}
  					};



  					xhr.open("GET", "tracemp/frypotato.php?quantity=" + quantity +
  						"&qid=" + qid + "&str=" + str + "&batch=" + batch, true);
  					xhr.send();

  				}
  			</script>

  		</div>
  	</div>
  </div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php
$dt = date('Y-m-d');
$date = new DateTime($dt);
$date->sub(new DateInterval('P7D'));
$dt1 = $date->format('Y-m-d') . "\n";





?>
<div class="page-header">
	<div class="page-block">
		<div class="row align-items-center">
			<div class="col-md-12">
				<div class="page-header-title">
					<h5 class="m-b-10">Dashboard</h5>
				</div>
				<ul class="breadcrumb">

					<li class="breadcrumb-item"><a href="#!">Home / Fryer Information </a></li>
				</ul>

			</div>
		</div>
	</div>
</div>
<div class="breadcrumbs">
	<div class="breadcrumbs-inner">
		<div class="row">
			<script language="javascript">
				function cal() {
					var d1 = document.getElementById("d1").value;
					var p1 = document.getElementById("p1").value;



					if (document.getElementById("d1").value == "") {
						document.getElementById("sd1").innerHTML = "* Please select date";
						document.getElementById("d1").focus();
						document.getElementById("d1").style.color = "red";

					} else {
						$.post("addmarinatedetail", {
								d1: d1,
								p1: p1
							},
							function(data) {
								$("#basket").html(data);
							});

					}

				}
			</script>

			<!-- <div class="col-4" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
				<div class="input-group">

					<input type="date" name="d1" id="d1" class="form-control" required />
				</div>
			</div> -->


			<!-- <div class="col-6" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd2">Select Product</label>
				<div class="input-group">


					<select name="p1" id="p1" class="form-control" required>
						<option value="">Please Select</option>
						<?php
						$sql3 = mysqli_query($con, "select * from tblrecipe order by name asc");
						while ($rows3 = mysqli_fetch_array($sql3)) {
						?>
							<option value="<?php echo $rows3['id']; ?>"> <?php echo $rows3['name']; ?></option>

						<?php
						}
						?>

					</select>
				</div>
			</div>
			<div class="col-2" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1"></label>
				<div class="input-group">
					<button class="btn btn-info" style="float:right" onclick="return cal();">
						<li class="fa fa-list"></li> Select & Go
					</button>
				</div>
			</div> -->
			<div class="col-xl-12" style="margin-bottom:20px">
				<a href="admin.php?id=Prodrecord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
	<a href="admin.php?id=drainoil"><button type="submit" class="btn  btn-danger" style="float:right;margin-left:15px">Drain Oil</button></a>
				<a href="admin.php?id=addfryinfo"><button type="submit" class="btn  btn-danger" style="float:right;">Add New</button></a>
			</div>


			<div class="col-xl-12">
				<div class="card">
					<div class="card-header">
						<h5>Daily Frying Information</h5>
						<span class="d-block m-t-5">Add / Edit / Delete</span>
					</div>


					<div class="card-body table-border-style" id="basket">
						<div class="table-responsive">
							<table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batchcode</th>
										<th>Fryer</th>
										<th>Input temp <sup>o</sup>C</th>
										<th>Gas on time</th>
										<th>Top Up Batch</th>
										<th>Gas off time</th>
										<th>Rake out temp <sup>o</sup>C</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$date = date('Y-m-d');
									$sql = mysqli_query($con, "select * from tblfryinfo  order by date DESC");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;
										$useby = date('d-m-Y', strtotime($row['useby1']));

									?>

										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
											<td style="color:#0000FF"><?php echo $row['batchcode']; ?></td>
											<td>
												<?php

												echo $row['cooking'];
												?>
											</td>
											<td><?php echo $row['stemp']; ?><sup>o</sup>C</td>
											<td><?php echo $row['stime']; ?></td>
											<?php
											if (!empty($row['topup'])) { ?>
												<td><?php if($row['topup']!='No'){
													echo $row['topup']."l";
												} ?></td>

											<?php
											} else {
											?>
												<td  class="text-center"> <a href="admin?id=addfryinfo5&fid=<?php echo $row['id']; ?>" class="btn btn-primary ">Add Top Up</a></td>
											<?php
											}
											?>

											<?php
											if (!empty($row['taketemp']) && !empty($row['taketime'])) { ?>
												<td><?php echo $row['taketime']; ?></td>
												<td><?php echo $row['taketemp']; ?><sup>o</sup>C</td>

											<?php
											} else {
											?>
												<td colspan="2" class="text-center"> <a href="admin?id=addfryinfo4&fid=<?php echo $row['id']; ?>" class="btn btn-primary ">Add Details</a></td>
											<?php
											}
											?>


											<td><a href="admin?id=viewfryrecord&fid=<?php echo $row['id']; ?>" class="btn btn-info">View Detail</a></td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
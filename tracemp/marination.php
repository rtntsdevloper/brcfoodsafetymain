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

					<li class="breadcrumb-item"><a href="#!">Home / Potato Usage </a></li>
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

			<div class="col-4" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
				<div class="input-group">

					<input type="date" name="d1" id="d1" class="form-control" required />
				</div>
			</div>


			<div class="col-6" style="margin:10px">
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
			</div>
			<div class="col-xl-12" style="margin-bottom:20px">
				<a href="admin.php?id=Prodrecord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

				<a href="admin.php?id=addpusage"><button type="submit" class="btn  btn-danger" style="float:right;">Add New</button></a>
			</div>


			<div class="col-xl-12">
				<div class="card">
					<div class="card-header">
						<h5>Daily Potato Usage</h5>
						<span class="d-block m-t-5">Add / Edit / Delete</span>
					</div>


					<div class="card-body table-border-style" id="basket">
						<div class="table-responsive">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batchcode</th>
										<th>Name</th>
										<th>Use By</th>
										<th>Quantity</th>
										<th>Wastage</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$date = date('Y-m-d');
									$sql = mysqli_query($con, "select * from tblpusage  order by date DESC");
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
												$sql1 = mysqli_query($con, "select * from tblrawmaterial where id='$row[name]'");
												$rows = mysqli_fetch_array($sql1);
												echo $rows['pname'];
												?>
											</td>
											<td style="color:#0000FF"><?php echo $useby; ?></td>
											<td><?php echo $row['quantity']; ?> Kg</td>
											<td><?php if (!empty($row['wastage'])) {
													echo $row['wastage']; ?> Kg
												<?php

												} else {
												?>
												<a href="admin?id=ptwaste&wid=<?php echo $row['id'];?>" class="btn btn-info">Add Wastage</a>
												<?php

												} ?></td>
											<td>

												<a href="admin.php?id=viewmarination&sno=<?php echo $row['id']; ?>">
													<button type="button" class="btn btn-info btn-sm">View </button></a>
											</td>

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
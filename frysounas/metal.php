<?php
include 'connection.php';

if (isset($_POST['sbmt'])) {
	$date = $_POST['d1'];
	
} else {
	$date = date('Y-m-d');
}



?>



<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Traceability</a></li>
			<li>View Detail</li>
		</ul>
	</div>
	<form name="form1" method="post" action="admin?id=metal&id2=<?php echo $_GET['id2']; ?>">
		<div class="row">


			<div class="col-4" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
				<div class="input-group">

					<input type="date" name="d1" id="d1" class="form-control" required />
				</div>
			</div>



			<div class="col-2" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1"></label>
				<div class="input-group">
					<button type="submit" class="btn btn-info" style="float:right" name="sbmt">
						<li class="fa fa-list"></li> Select & Go
					</button>
				</div>
			</div>

		</div>
	</form>
	</br></br>


	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-success"
							style="float:right; margin-left:15px">Go Back</button></a>
					<!-- <a href="upl1/METAL.pdf" target="_blank"><button class="btn btn-primary"
							style="float:right; margin-left:15px">View Report</button></a> -->




					

					<a href="admin.php?id=metal1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info"
							style="float:right; margin-left:15px">Add New</button></a>


					<h4 class="card-title mb-3">Daily Metal Detection & Labelling Checks</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table"
								style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batch Code</th>
										<th>Product</th>
										<th>Test Type</th>
										<th>Is the metal detection test result acceptable?</th>
										<th>Any correction needed ?</th>
										<th>View Report</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "select * from tblmetal where date(datetime)='$date' ORDER by date(datetime) DESC");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$pqx = mysqli_query($con, "SELECT * FROM tblmetal where date(datetime)='$date' AND status ='Verified' AND productbatch='$row[productbatch]'");
$pqxn = mysqli_num_rows($pqx);
										$i++;

										$sd2 = mysqli_query($con, "select * from tblmarination where batchcode='$row[productbatch]'");
										$sd3 = mysqli_fetch_array($sd2);

										$sd = mysqli_query($con, "select * from tblrecipe where id='$sd3[name]'");
										$sd1 = mysqli_fetch_array($sd);
										

										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
											<td><?php echo $row['productbatch']; ?></td>
											<td><?php echo $sd1['name']; ?></td>
											<td><?php echo $row['testtype']; ?></td>
											<td><?php echo $row['pack1']; ?></td>
											<td><?php echo $row['pack2']; ?></td>
											<td>	<?php if ($pqxn > 0) { ?>

						<a href="admin?id=viewmetal&id2=<?php echo $_GET['id2']; ?>&ac=1&date=<?php echo $date; ?>&batch=<?php echo $row['productbatch']; ?>" target="_blank"><button
								class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>
					<?php } else {
						?>

						<a href="admin.php?id=viewmetal&id2=<?php echo $_GET['id2']; ?>&ac=2&date=<?php echo $date; ?>&batch=<?php echo $row['productbatch']; ?>"><button
								class="btn btn-warning mr-3" style="float:right">Verify Record</button></a>

						<?php
					}
					?></td>


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
		</div>
	</div>
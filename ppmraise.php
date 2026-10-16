<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>
			<li>Machinery Management </li>
		</ul>
	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=ppm"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
					<a href="admin.php?id=addraise"><button class="btn btn-danger" style="float:right">Add New</button></a>
					<h4 class="card-title mb-3">Machinery Management</h4>



					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th scope="col">S No.</th>
									<th scope="col">Date Raised</th>
									<th scope="col">Request Number</th>
									<th scope="col">Equipment Name</th>

									<th scope="col">Raised By</th>
									<th scope="col">View</th>
									<th scope="col">Status</th>


								</tr>
							</thead>
							<tbody>
								<?php
								$sql = mysqli_query($con, "select * from ppmraise ORDER By id DESC ");
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;

									$sq1 = mysqli_query($con, "SELECT * FROM `tblequipment` where id='$row[eqpname]'");
									$r1 = mysqli_fetch_array($sq1);
								?>
									<tr>
										<th scope="row"><?php echo $i; ?></th>
										<td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>
										<td><?php echo $row['request']; ?></td>
										<td><?php echo $r1['name']; ?></td>

										<td><?php echo $row['raisedby']; ?></td>
										<td>
											<a href="admin.php?id=ppmraise1&sno=<?php echo $row['id']; ?>">
												<button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
											</a>
										</td>

										

											<td><?php
										$st = mysqli_query($con, "SELECT * FROM `tblequipment1` where eid='$row[eqpname]' and rid='$row[id]' ");
										$st1 = mysqli_fetch_array($st);

										if ($st1['mverify'] == 'done') {
										?>
												<a href="" class='badge badge-success' style="font-size: 12px;">Completed</a>
											<?php } else { ?>
												<a href="" class='badge badge-warning text-white' style="font-size: 12px;">Pending</a>

											<?php 	} ?>
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
	</div>
</div>
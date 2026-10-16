<?php
$sno = $_GET['sno'];

?>

<div class="main-content">
	<div class="breadcrumb">

		<ul>
			<li><a href="">Home</a></li>
			<li>Metal Detection Checks</li>
		</ul>
		</ul>
	</div>

	</br></br>


	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=metaldate"><button class="btn btn-success"
							style="float:right; margin-left:15px">Go Back</button></a>

					<?php
					$pxl = mysqli_query($con, "SELECT * FROM `tblmetaldetect`  WHERE DATE_FORMAT(datetime, '%Y-%m-%d') ='$sno'  and sign !=''");
					$pxln = mysqli_num_rows($pxl);

					if ($pxln > 0) {
					?>
						<a href="admin?id=metald2&sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-primary"
								style="float:right; margin-left:15px">View Report</button></a>
					<?php
					} else {
					?>

						<a href="admin.php?id=metalcmnt&date=<?php echo $sno; ?>"><button class="btn btn-info"
								style="float:right; margin-left:15px">Verify Record</button></a>
					<?php
					}

					?>



					<h4 class="card-title mb-3">Daily Metal Detection Checks</h4>


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
										<th>Test Time</th>
										<th>Verify</th>
										<th>View Report</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "SELECT * FROM `tblmetaldetect`");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;
										// print_r("select * from tblflavourmix where batch='$row[productbatch]'");

										$sd2 = mysqli_query($con, "select * from tblflavourmix where batch='$row[productbatch]'");
										$sd3 = mysqli_fetch_array($sd2);



									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
											<td><?php echo $row['productbatch']; ?></td>
											<td><?php echo

												$sd3['productname']; ?></td>
											<td><?php echo $row['testtype']; ?></td>
											<td><?php echo $row['testtime']; ?></td>
											<td><?php if (!empty($row['sign'])) {
												?>
													
													<button class="btn btn-success">Verified</button>
												<?php
												} else {
												?>
													<a href="admin.php?id=metalcmnt&tid=<?php echo $row['id']; ?>" class="btn btn-warning" target="_blank">Verify</a>
												<?php
												} ?>
											</td>


											<td><a href="admin?id=metald2&sno=<?php echo $row['id']; ?>" target="_blank"><button class="btn btn-primary"
														style="float:left; margin-left:15px">View Report</button></a></td>


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
<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>
			<li>General Compliance</li>
		</ul>
	</div>

	<div class="col-md-12">
		<div class="card text-left">
			<div class="card-body">
				<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>


				<h4 class="card-title mb-2">General Compliance | Requirements</h4>
				<p>Each main section or subsection of the requirements in the Standard begins with a statement of intent. This sets
					out the expected outcome of compliance with the requirements of that section. This forms part of the audit and
					all companies must comply with the statements of intent.</p>
				<div class="row">
					<div class="col-4">
						<div class="list-group" id="list-tab" role="tablist">
							<?php

							$sql = mysqli_query($con, "select * from addtest1");
							while ($rows = mysqli_fetch_array($sql)) {
							?>
								<?php
								if ($rows['testid'] == "1") {
								?>

									<a class="list-group-item list-group-item-action active" id="list-home-list<?php echo $rows['testid']; ?>" data-toggle="list" href="#list-home<?php echo $rows['testid']; ?>" role="tab" aria-controls="list-home<?php echo $rows['testid']; ?>"> <?php echo $rows['subject']; ?></a>
								<?php
								} else {
								?>
									<a class="list-group-item list-group-item" id="list-home-list<?php echo $rows['testid']; ?>" data-toggle="list" href="#list-home<?php echo $rows['testid']; ?>" role="tab" aria-controls="list-home<?php echo $rows['testid']; ?>"> <?php echo $rows['subject']; ?></a>
							<?php
								}
							}
							?>

						</div>
					</div>
					<div class="col-8">
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade show active" id="list-home1" role="tabpanel" aria-labelledby="list-home-list1">

								<?php
								$sql2r = mysqli_query($con, "select * from subtest where tid='1'");
								while ($row2r = mysqli_fetch_array($sql2r)) {
								?>

									<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#exampleModalLong<?php echo $row2r['id']; ?>" style="margin:5px 0px 5px 0px; width:120px">Interpretation </button>

									<div class="modal fade" id="exampleModalLong<?php echo $row2r['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLongTitle1">Interpretation </h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">Close</button>
												</div>
												<div class="modal-body">

													<?PHP echo  $row2r['inter']; ?>

												</div>
											</div>
										</div>
									</div>

									<a href="admin.php?id=brccompliance1&sno=<?php echo $row2r['tid']; ?>&sid=<?php echo $row2r['sid']; ?>">
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<div class="col-1">
												<span class="badge badge-primary badge-pill"><?php echo $row2r['sid']; ?></span>
											</div>
											<div class="col-11"><?php echo $row2r['subtest']; ?></div>
										</li>
									</a>

									</ul>

									<?php


									$sql2rr = mysqli_query($con, "select * from subtest1 where tid='1' and sid='$row2r[sid]'order by sid desc limit 1 ");
									while ($row2rr = mysqli_fetch_array($sql2rr)) {

										$qry = mysqli_query($con, "select * from subtest1 where tid='$row2rr[tid]' and sid='$row2rr[sid]'");
										$mtch = mysqli_num_rows($qry);

										$tyu = mysqli_query($con, "select distinct ssid from tblcmp where tid='$row2rr[tid]' and sid='$row2rr[sid]'  ");
										$yes = mysqli_num_rows($tyu);

										$tyu1 = mysqli_query($con, "select * from   tblcmp where tid='$row2rr[tid]' and sid='$row2rr[sid]'  ");
										$gh = mysqli_fetch_array($tyu1);

										//$tyu1=mysqli_query($con,"select * from tblcmp where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$row2[fid]'");
										//$no=mysqli_num_rows($tyu1);

										$totalyes = round($yes * 100 / $mtch);
										//$totalno=round($no*100/$mtch);

										$datetime1 = new DateTime(date('Y-m-d'));
										$datetime2 = new DateTime($gh['date']);
										$interval = $datetime1->diff($datetime2);
										$interval->format('%a');


										$dte = date('d-m-Y', strtotime($gh['date']));


									?>
										<?php
										if ($totalyes >= 1) {
										?>


											<div class="card-body">
												<h6 class="mb-2 text-muted">Status</h6>
												<p class="mb-1 text-22 font-weight-light"><?php echo $totalyes; ?>%</p>
												<div class="progress mb-1" style="height: 4px">
													<div class="progress-bar bg-warning" style="width:<?php echo $totalyes; ?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div><small class="text-muted">Updated on: <?php echo $dte; ?></small>
											</div>

										<?php
										} else if ($totalyes >= 100) {
										?>


											<div class="card-body">
												<h6 class="mb-2 text-muted">Status</h6>
												<p class="mb-1 text-22 font-weight-light"><?php echo $totalyes; ?>%</p>
												<div class="progress mb-1" style="height: 4px">
													<div class="progress-bar bg-success" style="width:<?php echo $totalyes; ?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div><small class="text-muted">Updated on: <?php echo $dte; ?></small>
											</div>

										<?php
										} else if ($totalyes <= 0) {
										?>


											<div class="card-body">
												<h6 class="mb-2 text-muted">Status</h6>
												<p class="mb-1 text-22 font-weight-light">0%</p>
												<div class="progress mb-1" style="height: 4px">
													<div class="progress-bar bg-warning" style="width:0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div><small class="text-muted">Not Updated Yet</small>
											</div>

									<?php
										}
									}
									?>
								<?php
								}
								?>
							</div>

							<?php
							$sql1 = mysqli_query($con, "select * from subtest");
							while ($row = mysqli_fetch_array($sql1)) {
							?>
								<div class="tab-pane fade" id="list-home<?php echo $row['tid']; ?>" role="tabpanel" aria-labelledby="list-home-list<?php echo $row['tid']; ?>">

									<?php
									$sql2 = mysqli_query($con, "select * from subtest where tid='$row[tid]' and ssid='' ");
									while ($row2 = mysqli_fetch_array($sql2)) {
									?>
										<ul class="list-group">



											<?php
											if ($row2['inter'] != "") {
											?>
												<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#exampleModalLong<?php echo $row2['id']; ?>" style="margin:5px 0px 5px 0px; width:120px">Interpretation </button>

												<div class="modal fade" id="exampleModalLong<?php echo $row2['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLongTitle1">Interpretation </h5>
																<button class="close" type="button" data-dismiss="modal" aria-label="Close">Close</button>
															</div>
															<div class="modal-body">

																<?PHP echo  $row2['inter']; ?>

															</div>
														</div>
													</div>
												</div>
											<?php
											}
											?>

											<a href="admin.php?id=brccompliance1&sno=<?php echo $row2['tid']; ?>&sid=<?php echo $row2['sid']; ?>">
												<li class="list-group-item d-flex justify-content-between align-items-center">
													<div class="col-1">
														<span class="badge badge-primary badge-pill"><?php echo $row2['sid']; ?></span>
													</div>
													<div class="col-11">
														<?php echo $row2['subtest']; ?>
													</div>
												</li>
											</a>

										</ul>


										<?php


										$sql2rr = mysqli_query($con, "select * from subtest1 where tid='$row2[tid]' and sid='$row2[sid]'order by sid desc limit 1 ");
										while ($row2rr = mysqli_fetch_array($sql2rr)) {

											$qry = mysqli_query($con, "select * from subtest1 where tid='$row2rr[tid]' and sid='$row2rr[sid]'");
											$mtch = mysqli_num_rows($qry);

											$tyu = mysqli_query($con, "select distinct ssid from tblcmp where tid='$row2rr[tid]' and sid='$row2rr[sid]'  ");
											$yes = mysqli_num_rows($tyu);

											$tyu1 = mysqli_query($con, "select * from  tblcmp where tid='$row2rr[tid]' and sid='$row2rr[sid]'  ");
											$gh = mysqli_fetch_array($tyu1);



											//$tyu1=mysqli_query($con,"select * from tblcmp where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$row2[fid]'");
											//$no=mysqli_num_rows($tyu1);

											$totalyes = round($yes * 100 / $mtch);
											//$totalno=round($no*100/$mtch);

											$dte = date('d-m-Y', strtotime($gh['date']));
										?>
											<?php

											$datetime1 = new DateTime(date('Y-m-d'));
											$datetime2 = new DateTime($gh['date']);
											$interval = $datetime1->diff($datetime2);
											$interval->format('%a');

											if ($totalyes >= 1) {
											?>


												<div class="card-body">
													<h6 class="mb-2 text-muted">Status</h6>
													<p class="mb-1 text-22 font-weight-light"><?php echo $totalyes; ?>%</p>
													<div class="progress mb-1" style="height: 4px">
														<div class="progress-bar bg-warning" style="width:<?php echo $totalyes; ?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div><small class="text-muted"> Updated on: <?php echo $dte; ?></small>
												</div>

											<?php
											} else if ($totalyes >= 100) {
											?>


												<div class="card-body">
													<h6 class="mb-2 text-muted">Status</h6>
													<p class="mb-1 text-22 font-weight-light"><?php echo $totalyes; ?>%</p>
													<div class="progress mb-1" style="height: 4px">
														<div class="progress-bar bg-success" style="width:<?php echo $totalyes; ?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div><small class="text-muted">Updated on: <?php echo $dte; ?></small>
												</div>

											<?php
											} else if ($totalyes <= 0) {
											?>


												<div class="card-body">
													<h6 class="mb-2 text-muted">Status</h6>
													<p class="mb-1 text-22 font-weight-light">0%</p>
													<div class="progress mb-1" style="height: 4px">
														<div class="progress-bar bg-warning" style="width:0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div><small class="text-muted">Not Updated Yet</small>
												</div>

										<?php
											}
										}
										?>



									<?php
									}
									?>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$('.modalButton').click(function() {
		var tid = $(this).attr('data-tid');
		var sid = $(this).attr('data-sid');
		$.ajax({
			url: "interpretation.php?tid=" + tid + "&sid=" + sid,
			cache: false,
			success: function(result) {
				$("#modal-body4").html(result);
			}
		});
	});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="modal-body4">
				<?php
				include 'interpretation.php';
				?>

			</div>
		</div>
	</div>
</div>
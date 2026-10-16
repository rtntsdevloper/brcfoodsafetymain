<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Procedure Management</a></li>
			<li>View Detail</li>
		</ul>
	</div>

	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">
					<?php
					if ($access != "superadmin") {
					?>
						<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

						<a href="admin.php?id=addaditional"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
					<?php
					}
					?>

					<h4 class="card-title mb-3">View Detail</h4>


					<div class="row">




						<div class="table-responsive">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>

										<th></th>
										<th>Type</th>
										<th>Section</th>
										<th>Sub-Section</th>

										<th>Issue Date</th>
										<th>Version</th>
										<th>Authorised By</th>
										<th>Doc</th>
										<th></th>


									</tr>
								</thead>
								<tbody>
									<?php
									$sql23 = mysqli_query($con, "select * from tbldetail where typee!='archive'");
									$i = 1;
									while ($row23 = mysqli_fetch_array($sql23)) {
										$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
										$hj1 = mysqli_fetch_array($hj);

									?>

										<tr>
											<td><?php echo $i; ?></td>
											<td>

												<?php
												if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
													echo "Additional Documents";
												} else {
													echo $row23['typee'];
												}
												?></td>
											<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
											<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?><br>(<?php echo $row23['fid']; ?>)</td>

											<td>
												<?php
												if ($row23['issuedate'] != '0000-00-00') {
													echo date('d-m-Y', strtotime($row23['issuedate']));
												}
												?>
											</td>

											<td><?php echo $row23['ver']; ?></td>
											<td><?php echo $row23['authrisedby']; ?></td>
											<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

											<td>
												<?php
												if ($access == "Admin") {
												?>
													<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
													</br> </br>
													<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
												<?php
												}
												?>

											</td>

										</tr>
									<?php
										$i++;
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
<?php
$tid = $_GET['tid'];
$access = $_SESSION['access'];
if ($access == "Auditor") {
	$sq = mysqli_query($con, "select * from tblauditor where name='$user'");
	$qu = mysqli_fetch_array($sq);
} else if ($access == "Auditee") {
	$sq = mysqli_query($con, "select * from tblauditee where name='$user'");
	$qu = mysqli_fetch_array($sq);
}

$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);
?>

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		
		<ul>
			<li><a href="">Home</a></li>
			<li><?php echo $qu2['name']; ?></li>
		</ul>

	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=dailychecksdetail"><button class="btn btn-success" style="float:right; margin-left:15px; margin-bottom:10px">Go Back</button></a>
					<a href="admin.php?id=dailychecks1&tid=<?php echo $tid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px;margin-bottom:10px">Attempt New</button></a>
					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Date</th>
									<th>Opening Checks</th>
									<?php

									if ($qu2['closing'] == 'Yes') {
									?>
										<th>Closing Checks</th>
									<?php
									}
									?>
									<?php

									if ($qu2['verify'] == 'Yes') {
									?>
										<th>Verification</th>
									<?php
									}
									?>


								</tr>
							</thead>
							<tbody>
								<?php

								$sql = mysqli_query($con, "select * from dailycheckss where name='$tid'");
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
									$gh = mysqli_query($con, "select * from dailychecks where id='$row[name]'");
									$gh1 = mysqli_fetch_array($gh);

								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $gh1['name']; ?></td>
										<td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>

										<td>
											<a href="admin.php?id=dailychecks3&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid; ?>">
												<button class="btn btn-info">View Report</button></a>
										</td>
										<?php

										if ($qu2['closing'] == 'Yes') {
										?>
											<td>
												<?php
												if ($row['name1'] == "2") {
												?>
													<a href="admin.php?id=dailychecks4&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid; ?>">
														<button class="btn btn-warning">View Report</button></a>
												<?php
												} else {
												?>
													<a href="admin.php?id=closingchecks1&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid; ?>">
														<button class="btn btn-danger"> Attempt Closing Checks</button></a>
												<?php
												}
												?>
											</td>


										<?php
										}
										?>

										<?php

										if ($qu2['verify'] == 'Yes') {
										?>
											<td>
												<?php
												if (!empty($row['verify'])) {
												?>
													<button class="btn btn-success">Verifed</button>

												<?php
												} else {
												?>
													<a href="admin.php?id=dailyverify&sno=<?= $row['id'] ?>&tid=<?= $tid ?>" rel="noopener noreferrer" class="btn btn-warning">Verify</a>
												<?php
												}
												?>
											</td>
										<?php
										}
										?>

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
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


?>


<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>

		</ul>
	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
					<?php
					if ($access == "Auditor") {
					?>
						<a href="admin.php?id=gmpaudit&tid=<?php echo $tid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Attempt Audit</button></a>
					<?php
					}
					?>
					<h4 class="card-title mb-3">Audit List</h4>



					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Date</th>
									<th scope="col">Auditor</th>
									<th scope="col">Auditee</th>
									<th scope="col">Audit</th>
									<th scope="col">Section</th>
									<th scope="col">Add/Edit</th>
									<th scope="col">Status</th>


								</tr>
							</thead>
							<tbody>
								<?php
								if ($access == "Auditor") {
									$sql = mysqli_query($con, "select * from tblgmpaudit2 where auditor='$qu[id]' and audit='$tid'");
								} else if ($access == "Auditee") {
									$sql = mysqli_query($con, "select * from tblgmpaudit2 where auditee='$qu[id]' and audit='$tid'");
								} else {
									$sql = mysqli_query($con, "select * from tblgmpaudit2  where  audit='$tid' ");
								}
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
								?>
									<tr>
										<th scope="row"><?php echo $i; ?></th>
										<td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>
										<td>
											<?php
											$sh = mysqli_query($con, "select * from tblauditor where id='$row[auditor]'");
											$hj = mysqli_fetch_array($sh);
											echo $hj['name'];
											?>

										</td>
										<td><?php
											$sh13 = mysqli_query($con, "select * from tblauditee where id='$row[auditee]'");
											$hj13 = mysqli_fetch_array($sh13);
											echo $hj13['name'];
											?> </td>


										<td>
											<?php
											$sh1 = mysqli_query($con, "select * from tblauditsection where id='$row[audit]'");
											$hj1 = mysqli_fetch_array($sh1);
											echo $hj1['name'];
											?>

										</td>

										<td>
											<?php
											$sh12 = mysqli_query($con, "select * from tblauditsection1 where id='$row[sid]'");
											$hj12 = mysqli_fetch_array($sh12);
											echo $hj12['name'];
											?>

										</td>

										<td>
											<?php
											if ($access == "Auditor") {
											?>
												<a href="admin.php?id=gmpaudit2&sno=<?php echo $row['id']; ?>&sno1=<?php echo $row['audit']; ?>&sno2=<?php echo $row['sid']; ?>"><button class="btn btn-danger">Click Here</button></a>
											<?php

											} else if ($access == "Auditee") {
											?>
												<a href="admin.php?id=gmpnc&sno=<?php echo $row['id']; ?>">
													<button class="btn btn-info"><?php echo strtoupper($row['status']); ?></button></a>
											<?php

											} else {
											?>
												<a href="admin.php?id=gmpnc&sno=<?php echo $row['id']; ?>">
													<button class="btn btn-info"><?php echo strtoupper($row['status']); ?></button></a>
											<?php
											}
											?>
										</td>
										<td>
											<a href="admin.php?id=gmpnc&sno=<?php echo $row['id']; ?>">
												<button class="btn btn-info"><?php echo strtoupper($row['status']); ?></button></a>
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
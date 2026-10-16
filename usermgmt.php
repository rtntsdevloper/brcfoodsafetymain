<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>
			<li>User Management </li>
		</ul>
	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
					<h4 class="card-title mb-3">User Management</h4>

					<p>List of staff</p>

					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Username</th>
									<th scope="col">Department</th>
									<th scope="col">Email</th>
									<th scope="col">Job title</th>
									<th scope="col">Photo</th>
									<th scope="col">Status</th>
									<th scope="col">View</th>

								</tr>
							</thead>
							<tbody>
								<?php
								$sql = mysqli_query($con, "select * from tblstaff");
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
								?>
									<tr>
										<th scope="row"><?php echo $i; ?></th>
										<td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>
										<td><?php echo $row['uname']; ?></td>
										<td><?php echo $row['department']; ?> </td>
										<td><?php echo $row['email']; ?> </td>
										<td><?php echo $row['jobtitle']; ?></td>
										<td><img src="student/<?php echo $row['img']; ?>" width="70" /></td>

										<td> <?php
												if ($row['status'] == "active") {
												?>
												<button class="btn btn-success" type="button">Active</button>
											<?php
												} else if ($row['status'] == "inactive") {
											?>

												<button class="btn btn-danger" type="button">Inactive</button>
											<?php
												}
											?>
										</td>

										<td>
											<a href="admin.php?id=userviewc&sno=<?php echo $row['id']; ?>">
												<button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
											</a>
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
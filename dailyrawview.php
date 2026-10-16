<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>
			<li>Product daily checks</li>
		</ul>
	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=dailychecksdetail"><button class="btn btn-success" style="float:right; margin-left:15px; margin-bottom:10px">Go Back</button></a>
<a href="admin.php?id=dailyrawpro"><button class="btn btn-outline-primary" style="float:right; margin-left:15px;margin-bottom:10px">Product List</button></a>
					<a href="admin.php?id=dailyrawadd"><button class="btn btn-primary" style="float:right; margin-left:15px;margin-bottom:10px">Attempt New</button></a>
					
					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Attempt by</th>
									<th>View Report</th>
								
								</tr>
							</thead>
							<tbody>
								<?php

								$sql = mysqli_query($con, "SELECT * FROM `tbl_dailyrecord`");
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date("d-m-Y", strtotime($row['cdate'])); ?></td>
										<td><?php echo $row['name']; ?></td>

										<td>
											<a href="admin.php?id=dailyrawview1&sno=<?php echo $row['id']; ?>">

												<button class="btn btn-info">View Report</button></a>
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
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

					<a href="admin.php?id=Prodrecord"><button class="btn btn-success"
							style="float:right; margin-left:15px">Go Back</button></a>


					<a href="admin.php?id=metald1"><button class="btn btn-info"
							style="float:right; margin-left:15px">Add New</button></a>


					<h4 class="card-title mb-3">Daily Metal Detection Checks</h4>

tracemp/metal.php
					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table"
								style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>View</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "select * from tblmetaldetect");
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
											
											<td><a href="admin?id=metaldetect&sno=<?php echo date('Y-m-d', strtotime($row['datetime'])); ?>" target="_blank"><button class="btn btn-primary"
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
<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Product daily checks</a></li>
			<li>Product list</li>
		</ul>
	</div>
	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">
					<h3>Product List</h3>

					<a href="admin.php?id=dailyrawview"><button class="btn btn-success" style="float:right; margin-left:15px; margin-bottom:10px">Go Back</button></a>

					<a href="admin.php?id=dailyrawpro1"><button class="btn btn-success" style="float:right; margin-left:15px;margin-bottom:10px">Add Product</button></a>
					
					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Product Name</th>
									<th>UOM</th>
									<th>Action</th>
								
								</tr>
							</thead>
							<tbody>
								<?php

								$sql = mysqli_query($con, "SELECT * FROM `tbl_dailyproduct`");
								$i = 0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['uom']; ?></td>

										<td>
											<a href="admin.php?id=dailyrawpro2&sno=<?php echo $row['id']; ?>">

												<button class="btn btn-info">Edit</button></a>
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
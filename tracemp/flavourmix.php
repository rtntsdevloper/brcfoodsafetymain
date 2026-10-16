<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php
$dt = date('Y-m-d');
$date = new DateTime($dt);
$date->sub(new DateInterval('P7D'));
$dt1 = $date->format('Y-m-d') . "\n";





?>
<div class="page-header">
	<div class="page-block">
		<div class="row align-items-center">
			<div class="col-md-12">
				<div class="page-header-title">
					<h5 class="m-b-10">Dashboard</h5>
				</div>
				<ul class="breadcrumb">

					<li class="breadcrumb-item"><a href="#!">Home / Flavour Mixing </a></li>
				</ul>

			</div>
		</div>
	</div>
</div>
<div class="breadcrumbs">
	<div class="breadcrumbs-inner">
		<div class="row">
			<div class="col-xl-12" style="margin-bottom:20px">
				<a href="admin.php?id=Prodrecord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				<a href="admin.php?id=flavouradd"><button type="submit" class="btn  btn-danger" style="float:right;">Add New</button></a>
			</div>


			<div class="col-xl-12">
				<div class="card">



					<div class="card-body table-border-style" id="basket">
						<h5>Flavour Mixing</h5>
						<div class="table-responsive">
							<table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Product Batch</th>
										<th>Product Name</th>
										<th>Product Quantity</th>
										<th>Potato Quantity</th>
										<th>Flavour Start Weight</th>
										<th>Flavour End Weight</th>
										<th>Flavour Total Use</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$date = date('Y-m-d');
									$sql = mysqli_query($con, "select * from `tblflavourmix`  order by date DESC");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;

									?>

										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
											<td style="color:#0000FF"><?php echo $row['batch']; ?></td>
											<td>
												<?php

												echo $row['productname'];
												?>
											</td>
											<td><?php echo $row['totalqty']; ?>Kg</td>
											<td class="text-center"><?php echo $row['quantity']; ?>Kg</td>
											<td class="text-center"><?php echo $row['flavourtotal']; ?>Kg</td>
											<?php
											if (!empty($row['flavouruse']) && !empty($row['flavourleft'])) { ?>
												<td><?php echo $row['flavourleft']; ?>Kg</td>
												<td><?php echo $row['flavouruse']; ?>Kg</td>


											<?php
											} else {
											?>
												<td colspan="2" class="text-center"> <a href="admin?id=flavouradd3&fid=<?php echo $row['id']; ?>" class="btn btn-primary ">Add Details</a></td>
											<?php
											}
											?>


											<td><a href="admin?id=viewflavourmix&fid=<?php echo $row['id']; ?>" class="btn btn-info">View Detail</a></td>
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
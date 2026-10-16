<?php
$sno = $_GET['sno'];

$sql = mysqli_query($con, "SELECT * FROM `tbl_dailyrecord1` where mid ='$sno'");

?>

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

					<a href="admin.php?id=dailyrawview"><button class="btn btn-success" style="float:right; margin-left:15px; margin-bottom:10px">Go Back</button></a>

					<a href="admin.php?id=dailyrawpdf&sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-success" style="float:right; margin-left:15px;margin-bottom:10px">View Report</button></a>
					
					<div class="table-responsive">
						<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Product Name</th>
									<th>Quantity from last day</th>
									<th>Quantity received today</th>
									<th>Quantity sold today</th>
									<th>Quantity wasted today</th>
									<th>Quantity remaining in stock</th>
									<th>Remark if any</th>
								
								</tr>
							</thead>
							<tbody>
								<?php

								$i=0;
								while ($row = mysqli_fetch_array($sql)) {
									$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['pname']; ?></td>
										<td><?php echo $row['lastqnty']." ".$row['uom']; ?></td>
										<td><?php echo $row['totalquantity']." ".$row['uom']; ?></td>
										<td><?php echo $row['quantitysale']." ".$row['uom']; ?></td>
										<td><?php echo $row['quantitywaste']." ".$row['uom']; ?></td>
										<td><?php echo $row['quantityleft']." ".$row['uom']; ?></td>
										<td><?php echo $row['cmnt']; ?></td>

										


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
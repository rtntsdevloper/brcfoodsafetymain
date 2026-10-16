<?php

$fid = $_GET['fid'];

$qs1 = mysqli_query($con,"select * from tblfrybatch where id= $fid");
$qs2 = mysqli_fetch_array($qs1);

$qsnm = $qs2['name'];



?>

<div class="col-xl-12">
	<div class="card">
		<div class="card-header">
			<h5>Daily Frying Information</h5>
			<span class="d-block m-t-5">Add / Edit / Delete</span>
			<h5>Cooking Oil Batch : <?php echo $qsnm; ?></h5>
			<div class="col-xl-12" style="margin-bottom:20px">
				<a href="admin.php?id=drainoil"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				

			</div>

		</div>



		<div class="card-body table-border-style" id="basket">
			<div class="table-responsive">
				<table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
					<thead>
						<tr>
							<th>S no.</th>
							<th>Date</th>
							<th>Frying Batch</th>
							<th>Quantity Used</th>
							<th>Type</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php
						$date = date('Y-m-d');
						$sql = mysqli_query($con, "select * from tblfrybatch1 where name = '$qsnm'");
						$i = 0;
						while ($row = mysqli_fetch_array($sql)) {
							$i++;
							$date = date('d-m-Y', strtotime($row['date']));

							if(!empty($row['draindate'])){
								$draindate = date('d-m-Y', strtotime($row['draindate']));
							}else{
								$draindate ='In Use';
							}

						?>

							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
								<td style="color:#0000FF"><?php echo $row['batchp']; ?></td>
								<td ><?php echo $row['quantity']; ?>l</td>
								
								
								
								<td><?php echo $row['mark']; ?></td>
							
								
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
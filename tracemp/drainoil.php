<div class="col-xl-12">
	<div class="card">
		<div class="card-header">
			<h5>Daily Frying Information</h5>
			<span class="d-block m-t-5">Add / Edit / Delete</span>
			<div class="col-xl-12" style="margin-bottom:20px">
				<a href="admin.php?id=fryrecord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				<a href="admin.php?id=clearoil"><button type="submit" class="btn  btn-danger" style="float:right;margin-left:15px">Drain Existing Oil</button></a>

			</div>

		</div>



		<div class="card-body table-border-style" id="basket">
			<div class="table-responsive">
				<table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
					<thead>
						<tr>
							<th>S no.</th>
							<th>Name</th>
							<th>Created On</th>
							<th>Drain On</th>
							<th>View detail</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php
						$date = date('Y-m-d');
						$sql = mysqli_query($con, "select * from tblfrybatch order by id desc");
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
								<td style="color:#0000FF"><?php echo $row['name']; ?></td>
								<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
								
								
								<td><?php echo $draindate; ?></td>
								
								

								

								


								<td><a href="admin?id=drainoil1&fid=<?php echo $row['id']; ?>" class="btn btn-info">View Detail</a></td>
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
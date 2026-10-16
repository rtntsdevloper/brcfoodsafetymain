<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Traceability</a></li>
			<li>View Detail</li>
		</ul>
	</div>
	<form name="form1" method="post" action="admin?id=metal&id2=<?php echo $_GET['id2']; ?>">
		<div class="row">


			<div class="col-4" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
				<div class="input-group">

					<input type="date" name="d1" id="d1" class="form-control" required />
				</div>
			</div>



			<div class="col-2" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1"></label>
				<div class="input-group">
					<button type="submit" class="btn btn-info" style="float:right" onclick="return cal();">
						<li class="fa fa-list"></li> Select & Go
					</button>
				</div>
			</div>

		</div>
	</form>
	</br></br>


	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

					<a href="admin.php?id=labeling1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>


					<h4 class="card-title mb-3">Labeling Management</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batch Code</th>
										<th>Product</th>
										<th>Test Type</th>
										<th>Is Correct Packaging Used ?</th>
										<th>Any Correction Need ?</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "select * from tbllabeling  ORDER by date(datetime) DESC");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;

										$sd2 = mysqli_query($con, "select * from tblmarination where batchcode='$row[productbatch]'");
										$sd3 = mysqli_fetch_array($sd2);

										$sd = mysqli_query($con, "select * from tblrecipe where id='$sd3[name]'");
										$sd1 = mysqli_fetch_array($sd);

									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
											<td><?php echo $row['productbatch']; ?></td>
											<td><?php echo $sd1['name']; ?></td>
											<td><?php echo $row['testtype']; ?></td>
											<td> <?php echo $row['ans']; ?></td>
											<td> <?php echo $row['cmnt']; ?></td>




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
<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Home</a></li>
			<li>User Management </li>
		</ul>
	</div>
	<script language="javascript">
		function cal() {
			var d1 = document.getElementById("d1").value;
			var d2 = document.getElementById("d2").value;
			var s1 = document.getElementById("s1").value;


			if (d1 == "" && d2 == "" && s1 == "") {
				document.getElementById("sd1").innerHTML = "* Please select one option from below";
			} else {
				$.post("knowledgedetail", {
						d1: d1,
						d2: d2,
						s1: s1
					},
					function(data) {
						$("#myTabContent").html(data);
					});
			}
		}
	</script>

	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<div class="row">

						<div class="col-12"><label for="cc-exp" class="control-label mb-1" id="sd1" style="color:#FF0000"></label>
						</div>
						<div class="col-4">
							<label for="cc-exp" class="control-label mb-1">Date From</label>
							<div class="input-group">

								<input type="date" name="d1" id="d1" class="form-control" />
							</div>
						</div>

						<div class="col-4">
							<label for="cc-exp" class="control-label mb-1"> Date To</label>
							<div class="input-group">

								<input type="date" name="d2" id="d2" class="form-control" />
							</div>
						</div>

						<div class="col-4">
							<label for="cc-exp" class="control-label mb-1">Select Category</label>
							<div class="input-group">


								<select name="s1" id="s1" class="form-control">
									<option value="">Please Select</option>
									<?php
									$sql2 = mysqli_query($con, "select *  from tblalert1 where status='alerts'");
									while ($rows = mysqli_fetch_array($sql2)) {
									?>
										<option value="<?php echo $rows['id']; ?>"> <?php echo $rows['name']; ?></option>

									<?php
									}
									?>

								</select>
							</div>
						</div>


						<div class="col-2" style="margin:10px">
							<label for="cc-exp" class="control-label mb-1"></label>
							<div class="input-group">
								<button class="btn btn-info" style="float:right" onclick="return cal();">
									<li class="fa fa-list"></li> Select & Go
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">

				<div class="card-body">

					<!--1st TAB START-->
					<div class="row mb-4">
						<div class="col-12">
							<div class="card text-left">
								<div class="card-body">
									<a href="admin.php?id=knowledgehub"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

									<h4 class="card-title mb-3">Horizon Scanning</h4>
									<p>Click on tabs below for the latest updates</p>
									<ul class="nav nav-tabs" id="myTab" role="tablist">
										<?php
										$sql1 = mysqli_query($con, "select * from tblalert1 where status='alerts'");
										while ($row1 = mysqli_fetch_array($sql1)) {
											if ($row1['id'] == "1") {
										?>
												<li class="nav-item"><a class="nav-link active" id="home-basic-tab<?php echo $row1['id']; ?>" data-toggle="tab" href="#homeBasic<?php echo $row1['id']; ?>" role="tab" aria-controls="homeBasic" aria-selected="true"><?php echo $row1['name']; ?></a></li>

											<?PHP
											} else {
											?>
												<li class="nav-item"><a class="nav-link" id="home-basic-tab<?php echo $row1['id']; ?>" data-toggle="tab" href="#homeBasic<?php echo $row1['id']; ?>" role="tab" aria-controls="homeBasic" aria-selected="true"><?php echo $row1['name']; ?></a></li>
										<?php
											}
										}
										?>
									</ul>
									<div class="tab-content" id="myTabContent">
										<?php
										$sql2 = mysqli_query($con, "select * from tblalert1 where status='alerts'");
										while ($row2 = mysqli_fetch_array($sql2)) {
											if ($row2['id'] == "1") {
										?>
												<div class="tab-pane fade show active" id="homeBasic<?php echo $row2['id']; ?>" role="tabpanel" aria-labelledby="home-basic-tab<?php echo $row2['id']; ?>">
													<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

														<thead>
															<tr>

																<th></th>
																<th>Type</th>
																<th>Section</th>
																<th>Sub-Section</th>

																<th>Issue Date</th>
																<th>Version</th>
																<th>Authorised By</th>
																<th>Doc</th>
																<th></th>


															</tr>
														</thead>
														<tbody>
															<?php
															$sql = mysqli_query($con, "select * from tblalerts where status='$row2[id]' order by date DESC");
															$i = 0;
															while ($row = mysqli_fetch_array($sql)) {
																$i++;
															?>
																<tr>
																	<th scope="row"><?php echo $i; ?></th>
																	<td><?php echo date("d-m-Y", strtotime($row['date'])); ?> </td>
																	<td><?php echo $row['ques']; ?>
																		<?php
																		if ($row['weblink'] != "") {
																		?>

																			<a href="<?php echo $row['weblink']; ?>" target="_blank"><button class="btn btn-primary btn-rounded m-1" type="button">View</button></a>
																		<?php
																		}
																		?>
																	</td>
																	<td><?php echo $row['category']; ?> </td>
																</tr>
															<?php
															}
															?>
														</tbody>
													</table>
												</div>
											<?php
											} else {
											?>
												<div class="tab-pane fade" id="homeBasic<?php echo $row2['id']; ?>" role="tabpanel" aria-labelledby="home-basic-tab<?php echo $row2['id']; ?>">
													<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

														<thead>
															<tr>
																<th scope="col">#</th>
																<th scope="col">Date</th>
																<th scope="col">Description</th>
																<th scope="col">Type</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$sql = mysqli_query($con, "select * from tblalerts where status='$row2[id]' order by date DESC");
															$i = 0;
															while ($row = mysqli_fetch_array($sql)) {
																$i++;
															?>
																<tr>
																	<th scope="row"><?php echo $i; ?></th>
																	<td><?php echo date("d-m-Y", strtotime($row['date'])); ?> </td>
																	<td><?php echo $row['ques']; ?>
																		<?php
																		if ($row['weblink'] != "") {
																		?>

																			<a href="<?php echo $row['weblink']; ?>" target="_blank"><button class="btn btn-primary btn-rounded m-1" type="button">View</button></a>
																		<?php
																		}
																		?>
																	</td>
																	<td><?php echo $row['category']; ?> </td>
																</tr>
															<?php
															}
															?>
														</tbody>
													</table>
												</div>
										<?php
											}
										}
										?>

										<div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--1st TAB END-->


				</div>

			</div>
		</div>
	</div>


</div>
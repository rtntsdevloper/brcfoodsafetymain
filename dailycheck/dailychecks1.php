 <?php
	$tid = $_GET['tid'];
	$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
	$qu2 = mysqli_fetch_array($sq2);
	?>

 <div class="main-content">
 	<div class="breadcrumb">

 		<ul>
 			<li><a href="">Home</a></li>
 			<li><?php echo $headingname; ?></li>
 		</ul>
 	</div>
 	<div class="row">

 	</div> <br />
 	<div class="col-md-12"></div>
 	<div class="col-md-12">
 		<div class="card">
 			<div class="card-body">
 				<div class="row">
 					<div class="col-md-6">
 						<h3><?php echo $qu2['name']; ?></h3>
 					</div>
 					<div class="col-md-6">
 						<a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px ">Go Back</button></a>
 					</div>
 				</div>

 				<div class="col-md-12" style="color:#996600"><?php echo $qu2['status']; ?></div>
 				</br>

 				<form name="form1" action="dailychecks2" enctype="multipart/form-data" method="post">


 					<div class="row">
 						<div class="col-md-6">
 							<label for="validationTooltip01"> Select Date</label>
 							<input type="date" name="date" class="form-control" required />
 						</div>
 						<!-- <div class="col-md-4">
 							<label for="validationTooltip01">Time</label>
 							<input type="time" name="ctime" class="form-control" required />
 						</div> -->
 						<div class="col-md-6">
 							<label for="validationTooltip01">Checked by</label>
 							<input type="text" name="cname" class="form-control" required />
 						</div>

 					</div>
 					</br>

 					</br>
 					<div id="txtHint"></div>
 					<?php
						if ($tid == 1) {
						?>
 						<h3 class="text-danger"><b>Instruction :</b> Daily Startup checks. To be completed at the start of every day.</h3>
 					<?php
						}
						?>


 					<?php
						$sql2 = mysqli_query($con, "select distinct section from dailychecks1 where tid='$tid' and closing !='1'");
						$j = 0;
						$i = 0;
						while ($th = mysqli_fetch_array($sql2)) {
							$j++;
						?>
 						<div class="row">
 							<div class="col-md-12" align="center">

 								<h2 style="color:#0000FF"><?php echo $j; ?>. <?php echo $th['section']; ?></h2>
 							</div>
 						</div>
 						<?php
							$sql1 = mysqli_query($con, "select * from dailychecks1 where tid='$tid' and section='$th[section]'and closing !='1'");

							while ($row1 = mysqli_fetch_array($sql1)) {
							?>
 							<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
 							<div class="row">
 								<div class="col-md-12">
 									<div class="form-group label-floating">
 										<?php echo $i + 1; ?>. <?php echo $row1['ques']; ?>
 									</div>
 								</div>
 							</div>
 							<input type="hidden" name="section[]" value="<?php echo $th['section']; ?>" />
 							<input type="hidden" name="ques[]" value="<?php echo $row1['ques']; ?>" />
 							<div class="row">
 								<?php
									if ($row1['inputt'] == 'time') {

									?>
 									<div class="col-md-3">
 										<div class="form-group label-floating">
 											<input type="time" name="r1<?php echo $i; ?>" id="r1<?php echo $i; ?>" class="form-control" required>

 										</div>
 									</div>
 								<?php
									} else {
									?>

 									<div class="col-md-3">
 										<div class="form-group label-floating">
 											<select name="r1<?php echo $i; ?>" id="r1<?php echo $i; ?>" class="form-control" required  onchange="comment(<?php echo $i; ?>,this.value)">
 												<option value="">Please Select</option>
 												<option value="Yes">Yes</option>
 												<option value="No">No</option>
 											</select>
 										</div>
 									</div>

 								<?php
									}

									?>


 								<div class="col-md-3">
 									<div class="form-group label-floating">
 										
										<?php
										$required = $row1['required'];
										 if ($required == 'Yes') { ?>
											
										<textarea name="cmnt<?php echo $i; ?>" class="form-control" placeholder="Comments/Corrective actions taken"  required></textarea>
										<?php } else { ?>
											<textarea name="cmnt<?php echo $i; ?>" id="f1<?php echo $i; ?>" class="form-control" placeholder="Comments/Corrective actions taken" ></textarea>
										<?php } ?>
 									</div>
 								</div>

 								<div class="col-md-3">
 									<div class="form-group label-floating">
 										<input type="file" name="img<?php echo $i; ?>" class="form-control" accept="image/*,.jpg,.png,.jpeg">
 									</div>
 								</div>

 							</div>
 							<div class="row" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
 					<?php
								$i++;
							}
						}
						?>

	<script>
						// function comment(id, ans) {
						// 	const commentr = document.getElementById("f1" + id);
						// if (ans == "No") || (ans == "Yes") {
						// 		commentr.setAttribute("required", "required");
						// 	} else {
						// 		commentr.removeAttribute("required");
						// 	}
						// }



						function comment(id, ans) {
							const commentr = document.getElementById("f1" + id);
							const commentr1 = document.getElementById("f2" + id);
							if (ans == "No") {
								commentr.setAttribute("required", "required");
								commentr1.setAttribute("required", "required");
							} else {
								commentr.removeAttribute("required");
								commentr1.removeAttribute("required");
							}
						}
					</script>



 					<div class="row">


 						<div class="col-md-3">
 							<div class="form-group label-floating">
 								<button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
 							</div>
 						</div>
 					</div>

 				</form>
 <?php
	$tid = $_GET['tid'];
	$fid = $_GET['id2'];
	$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
	$qu2 = mysqli_fetch_array($sq2);
	?>

 <div class="main-content">
 	<div class="breadcrumb">
 		<h1 class="mr-2"><?php echo $qu2['name']; ?>
 		</h1>
 		<ul>
 			<li><a href="">Home</a></li>
 			<li><?php echo $headingname; ?></li>
 		</ul>
 	</div>
 	<div class="row">
 		<a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>&"><button class="btn btn-success" style="float:right; margin-left:15px ">Go Back</button></a>
 	</div> <br />
 	<div class="col-md-12"></div>
 	<div class="col-md-12">
 		<div class="card">
 			<div class="card-body">

 				<div class="col-md-12" style="color:#996600"><?php echo $qu2['status']; ?></div>
 				</br>

 				<form name="form1" action="<?php echo $fid; ?>/dailychecks2" enctype="multipart/form-data" method="post">


 					<div class="row">
 						<div class="col-md-6">
 							<label for="validationTooltip01"> Select Date</label>
 							<input type="date" name="date" class="form-control" required />
 						</div>
 					</div>
 					</br>
 					</br>
 					<div id="txtHint"></div>
 					<input type="hidden" name="fid" value="<?php echo $_GET['id2']; ?>">
 					<?php
						$sql2 = mysqli_query($con, "select distinct section from dailychecks1 where tid = '$tid' && section='StartUp Checks'");
						$j = 0;
						$i = 0;
						while ($th = mysqli_fetch_array($sql2)) {
							$j++;
						?>
 						<div class="row">
 							<div class="col-md-12" align="center">

 								<h2 style="color:#0000FF"><?php echo $th['section']; ?></h2>
 							</div>
 						</div>
 						<?php
							$sql1 = mysqli_query($con, "select * from dailychecks1 where tid='$tid' and section='$th[section]'");

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
 								<div class="col-md-3">
 									<div class="form-group label-floating">
 										<select name="r1<?php echo $i; ?>" id="r1<?php echo $i; ?>" class="form-control" onchange="validateField(<?php echo $i; ?>)" required>
 											<option value="">Please Select</option>
 											<option value="Yes">Yes</option>
 											<option value="No">No</option>
 										</select>
 									</div>
 								</div>


 								<div class="col-md-3">
 									<div class="form-group label-floating">
 										<textarea name="cmnt<?php echo $i; ?>" id="f1<?php echo $i; ?>" class="form-control" placeholder="Comment"></textarea>
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
 						function validateField(q) {
 							let selectBox = document.getElementById("r1" + q);
 							let inputField = document.getElementById("f1" + q);

 							if (selectBox.value === "No") {
 								inputField.setAttribute("required", "true");
 							} else {
 								inputField.removeAttribute("required");
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
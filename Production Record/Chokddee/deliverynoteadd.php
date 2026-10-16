<?php
$pid = $_GET['tid'];
?>

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="ml-3"><?php echo $headingname; ?></h1>
		<ul>
			<li class="ml-2"><a href="">Production Record</a></li>
			<li>Delivery Note</li>
		</ul>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<a href="admin.php?id=deliverynote&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				<form name="form1" method="post" action="" enctype="multipart/form-data">
					<input type="hidden" name="vhc" id="vcheck">

					<div class="form-row">
						<div class="col-md-12">
							<h3>Delivery and Delivery vehicle Condition Log</h3>
							<br>
							<br>
							<div class="col-6">
								<label for="cc-exp" class="control-label mb-1">Date</label>
								<div class="input-group">
									<input type="date" name="date" class="form-control" id="date" required />
								</div>
							</div>
							<div class="col-6">
								<label for="cc-exp" class="control-label mb-1">Time</label>
								<div class="input-group">
									<input type="time" name="ttime" class="form-control" id="ttime" required />
								</div>
							</div>

							<div class="col-6">
								<label for="cc-exp" class="control-label mb-1">Customer Name</label>
								<div class="input-group">
									<input type="text" name="cname" class="form-control" id="cname" required />
								</div>
							</div>

							<div class="col-6">
								<label for="cc-exp" class="control-label mb-1">Customer Invoice number</label>
								<div class="input-group">
									<input type="text" name="cinvoice" class="form-control" id="cinvoice" required />
								</div>
							</div>

							<div class="col-6">
								<label for="cc-exp" class="control-label mb-1"></label>
								<div class="input-group">
									<button class="btn btn-info" type="button" onclick="return cal();" id="next1">Save & Next</button>
								</div>
							</div>

							<div id="div1" style="display:none">
								<strong class="card-title"> * Vehicle Checks</strong>
								<br /><br />
								<div class="form-row" id="row2">
									<?php
									$sql = mysqli_query($con, "select * from tblques2 where status='goodsout'");
									$i = 0;
									while ($rows = mysqli_fetch_array($sql)) {
									?>
										<div class="col-md-6">
											<label for="cc-exp" class="control-label mb-1"> <?php echo $rows['ques']; ?></label>
										</div>

										<div class="col-md-3">
											<label for="x_card_code" class="control-label mb-1">
												<input type="hidden" id="t1<?php echo $i; ?>" value="<?php echo $rows['ansa']; ?>" />
												<select class="form-control" name="ans[]" id="s1<?php echo $i; ?>" required>
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
											</label>
										</div>
									<?php
										$i++;
									}
									?>

									<div class="col-md-12 mt-4 mb-2">
										<strong class="card-title">* Product Checks</strong>
									</div>

									<?php
									$sql1 = mysqli_query($con, "select * from tblques2 where status='product'");
									$k = 0;
									while ($rows1 = mysqli_fetch_array($sql1)) {
									?>
										<div class="col-md-6">
											<label for="cc-exp" class="control-label mb-1"> <?php echo $rows1['ques']; ?></label>
										</div>

										<div class="col-md-3">
											<label for="x_card_code" class="control-label mb-1">
												<select class="form-control" name="proans[]" id="p1<?php echo $k; ?>" required>
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
											</label>
										</div>
									<?php
										$k++;
									}
									?>
								</div>

								<div class="col-6">
									<label for="cc-exp" class="control-label mb-1"></label>
									<div class="input-group">
										<button class="btn btn-info" id="save" onclick="return cal1()" type="button">Save & Next</button>
										<button class="btn btn-danger" id="reject" type="submit" name="submit2" style="display:none">Unacceptable</button>
									</div>
								</div>

								<div class="form-row mt-3 d-none" id="div2">
									<div class="col-md-6 mt-2">
										<label for="temp">Temperature of Vehicle</label><br>
										<div class="input-group mb-2">
											<input type="number" class="form-control" id="inlineFormInputGroup" name="tempvehicle" placeholder="temperature" required>
											<div class="input-group-prepend">
												<div class="input-group-text"><sup>o</sup>C</div>
											</div>
										</div>

									</div>

									<div class="col-md-6 mt-2">
										<label for="delivery_sent">Delivery Sent By(Sign)</label><br>
										<input class="form-control" type="text" name="deliverysent" id="delivery_sent" required>
									</div>

									<div class="col-md-6 mt-2">
										<label for="driver_name">Driver Name</label><br>
										<input class="form-control" type="text" name="drivername" id="driver_name" required>
									</div>

									<div class="col-md-6 mt-2">
										<label for="vehicle_reg">Vehicle Registration No.</label><br>
										<input class="form-control" type="text" name="vehiclereg" id="vehicle_reg" required>
									</div>




									<div class="col-md-6 mt-2">
										<label for="vehicle_reg">Attempt By</label><br>
										<?php
										$qs = mysqli_query($con, "Select * from tblprecord where id = '$pid'");
										$qs1 = mysqli_fetch_array($qs);
										$qsid = $qs1['pid'];

										$psr = mysqli_query($con, "Select * from `tblrecord_attempt` where pid = '$qsid'");



										?>
										<select name="addby" id="" class="form-control">
											<option>Select Your Name</option>
											<?php
											foreach ($psr as $psdata) {
												$prname  = $psdata['name'];
												echo '<option value="' . $prname . '">' . $prname . '</option>';
											}

											?>

										</select>

									</div>




									<br><br>

									<button type="submit" class="btn btn-primary mt-4" name="submit">Save & Next</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<script>
					// Track validation state and whether answers have been changed after validation
					let isCurrentlyValid = false;
					let answersChanged = false;

					function cal() {
						// Validate required fields before proceeding
						var date = document.getElementById("date").value.trim();
						var cname = document.getElementById("cname").value.trim();
						var cinvoice = document.getElementById("cinvoice").value.trim();
						if (!date || !cname || !cinvoice) {
							alert("Please fill in Date, Customer Name, and Customer Invoice number before proceeding.");
							return false;
						}
						document.getElementById("div1").style.display = "block";
						document.getElementById("next1").style.display = "none";
						addAnswerChangeDetectors();
						return true;
					}

					function addAnswerChangeDetectors() {
						// Vehicle check select elements (4 questions)
						for (let i = 0; i < 4; i++) {
							const element = document.getElementById('s1' + i);
							if (element) {
								element.addEventListener('change', handleAnswerChange);
							}
						}
						// Product check select elements (5 questions)
						for (let i = 0; i < 5; i++) {
							const element = document.getElementById('p1' + i);
							if (element) {
								element.addEventListener('change', handleAnswerChange);
							}
						}
					}

					function handleAnswerChange() {
						if (isCurrentlyValid) {
							answersChanged = true;
							resetValidationState();
						} else if (document.getElementById("reject").style.display === "block") {
							// If in "Unacceptable" state and answers are corrected
							if (checkAnswersValid()) {
								resetToSaveNextState();
							}
						}
					}

					function checkAnswersValid() {
						// Vehicle checks
						const v1 = document.getElementById('s10')?.value || '';
						const v2 = document.getElementById('s11')?.value || '';
						const v3 = document.getElementById('s12')?.value || '';
						const v4 = document.getElementById('s13')?.value || '';

						// Product checks
						const p1 = document.getElementById('p10')?.value || '';
						const p2 = document.getElementById('p11')?.value || '';
						const p3 = document.getElementById('p12')?.value || '';
						const p4 = document.getElementById('p13')?.value || '';
						const p5 = document.getElementById('p14')?.value || '';

						return (v1 === "Yes" && v2 === "No" && v3 === "No" && v4 === "No") &&
							(p1 === "Yes" && p2 === "Yes" && p3 === "No" && p4 === "Yes" && p5 === "Yes");
					}

					function resetValidationState() {
						document.getElementById("div2").classList.add("d-none");
						document.getElementById("save").style.display = "block";
						document.getElementById("reject").style.display = "none";
						isCurrentlyValid = false;
					}

					function resetToSaveNextState() {
						document.getElementById("reject").style.display = "none";
						document.getElementById("save").style.display = "block";
						document.getElementById("div2").classList.add("d-none");
						isCurrentlyValid = false;
						answersChanged = true;
					}

					function validateAnswers() {
						if (checkAnswersValid()) {
							document.getElementById("save").style.display = "none";
							document.getElementById("reject").style.display = "none";
							document.getElementById("div2").classList.remove("d-none");
							document.getElementById("vcheck").value = 'Acceptable';
							isCurrentlyValid = true;
							answersChanged = false;
							return true;
						} else {
							document.getElementById("reject").style.display = "block";
							document.getElementById("save").style.display = "none";
							document.getElementById("div2").classList.add("d-none");
							document.getElementById("vcheck").value = 'Unacceptable';
							isCurrentlyValid = false;
							return false;
						}
					}

					function cal1() {
						if (answersChanged || !isCurrentlyValid) {
							return validateAnswers();
						}
						return true;
					}
				</script>
				<?php
				if (isset($_POST['submit'])) {
					// Collect form data
					$cname = $_POST['cname'];
					$date = $_POST['date'];
					$ttime = $_POST['ttime'];
					$cinvoice = $_POST['cinvoice'];
					$temp_vehicle = $_POST['tempvehicle'];
					$delivery_sent = $_POST['deliverysent'];
					$driver_name = $_POST['drivername'];
					$vehicle_reg = $_POST['vehiclereg'];
					$ans = isset($_POST['ans']) ? $_POST['ans'] : [];
					$proans = isset($_POST['proans']) ? $_POST['proans'] : [];
					$addby = $_POST['addby'];

					if ($ans[0] == 'Yes' && $ans[1] == 'No' && $ans[2] == 'No' && $ans[3] == 'No') {
						$vehcheck = 'Acceptable';
					} else {
						$vehcheck = 'Unacceptable';
					}

					if ($proans[0] == 'Yes' && $proans[1] == 'Yes' && $proans[2] == 'No' && $proans[3] == 'Yes' && $proans[4] == 'Yes') {
						$prodcheck = 'Acceptable';
					} else {
						$prodcheck = 'Unacceptable';
					}

					$cmnt = isset($_POST['cmnt']) ? $_POST['cmnt'] : [];
					$ans_str = implode(',', $ans);
					$proans_str = implode(',', $proans);
					$cmnt_str = implode('||', $cmnt);


					$nrk = mysqli_query($con, "select * from tbldelivery ");
					$nrk1 = mysqli_num_rows($nrk);
					$nrkn = $nrk1 + 1;

					$recordc = "Delh010" . $nrkn;

					$sql = "INSERT INTO tbldelivery (cname, date, cinvoice, tempvehicle, deliverysent, drivername, vehiclereg, ans, proans, cmnt, prodcheck, vehcheck,recordid,ttime,tid,add_by) VALUES (
					'$cname','$date', '$cinvoice', '$temp_vehicle', '$delivery_sent', '$driver_name', '$vehicle_reg', '$ans_str', '$proans_str', '$cmnt_str', '$prodcheck', '$vehcheck','$recordc','$ttime',$pid,'$addby')";

					if (mysqli_query($con, $sql)) {
						echo '<script> window.location.href = "admin.php?id=dispatch_sign&rid=' . $recordc . '";</script>';
					} else {
						echo '<script>alert("Error in submission");</script>';
					}
				}

				if (isset($_POST['submit2'])) {
					echo '<script>alert("Submission rejected - answers are not acceptable");</script>';
				}
				?>
			</div>
		</div>
	</div>
</div>
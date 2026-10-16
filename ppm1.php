<?php
$sno = $_GET['sno'];



$sql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
$row = mysqli_fetch_array($sql);


$sql2 = mysqli_query($con, "SELECT * FROM tblequipment WHERE id='$row[eid]'");
$row2 = mysqli_fetch_array($sql2);
?>

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Corrective Maintaince</a></li>
			<li>Detail</li>
		</ul>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<a href="admin.php?id=ppm"><button class="btn btn-success mb-4" style="float:right; margin-left:15px">Go Back</button></a>

				<?php if (($row['mverify']) != 'done') { ?>
					<a href="admin.php?id=ppmreport&sno=<?php echo urlencode($sno); ?>"><button class="btn btn-warning mb-4" style="float:right; margin-left:15px">Verify Report</button></a>
				<?php } else { ?>
					<a href="admin.php?id=ppmreport&sno=<?php echo urlencode($sno); ?>"><button class="btn btn-info mb-4" style="float:right; margin-left:15px">View Report</button></a>
				<?php } ?>

				<table class="display table table-striped table-bordered" style="width:100%">
					<tbody>
						<tr>
							<th scope="col">Equipment Code</th>
							<td><?php echo $row2['code']; ?></td>
						</tr>
						<tr>
							<th scope="col">Manufacturer</th>
							<td><?php echo $row2['make']; ?></td>
						</tr>
						<tr>
							<th scope="col">Model Number</th>
							<td><?php echo $row2['model']; ?></td>
						</tr>
						<tr>
							<th scope="col">Equipment Name</th>
							<td><?php echo $row2['name']; ?></td>
						</tr>
						<tr>
							<th scope="col">Is equipment being services Internally or Externally?</th>
							<td><?php echo $row2['service']; ?></td>
						</tr>
						<tr>
							<th scope="col">Site</th>
							<td><?php echo $row2['site']; ?></td>
						</tr>
						<tr>
							<th scope="col">Location</th>
							<td><?php echo $row2['location']; ?></td>
						</tr>
						<tr>
							<th scope="col">Frequency</th>
							<td><?php echo $row2['frequency'] ?></td>
						</tr>
						<tr>
							<th scope="col">Responsible Person</th>
							<td><?php echo $row2['rperson']; ?></td>
						</tr>
					</tbody>
				</table>

				<div class="row">
					<div class="card-body">
						<h3 align="center" style="color:#FF0000"> Machine Update Detail</h3>
						<form enctype="multipart/form-data" method="post" name="form1">
							<input type="hidden" name="eid" value="<?php echo $row['eid']; ?>" />
							<input type="hidden" name="sno" value="<?php echo $sno; ?>" />

							<?php
							$string2 = $row['checks'];
							$tags2 = !empty($string2) ? explode(';', $string2) : ['', '', '', ''];
							$isReadonly = ($row['status1']) == 'Done' ? 'disabled' : '';
							$isRequired = ($row['status1']) == 'Done' ? '' : 'required="required"';
							$bothFilesExist = (!empty($row['serviceimg']) && !empty($row['supdoc']));
							$serviceimgDisabled = !empty($row['serviceimg']) ? 'disabled' : '';
							$supdocDisabled = !empty($row['supdoc']) ? 'disabled' : '';
							?>

							<!-- Safety Check 1 -->
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label>1&deg; Safety Check:(Maintenance work carried out and complete)</label>
									<div>
										<input type="radio" name="safety1" value="Yes" <?php echo (($tags2[0]) == 'Yes') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> Yes
										<input type="radio" name="safety1" value="No" <?php echo (($tags2[0]) == 'No') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> No
									</div>
								</div>
							</div>

							<!-- Safety Check 2 -->
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label>2° Safety Check: (Any residual debris from maintenance work removed and cleared)</label>
									<div>
										<input type="radio" name="safety2" value="Yes" <?php echo (($tags2[1]) == 'Yes') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> Yes
										<input type="radio" name="safety2" value="No" <?php echo (($tags2[1]) == 'No') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> No
									</div>
								</div>
							</div>

							<!-- Safety 2 Correction -->
							<div class="form-row" id="safety2Correction" style="display:<?php echo (($tags2[1]) == 'No') ? 'block' : 'none'; ?>;">
								<div class="col-md-6 mb-3">
									<label for="safety2_reason">Comment</label>
									<input type="text" class="form-control" name="safety2_reason" id="safety2_reason" value="<?php echo $row['safety2_reason']; ?>" <?php echo $isReadonly; ?>>
								</div>
							</div>

							<!-- Safety Check 3 -->
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label>3&deg; Safety Check: (Are tools and equipment used maintenance wiped cleaned and sanitized)</label>
									<div>
										<input type="radio" name="safety3" value="Yes" <?php echo (($tags2[2]) == 'Yes') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> Yes
										<input type="radio" name="safety3" value="No" <?php echo (($tags2[2]) == 'No') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> No
									</div>
								</div>
							</div>

							<!-- Safety Check 4 -->
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label>4&deg; Safety Check: (Equipment in good working order and ready for food safe operation)</label>
									<div>
										<input type="radio" name="safety4" value="Yes" <?php echo (($tags2[3]) == 'Yes') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> Yes
										<input type="radio" name="safety4" value="No" <?php echo (($tags2[3]) == 'No') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>> No
									</div>
								</div>
							</div>

							<!-- Corrective -->
							<div class="form-row">
								<div class="col-md-6 mb-6">
									<label>Corrective</label>
									<textarea class="form-control" name="description" <?php echo $isRequired; ?> <?php echo $isReadonly; ?>><?php echo $row['description']; ?></textarea>
								</div>
							</div>

							<!-- Parts Replaced -->
							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label>Any Parts Replaced</label>
									<input type="text" class="form-control" name="replace" value="<?php echo $row['preplace']; ?>" <?php echo $isReadonly; ?>>
								</div>
							</div>

							<!-- Service Report -->
							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label for="serviceimg">Service Report (PDF, JPG, PNG)</label>
									<input type="file" class="form-control" name="serviceimg" id="serviceimg" accept=".pdf,.jpg,.jpeg,.png" <?php echo $serviceimgDisabled; ?>>
									<div id="servicePreview" style="margin-top:10px;">
										<?php if (!empty($row['serviceimg'])): ?>
											<br><a href="upl1/<?php echo htmlspecialchars($row['serviceimg']); ?>" target="_blank">View Document</a>
										<?php else: ?>
											<span style="color:red;">No file uploaded</span>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<!-- Supporting Documents -->
							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label for="supdoc">Supporting Documents (PDF, JPG, PNG)</label>
									<input type="file" class="form-control" name="supdoc" id="supdoc" accept=".pdf,.jpg,.jpeg,.png" <?php echo $supdocDisabled; ?>>
									<div id="supdocPreview" style="margin-top:10px;">
										<?php if (!empty($row['supdoc'])): ?>
											<br><a href="upl1/<?php echo htmlspecialchars($row['supdoc']); ?>" target="_blank">View Document</a>
										<?php else: ?>
											<span style="color:red;">No file uploaded</span>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<!-- Engineer Name -->
							<div class="form-row mt-2">
								<div class="col-md-4 mb-3">
									<label>Engineer Name</label>
									<input class="form-control" type="text" <?php echo $isRequired; ?> name="ename" value="<?php echo $row['ename']; ?>" <?php echo $isReadonly; ?> />
								</div>

								<!-- Production Stop -->
								<div class="col-md-4 mb-3">
									<label>Due Production needs be stopped for this Maintenance</label>
									<div>
										<input type="radio" name="production" value="Yes" <?php echo (($row['production']) == 'Yes') ? 'checked' : ''; ?> onchange="showHoursField(this.value)" <?php echo $isReadonly; ?>> Yes
										<input type="radio" name="production" value="No" <?php echo (($row['production']) == 'No') ? 'checked' : ''; ?> onchange="showHoursField(this.value)" <?php echo $isReadonly; ?>> No
									</div>
								</div>

								<!-- Hours Field -->
								<div class="col-md-4 mb-3" id="hoursField" style="display: <?php echo (($row['production']) == 'Yes') ? 'block' : 'none'; ?>;">
									<label for="hours">How many hours production cannot be carried out ?</label>
									<input type="number" class="form-control" id="hours" name="hours" min="1" placeholder="Enter hours" value="<?php echo $row['hours']; ?>" <?php echo $isReadonly; ?>>
								</div>
							</div>

							<!-- Engineer Type -->
							<div class="form-row">
								<div class="col-md-4 mb-3">
									<label>Is the engineer internal or external?</label><br>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="engineer_type" id="engineerInternal" value="Internal" <?php echo (($row['engineer_type']) == 'Internal') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>>
										<label class="form-check-label" for="engineerInternal">Internal</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="engineer_type" id="engineerExternal" value="External" <?php echo (($row['engineer_type']) == 'External') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>>
										<label class="form-check-label" for="engineerExternal">External</label>
									</div>
								</div>
							</div>

							<!-- Visit Question -->
							<div class="form-row" id="visitQuestion" style="display:<?php echo (($row['engineer_type']) == 'External') ? 'block' : 'none'; ?>;">
								<div class="col-md-4 mb-3">
									<label>The person has completed visit before enter Production ?</label><br>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="visit_completed" id="visitYes" value="Yes" <?php echo (($row['visit_completed']) == 'Yes') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>>
										<label class="form-check-label" for="visitYes">Yes</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="visit_completed" id="visitNo" value="No" <?php echo (($row['visit_completed']) == 'No') ? 'checked' : ''; ?> <?php echo $isReadonly; ?>>
										<label class="form-check-label" for="visitNo">No</label>
									</div>
								</div>
							</div>

							<!-- Corrective Action -->
							<div class="form-row" id="correctiveAction" style="display:<?php echo (($row['visit_completed']) == 'No') ? 'block' : 'none'; ?>;">
								<div class="col-md-6 mb-3">
									<label for="corrective_reason">Corrective Action</label>
									<input type="text" class="form-control" name="corrective_reason" id="corrective_reason" value="<?php echo $row['corrective_reason']; ?>" <?php echo $isReadonly; ?>>
								</div>
							</div>

							<!-- Dates -->
							<div class="form-row">
								<div class="col-md-4 mb-3">
									<label for="sdate">Maintenance Start Time</label>
									<input class="form-control" id="sdate" type="datetime-local" <?php echo $isRequired; ?> name="sdate" value="<?php echo $row['stime']; ?>" <?php echo $isReadonly; ?> />
								</div>
								<div class="col-md-4 mb-3">
									<label for="edate">Maintenance End Time</label>
									<input class="form-control" id="edate" type="datetime-local" <?php echo $isRequired; ?> name="edate" value="<?php echo $row['etime']; ?>" <?php echo $isReadonly; ?> />
								</div>
								<div class="col-md-4 mb-3">
									<label for="ndate">Next Date of Maintenance:</label>
									<input class="form-control" id="ndate" type="date" <?php echo $isRequired; ?> name="ndate" value="<?php echo $row['nextdate']; ?>" <?php echo $isReadonly; ?> />
								</div>
							</div>

							<!-- Task Completed By -->
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="doneby">Task Completed By:</label>
									<input class="form-control" id="doneby" type="text" <?php echo $isRequired; ?> name="doneby" value="<?php echo $row['completedby']; ?>" <?php echo $isReadonly; ?> />
									<?php if (!empty($row['completesign'])): ?>
										<div class="mt-2">
											<img src="signature/<?php echo $row['completesign']; ?>.png" width="200" class="img-fluid border p-1 rounded" />
										</div>
									<?php endif; ?>
								</div>
							</div>

							<!-- Submit Button -->
							<div class="form-row">
								<div class="col-md-12 text-center">
									<?php
									if (($row['status1']) != 'Done') {
										echo '<button class="btn btn-primary" type="submit" name="submit">Submit</button>';
									} elseif (($row['status1']) == 'Done' && !$bothFilesExist) {
										echo '<button class="btn btn-warning" type="submit" name="update_files">Update Files</button>';
									}
									?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function showHoursField(value) {
		var hoursField = document.getElementById('hoursField');
		hoursField.style.display = (value === 'Yes') ? 'block' : 'none';
	}

	document.addEventListener("DOMContentLoaded", function() {
		// Safety 2 correction field
		const safety2Radios = document.querySelectorAll('input[name="safety2"]');
		const safety2Correction = document.getElementById("safety2Correction");
		const safety2Reason = document.getElementById("safety2_reason");

		safety2Radios.forEach(radio => {
			radio.addEventListener("change", function() {
				if (this.value === "No") {
					safety2Correction.style.display = "block";
					safety2Reason.setAttribute("required", "required");
				} else {
					safety2Correction.style.display = "none";
					safety2Reason.removeAttribute("required");
					safety2Reason.value = "";
				}
			});
		});

		// Engineer type fields
		const engineerRadios = document.querySelectorAll('input[name="engineer_type"]');
		const visitQuestion = document.getElementById("visitQuestion");
		const visitRadios = document.querySelectorAll('input[name="visit_completed"]');
		const correctiveAction = document.getElementById("correctiveAction");
		const correctiveInput = document.getElementById("corrective_reason");

		engineerRadios.forEach(radio => {
			radio.addEventListener("change", function() {
				if (this.value === "External") {
					visitQuestion.style.display = "block";
				} else {
					visitQuestion.style.display = "none";
					correctiveAction.style.display = "none";
					correctiveInput.removeAttribute("required");
					correctiveInput.value = "";
				}
			});
		});

		visitRadios.forEach(radio => {
			radio.addEventListener("change", function() {
				if (this.value === "No") {
					correctiveAction.style.display = "block";
					correctiveInput.setAttribute("required", "required");
				} else {
					correctiveAction.style.display = "none";
					correctiveInput.removeAttribute("required");
					correctiveInput.value = "";
				}
			});
		});
	});
</script>

<?php
// PROCESS SUBMIT
if (isset($_POST['submit'])) {
	$doneby = mysqli_real_escape_string($con, $_POST['doneby']);
	$ndate = mysqli_real_escape_string($con, $_POST['ndate']);
	$sdate = mysqli_real_escape_string($con, $_POST['sdate']);
	$edate = mysqli_real_escape_string($con, $_POST['edate']);
	$production = mysqli_real_escape_string($con, $_POST['production']);
	$hours = isset($_POST['hours']) ? mysqli_real_escape_string($con, $_POST['hours']) : '';
	$ename = mysqli_real_escape_string($con, $_POST['ename']);
	$safety1 = mysqli_real_escape_string($con, $_POST['safety1']);
	$safety2 = mysqli_real_escape_string($con, $_POST['safety2']);
	$safety3 = mysqli_real_escape_string($con, $_POST['safety3']);
	$safety4 = mysqli_real_escape_string($con, $_POST['safety4']);
	$sno = mysqli_real_escape_string($con, $_POST['sno']);
	$eid = mysqli_real_escape_string($con, $_POST['eid']);
	$replace = mysqli_real_escape_string($con, $_POST['replace']);
	$description = mysqli_real_escape_string($con, $_POST['description']);
	$safety2_reason = isset($_POST['safety2_reason']) ? mysqli_real_escape_string($con, $_POST['safety2_reason']) : '';
	$engineer_type = isset($_POST['engineer_type']) ? mysqli_real_escape_string($con, $_POST['engineer_type']) : '';
	$visit_completed = isset($_POST['visit_completed']) ? mysqli_real_escape_string($con, $_POST['visit_completed']) : '';
	$corrective_reason = isset($_POST['corrective_reason']) ? mysqli_real_escape_string($con, $_POST['corrective_reason']) : '';

	$upl1 = "upl1/";

	$currentSql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
	$currentRow = mysqli_fetch_array($currentSql);

	$serviceimg = $currentRow['serviceimg'];
	$supdoc = $currentRow['supdoc'];

	// Handle serviceimg upload
	if (!empty($_FILES['serviceimg']['name']) && $_FILES['serviceimg']['error'] == 0) {
		$ext = strtolower(pathinfo($_FILES['serviceimg']['name'], PATHINFO_EXTENSION));
		$allowed = ['pdf', 'jpg', 'jpeg', 'png'];
		if (in_array($ext, $allowed)) {
			$uniqueName = uniqid("service_", true) . "." . $ext;
			if (move_uploaded_file($_FILES['serviceimg']['tmp_name'], $upl1 . $uniqueName)) {
				if (!empty($currentRow['serviceimg']) && file_exists($upl1 . $currentRow['serviceimg'])) {
					unlink($upl1 . $currentRow['serviceimg']);
				}
				$serviceimg = $uniqueName;
			}
		}
	}

	// Handle supdoc upload
	if (!empty($_FILES['supdoc']['name']) && $_FILES['supdoc']['error'] == 0) {
		$ext = strtolower(pathinfo($_FILES['supdoc']['name'], PATHINFO_EXTENSION));
		$allowed = ['pdf', 'jpg', 'jpeg', 'png'];
		if (in_array($ext, $allowed)) {
			$uniqueName = uniqid("supdoc_", true) . "." . $ext;
			if (move_uploaded_file($_FILES['supdoc']['tmp_name'], $upl1 . $uniqueName)) {
				if (!empty($currentRow['supdoc']) && file_exists($upl1 . $currentRow['supdoc'])) {
					unlink($upl1 . $currentRow['supdoc']);
				}
				$supdoc = $uniqueName;
			}
		}
	}

	$safety = implode(";", [$safety1, $safety2, $safety3, $safety4]) . ";";


	$sql = "UPDATE tblequipment1 SET 
            checks='$safety',
            ename='$ename',
            production='$production',
            hours='$hours',
            stime='$sdate',
            etime='$edate',
            completedby='$doneby',
            status1='Done',
            description='$description',
            preplace='$replace',
            serviceimg='$serviceimg',
            supdoc='$supdoc',
            nextdate='$ndate',
            safety2_reason='$safety2_reason',
            engineer_type='$engineer_type',
            visit_completed='$visit_completed',
            corrective_reason='$corrective_reason' 
            WHERE id='$sno'";

	if (mysqli_query($con, $sql)) {
		$month = date("m", strtotime($ndate));
		mysqli_query($con, "INSERT INTO tblequipment1 (eid, date, month) VALUES ('$eid', '$ndate', '$month')");
	}

	echo '<script>window.open("admin.php?id=ppm3&sno=' . $sno . '", "_self");</script>';
	exit;
}

// PROCESS UPDATE FILES
if (isset($_POST['update_files'])) {
	$sno = mysqli_real_escape_string($con, $_POST['sno']);
	$upl1 = "upl1/";

	$currentSql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
	$currentRow = mysqli_fetch_array($currentSql);

	$serviceimg = $currentRow['serviceimg'];
	$supdoc = $currentRow['supdoc'];

	// Handle serviceimg upload
	if (!empty($_FILES['serviceimg']['name']) && $_FILES['serviceimg']['error'] == 0) {
		$ext = strtolower(pathinfo($_FILES['serviceimg']['name'], PATHINFO_EXTENSION));
		$allowed = ['pdf', 'jpg', 'jpeg', 'png'];
		if (in_array($ext, $allowed)) {
			$uniqueName = uniqid("service_", true) . "." . $ext;
			if (move_uploaded_file($_FILES['serviceimg']['tmp_name'], $upl1 . $uniqueName)) {
				if (!empty($currentRow['serviceimg']) && file_exists($upl1 . $currentRow['serviceimg'])) {
					unlink($upl1 . $currentRow['serviceimg']);
				}
				$serviceimg = $uniqueName;
			}
		}
	}

	// Handle supdoc upload
	if (!empty($_FILES['supdoc']['name']) && $_FILES['supdoc']['error'] == 0) {
		$ext = strtolower(pathinfo($_FILES['supdoc']['name'], PATHINFO_EXTENSION));
		$allowed = ['pdf', 'jpg', 'jpeg', 'png'];
		if (in_array($ext, $allowed)) {
			$uniqueName = uniqid("supdoc_", true) . "." . $ext;
			if (move_uploaded_file($_FILES['supdoc']['tmp_name'], $upl1 . $uniqueName)) {
				if (!empty($currentRow['supdoc']) && file_exists($upl1 . $currentRow['supdoc'])) {
					unlink($upl1 . $currentRow['supdoc']);
				}
				$supdoc = $uniqueName;
			}
		}
	}

	mysqli_query($con, "UPDATE tblequipment1 SET serviceimg='$serviceimg', supdoc='$supdoc' WHERE id='$sno'");

	echo '<script>window.open("admin.php?id=ppm", "_self");</script>';
}
?>
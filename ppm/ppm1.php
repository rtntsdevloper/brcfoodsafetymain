<?php
$sno = $_GET['sno'];

$sql = mysqli_query($con, "select * from tblequipment1 where id='$sno'");
$row = mysqli_fetch_array($sql);


$sql2 = mysqli_query($con, "select * from tblequipment where id='$row[eid]'");
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

				<?php
				if ($row['mverify'] != 'done') {
				?>

					<a href="admin.php?id=ppmreport&sno=<?php echo $sno; ?>"><button class="btn btn-warning mb-4" style="float:right; margin-left:15px">Verify Report</button></a>
				<?php  } else { ?>
					<a href="admin.php?id=ppmreport&sno=<?php echo $sno; ?>"><button class="btn btn-info mb-4" style="float:right; margin-left:15px">View Report</button></a>
				<?php
				} ?>
				<table class="display table table-striped table-bordered" style="width:100%">
					<thead>
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
							<td><?php echo $row2['frequency']; ?></td>
						</tr>

						<tr>
							<th scope="col">Responsible Person</th>
							<td><?php echo $row2['rperson']; ?></td>
						</tr>
					</thead>
				</table>
				<div class="row">
					<div class="card-body">
						<h3 align="center" style="color:#FF0000"> Machine Update Detail</h3>
						<form enctype="multipart/form-data" method="post" name="form1">
							<input type="hidden" name="eid" value="<?php echo $row['eid']; ?>" />
							<input type="hidden" name="sno" value="<?php echo $sno; ?>" />

							<?php
							$string2 = $row['checks'];
							$tags2 = explode(';', $string2);

							?>

							<div class="form-row">


								<div class="col-md-6 mb-3">
									<label for="validationTooltip01">1&deg; Safety Check:(Maintenance work carried out and complete)</label>

									<select class="form-control" name="safety1" required="required">
										<option value="<?php echo $tags2[0]; ?>"><?php echo $tags2[0]; ?></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="validationTooltip01">2&deg; Safety Check: (Any residual debris from maintenance work removed and cleared(Free from scews, metal pieces))</label>

									<select class="form-control" name="safety2" required="required">
										<option value="<?php echo $tags2[1]; ?>"><?php echo $tags2[1]; ?></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="validationTooltip01">3&deg; Safety Check: (Safety Check Equipment wiped cleaned and sanitized)</label>

									<select class="form-control" name="safety3" required="required">
										<option value="<?php echo $tags2[2]; ?>"><?php echo $tags2[2]; ?></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="validationTooltip01">4&deg; Safety Check: (Equipment in good working order and ready for food safe operation)</label>

									<select class="form-control" name="safety4" required="required">
										<option value="<?php echo $tags2[2]; ?>"><?php echo $tags2[3]; ?></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 mb-6">
									<label for="validationTooltip01">PPM Job Description To be filled by Engineer</label>
									<textarea class="form-control" name="description" required="required"><?php echo $row['description']; ?></textarea>

								</div>

							</div>

							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label for="validationTooltip01">Any Parts Replaced</label>
									<input type="text" class="form-control" value="<?php echo $row['preplace'] ?>">
								</div>

							</div>


							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label for="serviceimg">Service Report</label>
									<input type="file" class="form-control" name="serviceimg" id="serviceimg" accept="image/*">

									<?php if (!empty($row['serviceimg'])): ?>
										<a href="upl1/<?php echo $row['serviceimg']; ?>" target="_blank">View Service Report</a>
									<?php endif; ?>
								</div>
							</div>

							<div class="form-row mt-2">
								<div class="col-md-6 mb-6">
									<label for="supdoc">Supporting Documents</label>
									<input type="file" class="form-control" name="supdoc" id="supdoc" accept="image/*">

									<?php if (!empty($row['supdoc'])): ?>
										<a href="upl1/<?php echo $row['supdoc']; ?>" target="_blank">View Supporting Document</a>
									<?php endif; ?>
								</div>
							</div>




							<div class="form-row">

								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Engineer Name</label>
									<input class="form-control" id="validationTooltip01" type="text" required="required" name="ename" value="<?php echo $row['ename']; ?>" />
								</div>



								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Production Stop Required</label>
									<select class="form-control" name="production" required="required">
										<option value="<?php echo $row['production']; ?>"><?php echo $row['production']; ?></option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>



							<div class="form-row">
								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Machine achievement done(Start Time):</label>
									<input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="sdate" value="<?php echo $row['stime']; ?>" />
								</div>

								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Machine achievement done(End Time):</label>
									<input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="edate" value="<?php echo $row['etime']; ?>" />
								</div>

								<div class="col-md-4 mb-3">
									<label for="validationTooltip01"> Next date of Maintenance:</label>
									<input class="form-control" id="validationTooltip01" type="date" required="required" name="ndate" value="<?php echo $row['nextdate']; ?>" />
								</div>
							</div>


							<div class="form-row">
								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Task completed by:</label>
									<input class="form-control" id="validationTooltip01" type="text" required="required" name="doneby" value="<?php echo $row['completedby']; ?>" />


									<img src="signature/<?php echo $row['completesign']; ?>.png" width="200" />
								</div>

<!-- 
								<div class="col-md-4 mb-3">
									<label for="validationTooltip01">Task verified by:</label>
									<input class="form-control" id="validationTooltip01" type="text" required="required" name="verifiedby" value="<?php echo $row['verifiedby']; ?>" />

									<img src="signature/<?php echo $row['verifysign']; ?>.png" width="200" />

								</div> -->
							</div>
							<?php
							if ($row['status1'] != 'Done') {
							?>
								<button class="btn btn-primary" type="submit" name="submit">Submit </button>
							<?php
							}
							?>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_POST['submit'])) {
	// $verifiedby = $_POST['verifiedby'];
	$doneby = $_POST['doneby'];
	$ndate = $_POST['ndate'];
	$sdate = $_POST['sdate'];
	$edate = $_POST['edate'];
	$production = $_POST['production'];
	$ename = $_POST['ename'];
	$safety1 = $_POST['safety1'];
	$safety2 = $_POST['safety2'];
	$safety3 = $_POST['safety3'];
	$safety4 = $_POST['safety4'];
	$sno = $_POST['sno'];
	$eid = $_POST['eid'];
	$replace = $_POST['replace'];
	$upl1 = "upl1/";

	if (!empty($_FILES['serviceimg']['name'])) {
		$tmpPath = $_FILES['serviceimg']['tmp_name'];
		$info = pathinfo($_FILES['serviceimg']['name']);
		$ext = $info['extension'];

		$uniqueName = uniqid("service_", true) . "." . $ext;
		move_uploaded_file($tmpPath, $upl1 . $uniqueName);
		$serviceimg = $uniqueName;
	}

	if (!empty($_FILES['supdoc']['name'])) {
		$tmpPath = $_FILES['supdoc']['tmp_name'];
		$info = pathinfo($_FILES['supdoc']['name']);
		$ext = $info['extension'];

		$uniqueName = uniqid("supdoc_", true) . "." . $ext;
		move_uploaded_file($tmpPath, $upl1 . $uniqueName);
		$supdoc = $uniqueName;
	}

	$description = mysqli_real_escape_string($con, $_POST['description']);

	// Cleaner way to build safety string
	$safety = implode(";", [$safety1, $safety2, $safety3, $safety4]) . ";";

	// Corrected SQL
	$sql = "UPDATE tblequipment1 SET checks='$safety',ename='$ename',production='$production',stime='$sdate',etime='$edate',completedby='$doneby',status1='Done',description='$description',preplace='replace' ,serviceimg='$serviceimg',supdoc='$supdoc',nextdate='$ndate' WHERE id='$sno'";


	$sq = mysqli_query($con, $sql);

	$sq1 = mysqli_query($con, "INSERT INTO tblequipment1 (eid,date) VALUES ('$eid','$ndate')");
?>
	<script language="javascript">
		window.open('admin.php?id=ppm3&sno=<?php echo $sno; ?>', '_self');
	</script>
<?php
}
?>
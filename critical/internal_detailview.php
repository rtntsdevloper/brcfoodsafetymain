<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Critical Issue Non Conformance</a></li>
			<li>Internal Nc Detail</li>
		</ul>
	</div>
	<?php
	include 'connection_psd.php';
	$sno = $_GET['sno'];

	$query = mysqli_query($pcon, "SELECT * FROM `criticalissues` WHERE id='$sno'");
	$row = mysqli_fetch_array($query);

	$queryr = mysqli_query($pcon, "select * from rootcause where sno='$sno' ORDER BY id DESC");
	$row1 = mysqli_fetch_array($queryr);
	$count = mysqli_num_rows($queryr);
	?>

	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=internal_complaintmgmt1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

					<h4 class="card-title mb-3">Critical Issue Non Conformance Detail</h4>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-profile-1 mb-8">
								<div class="table-responsive">
									<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

										<tr>
											<th>Date of Non Conformance : <?php echo date('d-m-Y', strtotime($row['date'])); ?> </th>
										</tr>
										<tr>
											<th>Raised By: <?php echo $row['raised']; ?> </th>
										</tr>
										<tr>
											<th>Site Visit: <?php echo $row['sitevisit']; ?> </th>
										</tr>

										<tr>
											<th>Description of NC: <?php echo $row['description']; ?> </th>
										</tr>

										<!-- SUPPORTING DOCUMENTS -->
										<tr>
											<td>
												<?php
												$supdoc_data = $row['supdoc'];
												$supdoc_array = explode(';', $supdoc_data);

												if (!empty($supdoc_array)) {
													echo '<h5 style="color:#993300; margin-top:10px;">Supporting Documents:</h5>';
													echo '<ul style="list-style-type: none; padding-left: 0;">';

													$doc_count = 1;
													foreach ($supdoc_array as $doc) {
														if (!empty($doc)) {
															echo '<li style="padding: 5px 0;">';
															echo '<strong>' . $doc_count . '.</strong> ';
															echo '<a href="https://www.psdteams.com/newpsd/admin/critical/upl1/' . htmlspecialchars($doc) . '" target="_blank">';
															echo htmlspecialchars($doc);
															echo '</a>';
															echo '</li>';
															$doc_count++;
														}
													}
													echo '</ul>';
												} else {
													echo '<p>No supporting documents available</p>';
												}
												?>
											</td>
										</tr>

										<?php
										// SHOW INVESTIGATION DATA IF EXISTS
										if ($count > 0) {
										?>
											<tr>
												<td colspan="2">
													<h5 style="color:#993300">Investigation:</h5>
												</td>
											</tr>

											<tr>
												<th colspan="2">Root cause analysis:</th>
											</tr>
											<tr>
												<th style="width:30%;">Why 1:</th>
												<td style="width:70%;"><?php echo $row1['why1']; ?></td>
											</tr>
											<tr>
												<th>Why 2:</th>
												<td><?php echo $row1['why2']; ?></td>
											</tr>
											<tr>
												<th>Why 3:</th>
												<td><?php echo $row1['why3']; ?></td>
											</tr>
											<tr>
												<th>Why 4:</th>
												<td><?php echo $row1['why4']; ?></td>
											</tr>
											<tr>
												<th>Why 5:</th>
												<td><?php echo $row1['why5']; ?></td>
											</tr>
											<tr>
												<th>Corrective action:</th>
												<td><?php echo $row1['comment']; ?></td>
											</tr>
											<tr>
												<th>Preventive action:</th>
												<td><?php echo $row1['preventive']; ?></td>
											</tr>

											<tr>
												<th style="vertical-align:top;">Documents:</th>
												<td>
													<?php
													$supdoc_data1 = $row1['supdoc'];
													$supdoc_array1 = explode(';', $supdoc_data1);
													$supdoc_array1 = array_filter(array_map('trim', $supdoc_array1));

													if (!empty($supdoc_array1)) {
														echo '<h5 style="color:#993300; margin-top:10px;">Investigation Documents:</h5>';
														echo '<ul style="list-style-type: none; padding-left: 0; margin:0;">';
														$doc_count1 = 1;
														foreach ($supdoc_array1 as $doc) {
															if (!empty($doc)) {
																echo '<li style="padding: 5px 0;">';
																echo '<strong>' . $doc_count1 . '.</strong> ';
																echo '<a href="critical/upl1/' . htmlspecialchars($doc) . '" target="_blank">' . htmlspecialchars($doc) . '</a>';
																echo '</li>';
																$doc_count1++;
															}
														}
														echo '</ul>';
													} else {
														echo 'No documents available';
													}
													?>
												</td>
											</tr>

											<!-- SHOW STATUS -->
											<?php if ($row['status1'] == 'accepted') { ?>
												<tr>
													<th style="width:30%;">Status</th>
													<td style="color:#28a745; font-weight:bold;"><?php echo $row['status1']; ?></td>
												</tr>
												<tr>
													<th>Verified By</th>
													<td><?php echo $row['verified_by']; ?></td>
												</tr>
												<tr>
													<th>Verified Date</th>
													<td><?php echo date('d-m-Y h:i a', strtotime($row['verified_date'])); ?></td>
												</tr>
											<?php } elseif ($row['status1'] == 'rejected') { ?>
												<tr>
													<th style="width:30%;">Status</th>
													<td style="color:#dc3545; font-weight:bold;"><?php echo $row['status1']; ?></td>
												</tr>
												<tr>
													<th>Rejected By</th>
													<td><?php echo $row['rejected_by']; ?></td>
												</tr>
												<tr>
													<th>Rejected Date</th>
													<td><?php echo date('d-m-Y h:i a', strtotime($row['rejected_date'])); ?></td>
												</tr>
												<tr>
													<th>Rejection Comment</th>
													<td><?php echo $row['reject']; ?></td>
												</tr>
											<?php } ?>

										<?php
										} 
										
										if($row['status'] == 'open') {
										?>
											<!-- SHOW OPEN FORM -->
											<tr>
												<td colspan="2">
													<h5 style="color:#993300">Investigation:</h5>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<form name="form2" action="" method="post" enctype="multipart/form-data">
														<input type="hidden" name="sno" value="<?php echo $sno; ?>" />

														<strong>Root cause analysis :</strong><br>
														Why 1 : <textarea class="form-control" name="why1" required></textarea><br>
														Why 2: <textarea class="form-control" name="why2" required></textarea><br>
														why 3 : <textarea class="form-control" name="why3"></textarea><br>
														why 4: <textarea class="form-control" name="why4"></textarea><br>
														why 5 : <textarea class="form-control" name="why5"></textarea><br>

														<strong>Corrective action:</strong><br>
														<textarea class="form-control" name="corrective" required></textarea><br>
														
														<strong>Preventive action:</strong><br>
														<textarea class="form-control" name="prevent" required></textarea><br>
														
														<strong>Photo if any:</strong><br>
														<input type="file" class="file-input form-control" name="file[]" accept=".jpg,.jpeg,.png,.gif,.pdf" multiple />
														<div id="uploaded-files-list" class="mt-2"></div><br>

														<input type="submit" class="btn btn-danger" name="submit" />
													</form>
												</td>
											</tr>
										<?php
										}
										?>

									</table>
								</div>
							</div>
						</div>

					</div>

					<?php
					// HANDLE FORM SUBMISSION
					if (isset($_POST['submit'])) {
						$date = date('Y-m-d');
						$sno = $_POST['sno'];

						$why1 = $_POST['why1'];
						$why2 = $_POST['why2'];
						$why3 = $_POST['why3'];
						$why4 = $_POST['why4'];
						$why5 = $_POST['why5'];
						$corrective = $_POST['corrective'];
						$prevent = $_POST['prevent'];

						$uploaded_files = [];
						$uploadDir = 'critical/upl1/';

						if (!empty($_FILES['file']['name'][0])) {
							$totalFiles = count($_FILES['file']['name']);

							for ($i = 0; $i < $totalFiles; $i++) {
								if (empty($_FILES['file']['name'][$i])) {
									continue;
								}

								$file_name = $_FILES['file']['name'][$i];
								$file_tmp = $_FILES['file']['tmp_name'][$i];
								$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
								$unique_file = "CIN-" . uniqid() . "." . $file_ext;

								move_uploaded_file($file_tmp, $uploadDir . $unique_file);
								$uploaded_files[] = $unique_file;
							}
						}

						$uploaded_files_str = !empty($uploaded_files) ? implode(';', $uploaded_files) : '';

						$ft = mysqli_query($pcon, "INSERT INTO rootcause(sno, comment, preventive, supdoc, status, date, user, why1, why2, why3, why4, why5) 
						VALUES ('$sno', '$corrective', '$prevent', '$uploaded_files_str', 'Done', '$date', '$user', '$why1', '$why2', '$why3', '$why4', '$why5')");

						$jk = mysqli_query($pcon, "UPDATE criticalissues SET status='Waiting for the approval' WHERE id='$sno'");

					?>
						<script language="javascript">
							window.open('admin.php?id=internal_complaintmgmt1', '_self');
						</script>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		let uploadedFiles = [];
		let fileIdCounter = 0;

		$('.file-input').on('change', function() {
			const files = this.files;
			if (files.length > 0) {
				for (let i = 0; i < files.length; i++) {
					const file = files[i];
					const fileId = ++fileIdCounter;

					const fileEntry = {
						id: fileId,
						name: file.name,
						file: file
					};
					uploadedFiles.push(fileEntry);
				}

				updateFileList();
				this.value = '';
			}
		});

		window.removeFile = function(id) {
			if (confirm('Are you sure you want to remove this file?')) {
				uploadedFiles = uploadedFiles.filter(function(file) {
					return file.id !== id;
				});
				updateFileList();
			}
		};

		window.viewFile = function(id) {
			const file = uploadedFiles.find(function(f) {
				return f.id === id;
			});
			if (file) {
				const fileURL = URL.createObjectURL(file.file);
				window.open(fileURL, '_blank');
				setTimeout(function() {
					URL.revokeObjectURL(fileURL);
				}, 10000);
			}
		};

		function updateFileList() {
			let html = '';
			if (uploadedFiles.length === 0) {
				html = '<small class="text-muted">No files selected</small>';
			} else {
				html = '<strong>Selected Files (' + uploadedFiles.length + '):</strong><br>';
				uploadedFiles.forEach(function(file) {
					html += '<span style="display:inline-block;background:#f8f9fa;padding:3px 8px;margin:3px;border-radius:3px;border:1px solid #dee2e6;font-size:13px;">';
					html += file.name;
					html += ' <button type="button" class="btn btn-sm btn-info" style="padding:0px 5px;font-size:11px;" onclick="viewFile(' + file.id + ')">View</button>';
					html += ' <button type="button" class="btn btn-sm btn-danger" style="padding:0px 5px;font-size:11px;" onclick="removeFile(' + file.id + ')">Remove</button>';
					html += '</span>';
				});
			}
			$('#uploaded-files-list').html(html);
		}

		$('form[name="form2"]').on('submit', function(e) {
			if (uploadedFiles.length > 0) {
				const dataTransfer = new DataTransfer();
				uploadedFiles.forEach(function(fileEntry) {
					dataTransfer.items.add(fileEntry.file);
				});
				const fileInput = document.querySelector('.file-input');
				fileInput.files = dataTransfer.files;
			}
		});
	});
</script>
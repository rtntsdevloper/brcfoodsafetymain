<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css" />
<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css" />

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Supplier Monitoring</a></li>
			<li>Supplier Nc Detail</li>
		</ul>
	</div>
	<?php
	$sno = $_GET['sno'];
	$query = mysqli_query($con, "select * from tblsuppliercomplaint where id='$sno'");
	$row = mysqli_fetch_array($query);
	?>




	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=manage-complaint"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

					<h4 class="card-title mb-3">Supplier Nc Detail</h4>


					<div class="row">

						<div class="col-md-12">
							<div class="card card-profile-1 mb-8">
								<div class="table-responsive">
									<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">


										<tr>
											<th>Supplier Name : <?php echo $row['supplier']; ?> </th>
										</tr>
										<tr>
											<th>Supplier Type: <?php echo $row['suptype']; ?> </th>
										</tr>
										<?php
										if ($row['suptype']  == 'Raw Material Supplier' || $row['suptype'] == 'Primary Packaging Supplier') {
										?>
											<tr>
												<th>Is the NC raised is related to any raw material/ primary packaging supplied? : <?php echo $row['ucheck']; ?> </th>

											</tr>
											<?php
											if ($row['ucheck'] == 'Yes') {
											?>
												<tr>
													<th>Raw Material : <?php echo $row['ucmnt']; ?> </th>


												</tr>
											<?php
											}

											?>



										<?php

										}
										?>



										<tr>
											<td>

												<img src="docs/complaint/<?php echo $row['img']; ?>" width="100" />
											</td>
										</tr>


										</tr>
										<?php
										if ($row['status'] == "Done") {

											$queryr = mysqli_query($con, "select * from tblsuppliercomplaint1 where sno='$sno'");
											$row1 = mysqli_fetch_array($queryr);
										?>

											<tr>
												<th>Investigation Detail: <?php echo $row1['invest']; ?> </th>

											</tr>
											<tr>
												<th>Root cause analysis:</th>
											</tr>
											<tr>
												<th>Why 1: <?php echo $row1['rootcause']; ?> </th>
											</tr>
											<tr>
												<th>Why 2: <?php echo $row1['why2']; ?> </th>
											</tr>
											<tr>
												<th>Why 3: <?php echo $row1['why3']; ?> </th>
											</tr>
											<tr>
												<th>Why 4: <?php echo $row1['why4']; ?> </th>
											</tr>
											<tr>
												<th>Why 5: <?php echo $row1['why5']; ?> </th>
											</tr>
											<tr>
												<th>Corrective action: <?php echo $row1['corrective']; ?> </th>
											</tr>
											<tr>
												<th>Preventive action: <?php echo $row1['preventive']; ?> </th>
											</tr>
											<tr>
												<th> <?php 
												
												?><img src="docs/complaint/<?php echo $row1['img']; ?>" width="100" /> </th>
											</tr>

										<?php
										} else if ($row['status'] == "waiting") {
										?>




											<form name="form2" action="" method="post" class="pt-3" enctype="multipart/form-data">
												<input type="hidden" name="sno" value="<?php echo $sno; ?>" />
												<tr>
													<td>
														<h5 style="color:#993300">Investigation:</h5>
													</td>
												</tr>



												<tr>
													<td>Investigation Detail : <textarea class="form-control" name="investigate" required></textarea></td>
												</tr>
												<tr>
													<th>Root cause analysis :</th>
												</tr>
												<tr>
													<td>Why 1 : <textarea class="form-control" name="rootcause" required></textarea></td>
												</tr>
												<tr>
													<td>Why 2: <textarea class="form-control" name="why2" required></textarea></td>
												</tr>
												<tr>
													<td>why 3 : <textarea class="form-control" name="why3"></textarea></td>
												</tr>
												<tr>
													<td>why 4: <textarea class="form-control" name="why4"></textarea></td>
												</tr>
												<tr>
													<td>why 5 : <textarea class="form-control" name="why5"></textarea></td>
												</tr>


												<tr>
													<td>Corrective action: <textarea class="form-control" name="corrective" required></textarea></td>
												</tr>
												<tr>
													<td>Preventive action: <textarea class="form-control" name="prevent" required></textarea></td>
												</tr>
												<tr>
													<td>Photo if any: <input type="file" class="form-control" name="file" /></td>
												</tr>


												<tr>
													<td><input type="submit" class="btn btn-danger" name="submit" /></td>
												</tr>

											</form>
										<?php
										}

										?>


									</table>
								</div>
							</div>
						</div>


					</div>

					<?php
					if (isset($_POST['submit'])) {
						$date = date('Y-m-d');
						$sno = $_POST['sno'];
						$product = '';
						$code = '';
						$rootcause = $_POST['rootcause'];
						$corrective = $_POST['corrective'];
						$prevent = $_POST['prevent'];
						$invest = $_POST['investigate'];
						$file = $_FILES['file']['name'];
						move_uploaded_file($_FILES['file']['tmp_name'], 'docs/complaint/' . $file);

						$why2 = $_POST['why2'];
						$why3 = $_POST['why3'];
						$why2 = $_POST['why4'];
						$why3 = $_POST['why5'];



						$ft = mysqli_query($con, "INSERT INTO tblsuppliercomplaint1(sno, pname, pcode, rootcause, corrective, preventive, img, status, date, user,invest,why2,why3,why4,why5)
						VALUES ('$sno', '$product', '$code', '$rootcause', '$corrective', '$prevent', '$file', 'Done', '$date', '$user','$invest','$why2','$why3','$why4','$why5')");
						$jk = mysqli_query($con, "update tblsuppliercomplaint set status='Done' where id='$sno'");

					?>
						<script language="javascript">
							// window.open('admin.php?id=manage-complaint', '_self');
						</script>
					<?php
					}
					?>



				</div>
			</div>
		</div>
	</div>
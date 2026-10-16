     <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard.min.css" />
     <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css" />
     <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css" />
     <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css" />

     <div class="main-content">
     	<div class="breadcrumb">
     		<h1 class="mr-2"><?php echo $headingname; ?></h1>
     		<ul>
     			<li><a href="">Audit Management</a></li>
     			<li>View Detail</li>
     		</ul>
     	</div>
     	<?php
			$sno = $_GET['sno'];
			$query = mysqli_query($con, "select * from saveaudit where id='$sno'");
			$query1 = mysqli_fetch_array($query);
			$rid = $_GET['sno1'];
			$fidd = $_GET['fid'];




			$rows = mysqli_query($con, "select t1.* , t2.* , t3.*  from addtest1  t1, subtest1  t2, tblroster  t3  where  t3.id='$rid' and t1.testid=t3.tid and t2.sid=t3.sid and t2.tid=t3.tid and t2.fid='$fidd' and t2.cid='$query1[ques]'");
			$row = mysqli_fetch_array($rows);




			if ($row['ssid'] != "") {
				$fid = $row['ssid'];
			} else {
				$fid = $row['fid'];
			}


			?>

     	<?php
			$sh = mysqli_query($con, "select * from tblauditor where id='$row[auditor]'");
			$hj = mysqli_fetch_array($sh);
			?>

     	<?php
			$sh13 = mysqli_query($con, "select * from tblauditee where id='$row[auditee]'");
			$hj13 = mysqli_fetch_array($sh13);
			?>



     	<div class="row mb-12">
     		<div class="col-md-12 mb-12">
     			<div class="card text-left">
     				<div class="card-body">

     					<a href="admin.php?id=ncview&sno=<?php echo $_GET['sno1']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

     					<h4 class="card-title mb-3">View Detail</h4>


     					<div class="row">
     						<div class="col-md-3">
     							<div class="card card-profile-1 mb-4">
     								<div class="card-body text-center">
     									<div><img src="auditordoc/<?php echo $hj['userimg']; ?>" alt="" width="70" /></div>

     									<button class="btn btn-primary btn-rounded"> Auditor: <?php echo $hj['name']; ?></button>
     									<p class="mt-0">Contact: <?php echo $hj['contact']; ?></p>
     									<p>Email: <?php echo $hj['email']; ?></p>

     								</div>
     							</div>

     							<div class="card card-profile-1 mb-4">
     								<div class="card-body text-center">
     									<div>
     										<img src="auditordoc/<?php echo $hj13['img']; ?>" alt="" width="70" />
     									</div>

     									<button class="btn btn-primary btn-rounded"> Auditee: <?php echo $hj13['name']; ?></button>
     									<p class="mt-0">Contact: <?php echo $hj13['contact']; ?></p>
     									<p>Email: <?php echo $hj13['email']; ?></p>



     								</div>
     							</div>
     						</div>

     						<?php
								$sh4 = mysqli_query($con, "select * from saveaudit where id='$rid'");
								$hj4 = mysqli_fetch_array($sh4);
								$mch = mysqli_num_rows($sh4);
								if ($mch <= 0) {
								} else {
								?>

     							<div class="col-md-8">
     								<div class="card card-profile-1 mb-8">
     									<div class="table-responsive">
     										<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
     											<tr>
     												<th><?php echo $row['tid']; ?>. &nbsp;<?php echo $row['subject']; ?> </th>
     											</tr>
     											<tr>
     												<th><?php echo $fid; ?>. &nbsp;<?php echo $row['clause']; ?> </th>
     											</tr>
     											<tr>
     												<td>Audit date: <?php echo date("d-m-Y", strtotime($row['auditdate'])); ?> </td>
     											</tr>


     											<?php
													if ($hj4['deliver'] != "0000-00-00") {
													?>

     												<tr>
     													<td>Completion date agreed: <?php echo date("d-m-Y", strtotime($hj4['deliver'])); ?> </td>
     												</tr>
     											<?php
													}
													?>
     											<tr>
     												<td>Comment: <?php echo $hj4['title']; ?> </td>
     											</tr>
     											<tr>
     												<td>Action Required: <?php echo $hj4['action']; ?> </td>
     											</tr>

     											<?php
													if ($hj4['document'] != "") {
													?>
     												<tr>
     													<td>Document: &nbsp;
     														<?php
																$string = $hj4['document'];
																$tags1 = explode(';', $string);
																$i = 0;
																foreach ($tags1 as $key1) {
																	$i++;
																	$info5 = new SplFileInfo($key1);
																	$tpe5 = $info5->getExtension();
																	if ($tpe5 != "") {
																?>
     																<a href="documents/<?php echo $key1; ?>" target="_blank" style="color:#0033FF"><?php echo $key1; ?></a>

     																<br />
     														<?php
																	}
																}
																?>

     													</td>
     												</tr>
     											<?php
													}
													?>



     											<?php
													$sh44 = mysqli_query($con, "select * from tblaction where sno='$sno'");
													$mch = mysqli_num_rows($sh44);
													if ($mch >= 1) {
													?>
     												<tr>
     													<td>
     														<h5 style="color:#993300">Auditee Response:</h5>
     													</td>
     												</tr>
     											<?php
													}
													?>
     											<?php
													$rts = mysqli_query($con, "select * from tblrootcause where sno='$sno'");
													$mb = mysqli_num_rows($rts);
													if ($mb >= 1) {
														while ($rts1 = mysqli_fetch_array($rts)) {
													?>
     													<tr>
     														<td>
     															<h5 style="color:#993300">Root Cause Analysis :</h5>
     														</td>
     													</tr>

     													<tr>
     														<td>
     															<h5 style="color:#993300">Question 1 why? : </h5><?php echo $rts1['root1']; ?>
     														</td>
     													</tr>
     													<tr>
     														<td>
     															<h5 style="color:#993300">Question 2 why? : </h5> <?php echo $rts1['root2']; ?>
     														</td>
     													</tr>
     													<tr>
     														<td>
     															<h5 style="color:#993300">Question 3 why? : </h5> <?php echo $rts1['root3']; ?>
     														</td>
     													</tr>
     													<tr>
     														<td>
     															<h5 style="color:#993300">Question 4 why?: </h5> <?php echo $rts1['root4']; ?>
     														</td>
     													</tr>
     													<tr>
     														<td>
     															<h5 style="color:#993300">Question 5 why?: </h5><?php echo $rts1['root5']; ?>
     														</td>
     													</tr>
     											<?php
														}
													}
													?>


     											<?php
													$sh6 = mysqli_query($con, "select * from tblaction where sno='$sno'");

													while ($hj6 = mysqli_fetch_array($sh6)) {
													?>




     												<?php
														if ($hj6['comment'] != "") {
														?>
     													<tr>
     														<td>Auditee Comment: <?php echo $hj6['comment']; ?></td>
     													</tr>
     												<?php
														}
														?>
     												<?php
														if ($hj6['corrective'] != "") {
														?>
     													<tr>
     														<td>Corrective Action: <?php echo $hj6['corrective']; ?></td>
     													</tr>
     												<?php
														}
														?>
     												<?php
														if ($hj6['preventive'] != "") {
														?>
     													<tr>
     														<td>Preventive Action: <?php echo $hj6['preventive']; ?></td>
     													</tr>
     												<?php
														}
														?>

     												<?php
														if ($hj6['img'] != "") {
														?>
     													<tr>
     														<td>Document: <a href="rootcause/<?php echo $hj6['img']; ?>" style="color:#0000FF" target="_blank"><?php echo $hj6['img']; ?></a></td>
     													</tr>
     												<?php
														}
														?>

     												<tr>
     													<td>
     														<h5 style="color:#993300">Auditor Response:</h5>
     													</td>
     												</tr>

     												<tr>
     													<td>Status: <?php echo $hj6['ans']; ?></td>
     												</tr>

     												<tr>
     													<td>Auditor Comment: <?php echo $hj6['cmnt']; ?></td>
     												</tr>


     											<?php
													}
													?>

     											<?php
													if ($hj4['status'] == "closedoff" && $access == "Auditor") {
													?>
     												<tr>
     													<td>
     														<h5>Take Action:</h5>
     													</td>
     												</tr>

     												<?php
														$sh6 = mysqli_query($con, "select * from tblaction where sno='$sno'");
														while ($hj6 = mysqli_fetch_array($sh6)) {
														?>

     												<?php
														}
														?>
     												<form name="form2" action="" method="post" class="pt-3" enctype="multipart/form-data">

     													<tr>
     														<td>Accepted: <input type="radio" name="r1" value="Accepted"> Rejected: <input type="radio" name="r1" value="Rejected"></td>
     													</tr>
     													<tr>
     														<td>Comment: <textarea class="form-control" name="rt1" required></textarea></td>
     													</tr>
     													<tr>
     														<td><button type="submit" class="btn btn-info" name="submit2">Submit</button></td>
     													</tr>
     												</form>
     											<?php
													}
													?>

     											<?php
													if ($hj4['status'] == "Rejected" && $access == "Auditee") {
													?>
     												<form name="form3" action="" method="post" class="pt-3" enctype="multipart/form-data">

     													<tr>
     														<td>Comment: <textarea class="form-control" name="rt" required></textarea></td>
     													</tr>
     													<tr>
     														<td>Upload Document: <input type="file" class="form-control" name="img1"></td>
     													</tr>
     													<tr>
     														<td><button type="submit" class="btn btn-info" name="submit3">Submit</button></td>
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

									$rtss = mysqli_query($con, "select * from tblrootcause where sno='$sno' order by id desc limit 1");
									$rtss1 = mysqli_fetch_array($rtss);

							?>

     					<?php

									$rtsw = mysqli_query($con, "select * from tblaction where sno='$sno' order by id asc limit 1");
									$rtsw1 = mysqli_fetch_array($rtsw);

							?>

     					<?php
									if ($hj4['status'] == "waiting" && $access == "Auditee") {
							?>

     						<!-- ============ Body content start ============= -->

     						<div class="breadcrumb">
     							<h1>Root Cause Analysis</h1>
     							<ul>

     								<li>| Give your response</li>
     							</ul>
     						</div>



     						<form name="form1" action="" method="post" class="pt-3" enctype="multipart/form-data">

     							<div class="row">
     								<div class="col-md-12">
     									<!--  SmartWizard html -->
     									<div id="smartwizard">
     										<ul>
     											<li><a href="#step-1">Step 1<br /><small>Question 1 why?</small></a></li>
     											<li><a href="#step-2">Step 2<br /><small>Question 2 why?</small></a></li>
     											<li><a href="#step-3">Step 3<br /><small>Question 3 why?</small></a></li>
     											<li><a href="#step-4">Step 4<br /><small>Question 4 why?</small></a></li>
     											<li><a href="#step-5">Step 5<br /><small>Question 5 why?</small></a></li>
     											<li><a href="#step-6">Concluded<br /><small></small></a></li>
     										</ul>
     										<div>

     											<div id="step-1">
     												<h3 class="border-bottom border-gray pb-2">
     													<textarea class="form-control" name="root1" placeholder="Explain Why?" required></textarea>
     											</div>
     											<div id="step-2">

     												<div><textarea class="form-control" name="root2" placeholder="Explain Why?" required></textarea></div>
     											</div>
     											<div id="step-3">
     												<textarea class="form-control" name="root3" placeholder="Explain Why?"></textarea>
     											</div>
     											<div id="step-4">
     												<textarea class="form-control" name="root4" placeholder="Explain Why?"></textarea>

     											</div>

     											<div id="step-5">
     												<textarea class="form-control" name="root5" placeholder="Explain Why?"></textarea>

     											</div>


     											<div id="step-6">
     												<h5> Corrective Action</h5>
     												<textarea class="form-control" name="corrective" required></textarea>
     												<br />
     												<h5> Preventive Action</h5>
     												<textarea class="form-control" name="preventive" required></textarea>

     												<br />
     												<h5>Upload Document: <a href="rootcause/<?php echo $rtsw1['img']; ?>" target="_blank"><?php echo $rtsw1['img']; ?></a></h5>
     												<input type="hidden" class="form-control" name="imgg" value="<?php echo $rtsw1['img']; ?>">

     												<input type="file" class="form-control" name="img">

     											</div>
     										</div>
     									</div>

     						</form>
     						<script language="javascript">
     							"use strict";

     							$(document).ready(function() {
     								// Step show event
     								$("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
     									$("#Button").addClass('disabled');
     									$("#Button1").addClass('disabled');


     									if (stepNumber > "5") {
     										$("#Button").removeClass('disabled');
     										$("#Button1").removeClass('disabled');
     									}

     									if (stepPosition === 'first') {

     										$("#prev-btn").addClass('disabled');
     									} else if (stepPosition === 'final') {
     										$("#Button").removeClass('disabled');
     										$("#Button1").removeClass('disabled');

     										$("#next-btn").addClass('disabled');
     									} else {

     										$("#prev-btn").removeClass('disabled');
     										$("#next-btn").removeClass('disabled');
     									}
     								}); // Toolbar extra buttons

     								var btnFinish = $('<button type="button" name="dS" id="Button"  ></button>').text('Concluded').addClass('btn btn-info').on('click', function() {
     									window.open('#step-6', '_self');
     								});
     								var btnCancel = $('<button type="submit" name="submit" id="Button1"></button>').text('Submit').addClass('btn btn-danger').on('click', function() {
     									// $('#smartwizard').smartWizard("reset");
     								}); // Smart Wizard

     								$('#smartwizard').smartWizard({
     									selected: 0,
     									theme: 'default',
     									transitionEffect: 'fade',
     									showStepURLhash: true,
     									toolbarSettings: {

     										toolbarButtonPosition: 'end',
     										toolbarExtraButtons: [btnFinish, btnCancel]
     									}
     								}); // External Button Events

     								$("#reset-btn").on("click", function() {
     									// Reset wizard
     									$('#smartwizard').smartWizard("reset");
     									return true;
     								});
     								$("#prev-btn").on("click", function() {
     									// Navigate previous
     									$('#smartwizard').smartWizard("prev");
     									return true;
     								});
     								$("#next-btn").on("click", function() {
     									// Navigate next
     									$('#smartwizard').smartWizard("next");
     									return true;
     								});
     								$("#theme_selector").on("change", function() {
     									// Change theme
     									$('#smartwizard').smartWizard("theme", $(this).val());
     									return true;
     								}); // Set selected theme on page refresh

     								$("#theme_selector").change();
     							});
     						</script>
     					<?php
									}
							?>


     				</div>
     			</div>
     		</div>
     	</div>



     	<?php
									if (isset($_POST['submit'])) {
										$user = $_SESSION['user'];
										$sn = $_GET['sno'];
										$rt = mysqli_real_escape_string($con, $_POST['rt']);
										$corrective = mysqli_real_escape_string($con, $_POST['corrective']);
										$preventive = mysqli_real_escape_string($con, $_POST['preventive']);

										$root1 = mysqli_real_escape_string($con, $_POST['root1']);
										$root2 = mysqli_real_escape_string($con, $_POST['root2']);
										$root3 = mysqli_real_escape_string($con, $_POST['root3']);
										$root4 = mysqli_real_escape_string($con, $_POST['root4']);
										$root5 = mysqli_real_escape_string($con, $_POST['root5']);
										$imgg = $_POST['imgg'];


										if ($_FILES['img']['name'] == "") {
											$img = $_FILES['img']['name'];
										} else {
											$img = $sn . $_FILES['img']['name'];
											move_uploaded_file($_FILES['img']['tmp_name'], 'rootcause/' . $img);
										}


										$date = date("Y-m-d");




										$ghjkl = mysqli_query($con, "insert into tblaction (sno,comment,date,user,img,corrective,preventive)values('$sn','$rt','$date','$user','$img','$corrective','$preventive')");

										$ghjkl4 = mysqli_query($con, "insert into tblrootcause (sno,root1,root2,root3,root4,root5)values('$sn','$root1','$root2','$root3','$root4','$root5')");


										// $jk=mysqli_query($con,"update saveaudit set status='closedoff' where id='$sn'");
										//$jk1=mysqli_query($con,"update tblroster set status1='closedoff' where sno='$_GET[sno1]'");

										$sd = mysqli_query($con, "select * from tblrootcause where sno='$sn' order by id desc limit 1");
										$sd1 = mysqli_fetch_array($sd);
										$snid = $sd1['id'];


										$sdd = mysqli_query($con, "select * from tblaction where sno='$sn' order by id desc limit 1");
										$sdd1 = mysqli_fetch_array($sdd);
										$snid1 = $sdd1['id'];

			?>
     		<script language="javascript">
     			window.open('admin.php?id=ncvieww&sno=<?php echo $_GET['sno']; ?>&sno1=<?php echo $_GET['sno1']; ?>&snid=<?php echo $snid; ?>&snid1=<?php echo $snid1; ?>', '_self');
     		</script>
     	<?php
									}
			?>

     	<?php
									if (isset($_POST['submit3'])) {
										$user = $_SESSION['user'];
										$sn = $_GET['sno'];
										$rt = mysqli_real_escape_string($con, $_POST['rt']);



										if ($_FILES['img1']['name'] == "") {
											$img1 = $_POST['imgg'];
										} else {
											$img1 = $sn . $_FILES['img1']['name'];
											move_uploaded_file($_FILES['img1']['tmp_name'], 'rootcause/' . $img1);
										}

										$date = date("Y-m-d");

										$ghjkl = mysqli_query($con, "insert into tblaction (sno,comment,date,user,img)values('$sn','$rt','$date','$user','$img1')");
										$sd = mysqli_query($con, "select * from tblaction where sno='$sn' order by id desc limit 1");
										$sd1 = mysqli_fetch_array($sd);
										$snid1 = $sd1['id'];



			?>
     		<script language="javascript">
     			window.open('admin.php?id=ncvieww&sno=<?php echo $_GET['sno']; ?>&sno1=<?php echo $_GET['sno1']; ?>&snid1=<?php echo $snid1; ?>', '_self');
     		</script>
     	<?php
									}
			?>


     	<?php
									if (isset($_POST['submit2'])) {
										$user = $_SESSION['user'];

										$sn = $_GET['sno'];
										$r1 = $_POST['r1'];
										$rt1 = mysqli_real_escape_string($con, $_POST['rt1']);
										$date = date("Y-m-d");


										$jk = mysqli_query($con, "update saveaudit set status='$r1' where id='$sn'");

										$sd = mysqli_query($con, "select * from tblaction where sno='$sn' order by id desc limit 1");
										$sd1 = mysqli_fetch_array($sd);
										$snid1 = $sd1['id'];


										$jk1 = mysqli_query($con, "update tblaction set ans='$r1',date1='$date',cmnt='$rt1'  where id='$snid1'");

			?>
     		<script language="javascript">
     			window.open('ncviewsubmit.php?sno=<?php echo $_GET['sno']; ?>&sno1=<?php echo $_GET['sno1']; ?>&msg=2', '_self');
     		</script>
     	<?php
									}
			?>
     <?php
								}
		?>
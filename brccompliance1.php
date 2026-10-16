<?php
$sno = $_GET['sno'];
$sid = $_GET['sid'];

$hjx = mysqli_query($con, "select * from subtest where sid='$sid'");
$hjx1 = mysqli_fetch_array($hjx);

$hj = mysqli_query($con, "select * from subtest1 where sid='$sid'");
$hj1 = mysqli_fetch_array($hj);
?>
<script>
	function showHint(str, qid, tid, sid, ssid) {
		if (str.length == 0) {
			document.getElementById("txtHint" + qid).innerHTML = "";
			return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtHint" + qid).innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "savestatus.php?ans=" + str + "&tid=" + tid + "&sid=" + sid + "&ssid=" + ssid, true);
			xmlhttp.send();
		}
	}
</script>


<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Compliance</a></li>
			<li>General Compliance</li>
		</ul>
	</div>
	<div class="col-md-12">
		<div class="card text-left">
			<div class="card-body">
				<a href="admin.php?id=brccompliance" tabindex="2"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

				<h4 class="card-title mb-2">General Compliance</h4>



				<div class="row">
					<div class="row mb-4">
						<div class="col-md-12 mb-12">
							<div class="card text-left">
								<div class="container-fluid ">
									<div class="row p-3">
										
											<li class="list-group-item d-flex justify-content-between align-items-center">
												<div class="col-md-1">
													<span class="badge badge-primary badge-pill"><?php echo $hjx1['sid']; ?></span>
												</div>
												<div class="col-md-11"><?php echo $hjx1['intent']; ?></div>
											</li>
										

									</div>
								</div>

								<?php
								$fid = "";
								$sql2 = mysqli_query($con, "select * from subtest1 where sid='$sid'");
								$i = 0;
								while ($row2 = mysqli_fetch_array($sql2)) {
									$i++;
								?>
									<div class="card-body">
										<p style="color:#0066FF">

											<?php
											if ($row2['ssid'] != "") {
												$row2['ssid'];
												$fid = $row2['ssid'];
											} else {
												$row2['fid'];
												$fid = $row2['fid'];
											}

											echo $fid;
											?>

											<?php echo $row2['clause']; ?></p>
										<ul class="nav nav-tabs" id="dropdwonTab" role="tablist">
											<li class="nav-item">

												<!--------compliance---------->


											<li class="nav-item"><a class="nav-link" id="profile-basic-tab<?php echo $i; ?>" data-toggle="tab" href="#profileBasic<?php echo $i; ?>" role="tab" aria-controls="profileBasic<?php echo $i; ?>" aria-selected="false" tabindex="3">Interpretation</a></li>






											<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" tabindex="4">
													Detail
												</a>

												<div class="dropdown-menu">
													<?php
													$sql = mysqli_query($con, "select * from tblcat");
													while ($rowl = mysqli_fetch_array($sql)) {
													?>
														<a class="dropdown-item " id="dropdown<?php echo $rowl['id']; ?>-tab" href="#dropdown<?php echo $rowl['id']; ?><?php echo $row2['id']; ?>" data-toggle="tab" aria-controls="dropdown<?php echo $rowl['id']; ?>" aria-expanded="true"><?php echo $rowl['name1']; ?></a>
													<?php
													}
													?>
												</div>
											</li>


											<!--------complinace end---------->
											<!--------original---------->

											<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
													Archive Documents
												</a>
												<div class="dropdown-menu">
													<?php
													$sql24 = mysqli_query($con, "select * from tbldetail where sid='$sid' and fid='$fid' and typee='archive'");
													while ($row24 = mysqli_fetch_array($sql24)) {
													?>
														<a class="dropdown-item " id="dropdown3-tab<?php echo $row24['id']; ?>" href="#dropdowntab<?php echo $row24['id']; ?>" data-toggle="tab" aria-controls="dropdown3<?php echo $row24['id']; ?>" aria-expanded="true"><?php echo $row24['section']; ?></a>

													<?php
													}
													?>
												</div>
											</li>

											<li class="nav-item "><a class="nav-link active" id="status-tab<?php echo $i; ?>" data-toggle="tab" href="#status<?php echo $i; ?>" role="tab"
													aria-controls="status<?php echo $i; ?>" aria-selected="false">Status</a>
											</li>

										</ul>

										<!--------original end---------->
										<div class="tab-content" id="myTabContent">

											<div class="tab-pane fade show active" id="status<?php echo $i; ?>" role="tabpanel" aria-labelledby="status-tab<?php echo $i; ?>">
												<div id="txtHint<?php echo $i; ?>"> </div>

												<div style="margin:10px">

													<?php
													$jk = mysqli_query($con, "select * from tblcmp  where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$fid' order by id desc limit 1");
													$match = mysqli_num_rows($jk);
													$jk1 = mysqli_fetch_array($jk);
													$signi = "";
													if ($match <= 0) {
														$signi = 0;
													} else {
														$signi = $jk1['status'];
													}
													?>


													<label class="radio radio-danger">
														<input type="radio" name="radio<?php echo $fid; ?>" value="0" onchange="showHint(this.value,'<?php echo $i; ?>','<?php echo $row2['tid']; ?>','<?php echo $row2['sid']; ?>','<?php echo $fid; ?>')" <?php echo ($signi == "0") ?  "checked" : "";  ?> /><span>Not Started</span><span class="checkmark"></span>
													</label>
													<label class="radio radio-warning">
														<input type="radio" name="radio<?php echo $fid; ?>" value="1" onchange="showHint(this.value,'<?php echo $i; ?>','<?php echo $row2['tid']; ?>','<?php echo $row2['sid']; ?>','<?php echo $fid; ?>')" <?php echo ($signi == "1") ?  "checked" : "";  ?> /><span>In Process</span><span class="checkmark"></span>
													</label>
													<label class="radio radio-success">
														<input type="radio" name="radio<?php echo $fid; ?>" value="2" onchange="showHint(this.value,'<?php echo $i; ?>','<?php echo $row2['tid']; ?>','<?php echo $row2['sid']; ?>','<?php echo $fid; ?>')" <?php echo ($signi == "2") ?  "checked" : "";  ?> /><span>Completed</span><span class="checkmark"></span>
													</label>
													<label class="radio radio-light">
														<input type="radio" name="radio<?php echo $fid; ?>" value="3" onchange="showHint(this.value,'<?php echo $i; ?>','<?php echo $row2['tid']; ?>','<?php echo $row2['sid']; ?>','<?php echo $fid; ?>')" <?php echo ($signi == "3") ?  "checked" : "";  ?> /><span>Not Applicable</span><span class="checkmark"></span>
													</label>
												</div>
											</div>



											<div class="tab-pane fade" id="profileBasic<?php echo $i; ?>" role="tabpanel" aria-labelledby="profile-basic-tab<?php echo $i; ?>">
												<?PHP echo  $row2['inter']; ?>
											</div>

											<!-- 	   
	details document -->

											<?php
											$sql = mysqli_query($con, "select * from tblcat");
											while ($rowl = mysqli_fetch_array($sql)) {
											?>
												<div class="tab-pane fade" id="dropdown<?php echo $rowl['id']; ?><?php echo $row2['id']; ?>" role="tabpanel" aria-labelledby="dropdown-tab" aria-expanded="true"
													style="tab-index:5">
													<div class="accordion" id="accordionExample1">

														<?php

														$sql22 = mysqli_query($con, "select * from tbldetail where sid='$sid' and fid='$fid' and typee='$rowl[name]'");
														while ($row22 = mysqli_fetch_array($sql22)) {
														?> <!-- right control icon-->


															<div class="card">
																<div class="card-header header-elements-inline">
																	<h1 class="card-title mb-0" style="font-size:14px">
																		<a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-group1<?php echo $row22['id']; ?>" aria-expanded="false">
																			<span><i class="fa fa-plus" style="color:#3366FF; font-size:14px"></i></span> <?php echo $row22['section']; ?></a>
																	</h1>
																</div>
																<div class="collapse" id="accordion-item-group1<?php echo $row22['id']; ?>" data-parent="#accordionExample1">
																	<div class="card-body">
																		<p>
																			Detail: <?php echo $row22['detail']; ?><br /><br />
																			<?php if ($row22['ver'] != "") {
																			?>
																				Version: <?php echo $row22['ver']; ?><br />
																			<?php
																			}
																			?>
																			<?php if ($row22['issuedate'] != "0000-00-00") {
																			?>
																				Issue Date: <?php echo date('d-m-Y', strtotime($row22['issuedate'])); ?><br />
																			<?php
																			}
																			?>
																			<?php if ($row22['authrisedby'] != "") {
																			?>
																				Authorised By: <?php echo $row22['authrisedby']; ?><br />

																			<?php
																			}
																			?>

																			<?php if ($row22['recertification'] != "0000-00-00") {
																			?>
																				Recertification Date: <?php echo date('d-m-Y', strtotime($row22['recertification'])); ?><br />

																			<?php
																			}
																			?>

																			<?php
																			if ($row22['img'] == "") {
																			} else {
																			?>
																				<a href="document/<?php echo $row22['img']; ?>" target="_blank" tabindex="8" style="tab-index:5"> Attached Document: <?php echo $row22['img']; ?></a>
																				<br /><br />
																			<?php
																			}
																			?>

																			<?php
																			if ($row22['linkk'] == "") {
																			} else {
																			?>
																				<a href="<?php echo $row22['linkk']; ?>" target="_blank" tabindex="8" style="tab-index:5;color:#0033FF"> Check Link: <?php echo $row22['linkk']; ?></a>
																			<?php
																			}
																			?>
																		</p>
																	</div>
																</div>
															</div>



														<?php
														}
														?>
													</div>
												</div>



												<!-- Archeiev Documents -->


												<?php
												$sql23 = mysqli_query($con, "select * from tbldetail where sid='$sid' and fid='$fid' and typee='archive'");
												while ($row23 = mysqli_fetch_array($sql23)) {
												?>

													<div class="tab-pane fade" id="dropdowntab<?php echo $row23['id']; ?>" role="tabpanel" aria-labelledby="dropdown3-tab<?php echo $row23['id']; ?>" aria-expanded="true" style="tab-index:5">
														<p>
															Name: <?php echo $row23['section']; ?><br /><br />
															Detail: <?php echo $row23['detail']; ?><br /><br />
															<?php
															if ($row23['img'] == "") {
															} else {
															?>
																<a href="document/<?php echo $row23['img']; ?>" target="_blank" tabindex="8" style="tab-index:5"> Attached Document: <?php echo $row23['img']; ?></a>
																<br /><br />
															<?php
															}
															?>

															<?php
															if ($row23['linkk'] == "") {
															} else {
															?>
																<a href="<?php echo $row23['linkk']; ?>" target="_blank" tabindex="8" style="tab-index:5;color:#0033FF">Check Link: <?php echo $row23['linkk']; ?></a>
															<?php
															}
															?>
														</p>






														<a href="unarchive.php?id=<?php echo $row23['id']; ?>"> <button class="btn btn-info">Restore</button></a>



													</div>

												<?php
												}
												?>

											<?php
											}
											?>


										</div>
									</div>



								<?php
								}
								?>





							</div>
						</div>
					</div>
				</div>
			</div>







		</div>
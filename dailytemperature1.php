<?php
$tid = $_GET['tid'];
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
		<a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success"
				style="float:right; margin-left:15px ">Go Back</button></a>
	</div> <br />
	<div class="col-md-12"></div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">

				<!-- <div class="col-md-12" style="color:#996600"><?php echo $qu2['status']; ?></div> -->
				</br>

				<form name="form1" enctype="multipart/form-data" method="post">


					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="validationTooltip01"> Select Date</label>
							<input type="date" name="date" class="form-control" required />
						</div>
						<div class="col-md-6 mb-3">
							<label for="validationTooltip01"> Select Time</label>
							<input type="time" name="etime" class="form-control" required />
						</div>
						<div class="col-md-6">
							<label for="validationTooltip01"> Enter Name</label>
							<input type="text" name="name" class="form-control" required />
						</div>
					</div>
					</br>

					</br>
					<div id="txtHint"></div>

					<?php
					$sql2 = mysqli_query($con, "select distinct section from dailychecks1 where tid='$tid'");
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
						$sql1 = mysqli_query($con, "select * from dailychecks1 where tid='$tid' and section='$th[section]'");

						while ($row1 = mysqli_fetch_array($sql1)) {



						?>
							<div class="row">
								<div class="col-md-12">
									<h5><?php echo $row1['ques']; ?></h5>
									<input type="hidden" name="ques[]" value="<?php echo $row1['ques']; ?>">
									<input type="hidden" name="section[]" value="<?php echo $row1['section']; ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<input type="number" name="inputn<?php echo $i; ?>" class="form-control" placeholder="Enter Temperature" oninput="comment(this.value,<?php echo $i; ?>,<?php echo $row1['temp']; ?>)" step="0.01" required>
								</div>
								<div class="col-md-3">
									<textarea name="corrective<?php echo $i; ?>" class="form-control" id="correct<?php echo $i; ?>" placeholder="Corrective Action" oninvalid="this.setCustomValidity('Please Enter Corrective Action Taken')" oninput="setCustomValidity('')"></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>

					<?php

							$i++;
						}
					}
					?>

					<script>
						function comment(ans, id, temp) {

							const commentr = document.getElementById("correct" + id);
							if (ans > temp) {
								commentr.setAttribute("required", "required");

							} else {
								commentr.removeAttribute("required");
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



				<?php
				include 'connection.php';
				date_default_timezone_set('Europe/London');
				if (isset($_POST['submit'])) {


					$date = $_POST['date'];
					$etime = $_POST['etime'];
					$name = $_POST['name'];
					$tid = $_GET['tid'];
					$user = $_SESSION['user'];
					$ansa = array();
					$qsa = array();
					$cmsta = array();

					$gh = mysqli_query($con, "INSERT INTO `tbldailytemp`(`edate`, `user`, `etime`, `tid`) VALUES ('$date','$user','$etime','$tid')");

					$ghj = mysqli_query($con, "select * from tbldailytemp where tid='$tid' and edate='$date'and etime='$etime' and user='$user' order by id desc limit 1");
					$ghj11 = mysqli_fetch_array($ghj);
					$cid = $ghj11['id'];



					if (!empty($_POST['ques'])) {
						for ($i = 0; $i < count($_POST['ques']); $i++) {
							$q = mysqli_real_escape_string($con, $_POST['ques'][$i]);
							$section = mysqli_real_escape_string($con, $_POST['section'][$i]);

							if (empty($_POST['inputn' . $i])) {
								$ans = ''; // Or some default action
							} else {
								$ans = $_POST['inputn' . $i];
							}

							if (empty($_POST['corrective' . $i])) {
								$cmnt = ''; // Or some default action
							} else {
								$cmnt = $_POST['corrective' . $i];
							}








							// $file = $_FILES['img' . $i]['name'];


							// if ($file != "") {
							// 	$file = $i . date('dmy') . $_FILES['img' . $i]['name'];
							// 	move_uploaded_file($_FILES["img" . $i]["tmp_name"], "upl1/" . $file);
							// }
							$file = '';

							$ghi = mysqli_query($con, "INSERT INTO `tbldailytemp2`(`cid`, `ques`, `ans`, `pic`, `cmnt`, `date`, `user`, `section`) VALUES ('$cid','$q','$ans','$file','$cmnt','$date','$user','$section')");
						}
					}

					if ($ghi) {
						echo "<script>alert('Data Inserted Successfully');window.location.href='admin.php?id=dailytempcheck&tid=$tid';</script>";
					}
				}
				?>
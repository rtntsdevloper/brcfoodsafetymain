<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2">Add Daily Raw Material Check
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
						<div class="col-md-6">
							<label for="validationTooltip01"> Select Date</label>
							<input type="date" name="date" class="form-control" required />
						</div>
						<div class="col-md-6">
							<label for="validationTooltip01"> Enter Name</label>
							<input type="text" name="name" class="form-control" required />
						</div>
					</div>
					</br>

					</br>
					<div id="txtHint"></div>
					<div class="container-fluid ">
						<h3 class="mb-3 text-primary">List of Products</h3>
						<?php
						$sql2 = mysqli_query($con, "SELECT * FROM `tbl_dailyproduct`");
						$j = 0;
						$i = 0;
						while ($sql3 = mysqli_fetch_array($sql2)) {
							$j++;
						?>




							<input type="hidden" name="pid[]" value="<?php echo $sql3['id']; ?>" />
							<input type="hidden" name="pname[]" value="<?php echo $sql3['name']; ?>" />
							<input type="hidden" name="uom[]" value="<?php echo $sql3['uom']; ?>" />
							<div class="row">
								<div class="col-md-12">
									<h3><?php echo $sql3['name']; ?></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label for="validationTooltip01">Quantity from last day</label>
									<div class="input-group mb-3">
										<input type="text" name="ldqty[]" id="" class="form-control" placeholder="Last day quantity left" value="<?= $sql3['lqnty'] ?>" readonly>
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $sql3['uom']; ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<label for="validationTooltip01">Quantity received today</label>
									<div class="input-group mb-3">
										<input type="text" name="totalqty[]" id="" class="form-control" placeholder="Today Total quantity" required>
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $sql3['uom']; ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<label for="validationTooltip01">Quantity sold today</label>
									<div class="input-group mb-3">
										<input type="text" name="usedqty[]" id="" class="form-control" placeholder="Total quantity" required>
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $sql3['uom']; ?></span>
										</div>

									</div>

								</div>
							</div>

							<div class="row mt-3 mb-3">
								<div class="col-md-4">
									<label for="validationTooltip01">Quantity wasted today</label>
									<div class="input-group mb-3">
										<input type="text" name="wastedqty[]" id="" class="form-control" placeholder="Total  quantity wasted" required>
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $sql3['uom']; ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<label for="validationTooltip01">Quantity remaining in stock</label>
									<div class="input-group mb-3">
										<input type="text" name="remainqty[]" id="" class="form-control" placeholder="Remaining quantity" required>
										<div class="input-group-prepend">
											<span class="input-group-text"><?php echo $sql3['uom']; ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<label for="validationTooltip01"> Remark if any</label>

									<textarea name="remark[]" id="" class="form-control" placeholder="Remark if any"></textarea>
								</div>
							</div>





							<div class="row" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
						<?php
							$i++;
						}
						?>
					</div>





					<div class="row">


						<div class="col-md-3">
							<div class="form-group label-floating">
								<button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
							</div>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>


<?php
if (isset($_POST['submit'])) {
	$date = $_POST['date'];
	$name = $_POST['name'];
	$cdate = date('d-m-Y');
	$atime = date('H:i:s');

	$dcode = date('Ymd') . rand(1000, 9999);


	$sqt = mysqli_query($con, "INSERT INTO `tbl_dailyrecord`(`cdate`, `stime`, `adate`, `name`, `user`, `dcode`) VALUES ('$date', '$atime', '$cdate', '$name', '$user', '$dcode')");
	$sqtid = mysqli_insert_id($con);


	$pid = $_POST['pid'];
	foreach ($pid as $key => $value) {
		$ldqty = $_POST['ldqty'][$key];
		$pname = $_POST['pname'][$key];
		$ttqty = $_POST['totalqty'][$key];
		$tuqnty = $_POST['usedqty'][$key];
		$wqnty = $_POST['wastedqty'][$key];
		$rqnty = $_POST['remainqty'][$key];
		$remark = $_POST['remark'][$key];
		$uom = $_POST['uom'][$key];

		$lqnd = mysqli_query($con, "INSERT INTO `tbl_dailyrecord1`(`mid`, `dcode`, `pid`, `pname`, `totalquantity`, `quantityleft`, `quantitysale`, `quantitywaste`, `lastqnty`,`cmnt`,`uom`) VALUES ('$sqtid','$dcode','$value','$pname','$ttqty','$rqnty','$tuqnty','$wqnty','$ldqty','$remark','$uom')");

		$productqd = mysqli_query($con, "UPDATE `tbl_dailyproduct` SET `lqnty`='$rqnty' WHERE `id`='$value'");
	}

?>
	<script language="javascript">
		window.open('admin.php?id=dailyrawview', '_self');
	</script>
<?php
}
?>
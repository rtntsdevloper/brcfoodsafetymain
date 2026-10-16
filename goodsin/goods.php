<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Goods In Management</a></li>
			<li>View Detail</li>
		</ul>
	</div>

	<script>
		function getsupplier(str) {

			if (str == "") {
				document.getElementById("p1").innerHTML = "";
				return;
			}
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("p1").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "goodsin/getproducts.php?q=" + str, true);
			xmlhttp.send();
		}
	</script>

	<script language="javascript">
		function cal() {

			var d1 = document.getElementById("d1").value;
			var d2 = document.getElementById("d2").value;
			var s1 = document.getElementById("s1").value;
			var p1 = document.getElementById("p1").value;

			if (d1 == "" && d2 == "" && s1 == "" && p1 == "") {
				document.getElementById("sd1").innerHTML = "* Please select one option from below";
			} else {
				$.post("goodsin/goodsin1", {
						d1: d1,
						d2: d2,
						s1: s1,
						p1: p1
					},
					function(data) {
						$("#basket").html(data);
					});

			}

		}
	</script>




	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<div class="row">

						<div class="col-12"><label for="cc-exp" class="control-label mb-1" id="sd1" style="color:#FF0000"></label>
						</div>
						<div class="col-3">
							<label for="cc-exp" class="control-label mb-1">Date From</label>
							<div class="input-group">

								<input type="date" name="d1" id="d1" class="form-control" />
							</div>
						</div>

						<div class="col-3">
							<label for="cc-exp" class="control-label mb-1"> Date To</label>
							<div class="input-group">

								<input type="date" name="d2" id="d2" class="form-control" />
							</div>
						</div>

						<div class="col-3">
							<label for="cc-exp" class="control-label mb-1">Select Supplier</label>
							<div class="input-group">


								<select name="s1" id="s1" class="form-control" onchange="getsupplier(this.value)">
									<option value="">Please Select</option>
									<?php
									$sql2 = mysqli_query($con, "select * from tblrawsupplier order by supname asc");
									while ($rows = mysqli_fetch_array($sql2)) {
									?>
										<option value="<?php echo $rows['supid']; ?>"> <?php echo $rows['supname']; ?></option>

									<?php
									}
									?>

								</select>
							</div>
						</div>


						<div class="col-3">
							<label for="cc-exp" class="control-label mb-1">Select Product </label>
							<div class="input-group">


								<select name="p1" id="p1" class="form-control">
									<option value="">Please Select</option>


								</select>
							</div>
						</div>




						<div class="col-2" style="margin:10px">
							<label for="cc-exp" class="control-label mb-1"></label>
							<div class="input-group">
								<button class="btn btn-info" style="float:right" onclick="return cal();">
									<li class="fa fa-list"></li> Select & Go
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

					<a href="admin.php?id=1addnewgoods2"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>




					<h4 class="card-title mb-3">Goods In</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Supplier</th>
										<th>GRN No</th>
										<th>Invoice</th>
										<th>Action</th>
										<th>Detail</th>



									</tr>
								</thead>
								<tbody>


									<?php
									$date = date('Y-m-d');
									$sql = mysqli_query($con, "select * from tblgrnno2 order by cdate desc ");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;

										$sql2 = mysqli_query($con, "select * from tblrawsupplier where supid='$row[supid]' ");
										$row2 = mysqli_fetch_array($sql2)
									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['cdate'])); ?></td>

											<td><?php echo $row2['supname']; ?></td>
											<td><?php echo $row['grnno']; ?></td>

											<td><?php echo $row['po']; ?></td>
											<td>
												<?php
												if ($row['stockin'] == 'Done') {
												?>
													<button class="btn btn-success">Stock Transferred</button>
												<?php
												} else {
												?>

													<a href="admin.php?id=stockin&sno=<?php echo $row['id']; ?>">
														<button type="button" class="btn btn-info btn-sm">Transfer to Store</button></a>

												<?php
												}

												?>

											</td>
											<td>
												<a href="admin.php?id=goodsdetail&sno=<?php echo $row['id']; ?>">
													<button type="button" class="btn btn-info btn-sm">View </button></a>

											</td>


										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>





				</div>
			</div>
		</div>
	</div>
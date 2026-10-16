<?php
$sno = $_GET['sno'];


$sql3 = mysqli_query($con, "select * from tblgrnno2 where id='$sno'");
$row3 = mysqli_fetch_array($sql3);


$sql4 = mysqli_query($con, "select * from tblgrn1 where grncode='$row3[grnno]'");
$row4 = mysqli_fetch_array($sql4);


?>



<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Goods In Management</a></li>
			<li>Goods In</li>
		</ul>
	</div>











	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script>
		function prod(str) {

			if (str == "") {
				document.getElementById("chkproduct").innerHTML = "";
				return;
			}
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("chkproduct").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "goodsin/getproductt.php?q=" + str, true);
			xmlhttp.send();
		}
	</script>

	<script>
		function prod11() {
			let x = $("#temp").val();
			let y = $("#ptemp").val();

			if (y > x) {
				document.getElementById("perror").innerHTML = "* Temperature is beyond critical limit";
				document.getElementById("ptemp").focus();
				document.getElementById("ptemp").value = "";
				document.getElementById("perror ").style.color = "red";
			} else {
				document.getElementById("perror").innerHTML = "Product Temperature";

				document.getElementById("perror").style.color = "black";
			}

		}
	</script>


	<script>
		function prod2(str) {

			var days = document.getElementById("uom1").value;
			var days1 = document.getElementById("uom2").value;


			if (str == "") {
				document.getElementById("perror1").innerHTML = "";
				return;
			}
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("perror1").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "goodsin/getproductts.php?q=" + str + "&days=" + days + "&days1=" + days1, true);
			xmlhttp.send();
		}
	</script>



	<div class="col-md-12">
		<div class="row mb-12">
			<div class="col-md-12 mb-12">
				<div class="card text-left">
					<div class="card-body">
						<a href="admin.php?id=goodsdetail&sno=<?php echo $sno; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

						<h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GRN NO : <?php echo $row3['grnno']; ?></strong></h4>

						<div class="row">

							<form name="form1" method="post" action="" enctype="multipart/form-data">
								<input type="hidden" name="grn" value="<?php echo $row3['grnno']; ?>" />
								<input type="hidden" name="supid" value="<?php echo $row3['supid']; ?>" />
								<input type="hidden" name="ptemp" value="<?php echo $row4['ptemp']; ?>" />
								<input type="hidden" name="vtemp" value="<?php echo $row4['vtemp']; ?>" />
								<div class="form-row">

									<div class="col-md-6">
										<label for="x_card_code" class="control-label mb-1">Select Product</label>
										<div class="input-group">




											<select class="form-control" id="product" onchange="prod(this.value)" required>
												<option value="">Please Select</option>
												<?php
												$sql3 = mysqli_query($con, "select * from tblrawmaterial where supid='$row3[supid]'");
												while ($rows3 = mysqli_fetch_array($sql3)) {
												?>
													<option value="<?php echo $rows3['id']; ?>"> <?php echo $rows3['pname']; ?></option>

												<?php
												}

												?>

											</select>
											<div id="des">


											</div>
										</div>
									</div>

									<div>
										<script>
											
											$(document).ready(function() {
												$("#add-row").click(function() {
													var product = $("#product").val();
													var prodname = $("#prodname").val();
													var chiller = $("#chiller").val();
													var totalbox = $("#totalbox").val();
													var qty = $("#qty").val();
													var batchcode = $("#batchcode").val();
													var ptemp = $("#ptemp").val();
													var vtemp = $("#vtemp").val();
													var killdate = $("#killdate").val();
													var useby = $("#useby").val();
													var stype = $("#stype").val();
													var uom1 = $("#uom1").val();
													var killdate1 = $("#killdate1").val();
													var temp = $("#temp").val();
													var uomm = $("#uomm").val();

													//var bb = $("#bb").val();

													if (product == "") {
														document.getElementById("error").innerHTML = "* Please select the product";
														document.getElementById("product").focus();
													} else if (chiller == "") {
														document.getElementById("error").innerHTML = "* Please select the chiller/freezer";
														document.getElementById("chiller").focus();
													} else if (totalbox == "") {
														document.getElementById("error").innerHTML = "* Please enter total box";
														document.getElementById("totalbox").focus();
													} else if (qty == "") {
														document.getElementById("error").innerHTML = "* Please enter quantity";
														document.getElementById("qty").focus();
													} else if (killdate1 != "No" && killdate == "") {
														document.getElementById("error").innerHTML = "* Please enter kill date";
														document.getElementById("killdate").focus();
													} else if (uom1 != "N/A" && stype == "") {
														document.getElementById("error").innerHTML = "* Please select useby / best before ";
														document.getElementById("stype").focus();
													} else if (uom1 != "N/A" && useby == "") {
														document.getElementById("error").innerHTML = "* Please enetr shelflife date ";
														document.getElementById("useby").focus();
													} else {



														var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='text' name='product[]' value='" + product + "'>" + prodname + "</td><td><input type='hidden' name='chiller[]' value='" + chiller + "'>" + chiller + "</td><td><input type='hidden' name='totalbox[]' value='" + totalbox + "'>" + totalbox + "</td><td><input type='hidden' name='qty[]' value='" + qty + "'>" + qty + uomm + "</td><td><input type='hidden' name='batchcode[]' value='" + batchcode + "'>" + batchcode + "</td><td><input type='hidden' name='killdate[]' value='" + killdate + "'>" + killdate + "</td><td><input type='hidden' name='stype[]' value='" + stype + "'> <input type='hidden' name='uomm[]' value='" + uomm + "'> <input type='hidden' name='useby[]' value='" + useby + "'>" + stype + ": " + useby + "</td></tr>";

														$("table tbody").append(markup);
														document.getElementById("sub").style.display = "block";
														document.getElementById("supp").disabled = false;
														document.getElementById("po").disabled = false;
														document.getElementById("product").value = "";
														document.getElementById("chiller").value = "";
														document.getElementById("totalbox").value = "";
														document.getElementById("qty").value = "";
														document.getElementById("batchcode").value = "";
														//document.getElementById("ptemp").value="";
														//document.getElementById("vtemp").value="";
														document.getElementById("killdate").value = "";
														document.getElementById("useby").value = "";
														document.getElementById("uom1").value = "";
														document.getElementById("killdate1").value = "";
														document.getElementById("temp").value = "";
														document.getElementById("uomm").value = "";
														//document.getElementById("bb").value="";




													}
												});

												// Find and remove selected table rows
												$("#delete-row").click(function() {
													$("table tbody").find('input[name="record"]').each(function() {
														if ($(this).is(":checked")) {
															$(this).parents("tr").remove();
														}
													});
												});
											});
										</script>
									</div>

									<div class="col-md-3">
										<label for="x_card_code" class="control-label mb-1">Total Boxes</label>
										<div class="input-group">

											<input name="postcode" type="number" class="form-control" id="totalbox">
										</div>
									</div>


									<div class="col-md-3">
										<label for="x_card_code" class="control-label mb-1">Quantity</label>
										<div class="input-group">

											<input name="postcode" type="number" class="form-control" id="qty">
										</div>
									</div>


									<div class="col-md-3">
										<label for="x_card_code" class="control-label mb-1">Batch Code</label>
										<div class="input-group">

											<input name="postcode" type="text" class="form-control" id="batchcode">
										</div>
									</div>


								</div>

								<div class="row" id="chkproduct">


								</div>


						</div>


						<br />
						<button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add </button>
						<br /><br />
						<div class="form-row">
							<table id="bootstrap-data-table" class="table table-striped table-bordered" id="tbl">
								<thead>
									<tr>
										<th></th>
										<th>Product</th>
										<th>Chiller</th>
										<th>Boxes</th>
										<th>Qty</th>
										<th>Batchcode</th>

										<th>Kill Date</th>
										<th>Use By/Best Before</th>

									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>

										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>

									</tr>
								</tbody>
							</table>
						</div>
						<br /><br />

						<script language="javascript">
							function cnt() {

								var dt = $("table tr").length;
								if (dt < 3) {
									return false;
								} else {
									return true;
								}
							}
						</script>
						<button type="button" id="delete-row" class="btn btn-danger">Delete Row</button>

						<button type="submit" class="btn btn-success" style="float:right; display:none" id="sub" name="submit1" onclick="return cnt();">Save & Generate GRN</button>

					</div>
				</div>
			</div>


		</div>

		</form>


	</div>
</div>
</div>

<?php
if (isset($_POST['submit1'])) {
	echo"done";
	$grn = $_POST['grn'];
	$supid = $_POST['supid'];
	$date = date('Y-m-d');


	$vb2 = mysqli_query($con, "select * from tblgrn1 where grncode='$grn'");
	$lastrow2 = mysqli_num_rows($vb2);
	$num2 = $lastrow2 + 1;



	$productc = count($_POST["product"]);



	$tp2 = "";
	for ($i2 = 0; $i2 < $productc; $i2++) {
		$jk = $i2 + 1;
		$num2 = $num2 + 1;
		$grnc = $grn . "/" . $jk;

		$product = mysqli_real_escape_string($con, $_POST["product"][$i2]);
		$chillerc = $_POST["chiller"][$i2];
		$totalboxc = $_POST["totalbox"][$i2];
		$qtyc = $_POST["qty"][$i2];
		$batchcodec = $_POST["batchcode"][$i2];
		$ptempc = $_POST["ptemp"];
		$vtempc = $_POST["vtemp"];
		$killdatec = $_POST["killdate"][$i2];
		$usebyc = $_POST["useby"][$i2];
		$uommc = $_POST["uomm"][$i2];
		$stypec = $_POST["stype"][$i2];
		//$bbc=$_POST["bb"][$i2];

		if ($ptempc == "undefined") {
			$ptempc = "N/A";
		}

		if ($killdatec == "undefined") {
			$killdatec = "N/A";
		}

		if ($usebyc == "undefined") {
			$usebyc = "N/A";
		}

		if ($usebyc == "undefined") {
			$usebyc = "N/A";
		}

		if ($uommc == "undefined") {
			$uommc = "";
		}

		print_r("INSERT INTO tblgrn1(cdate,supplier, product, batchcode, qty,  useby, killdate, ptemp, vtemp, box, grn, date,chiller,grncode,uomm) VALUES ( '$date',
			'$supid', '$product', '$batchcodec', '$qtyc', '$usebyc', '$killdatec', '$ptempc', '$vtempc', '$totalboxc', '$grnc', '$date', '$chillerc', '$grn','$stypec') ");die;
		$qury = mysqli_query($con, "INSERT INTO tblgrn1(cdate,supplier, product, batchcode, qty,  useby, killdate, ptemp, vtemp, box, grn, date,chiller,grncode,uomm) VALUES ( '$date',
			'$supid', '$product', '$batchcodec', '$qtyc', '$usebyc', '$killdatec', '$ptempc', '$vtempc', '$totalboxc', '$grnc', '$date', '$chillerc', '$grn','$stypec') ");
	}
?>
	<!-- <script language="javascript">
		window.open('admin.php?id=goodsdetail&sno=<?php echo $_GET['sno']; ?>', '_self');
	</script> -->
<?php
}
?>
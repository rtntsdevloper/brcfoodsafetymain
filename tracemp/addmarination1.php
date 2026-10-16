  <?php
	$sno = $_GET['sno'];
	$sqlt = mysqli_query($con, "select * from tblrecipe where id='$sno'");
	$rowt = mysqli_fetch_array($sqlt);

	?>

  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Potato Usage Record - (Add New) </a></li>
  				</ul>

  			</div>
  		</div>
  	</div>
  </div>

  <div class="col-xl-12" style="margin-bottom:20px">

  	<a href="admin.php?id=addpusage"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

  </div>


  <script>
  	function tempcheck(str) {

  		if (str > 8) {
  			document.getElementById("tempchk").innerHTML = "* Temperature is greater than critical limit";
  			document.getElementById("tempchk").style.color = 'red';
  			document.getElementById("temp").focus();
  			document.getElementById("temp").value = "";
  		}
  	}
  </script>




  <script>
  	function checkqtyy(str, str1) {
  		var qt = document.getElementById('checkqty' + str1).value;
  		var qt1 = document.getElementById('qtyy' + str1).value;


  		if (parseFloat(parseFloat(qt1).toFixed(2)) > parseFloat(parseFloat(qt).toFixed(2))) {

  			document.getElementById('qused' + str1).innerHTML = "* Enter correct qty of ingredient";
  			document.getElementById('qused' + str1).style.color = 'red';
  			document.getElementById("qused" + str1).focus();
  			document.getElementById("qtyy" + str1).value = "";
  		} else if (parseFloat(parseFloat(qt1).toFixed(2)) < parseFloat(parseFloat(qt).toFixed(2))) {

  			document.getElementById('qused' + str1).innerHTML = "* Enter correct qty of ingredient";
  			document.getElementById('qused' + str1).style.color = 'red';
  			document.getElementById("qused" + str1).focus();
  			document.getElementById("qtyy" + str1).value = "";
  		}
  	}
  </script>


  <script language="javascript">
  	function changetextbox(y) {

  		//document.getElementById("save").style.display = "block"; 
  		//document.getElementById("reject").style.display = "none"; 

  		var sum = y + 1;
  		var s2 = document.getElementById('s1' + y).value;
  		//var cmnt = document.getElementById('s2'+y).value;
  		var tid = document.getElementById('t1' + y).value;

  		var phpvalue = y;

  		if (s2 == tid) {
  			document.getElementById("s2" + y).disabled = true;
  			return false;
  		} else if (s2 != tid) {
  			for (var n = y; n <= phpvalue; n++) {
  				document.getElementById("s2" + y).disabled = false;
  			}
  			return false;
  		} else {
  			return true;
  		}
  	}
  </script>

  <div class="col-sm-12">
  	<div class="card">

  		<div class="card-body">
  			<h4 style="color:#3399FF">Product: <?php // $rowt['name'];
													?></h4>

  			<?php
				if (isset($_GET['msg'])) {
				?>
  				<div style="color:#FF0000; text-align:center; font-size:18px"> Supplier Already Exist! </div><br />
  			<?php
				}
				?>
  			<script>
  				function cal() {
  					if (document.getElementById("date").value == "") {
  						document.getElementById("supperror").innerHTML = "* Please  select production date";
  						document.getElementById("date").focus();
  					} else if (document.getElementById("qty").value == "") {
  						document.getElementById("supperror").innerHTML = "* Please  enter quantity";
  						document.getElementById("qty").focus();
  					} else {
  						//document.getElementById("supp").disabled = true;
  						document.getElementById("qty").disabled = true;
  						document.getElementById("div1").style.display = "block";
  						document.getElementById("div1").focus();
  					}
  				}
  			</script>




  			<form name="form1" method="post" action="" enctype="multipart/form-data">
  				<div class="row">
  					<div class="col-md-12">
  						<script>
  							function reloadPrice() {
  								var str = document.getElementById("qty").value;
  								var str1 = document.getElementById("date").value;

  								var str2 = document.getElementById("udate").value;


  								if (str1 == "") {
  									document.getElementById("supperror").innerHTML = "* Please  select production date";
  									document.getElementById("date").focus();
  								} else if (str2 == "") {
  									document.getElementById("supperror").innerHTML = "* Please  select useby date";
  									document.getElementById("udate").focus();
  								} else if (str == "") {
  									document.getElementById("supperror").innerHTML = "* Please  enter quantity";
  									document.getElementById("qty").focus();
  								} else {
  									document.getElementById("qty").disabled = true;
  									document.getElementById("div1").style.display = "block";
  									document.getElementById("div1").focus();

  									if (str == "") {
  										document.getElementById("div1").innerHTML = "";
  										return;
  									}
  									if (window.XMLHttpRequest) {
  										xmlhttp = new XMLHttpRequest();
  									} else {
  										xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  									}
  									xmlhttp.onreadystatechange = function() {
  										if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
  											document.getElementById("div1").innerHTML = xmlhttp.responseText;
  										}
  									}
  									xmlhttp.open("GET", "marination/addmarination3.php?q=" + str + "&sno=" + <?php echo $sno; ?>, true);
  									xmlhttp.send();
  								}
  							}
  						</script>
  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Production Date</label>
  							<div class="input-group">
  								<input type="date" name="date" id="date" class="form-control" required />

  							</div>
  						</div>



  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Product Use by</label>
  							<div class="input-group">
  								<input type="date" name="udate" id="udate" class="form-control" required />

  							</div>
  						</div>



  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Enter quantity of "PRODUCT" you want to produce in KG</label>
  							<div class="input-group">



  								<input type="number" name="qty" class="form-control" id="qty" placeholder="Enter in kg" required />
  							</div>
  						</div>

  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"></label>
  							<div class="input-group">

  								<button class="btn btn-info" type="submit" name="submit">Save & Next</button>
  							</div>
  						</div>
  						<br />

  					</div>
  			</form>
  		</div>
  	</div>
  </div>

  <?php

	if (isset($_POST['submit'])) {
		$cname = "RPU";
		$user = $_SESSION['user'];
		$cid = "1";
		$result = substr($cname, 0, 3);

		$qty = $_POST['qty'];
		$date = $_POST['date'];
		$udate = $_POST['udate'];
		$sno = $_GET['sno'];

		$vb = mysqli_query($con, "select * from tblpusage ");
		$lastrow = mysqli_num_rows($vb);

		$num = $lastrow + 1;
		$grn = $result . date('dmy') . "00" . $num;

		$qury = mysqli_query($con, "INSERT INTO tblpusage(date,batchcode,name,quantity,user,cname,useby1) VALUES ('$date','$grn', '$sno', '$qty',  '$user','$cname','$udate') ");


	?>

  	<script language="javascript">
  		window.open('admin.php?id=addptusage&batch=<?php echo $grn; ?>', '_self')
  	</script>
  <?php
	}
	?>
  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Flavour Mixing - (Add New) </a></li>
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
  			<h4 style="color:#3399FF">Add Flavour Mixing Information</h4>

  			<form name="form1" method="post" action="" enctype="multipart/form-data">
  				<div class="row">
  					<div class="col-md-12">

  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Date</label>
  							<div class="input-group">
  								<input type="date" name="date" id="date" class="form-control" required />

  							</div>
  						</div>
  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Enter Product</label>
  							<input type="text" name="product" id="" class="form-control">
  						</div>

  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1"> Select Flavour</label>
  							<select name="flavour" id="" class="form-control">
  								<option>Please Flavour</option>

  								<?php

									$prdn = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE `pname` LIKE '%seasoning%'");
									foreach ($prdn as $prdata) {
										echo "<option value='" . $prdata['id'] . "'>" . $prdata['pname'] . "</option>";
									}


									?>


  							</select>
  						</div>

  						<div class="col-6">
  							<label for="cc-exp" class="control-label mb-1">Total number of boxes</label>
  							<div class="input-group">
  								<input type="number" name="oqty" id="udate" class="form-control" required oninput="flavoura(this.value)" />
  								<span class="input-group-text">boxes</span>
  							</div>
  						</div>

  						<script>
  							function flavoura(totalValue) {
  								const total1 = parseInt(totalValue);
								const total = total1 * 0.960;

  								const flavour = (total * 0.07).toFixed(2);
							
  								const potat = total - flavour;
								potat1 = potat.toFixed(2);
								


  								document.getElementById('ptuse').value = potat1;
  								document.getElementById('flv').value = flavour;

  							}
  						</script>



  						<div class="col-md-6">
  							<br>
  							<h5>Use 7% flavour to prepare product</h5>
  							<div class="row">
  								<div class="col-md-12">
  									<label for="">Frying Potato Quantity(In Kg)</label>
  									<input type="text" name="pqty" id="ptuse" class="form-control">
  								</div>
  								<div class="col-md-12">
  									<label for="">Flavour Quantity(In Kg)</label>
  									<input type="text" name="fqty" id="flv" class="form-control">
  								</div>
  							</div>
  						</div>


  						<br />
  						<div class="col-md-6">
  							<button class="btn btn-primary" type="submit" name="submit">Submit</button>
  						</div>

  					</div>
  			</form>
  		</div>
  	</div>
  </div>

  <?php

	if (isset($_POST['submit'])) {
		$cname = "PROD";
		$user = $_SESSION['user'];

		$mdate = $_POST['date'];
		$prod = $_POST['product'];
		$flavour = $_POST['flavour'];
		$total = $_POST['oqty'];
		$pqty = $_POST['pqty'];
		$fqty = $_POST['fqty'];
		

		$vb = mysqli_query($con, "select * from tblflavourmix");
		$lastrow = mysqli_num_rows($vb);

		$num = $lastrow + 1;
		$grn = $cname . date('dmy') . "00" . $num;

	
		$qury = mysqli_query($con, "INSERT INTO `tblflavourmix`(`date`, `quantity`, `totalqty`, `flavour`, `flavourid`, `productname`, `batch`,`totalleft`) VALUES ('$mdate','$pqty','$total','$fqty','$flavour','$prod','$grn','$total')");


	?>

  	<script language="javascript">
  		window.open('admin.php?id=flavouradd1&batch=<?php echo $grn; ?>', '_self')
  	</script>
  <?php
	}
	?>
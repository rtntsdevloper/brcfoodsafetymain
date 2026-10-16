<?php
include 'connection.php';
$random = rand(70, 7000);

$name = $_POST['name'];
$reason = $_POST['reason'];
$img = $_FILES['pic']['name'];
move_uploaded_file($_FILES['pic']['tmp_name'], "upl1/" . $img);
$orginisation = $_POST['org'];
$vehicle = $_POST['vehiclereg'];

$vd = date('dmy');
$vs = mysqli_query($con, "SELECT * FROM `visit`");
$vs1 = mysqli_num_rows($vs);
$vs2 = $vs1 + 1;

$visitcode = "Visit_" . $vd . "0" . $vs2;

$date = date('Y-m-d');
$q = mysqli_query($con, "INSERT INTO `visit`(`name`, `reason`, `pic`, `visitcode`,`register`,correct,org) VALUES ('$name','$reason','$img','$visitcode','$vehicle','$random','$orginisation')");
$nk = 0;
if (!empty($_POST['ques'])) {
	for ($i = 0; $i < count($_POST['ques']); $i++) {




		$qid = $_POST['qid'][$i];
		$module = $_POST['module'][$i];
		$status = $_POST['status'][$i];
		$statuss = $_POST['statuss'][$i];

		$ques = mysqli_real_escape_string($con, $_POST['ques'][$i]);

		if ($i == 1 && $i == 2) {
			if (empty($_POST['ans'][$i])) {
				$ans = "N/A";
			}
		} else {

			$ans = $_POST['ans'][$i];
		}
		$cmnt = $_POST['cmnt'][$i];

		if ($i == 12) {
			$nk  = $nk + 0;
		} elseif ($ans == 'Yes') {
			$nk = $nk + 1;
		}


		$sql = mysqli_query($con, "insert into saveques(qid,ques,cmnt,date,ans,module,status,correct,name,vcode)values('$qid','$ques','$cmnt','$date','$ans','$module','$status','$random','$name','$visitcode')");
		//  die;
	}
}

if ($nk > 0) {
	$qsn = "Thanks for submitting the response, your response is shared with your host please lies with him for further proceeding";
} else {
	$qsn = "Thanks for Submitting Response ! You can allowed to Visit the site";
}





?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script language="javascript">
	jQuery(document).ready(function($) {
		// Store the window width
		var windowWidth = $(window).width();
		// Resize Event
		$(window).resize(function() {

			// Check window width has actually changed and it's not just iOS triggering a resize event on scroll
			if ($(window).width() != windowWidth) {

				// Update the window width for next time
				windowWidth = $(window).width();

				// Do stuff here

			}

			// Otherwise do nothing

		});

	});
</script>
<style>
	.kbw-signature {
		width: 400px;
		height: 200px;
	}

	#signature canvas {
		width: 100% !important;
		height: auto;
	}

	.kbw-signature1 {
		width: 400px;
		height: 200px;
	}

	#signature1 canvas {
		width: 100% !important;
		height: auto;
	}

	.container {
		margin-left: 420px;

	}
</style>
<div class="main-content">
	<div class="container-fluid ">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-5">

					<div class="row ">
						<h3>HYGIENE RULES FOR THIS PRODUCTION SITE</h3>
						<p>Before entry to the production unit, visitors and contractors must adhere to the following rules at all times:</p>
						<br>
						<p>Before entry to the production unit, visitors and contractors must adhere to the following rules at all times:</p>

						<ul>
							<li> Follow the hand washing and sanitizing at the entrance and the different areas.</li>

							<li> Protective clothing must be worn before entering a production area. This includes a coat/disposable coat, hairnet, mask (wherever appropriate) and site provided factory footwear. 
								Please follow the procedures mentioned in each area.</li>

							<li> All jewellery must be removed before entering a production area. This includes watches and all types of earrings and necklaces. 
								A plain band wedding ring is permitted.</li>
							<li> Mobile phones are not permitted within the production areas.</li>
							<li> Smoking (including electronic cigarettes/vaping) is strictly forbidden in any part of the premises. Those who wish to smoke should do so outside in the designated area only.</li>

							<li> Any first aid dressing must be factory approved – if in doubt, ask your immediate manager or supervisor, prior to entry into any production area. 
								Personal medicines are not permitted to be taken into the factory.</li>
							<li> Please fill the visitor/ contractor register CD88 or CD97 whichever is applicable.</li>
							<li> Entry to the factory will be forbidden (depends on the purpose of the visit) if any of the following apply:</li>
						</ul>
					</div>


					<div class="row mt-3">
						<div class="col-md-6">
							<h3 style="color:#FF0000">Visitor Signature</h3>
							<form id="uploadForm3" method="post" action="">
								<input type="hidden" name="sno" value="<?php echo $visitcode; ?>">

								<div id="res" style="color:red; font-size:20px"></div>
								<br />
								<div id="signature"></div>
								<br />
								<br>
								<button id="clear" class="btn btn-warning">Clear Signature</button>
								<button class="btn btn-success" id="Submit" type="submit" style="margin-left:20px">Signature & Verify</button>

								<textarea id="sigpad" name="signature_image" style="display: none"></textarea>

							</form>


						</div>


					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var signature = $('#signature').signature({
			syncField: '#sigpad',
			syncFormat: 'PNG'
		});
		$('#clear').click(function(e) {
			e.preventDefault();
			signature.signature('clear');
			$("#sigpad").val('');
		});
	</script>


	<script type="text/javascript">
		$(document).ready(function(g) {

			$("#uploadForm3").on('submit', (function(g) {
				$("#loading").show();
				g.preventDefault();
				$.ajax({
					url: "visitsign",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(data) {
						$("#res").html(data);


						if (data == "") {
							$("#res").html('<span style="color:red;">Signature not verified.<span>');

						} else {
							alert('<?php echo $qsn; ?>');
							window.open('visit_report.php?visit=<?php echo $visitcode; ?>', '_self');
						}


					},
					error: function() {}
				});
			}));
		});
	</script>
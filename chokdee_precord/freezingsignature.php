<?php
include 'connection.php';

$date = $_GET['date'];
$product = $_GET['product'];
$pid = $_GET['pid'];
?>




<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script language="javascript">
	jQuery(document).ready(function ($) {
		// Store the window width
		var windowWidth = $(window).width();
		// Resize Event
		$(window).resize(function () {

			// Checik window width has actually changed and it's not just OS triggering a resize event on scroll
			if ($(window).width() != windowWidth) {

				// Update the window width for next time
				windowWidth = $(window).width();


			}



		});

	}
	);</script>
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
	<div class="breadcrumb">
		<!-- Removed undefined $headingname -->
		<ul>
			<li><a href="">Verification Signature
				</a></li>
			<!-- <li>Detail</li> -->
		</ul>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<!-- <a href="admin.php?id=ppm"><button class="btn btn-success" style="float:right; margin-left:15px">Go
						Back</button></a> -->


				<div class="row">
					<div class="col-md-6">
						<h3 style="color:#FF0000">Staff Signature</h3>
						<form id="uploadForm3" method="post" action="">

							<input type="text" hidden name="date" value="<?php echo $date; ?>">
							<input type="text" hidden name="product" value="<?php echo $product; ?>">
							<input type="text" hidden name="pid" value="<?php echo $pid; ?>">


							<div id="res" style="color:red; font-size:20px"></div>
							<br />
							<div id="signature"></div>
							<br />
							<button id="clear" class="btn btn-warning">Clear Signature</button>
							<button class="btn btn-success" id="Submit" type="submit" style="margin-left:20px">Signature
								& Verify</button>

							<textarea id="sigpad" name="signature_image" style="display: none"></textarea>

						</form>


					</div>


				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		var signature = $('#signature').signature({ syncField: '#sigpad', syncFormat: 'PNG' });
		$('#clear').click(function (e) {
			e.preventDefault();
			signature.signature('clear');
			$("#sigpad").val('');
		});
	</script>


	<script type="text/javascript">
		$(document).ready(function (g) {

			$("#uploadForm3").on('submit', (function (g) {
				// $("#loading").show();
				g.preventDefault();
				$.ajax({
					url: "chokdee_precord/freezingsign",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function (data) {
						$("#res").html(data);


						if (data == "") {
							$("#res").html('<span style="color:red;">Signature not verified.<span>');

						}

						else {

							 window.location.href = "admin.php?id=savouryproduction1&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>";

						}


					},
					error: function (xhr, status, error) {
						$("#res").html('<span style="color:red;">An error occurred: ' + error + '</span>');
					}
				});
			}));
		});
	</script>
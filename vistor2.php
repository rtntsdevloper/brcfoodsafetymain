<?php

$nk = $_GET['nk'];
$vst = $_GET['visit'];
if ($nk > 0) {
	$qsn = "Thank you for submitting your response. It has been shared with your host. Please follow up with them for the next steps";
} else {
	$qsn = "Thanks for submitting your response, you can proceed to the production area";
}

?>




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

<!DOCTYPE html>
<html lang="en" dir="">

<head>
	<meta charset="ISO-8859-1">
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title> RTNTS - Web Portal </title>
	<link rel="shortcut icon" href="favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
	<link href="dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
	<link href="dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
	<script src="dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
	<script src="dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="dist-assets/js/scripts/script.min.js"></script>
	<script src="dist-assets/js/scripts/sidebar.large.script.min.js"></script>
	<script src="dist-assets/js/plugins/echarts.min.js"></script>
	<script src="dist-assets/js/scripts/echart.options.min.js"></script>
	<script src="dist-assets/js/plugins/datatables.min.js"></script>
	<script src="dist-assets/js/scripts/form.validation.script.min.js"></script>
	<script src="dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
	<script src="dist-assets/js/plugins/sweetalert2.min.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/reset.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


	

</head>

<body class="text-left" style="overflow:hidden;">
	<div class="app-admin-wrap layout-sidebar-large">
		<div class="main-header">

			<img src="images/logo1.png" alt="" width="70" style="margin-left:20px">
			<div class="menu-toggle">
				<div></div>
				<div></div>
				<div></div>
			</div>
			<div class="d-flex align-items-center">
				<!-- Mega menu -->
				<div class="dropdown mega-menu d-none d-md-block">
					Regal Technical and Training Solutions Limited </div>
				<!-- / Mega menu -->
			</div>
			<div style="margin: auto"></div>
			<div class="header-part-right">
				<!-- Full screen toggle -->
				<i class="fa fa-arrows" data-fullscreen></i>
				<!-- Grid menu Dropdown -->

				<!-- Notificaiton -->

				<!-- Notificaiton End -->
				<!-- User avatar dropdown -->
				<div class="dropdown">

				</div>
			</div>
		</div>

		<div class="side-content-wrap">
			<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
				<ul class="navigation-left">
					<li class="nav-item"><a class="nav-item-hold" href=""> <i class="fa fa-bank"
								style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
						<div class="triangle"></div>
					</li>

				</ul>
			</div>

			<div class="sidebar-overlay"></div>
		</div>
		<div class="main-content-wrap sidenav-open d-flex flex-column">
			<div class="container-fluid ">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body p-5">
							<div class="row mt-3">
								<div class="col-md-6">
									<h3 style="color:#FF0000">Visitor Signature</h3>
									<form id="uploadForm3" method="post" action="">
										<input type="hidden" name="sno" value="<?php echo $vst; ?>">

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
		</div>
	</div>
</body>

</html>

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
						window.open('visit_report.php?visit=<?php echo $vst; ?>', '_self');
					}


				},
				error: function() {}
			});
		}));
	});
</script>
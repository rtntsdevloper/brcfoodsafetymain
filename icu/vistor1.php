<?php
include 'connection.php';

// Set timezone to UK
date_default_timezone_set("Europe/London");

// Show current UK date and time
$time = date("H:i:s");


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

$q = mysqli_query($con, "INSERT INTO `visit`(`name`, `reason`, `pic`, `visitcode`,`register`,correct,org,vtime) VALUES ('$name','$reason','$img','$visitcode','$vehicle','$random','$orginisation','$time')");


$nk = 0;
if (!empty($_POST['ques'])) {
	for ($i = 0; $i < count($_POST['ques']); $i++) {




		$qid = $_POST['qid'][$i];
		$module = $_POST['module'][$i];
		$status = $_POST['status'][$i];
		$statuss = $_POST['statuss'][$i];

		$ques = mysqli_real_escape_string($con, $_POST['ques'][$i]);



		$ans = $_POST['ans'][$i];

		$cmnt = $_POST['cmnt'][$i];

		if ($ans == 'Yes') {
			$nk = $nk + 1;
		}


		$sql = mysqli_query($con, "insert into saveques(qid,ques,cmnt,date,ans,module,status,correct,name,vcode)values('$qid','$ques','$cmnt','$date','$ans','$module','$status','$random','$name','$visitcode')");
		//  die;
	}
}







?>





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
<?php
date_default_timezone_set("Europe/London");
include 'connection.php';
?>
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



</head>

<body class="text-left">
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

							<div class="row ">
								<h3>VISITORS ARE REQUESTED NOT TO TOUCH ANY FOOD ITEMS DURING THE FACTORY VISIT</h3>
								<h3>HYGIENE RULES FOR THIS PRODUCTION SITE</h3>

								<ol>
									<li>Visitors must be accompained by a member of staff at all times.</li>
									<li>Please follow any instructions given to you by your guide.</li>
									<li>Loose items of jewellery (watches, earrings, bracelets, necklaces and rings) are not permitted inside
										of the fridges/freezers or production areas and you are kindly asked to remove them before
										entering</li>
									<li>Please alert your guide to any medications or drugs you have on you, as they are not allowed in any
										of the fridges/freezers or production areas.</li>
									<li>Please also empty your pockets of peanuts, shellfish and any other allergens you may have on you.</li>
									<li>You must wash your hands and use the sanitiser upon entering any of the fridges/freezers and food
										production areas.</li>
									<li>No food is allowed inside the factory, specially Allergens (wheat, rye, barley, and oats), crustaceans (such as prawns, crabs and lobsters), eggs, fish, lupin, milk, molluscs (such as mussels and oysters), mustard, peanuts, sesame, soybeans, sulphur dioxide and sulphites) not allowed inside the factory.</li>
								</ol>
								<h4> Please refrain from unhygienic behaviour such as</h4>
								<ol>

									<li> Coughing or sneezing over or near products </li>
									<li>Exploration of nose, ears or teeth </li>
									<li>Smoking, eating, chewing gum and drinking</li>
									<li>CCTV is in operation within our premises to ensure product, employees, visitors and contractors
										security.</li>

								</ol>

							</div>
							<div class="row">
								<form action="vistor2" method="post">
									<input type="hidden" name="nk" value="<?php echo $nk; ?>">
									<input type="hidden" name="visit" value="<?php echo $visitcode; ?>">
									<button class="btn btn-primary" type="submit">Next</button>
								</form>
							</div>



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
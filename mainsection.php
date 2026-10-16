 <?php
//decomment if open after login



	// date_default_timezone_set("Europe/London");
	
	// session_start();

	// if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
	?>
 	<script>
 		// window.open('index.php', '_self');
 	</script>
 

 <!DOCTYPE html>
 <html lang="en" dir="">

 <head>
 	<meta charset="ISO-8859-1">
 	<meta name="viewport" content="width=device-width,initial-scale=1" />
 	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
 	<title> RTNTS - Web Portal </title>

 	<meta name="robots" content="noindex, nofollow">
 	<meta name="autocomplete" content="off">


 	<link rel="shortcut icon" href="favicon.ico">
 	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
 	<link href="dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
 	<link href="dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
 	<link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css" />
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link rel="stylesheet" href="dist-assets/css/plugins/datatables.min.css" />


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
 	<style type="text/css">
 		.modalk {
 			position: fixed;
 			z-index: 999;
 			height: 100%;
 			width: 100%;
 			top: 0;
 			left: 0;
 			background-color: Black;
 			filter: alpha(opacity=60);
 			opacity: 0.6;
 			-moz-opacity: 0.8;
 		}

 		.center {
 			z-index: 1000;
 			margin: 300px auto;
 			padding: 10px;
 			width: 130px;
 			background-color: White;
 			border-radius: 10px;
 			filter: alpha(opacity=100);
 			opacity: 1;
 			-moz-opacity: 1;
 		}

 		.center img {
 			height: 128px;
 			width: 128px;
 		}
 	</style>
 </head>


 <body class="text-left">

 	<div class="modalk" style="display: none">
 		<div class="center">
 			<img alt="" src="loader.gif" />
 		</div>
 	</div>

 	<div class="app-admin-wrap layout-sidebar-large">
 		<div class="main-header">

 			<img src="images/logo1.png" alt="" width="70" style="margin-left:20px">
 			
 			<div class="d-flex align-items-center ml-5">
 				<!-- Mega menu -->
 				<div class=" d-none d-md-block">
 					Regal Technical and Training Solutions Limited </div>
 				<!-- / Mega menu -->
 			</div>
 			<div style="margin: auto"></div>
 			<div class="header-part-right">
 				<!-- Full screen toggle -->
 				
 				



				<!-- if after login -->

				<!-- <i class="fa fa-arrows" data-fullscreen></i> -->
 				<!-- <div class="dropdown">
 					<div class="user col align-self-end">
 						<i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome: <?php echo $user; ?> (<?php echo $access; ?>)</i>
 					</div>
 				</div> -->








 			</div>
 		</div>

 		
 		<!-- =============== Left side End ================-->
 		<div class="main-content-wrap sidenav-open d-flex flex-column">
 		
				<div class="row mt-5">
					<div class="col-lg-1"></div>
					<div class="col-lg-5 col-md-6 col-sm-6">
                     <a href="https://jdmeats.rtnts.com/">   
						<!-- <a href="https://jdmeats.rtnts.com/admin.php?id=1">   -->
					 <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0 text-26">Unit</p>
                                    <p class="text-primary text-32 line-height-1 mb-2">5</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					<div class="col-lg-5 col-md-6 col-sm-6">
                     <a href="https://jdmeats.rtnts.com/unit17/">  
					<!-- <a href="https://jdmeats.rtnts.com/unit17/admin.php?id=1">   -->	
					 <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#990000"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0 text-26">Unit</p>
                                    <p class="text-primary text-32 line-height-1 mb-2">17</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					<div class="col-lg-1"></div>
				</div>
			

 		</div>
 		<!-- PAGINATION CONTROL -->
 		<!-- ============ Search UI End ============= -->
 		<script src="dist-assets/js/plugins/jquery.smartWizard.min.js"></script>
 		<script src="dist-assets/js/plugins/datatables.min.js"></script>
 		<script src="dist-assets/js/scripts/datatables.script.min.js"></script>
 		<script src="dist-assets/js/plugins/dropzone.min.js"></script>
 		<script src="dist-assets/js/scripts/dropzone.script.min.js"></script>


 </body>

 </html>
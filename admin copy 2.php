 <?php
	date_default_timezone_set("Europe/London");
	include 'connection.php';

	session_start();


	include 'connection_psd.php';
	$psdcust = 32;


	if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
	?>
 	<script>
 		window.open('index.php', '_self');
 	</script>
 <?php
	} else {
		$user = $_SESSION['user'];
		$access = $_SESSION['access'];
		$headingname = $_SESSION['headingname'];
		$tabs = $_SESSION['tabs'];
	}

	$sqw = mysqli_query($con, "select * from tblmain where status='portallink'");
	$sqq = mysqli_fetch_array($sqw);
	$_SESSION['portallink'] = $sqq['name'];

	$portallink = $_SESSION['portallink'];

	?>

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
 					<div class="user col align-self-end">
 						<i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome: <?php echo $user; ?> (<?php echo $access; ?>)</i>
 					</div>
 				</div>
 			</div>
 		</div>

 		<div class="side-content-wrap">
 			<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">

 				<ul class="navigation-left">
 					<li class="nav-item active"><a class="nav-item-hold" href="admin.php?id=1"><i class="fa fa-list" style="font-size:34px; color:pink;"></i><span class="nav-text">Dashboard</span></a>
 						<div class="triangle"></div>
 					</li>
					<li class="nav-item" data-item="section"><a class="nav-item-hold" href="#"><i class="fa fa-list" style="font-size:34px; color:#188BB1"></i><span class="nav-text">Section Management</span></a>
 						<div class="triangle"></div>
 					</li>
 					<?php
						$string = $tabs;
						$array = explode(";", $string);
						$data = array();
						foreach ($array as $arr) {
							$sq = mysqli_query($con, "select * from tbltabs where sno='$arr' and navbar='yes'");

							while ($qr = mysqli_fetch_array($sq)) {
						?>
 							<li class="nav-item active"><a class="nav-item-hold" href="<?php echo $qr['weblink']; ?>"><i class="fa fa-list" style="font-size:34px; color:<?php echo $qr['color']; ?>"></i><span class="nav-text">
 										<?php echo $qr['name']; ?> <?php echo $qr['name1']; ?></span></a>
 								<div class="triangle"></div>
 							</li>

 					<?PHP
							}
						}
						?>

 					<li class="nav-item"><a class="nav-item-hold" href="logged.php"><i class="fa fa-sign-out" style="font-size:34px; color:#990000"></i><span class="nav-text">Log Out</span></a>
 						<div class="triangle"></div>
 					</li>
 				</ul>

 			</div>
 			<div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">

 				<ul class="childNav" data-parent="section">
 					<?php
						$section = mysqli_query($con, "SELECT * FROM `addtest1` order by testid asc");
						foreach ($section as $secdata) {
							$tid = $secdata['testid'];
						?>
 						<li class="nav-item dropdown-sidemenu"><a href=""><i class="fa fa-list" style="font-size:18px; margin-left: 5px;color:#188BB1"></i><span class="item-name" style="font-size:14px; margin-left: 5px;">Section <?php echo $secdata['testid']; ?></span>
 							</a>
 							<ul class="submenu">
								<?php 
								$subc = mysqli_query($con, "SELECT distinct sid FROM `subtest` WHERE tid ='$tid'");
								foreach ($subc as $subcdata) {
									$subsid = $subcdata['sid'];
									$qh = mysqli_query($con, "SELECT * FROM `subtest` WHERE sid ='$subsid'");
									$qh1 = mysqli_fetch_array($qh);
									$ssid = $qh1['id'];

								?>
								<li><a href="admin.php?id=sectiontabs&ssid=<?php echo $ssid; ?>">Section <?php echo $subcdata['sid']; ?></a></li>
								<?php
								}
								?>
 							</ul>
 						</li>

 					<?php
						}

						?>

 					<!-- <i class="fa fa-sort-down" style="font-size:18px; margin-left: 5px;"></i> -->

 				</ul>
 				<div class="sidebar-overlay"></div>
 			</div>
 			<!-- =============== Left side End ================-->
 			<div class="main-content-wrap sidenav-open d-flex flex-column">
 				<!-- ============ Body content start ============= -->
 				<?php
					if ($_GET['id'] == "1") {
						include 'dashboard.php';
					} else if ($_GET['id'] == "audit") {
						include 'audit.php';
					} else if ($_GET['id'] == "viewmore") {
						include 'viewmore.php';
					} else if ($_GET['id'] == "cmgmt") {
						include 'cmgmt.php';
					} else if ($_GET['id'] == "umgmt1") {
						include 'umgmt1.php';
					} else if ($_GET['id'] == "umgmt") {
						include 'umgmt.php';
					} else if ($_GET['id'] == "adduser") {
						include 'adduser.php';
					} else if ($_GET['id'] == "edituser") {
						include 'edituser.php';
					} else if ($_GET['id'] == "cmgmt1") {
						include 'cmgmt1.php';
					} else if ($_GET['id'] == "editcompany") {
						include 'editcompany.php';
					} else if ($_GET['id'] == "audits") {
						include 'audits.php';
					} else if ($_GET['id'] == "viewdetail") {
						include 'viewdetail.php';
					} else if ($_GET['id'] == "training") {
						include 'training.php';
					} else if ($_GET['id'] == "training1") {
						include 'training1.php';
					} else if ($_GET['id'] == "viewdata") {
						include 'viewdata.php';
					} else if ($_GET['id'] == "machine") {
						include 'machine.php';
					} else if ($_GET['id'] == "report") {
						include 'reportt.php';
					} else if ($_GET['id'] == "adddetail") {
						include 'adddetails.php';
					} else if ($_GET['id'] == "view") {
						include 'view.php';
					} else if ($_GET['id'] == "editdetail") {
						include 'editdetail.php';
					} else if ($_GET['id'] == "test") {
						include 'test.php';
					} else if ($_GET['id'] == "corrective") {
						include 'corrective.php';
					} else if ($_GET['id'] == "addnew") {
						include 'addnew.php';
					} else if ($_GET['id'] == "correctivedetail") {
						include 'correctivedetail.php';
					} else if ($_GET['id'] == "savesign") {
						include 'savesign.php';
					} else if ($_GET['id'] == "archive") {
						include 'archive.php';
					} else if ($_GET['id'] == "machinee") {
						include 'machinee.php';
					} else if ($_GET['id'] == "viewdetails") {
						include 'viewdetails.php';
					} else if ($_GET['id'] == "archivee") {
						include 'archivee.php';
					} else if ($_GET['id'] == "auditmgmt") {
						include 'auditmgmt.php';
					} else if ($_GET['id'] == "audit1") {
						include 'audit1.php';
					} else if ($_GET['id'] == "auditalert") {
						include 'auditalert.php';
					} else if ($_GET['id'] == "brccompliance") {
						include 'brccompliance.php';
					} else if ($_GET['id'] == "brccompliance1") {
						include 'brccompliance1.php';
					} else if ($_GET['id'] == "brccompliance2") {
						include 'brccompliance2.php';
					} else if ($_GET['id'] == "brccompliance3") {
						include 'brccompliance3.php';
					} else if ($_GET['id'] == "brccompliance4") {
						include 'brccompliance4.php';
					} else if ($_GET['id'] == "try") {
						include 'try.php';
					} else if ($_GET['id'] == "auditprogress") {
						include 'auditprogress.php';
					} else if ($_GET['id'] == "auditdetail") {
						include 'auditdetail.php';
					} else if ($_GET['id'] == "auditor") {
						include 'auditor.php';
					} else if ($_GET['id'] == "addauditor") {
						include 'addauditor.php';
					} else if ($_GET['id'] == "viewauditor") {
						include 'viewauditor.php';
					} else if ($_GET['id'] == "auditorassign") {
						include 'auditorassign.php';
					} else if ($_GET['id'] == "auditorassign1") {
						include 'auditorassign1.php';
					} else if ($_GET['id'] == "auditeemgmt") {
						include 'auditeemgmt.php';
					} else if ($_GET['id'] == "addauditee") {
						include 'addauditee.php';
					} else if ($_GET['id'] == "ncview") {
						include 'ncview.php';
					} else if ($_GET['id'] == "ncview1") {
						include 'ncview1.php';
					} else if ($_GET['id'] == "editauditor") {
						include 'editauditor.php';
					} else if ($_GET['id'] == "editauditee") {
						include 'editauditee.php';
					} else if ($_GET['id'] == "auditreport") {
						include 'auditreport.php';
					} else if ($_GET['id'] == "glutenfree") {
						include 'glutenfree.php';
					} else if ($_GET['id'] == "glutenfree1") {
						include 'glutenfree1.php';
					} else if ($_GET['id'] == "glutenfreeupload") {
						include 'glutenfreeupload.php';
					} else if ($_GET['id'] == "viewdetail") {
						include 'viewdetail.php';
					} else if ($_GET['id'] == "auditreport") {
						include 'auditreport.php';
					} else if ($_GET['id'] == "gmp") {
						include 'gmp.php';
					} else if ($_GET['id'] == "gmp1") {
						include 'gmp1.php';
					} else if ($_GET['id'] == "ques") {
						include 'ques.php';
					} else if ($_GET['id'] == "ques1") {
						include 'ques1.php';
					} else if ($_GET['id'] == "staffdetail") {
						include 'staffdetail.php';
					} else if ($_GET['id'] == "gmpaudit") {
						include 'gmpaudit.php';
					} else if ($_GET['id'] == "gmpaudit1") {
						include 'gmpaudit1.php';
					} else if ($_GET['id'] == "gmpaudit2") {
						include 'gmpaudit2.php';
					} else if ($_GET['id'] == "addaudit") {
						include 'addaudit.php';
					} else if ($_GET['id'] == "addaudit1") {
						include 'addaudit1.php';
					} else if ($_GET['id'] == "viewaudit") {
						include 'viewaudit.php';
					} else if ($_GET['id'] == "allowaudit") {
						include 'allowaudit.php';
					} else if ($_GET['id'] == "gmpauditt") {
						include 'gmpauditt.php';
					} else if ($_GET['id'] == "gmpnc") {
						include 'gmpnc.php';
					} else if ($_GET['id'] == "gmpnc1") {
						include 'gmpnc1.php';
					} else if ($_GET['id'] == "amgmt") {
						include 'amgmt.php';
					} else if ($_GET['id'] == "viewallreport") {
						include 'viewallreport.php';
					} else if ($_GET['id'] == "fscsurveytrendings") {
						include 'fscsurveytrendings.php';
					} else if ($_GET['id'] == "fscsurveytrending") {
						include 'fscsurveytrending.php';
					} else if ($_GET['id'] == 'procedure') {
						include 'procedure.php';
					} else if ($_GET['id'] == 'procedure1') {
						include 'procedure1.php';
					} else if ($_GET['id'] == 'addprocedure') {
						include 'addprocedure.php';
					} else if ($_GET['id'] == 'proceduretraining') {
						include 'proceduretraining.php';
					} else if ($_GET['id'] == 'proceduredetail') {
						include 'proceduredetail.php';
					} else if ($_GET['id'] == 'addproceduretraining') {
						include 'addproceduretraining.php';
					} else if ($_GET['id'] == 'addproceduredetail') {
						include 'addproceduredetail.php';
					} else if ($_GET['id'] == 'viewdocument') {
						include 'viewdocument.php';
					} else if ($_GET['id'] == 'addstaffprocedure') {
						include 'addstaffprocedure.php';
					} else if ($_GET['id'] == 'addstaffprocedure1') {
						include 'addstaffprocedure1.php';
					} else if ($_GET['id'] == 'editpocedure') {
						include 'editpocedure.php';
					} else if ($_GET['id'] == 'recordsmgmt') {
						include 'recordsmgmt.php';
					} else if ($_GET['id'] == 'additionalmgmt') {
						include 'additionalmgmt.php';
					} else if ($_GET['id'] == 'addaditional') {
						include 'addaditional.php';
					} else if ($_GET['id'] == 'editaditional') {
						include 'editaditional.php';
					} else if ($_GET['id'] == 'editbrccompliance') {
						include 'editbrccompliance.php';
					} else if ($_GET['id'] == 'attemptnewaudit') {
						include 'attemptnewaudit.php';
					} else if ($_GET['id'] == 'goodsin') {
						include 'goodsin.php';
					} else if ($_GET['id'] == 'addnewgoods') {
						include 'addnewgoods.php';
					} else if ($_GET['id'] == 'goodsindetail') {
						include 'goodsindetail.php';
					} else if ($_GET['id'] == 'dailycheck') {
						include 'dailycheck.php';
					} else if ($_GET['id'] == 'dailychecks') {
						include 'dailychecks.php';
					} else if ($_GET['id'] == 'dailychecks1') {
						include 'dailychecks1.php';
					} else if ($_GET['id'] == 'dailychecks3') {
						include 'dailychecks3.php';
					} else if ($_GET['id'] == 'dailychecks5') {
						include 'dailychecks5.php';
					} else if ($_GET['id'] == 'dailycheckss') {
						include 'dailycheckss.php';
					} else if ($_GET['id'] == 'dailychecks4') {
						include 'dailychecks4.php';
					} else if ($_GET['id'] == 'dailychecksdetail') {
						include 'dailychecksdetail.php';
					} else if ($_GET['id'] == 'uploadcsv') {
						include 'uploadcsv.php';
					} else if ($_GET['id'] == 'uploadcsv1') {
						include 'uploadcsv1.php';
					} else if ($_GET['id'] == 'addnewgoods2') {
						include 'addnewgoods2.php';
					} else if ($_GET['id'] == 'addnewgoods3') {
						include 'addnewgoods3.php';
					} else if ($_GET['id'] == 'addnewgoods4') {
						include 'addnewgoods4.php';
					} else if ($_GET['id'] == 'addnewgoods7') {
						include 'addnewgoods7.php';
					} else if ($_GET['id'] == 'complaintmgmt') {
						include 'complaintmgmt.php';
					} else if ($_GET['id'] == 'viewcomplaintdetail') {
						include 'viewcomplaintdetail.php';
					} else if ($_GET['id'] == 'complaintview') {
						include 'complaintpdf.php';
					} else if ($_GET['id'] == 'goods') {
						include 'goodsin/goods.php';
					} else if ($_GET['id'] == '1addnewgoods2') {
						include 'goodsin/1addnewgoods2.php';
					} else if ($_GET['id'] == 'goodsdetail') {
						include 'goodsin/goodsdetail.php';
					} else if ($_GET['id'] == 'goodseditdetail') {
						include 'goodsin/goodseditdetail.php';
					} else if ($_GET['id'] == '1addnewgoods21') {
						include 'goodsin/1addnewgoods21.php';
					} else if ($_GET['id'] == "genratelabel") {
						include 'genratelabel.php';
					} else if ($_GET['id'] == "goodsout") {
						include 'goodsin/goodsout.php';
					} else if ($_GET['id'] == "goodsout1") {
						include 'goodsin/goodsout1.php';
					} else if ($_GET['id'] == "goodsoutdetail") {
						include 'goodsin/goodsoutdetail.php';
					} else if ($_GET['id'] == "gmptrending") {
						include 'gmptrending.php';
					} else if ($_GET['id'] == "brctrending") {
						include 'brctrending.php';
					} else if ($_GET['id'] == "knowledge") {
						include 'knowledge.php';
					} else if ($_GET['id'] == "goodsoutedit") {
						include 'goodsin/goodsoutedit.php';
					} else if ($_GET['id'] == "knowledgemgmt") {
						include 'knowledgemgmt.php';
					} else if ($_GET['id'] == "knowledgehub") {
						include 'knowledgehub.php';
					} else if ($_GET['id'] == "legislation") {
						include 'legislation.php';
					} else if ($_GET['id'] == "legislationdetail") {
						include 'legislationdetail.php';
					} else if ($_GET['id'] == "alerts") {
						include 'alerts.php';
					} else if ($_GET['id'] == 'recordsmgmt') {
						include 'recordsmgmt.php';
					} else if ($_GET['id'] == 'additionalmgmt') {
						include 'additionalmgmt.php';
					} else if ($_GET['id'] == 'additionalmgmt_view') {
						include 'additionalmgmtview.php';
					} else if ($_GET['id'] == 'additionalmanage') {
						include 'aditionalmanage.php';
					} else if ($_GET['id'] == 'viewaddmanage') {
						include 'viewaddmanage.php';
					} else if ($_GET['id'] == 'addrecord') {
						include 'addrecord.php';
					} else if ($_GET['id'] == 'editbrccompliance') {
						include 'editbrccompliance.php';
					} else if ($_GET['id'] == 'ppm') {
						include 'ppm.php';
					} else if ($_GET['id'] == 'ppm1') {
						include 'ppm1.php';
					} else if ($_GET['id'] == 'ppmmgmt') {
						include 'ppmmgmt.php';
					} else if ($_GET['id'] == 'addppm') {
						include 'addppm.php';
					} else if ($_GET['id'] == 'uploadspec') {
						include 'goodsin/uploadspec.php';
					} else if ($_GET['id'] == 'viewspec') {
						include 'goodsin/viewspec.php';
					} else if ($_GET['id'] == 'specdetail') {
						include 'goodsin/specdetail.php';
					} else if ($_GET['id'] == "editaccess") {
						include 'editaccess.php';
					} else if ($_GET['id'] == "adminmgmt") {
						include 'adminmgmt.php';
					} else if ($_GET['id'] == "addadmin") {
						include 'addadmin.php';
					} else if ($_GET['id'] == "editadmin") {
						include 'editadmin.php';
					} else if ($_GET['id'] == "emailmgmt") {
						include 'emailmgmt.php';
					} else if ($_GET['id'] == "addemail") {
						include 'addemail.php';
					} else if ($_GET['id'] == "editgmp") {
						include 'editgmp.php';
					} else if ($_GET['id'] == "addlegislation") {
						include 'addlegislation.php';
					}
					// marination
					// else if ($_GET['id'] == "marination") {
					// 	include 'marination/marination.php';
					// } else if ($_GET['id'] == "addmarination") {
					// 	include 'marination/addmarination.php';
					// } else if ($_GET['id'] == "addmarination1") {
					// 	include 'marination/addmarination1.php';
					// } else if ($_GET['id'] == "viewmarination") {
					// 	include 'marination/viewmarination.php';
					// } else if ($_GET['id'] == "addmarinationn1") {
					// 	include 'marination/addmarinationn1.php';
					// }









					else if ($_GET['id'] == "goods1") {
						include 'goods1.php';
					} else if ($_GET['id'] == "prodmgmt") {
						include 'prodmgmt.php';
					} else if ($_GET['id'] == 'viewspecc') {
						include 'viewspec.php';
					} else if ($_GET['id'] == 'addlegislationn') {
						include 'addlegislationn.php';
					} else if ($_GET['id'] == "alertcategory") {
						include 'alertcategory.php';
					} else if ($_GET['id'] == "legislationcategory") {
						include 'legislationcategory.php';
					}
					// else if ($_GET['id'] == "scale") {
					// 	include $_GET['id2'] . '/scale.php';
					// } else if ($_GET['id'] == "scale1") {
					// 	include $_GET['id2'] . '/scale1.php';
					// } 
					else if ($_GET['id'] == "goodsoutt") {
						include $_GET['id2'] . '/goodsoutt.php';
					} else if ($_GET['id'] == "goodsoutt1") {
						include $_GET['id2'] . '/goodsoutt1.php';
					} else if ($_GET['id'] == "ggoodsoutdetail") {
						include $_GET['id2'] . '/ggoodsoutdetail.php';
					} else if ($_GET['id'] == "baking") {
						include $_GET['id2'] . '/baking.php';
					} else if ($_GET['id'] == "baking1") {
						include $_GET['id2'] . '/baking1.php';
					} else if ($_GET['id'] == "cooling") {
						include $_GET['id2'] . '/cooling.php';
					} else if ($_GET['id'] == "cooling1") {
						include $_GET['id2'] . '/cooling1.php';
					} else if ($_GET['id'] == "packing") {
						include $_GET['id2'] . '/packing.php';
					} else if ($_GET['id'] == "packing1") {
						include $_GET['id2'] . '/packing1.php';
					} else if ($_GET['id'] == "metal") {
						include $_GET['id2'] . '/metal.php';
					} else if ($_GET['id'] == "metal1") {
						include $_GET['id2'] . '/metal1.php';
					} else if ($_GET['id'] == "boxing") {
						include $_GET['id2'] . '/boxing.php';
					} else if ($_GET['id'] == "boxing1") {
						include $_GET['id2'] . '/boxing1.php';
					} else if ($_GET['id'] == "production") {
						include $_GET['id2'] . '/production.php';
					} else if ($_GET['id'] == "production1") {
						include $_GET['id2'] . '/production1.php';
					} else if ($_GET['id'] == "labeling") {
						include $_GET['id2'] . '/labeling.php';
					} else if ($_GET['id'] == "labeling1") {
						include $_GET['id2'] . '/labeling1.php';
					} else if ($_GET['id'] == "boxingg") {
						include $_GET['id2'] . '/boxingg.php';
					} else if ($_GET['id'] == "addrawmaterial") {
						include 'rawmaterial.php';
					} else if ($_GET['id'] == "addrawmaterial1") {
						include 'rawmaterial1.php';
					} elseif ($_GET['id'] == "editrawmaterial") {
						include 'editrawmaterial.php';
					} elseif ($_GET['id'] == "editrawsupplier") {
						include 'editrawsupplier.php';
					} else if ($_GET['id'] == "rawsupplier") {
						include 'rawsupplier.php';
					} else if ($_GET['id'] == "addrawsupplier") {
						include 'addrawsupplier.php';
					} else if ($_GET['id'] == 'customer') {
						include 'product_supplier.php';
					} else if ($_GET['id'] == 'addcustomer') {
						include 'addcustomer.php';
					} else if ($_GET['id'] == 'editcustomer') {
						include 'editcustomer.php';
					} else if ($_GET['id'] == 'goodoutmgmt') {
						include 'goodoutmgmt.php';
					} else if ($_GET['id'] == 'addgoodsout') {
						include 'addgoodsout.php';
					} else if ($_GET['id'] == 'editgoodsout') {
						include 'editgoodsout.php';
					} else if ($_GET['id'] == 'foodfraud') {
						include 'foodfraud.php';
					} else if ($_GET['id'] == 'addfoodfraud') {
						include 'addfoodfraud.php';
					} else if ($_GET['id'] == 'uploadreport') {
						include 'uploadreport.php';
					} else if ($_GET['id'] == 'uploadreport1') {
						include 'uploadreport1.php';
					} else if ($_GET['id'] == "ps") {
						include $_GET['id2'] . '/ps.php';
					} else if ($_GET['id'] == "ps1") {
						include $_GET['id2'] . '/productsection.php';
					} else if ($_GET['id'] == "pattemptaudit") {
						include $_GET['id2'] . '/pattemptaudit.php';
					} else if ($_GET['id'] == "pss") {
						include $_GET['id2'] . '/pss.php';
					} else if ($_GET['id'] == "pss1") {
						include $_GET['id2'] . '/pss1.php';
					} else if ($_GET['id'] == "pattemptauditt") {
						include $_GET['id2'] . '/pattemptauditt.php';
					} else if ($_GET['id'] == "viewspec1") {
						include $_GET['id2'] . '/viewspec1.php';
					} else if ($_GET['id'] == "ps-edit") {
						include $_GET['id2'] . '/edit_productspec.php';
					} else if ($_GET['id'] == "deletemicro") {
						include $_GET['id2'] . '/deletemicro.php';
					} else if ($_GET['id'] == "addmicro") {
						include $_GET['id2'] . '/addmicro.php';
					} else if ($_GET['id'] == "ppm2") {
						include 'ppm2.php';
					} else if ($_GET['id'] == "ppm3") {
						include 'ppm3.php';
					} else if ($_GET['id'] == "viewppm") {
						include 'viewppm.php';
					} else if ($_GET['id'] == 'techdoc') {
						include 'techdoc.php';
					} else if ($_GET['id'] == 'techdoc1') {
						include 'techdoc1.php';
					} else if ($_GET['id'] == 'verifyaudit') {
						include 'verifyaudit.php';
					} else if ($_GET['id'] == 'ncvieww') {
						include 'ncvieww.php';
					} else if ($_GET['id'] == 'gmpnc3') {
						include 'gmpnc3.php';
					} else if ($_GET['id'] == "deptmgmt") {
						include 'deptmgmt.php';
					} else if ($_GET['id'] == "adddept") {
						include 'adddept.php';
					} else if ($_GET['id'] == "supplier-management") {
						include 'rmservice/service_supplier_issue.php';
					} else if ($_GET['id'] == "add_service_supplier_issues") {
						include 'rmservice/add_service_supplier.php';
					} else if ($_GET['id'] == "supplier_view") {
						include 'rmservice/service_supplier_view.php';
					} else if ($_GET['id'] == "supplier_edit") {
						include 'rmservice/service_supplier_edit.php';
					} elseif ($_GET['id'] == "question") {
						include 'rmservice/assesment.php';
					} elseif ($_GET['id'] == "question-add") {
						include 'rmservice/assesment_add.php';
					} elseif ($_GET['id'] == "question-edit") {
						include 'rmservice/assesment_edit.php';
					} elseif ($_GET['id'] == "vulner") {
						include 'rmservice/vulner_asessment.php';
					} elseif ($_GET['id'] == "risk") {
						include 'rmservice/risk_assesment.php';
					} elseif ($_GET['id'] == "assesmentprod") {
						include 'rmservice/assesment-product.php';
					} elseif ($_GET['id'] == "assesmentvulner") {
						include 'rmservice/assesment-details.php';
					} elseif ($_GET['id'] == "assesmentrisk") {
						include 'rmservice/assesment-detailr.php';
					}


					//remperature checks




					// supplier monitoring

					elseif ($_GET['id'] == "manage-complaint") {
						include 'rmservice/complaintmgmt.php';
					} elseif ($_GET['id'] == "viewsuppliercomplaint") {
						include 'rmservice/viewcomplaintdetail.php';
					} elseif ($_GET['id'] == "complaintadd") {
						include 'rmservice/CFB.php';
					} elseif ($_GET['id'] == "complaint-analysis") {
						include 'rmservice/complaint_analysis.php';
					} elseif ($_GET['id'] == "service-analysis") {
						include 'rmservice/complaint_analysis-service.php';
					}
					//
					else if ($_GET['id'] == "alertsmgmt") {
						include 'alertsmgmt.php';
					} else if ($_GET['id'] == "uploadcert1") {
						include 'uploadcert1.php';
					} else if ($_GET['id'] == "uploadcert") {
						include 'uploadcert.php';
					} else if ($_GET['id'] == "savesignature") {
						include 'savesignature.php';
					} else if ($_GET['id'] == "savesignature1") {
						include 'savesignature1.php';
					} else if ($_GET['id'] == "isavesignature") {
						include 'isavesignature.php';
					} else if ($_GET['id'] == "isavesignature1") {
						include 'isavesignature1.php';
					}


					// meeting review meeting
					elseif ($_GET['id'] == "monthly_review") {
						include 'monthly_meeting.php';
					} elseif ($_GET['id'] == "monthly_review_add") {
						include 'monthly_meeting_add.php';
					} elseif ($_GET['id'] == "monthly_review_report") {
						include 'monthly_review_report.php';
					} elseif ($_GET['id'] == "meeting_attendee") {
						include 'meeting_attendee.php';
					} elseif ($_GET['id'] == "meeting_attendee_add") {
						include 'meeting_attendee_add.php';
					} elseif ($_GET['id'] == "meeting_attendee_edit") {
						include 'meeting_attendee_edit.php';
					}





					/// ml meats daily checks
					else if ($_GET['id'] == 'dailycheckksdetail') {
						include $_GET['id2'] . '/dailychecksdetail.php';
					} else if ($_GET['id'] == 'dailycheckks') {
						include $_GET['id2'] . '/dailychecks.php';
					} else if ($_GET['id'] == 'dailycheckks1') {
						include $_GET['id2'] . '/dailychecks1.php';
					} else if ($_GET['id'] == 'dailycheckks3') {
						include $_GET['id2'] . '/dailychecks3.php';
					} else if ($_GET['id'] == 'dailycheckkss') {
						include $_GET['id2'] . '/dailycheckss.php';
					} else if ($_GET['id'] == 'closingcheckks1') {
						include $_GET['id2'] . '/closingchecks1.php';
					} else if ($_GET['id'] == 'dailycheckks4') {
						include  $_GET['id2'] . '/dailychecks4.php';
					}













					//upload daily checks

					else if ($_GET['id'] == 'dailychecksview') {
						include 'dailycheck_main.php';
					} else if ($_GET['id'] == 'dailychecksadd') {
						include  'dailycheck_add.php';
					} else if ($_GET['id'] == 'dailyviewques') {
						include  'dailyviewques.php';
					} else if ($_GET['id'] == 'dailycheckedit') {
						include  'dailycheckedit.php';
					}
					//end daily checks



					else if ($_GET['id'] == 'email_tracking') {
						include  'emailtracking/email.php';
					} else if ($_GET['id'] == 'email_tracking_add') {
						include 'emailtracking/email_add.php';
					} else if ($_GET['id'] == 'email_followup') {
						include 'emailtracking/followup.php';
					} else if ($_GET['id'] == 'email_follow') {
						include 'emailtracking/email_follow.php';
					} else if ($_GET['id'] == 'email_view') {
						include 'emailtracking/email_view.php';
					} else if ($_GET['id'] == 'email_close') {
						include 'emailtracking/email_close.php';
					} else if ($_GET['id'] == 'email_comment') {
						include 'emailtracking/comment.php';
					}


					//product
					else if ($_GET['id'] == 'productspec_detail') {
						include 'productspec_main.php';
					} else if ($_GET['id'] == 'productspec_add') {
						include  'productspec_add.php';
					} else if ($_GET['id'] == 'productspecviewques') {
						include  'productspec_viewques.php';
					} else if ($_GET['id'] == 'productspecedit') {
						include  'productspec_edit.php';
					} else if ($_GET['id'] == 'dashboardnew') {
						include  'dashboardnew.php';
					}









					//product specification jd meat

					else if ($_GET['id'] == "jdps") {
						include $_GET['id2'] . '/ps.php';
					} else if ($_GET['id'] == "jdps1") {
						include $_GET['id2'] . '/productsection.php';
					} else if ($_GET['id'] == "jdpattemptaudit") {
						include $_GET['id2'] . '/pattemptaudit.php';
					} else if ($_GET['id'] == "jdpss") {
						include $_GET['id2'] . '/pss.php';
					} else if ($_GET['id'] == "jdpss1") {
						include $_GET['id2'] . '/pss1.php';
					} else if ($_GET['id'] == "jdpattemptauditt") {
						include $_GET['id2'] . '/pattemptauditt.php';
					} else if ($_GET['id'] == "jdviewspec1") {
						include $_GET['id2'] . '/viewspec1.php';
					}


					//product

					elseif ($_GET['id'] == "products") {
						include 'products.php';
					} elseif ($_GET['id'] == "products_add") {
						include 'products_add.php';
					} elseif ($_GET['id'] == "products_edit") {
						include 'products_edit.php';
					}
					//trucks checks

					elseif ($_GET['id'] == "trcheck") {
						include 'truckchecks/tchecks.php';
					} elseif ($_GET['id'] == "trcheck_add") {
						include 'truckchecks/tchecks_add.php';
					} elseif ($_GET['id'] == "trcheck_view") {
						include 'truckchecks/tchecks_view.php';
					}
					//complaint trend
					elseif ($_GET['id'] == "complaint-trending") {
						include 'complaint-trending.php';
					} elseif ($_GET['id'] == "complaint-trending-year") {
						include 'complaint-trending-year.php';
					} else if ($_GET['id'] == 'complaint-trending1') {
						include 'complaint-trending1.php';
					}

					//atp result

					else if ($_GET['id'] == 'atpresult') {
						include 'atpresult.php';
					} else if ($_GET['id'] == 'atpresult1') {
						include 'atpresult1.php';
					} else if ($_GET['id'] == 'viewatp') {
						include 'aptresultview.php';
					} else if ($_GET['id'] == 'psdtaskview') {
						include 'psdtask.php';
					}

					// // changes raw & complaint

					// else if ($_GET['id'] == 'viewrawspecs') {
					// 	include 'viewrawspec.php';
					// } else if ($_GET['id'] == 'uploadrawspec') {
					// 	include 'viewrawspec.php';
					// } else if ($_GET['id'] == 'rawspecdetail') {
					// 	include 'rawspecdetail.php';
					// }

					//visitor report
					else if ($_GET['id'] == 'visitortrending') {
						include 'visitortrending.php';
					} else if ($_GET['id'] == 'rawmaterial_view') {
						include 'rawmaterial_view.php';
					}


					//production area

					// else if ($_GET['id'] == 'precord') {
					// 	include 'prodicu/recordpro.php';
					// } 
					// else if ($_GET['id'] == 'precord') {
					// 	include 'chokdee/precord.php';
					// }
					//  else if ($_GET['id'] == 'defrost') {
					// 	include 'prodicu/defrostadd.php';
					// } else if ($_GET['id'] == 'defrost1') {
					// 	include 'prodicu/defrost.php';
					// } else if ($_GET['id'] == 'freeze') {
					// 	include 'prodicu/freeze.php';
					// } else if ($_GET['id'] == 'freeze1') {
					// 	include 'prodicu/freezeadd.php';
					// } 

					else if ($_GET['id'] == 'plasterr1') {
						include 'prodicu/plasteradd.php';
					} else if ($_GET['id'] == 'plasterr') {
						include 'prodicu/plaster.php';
					}
					//icu PDF

					// else if ($_GET['id'] == 'freezepdf1') {
					// 	include 'prodicu/freezepdf.php';
					// } else if ($_GET['id'] == 'plasterpdf') {
					// 	include 'prodicu/plasterpdf.php';
					// } else if ($_GET['id'] == 'defrostpdf') {
					// 	include 'prodicu/defrostpdf.php';
					// } else if ($_GET['id'] == 'plasterpdf') {
					// 	include 'prodicu/plasterpdf.php';
					// }


					//ml meats production record

					// //plaster
					// else if ($_GET['id'] == 'productionrecord') {
					// 	include 'production/recordpro.php';
					// } else if ($_GET['id'] == 'plaster') {
					// 	include 'production/plaster.php';
					// } else if ($_GET['id'] == 'plaster1') {
					// 	include 'production/plaster1.php';
					// } else if ($_GET['id'] == 'metal1') {
					// 	include 'production/metal1.php';
					// } else if ($_GET['id'] == 'metal') {
					// 	include 'production/metal.php';
					// }

					// //mlmeats

					// else if ($_GET['id'] == 'mlmeats') {
					// 	include 'production/mlmeatss.php';
					// } else if ($_GET['id'] == 'mlmeats1') {
					// 	include 'production/mlmeatss1.php';
					// } else if ($_GET['id'] == 'mldetect') {
					// 	include 'production/mldetect.php';
					// } else if ($_GET['id'] == 'mldetect1') {
					// 	include 'production/mldetect1.php';
					// }


					//raw material specification
					else if ($_GET['id'] == 'viewrawspec') {
						include 'viewrawspec.php';
					} else if ($_GET['id'] == 'uploadrawspecs') {
						include 'uploadrawspec.php';
					} else if ($_GET['id'] == 'rawspecdetail') {
						include 'rawspecdetail.php';
					} else if ($_GET['id'] == 'rawmaterial_view') {
						include 'rawmaterial_view.php';
					}







					//production record


					else if ($_GET['id'] == 'precord') {
						include 'precord/precord.php';
					}
					//delivery note

					else if ($_GET['id'] == 'delivernote_add') {
						include 'precord/deliverynoteadd.php';
					} else if ($_GET['id'] == 'deliverynote') {
						include 'precord/deliveryview.php';
					} else if ($_GET['id'] == 'delivery') {
						include 'precord/delivery1.php';
					} else if ($_GET['id'] == 'delivery') {
						include 'precord/dispatch_sign.php';
					}

					//plaster record
					else if ($_GET['id'] == 'plaster1') {
						include 'precord/plasteradd.php';
					} else if ($_GET['id'] == 'plaster') {
						include 'precord/plaster.php';
					} else if ($_GET['id'] == 'plasterpdf') {
						include 'precord/plasterpdf.php';
					} else if ($_GET['id'] == 'dispatch_sign') {
						include 'precord/dispatch_sign.php';
					}





					//delivery note
					// else if ($_GET['id'] == 'plaster1') {
					// 	include 'precord/plasteradd.php';
					// } else if ($_GET['id'] == 'plaster') {
					// 	include 'precord/plaster.php';
					// } else if ($_GET['id'] == 'plasterpdf') {
					// 	include 'precord/plasterpdf.php';
					// } 


					else if ($_GET['id'] == 'dispatch') {
						include 'precord/dispatch.php';
					} else if ($_GET['id'] == 'dispatchpdf') {
						include 'precord/dispatchpdf.php';
					} else if ($_GET['id'] == 'dlog_sign') {
						include 'precord/dlog_sign.php';
					} else if ($_GET['id'] == 'dispatchadd') {
						include 'precord/dispatchlogform.php';
					}

					//prob
					else if ($_GET['id'] == 'prob') {
						include 'precord/prob.php';
					} else if ($_GET['id'] == 'probadd') {
						include 'precord/probadd.php';
					} else if ($_GET['id'] == 'probpdf') {
						include 'precord/probpdf.php';
					} else if ($_GET['id'] == 'probdate') {
						include 'precord/probdate.php';
					} else if ($_GET['id'] == 'probsign') {
						include 'precord/probsign.php';
					}

					//scale

					else if ($_GET['id'] == 'scale') {
						include 'precord/scale.php';
					} else if ($_GET['id'] == 'scale1') {
						include 'precord/scale1.php';
					} else if ($_GET['id'] == 'scaleadd') {
						include 'precord/scaleadd.php';
					} else if ($_GET['id'] == 'scalepdf') {
						include 'precord/scalepdf.php';
					} else if ($_GET['id'] == 'scaleverify') {
						include 'precord/scalevpdf.php';
					} else if ($_GET['id'] == 'scalesign1') {
						include 'precord/scalesign1.php';
					}


					//deliverylog

					else if ($_GET['id'] == 'deliverylogadd') {
						include 'precord/deliverylogadd.php';
					} else if ($_GET['id'] == 'deliverylog') {
						include 'precord/deliverylog.php';
					} else if ($_GET['id'] == 'deliverylogpdf') {
						include 'precord/deliverylogpdf.php';
					} else if ($_GET['id'] == 'signature') {
						include 'precord/upsign.php';
					} else if ($_GET['id'] == 'dailysign') {
						include 'precord/dailysign.php';
					}





					//site visit
					else if ($_GET['id'] == 'sitevisit') {
						include 'sitevisit.php';
					} else if ($_GET['id'] == 'sitevisit3') {
						include 'sitevisit3.php';
					}


					//sauce first one is sauce
					else if ($_GET['id'] == 'sauce') {
						include 'precord/sauce.php';
					} else if ($_GET['id'] == 'saucedate') {
						include 'precord/saucedate.php';
					} else if ($_GET['id'] == 'sauceadd') {
						include 'precord/sauceadd.php';
					} else if ($_GET['id'] == 'sauceform1') {
						include 'precord/sauceform1.php';
					} else if ($_GET['id'] == 'sauceform2') {
						include 'precord/sauceform2.php';
					} else if ($_GET['id'] == 'saucesign') {
						include 'precord/saucesign.php';
					} else if ($_GET['id'] == 'verify_sauce') {
						include 'precord/sauce_verify.php';
					} else if ($_GET['id'] == 'saucepdf') {
						include 'precord/saucepdf.php';
					}

					//oven 
					else if ($_GET['id'] == 'oven') {
						include 'precord/oven.php';
					} else if ($_GET['id'] == 'ovenform') {
						include 'precord/ovenform.php';
					} else if ($_GET['id'] == 'ovenform1') {
						include 'precord/ovenform1.php';
					} else if ($_GET['id'] == 'ovenform2') {
						include 'precord/ovenform2.php';
					} else if ($_GET['id'] == 'ovendate') {
						include 'precord/ovendate.php';
					} else if ($_GET['id'] == 'ovenpdf') {
						include 'precord/ovenpdf.php';
					}

					//ovensign
					else if ($_GET['id'] == 'ovensign') {
						include 'precord/ovensign.php';
					} else if ($_GET['id'] == 'ovendate') {
						include 'precord/ovendate.php';
					}
					//ovenverify
					else if ($_GET['id'] == 'ovenverify') {
						include 'precord/ovenverify.php';
					}


					//hotsouce
					else if ($_GET['id'] == 'hotdate') {
						include 'precord/hotdate.php';
					} else if ($_GET['id'] == 'hotsauce') {
						include 'precord/hotsauce.php';
					} else if ($_GET['id'] == 'hotsauceform') {
						include 'precord/hotsauceform.php';
					} else if ($_GET['id'] == 'hotsaucepdf') {
						include 'precord/hotsaucepdf.php';
					} else if ($_GET['id'] == 'hotform1') {
						include 'precord/hotform1.php';
					} else if ($_GET['id'] == 'hotform2') {
						include 'precord/hotform2.php';
					} else if ($_GET['id'] == 'hotsign') {
						include 'precord/hotsign.php';
					} else if ($_GET['id'] == 'shot') {
						include 'precord/shot.php';
					} else if ($_GET['id'] == 'verify_hot') {
						include 'precord/verify_hot.php';
					}

					//hotpdf

					else if ($_GET['id'] == 'hotpdf') {
						include 'precord/hotpdf.php';
					}

					//weight
					else if ($_GET['id'] == 'weight') {
						include 'precord/weight.php';
					} else if ($_GET['id'] == 'weightform') {
						include 'precord/weightadd.php';
					} else if ($_GET['id'] == 'weightsign') {
						include 'precord/weightsign.php';
					} else if ($_GET['id'] == 'wheights') {
						include 'precord/weights.php';
					} else if ($_GET['id'] == 'weightpdf') {
						include 'precord/weightpdf.php';
					} else if ($_GET['id'] == 'addweight') {
						include 'precord/addweight.php';
					} else if ($_GET['id'] == 'mweight') {
						include 'precord/mweight.php';
					}
					//weightdate
					else if ($_GET['id'] == 'weightdate') {
						include 'precord/weightdate.php';
					}


					//blast

					else if ($_GET['id'] == 'blastform') {
						include 'precord/blastform.php';
					} else if ($_GET['id'] == 'blastform2') {
						include 'precord/blastform2.php';
					} else if ($_GET['id'] == 'blast') {
						include 'precord/blast.php';
					} else if ($_GET['id'] == 'blastpdf') {
						include 'precord/blastpdf.php';
					} else if ($_GET['id'] == 'blastdate') {
						include 'precord/blastdate.php';
					}

					//blastsign
					else if ($_GET['id'] == 'blastsign') {
						include 'precord/blastsign.php';
					} else if ($_GET['id'] == 'verifysign') {
						include 'precord/bverifysign.php';
					} else if ($_GET['id'] == 'verifyreport') {
						include 'precord/verifyreport.php';
					}
					//other
					else if ($_GET['id'] == 'fryeroil') {
						include 'precord/fryoildate.php';
					} else if ($_GET['id'] == 'fryeroil1') {
						include 'precord/fryoil.php';
					} else if ($_GET['id'] == 'fryeroiladd') {
						include 'precord/fryoildateadd.php';
					} else if ($_GET['id'] == 'fryeroilpdf') {
						include 'precord/fryeroilpdf.php';
					} else if ($_GET['id'] == 'fryeroilsign') {
						include 'precord/fryoilsign.php';
					}


					//

					else if ($_GET['id'] == 'verifysign') {
						include 'precord/bverifysign.php';
					} else if ($_GET['id'] == 'verifyreport') {
						include 'precord/verifyreport.php';
					}

					// dailycheck Kpi


					else if ($_GET['id'] == 'daily') {
						include 'marsh/daily.php';
					} else if ($_GET['id'] == 'viewdaily') {
						include 'marsh/viewdaily.php';
					} else if ($_GET['id'] == 'viewpdf') {
						include 'marsh/viewpdf.php';
					} else if ($_GET['id'] == 'daily1') {
						include 'marsh/daily1.php';
					}










					//sauce first one is sauce




					//daily temperature check

					//plaster record mlmeat

					// else if ($_GET['id'] == 'plaster11') {

					// 	include 'precord/plaster.php';

					// } else if ($_GET['id'] == 'plaster2') {

					// 	include 'precord/plaster1.php';

					// } else if ($_GET['id'] == 'metal11') {

					// 	include 'precord/metal1.php';

					// } else if ($_GET['id'] == 'metal2') {

					// 	include 'precord/metal.php';

					// }

					//plastermetalsign

					//  else if ($_GET['id'] == 'psign2') {

					// 	include 'precord/psign.php';

					// }

					//mlmeats

					// else if ($_GET['id'] == 'mlmeats') {

					// 	include 'precord/mlmeatss.php';

					// } else if ($_GET['id'] == 'mlmeats1') {

					// 	include 'precord/mlmeatss1.php';

					// } else if ($_GET['id'] == 'mldetect') {

					// 	include 'precord/mldetect.php';

					// } else if ($_GET['id'] == 'mldetect1') {

					// 	include 'precord/mldetect1.php';

					// }

					//pdf

					// else if ($_GET['id'] == 'plasterpdf1') {

					// 	include 'precord/plasterpdf1.php';

					// } else if ($_GET['id'] == 'mlmeatspdf') {

					// 	include 'precord/mlmeatspdf.php';

					// }



					//     else if ($_GET['id'] == 'sign') {
					// 	include 'precord/sign.php';
					// }
					//  else if ($_GET['id'] == 'sign2') {
					// 	include 'precord/sign2.php';
					// }

					//mlmeat production record end





					// potato usage
					else if ($_GET['id'] == "Prodrecord") {
						include 'tracemp/precord.php';
					} else if ($_GET['id'] == "potatousage") {
						include 'tracemp/marination.php';
					} else if ($_GET['id'] == "addpusage") {
						include 'tracemp/addmarination.php';
					} else if ($_GET['id'] == "addpusage1") {
						include 'tracemp/addmarination1.php';
					} else if ($_GET['id'] == "viewmarination") {
						include 'tracemp/viewmarination.php';
					} else if ($_GET['id'] == "addptusage") {
						include 'tracemp/addmarinationn1.php';
					} else if ($_GET['id'] == "ptwaste") {
						include 'tracemp/pwastage.php';
					} else if ($_GET['id'] == "packadd2") {
						include 'tracemp/packadd2.php';
					}
					// Frying information

					else if ($_GET['id'] == "fryrecord") {
						include 'tracemp/fryrecord.php';
					} else if ($_GET['id'] == "addfryinfo") {
						include 'tracemp/addfryinfo.php';
					} else if ($_GET['id'] == "addfryinfo1") {
						include 'tracemp/addfryinfo1.php';
					} else if ($_GET['id'] == "viewmarination") {
						include 'tracemp/viewmarination.php';
					} else if ($_GET['id'] == "addfryinfo2") {
						include 'tracemp/addfryinfo2.php';
					} else if ($_GET['id'] == "addfryinfo3") {
						include 'tracemp/addfryinfo3.php';
					} else if ($_GET['id'] == "addfryinfo4") {
						include 'tracemp/addfryinfo4.php';
					} else if ($_GET['id'] == "addfryinfo5") {
						include 'tracemp/addfryinfo5.php';
					} else if ($_GET['id'] == "viewfryrecord") {
						include 'tracemp/viewfryrecord.php';
					} else if ($_GET['id'] == "drainoil") {
						include 'tracemp/drainoil.php';
					} else if ($_GET['id'] == "drainoil1") {
						include 'tracemp/drainoil1.php';
					} else if ($_GET['id'] == "clearoil") {
						include 'tracemp/clearoil.php';
					}

					// flavour mixing

					else if ($_GET['id'] == "flavourmix") {
						include 'tracemp/flavourmix.php';
					} else if ($_GET['id'] == "flavouradd") {
						include 'tracemp/flavouradd.php';
					} else if ($_GET['id'] == "flavouradd1") {
						include 'tracemp/flavouradd1.php';
					} else if ($_GET['id'] == "flavouradd2") {
						include 'tracemp/flavouradd2.php';
					} else if ($_GET['id'] == "flavouradd3") {
						include 'tracemp/flavouradd3.php';
					} else if ($_GET['id'] == "viewflavourmix") {
						include 'tracemp/viewmixrecord.php';
					}
					//metal detect
					else if ($_GET['id'] == "metaldetect") {
						include 'tracemp/metal.php';
					} else if ($_GET['id'] == "metald1") {
						include 'tracemp/metal1.php';
					} else if ($_GET['id'] == "metald2") {
						include 'tracemp/metal2.php';
					} else if ($_GET['id'] == "metaldate") {
						include 'tracemp/metaldate.php';
					} else if ($_GET['id'] == "metalcmnt") {
						include 'tracemp/metalcmnt.php';
					} else if ($_GET['id'] == "metalsign") {
						include 'tracemp/metalsign.php';
					}



					// ///weight check
					// else if ($_GET['id'] == "weightcheckadd") {
					// 	include 'tracemp/weightcheckadd.php';
					// } else if ($_GET['id'] == 'weightcheck1') {
					// 	include 'tracemp/weight.php';
					// } else if ($_GET['id'] == 'weightsign') {
					// 	include 'tracemp/weightsign.php';
					// } else if ($_GET['id'] == 'weightpdf') {
					// 	include 'tracemp/weightpdf.php';
					// } else if ($_GET['id'] == 'weightcheckadd2') {
					// 	include 'tracemp/weightcheckadd2.php';
					// } else if ($_GET['id'] == 'mweight') {
					// 	include 'tracemp/mweight.php';
					// }


					// //weightdate
					// else if ($_GET['id'] == 'weightcheck') {
					// 	include 'tracemp/weightdate.php';
					// }
					// ////label

					else if ($_GET['id'] == "package") {
						include 'tracemp/package.php';
					} else if ($_GET['id'] == "addpackage") {
						include 'tracemp/addpackage.php';
					} else if ($_GET['id'] == "packagepdf") {
						include 'tracemp/packagepdf.php';
					} else if ($_GET['id'] == "opsign") {
						include 'tracemp/opsign.php';
					} else if ($_GET['id'] == "packadd") {
						include 'tracemp/packadd.php';
					}


					//outer
					else if ($_GET['id'] == 'outer') {
						include 'tracemp/outer.php';
					} else if ($_GET['id'] == 'outeradd') {
						include 'tracemp/outeradd.php';
					} else if ($_GET['id'] == 'signouter') {
						include 'tracemp/signouter.php';
					} else if ($_GET['id'] == 'outers') {
						include 'tracemp/outers.php';
					} else if ($_GET['id'] == 'outerpdf') {
						include 'tracemp/outerpdf.php';
					} else if ($_GET['id'] == 'addouter') {
						include 'tracemp/addouter.php';
					} else if ($_GET['id'] == 'addouter1') {
						include 'tracemp/addouter1.php';
					} else if ($_GET['id'] == 'mouter') {
						include 'tracemp/mouter.php';
					} else if ($_GET['id'] == 'viewtab') {
						include 'tabview.php';
					}

					//outerdate
					else if ($_GET['id'] == 'outerdate') {
						include 'tracemp/outerdate.php';
					} else if ($_GET['id'] == 'supplier_delist') {
						include 'rmservice/delist.php';
					} else if ($_GET['id'] == 'raw_delist') {
						include 'rmservice/delistraw.php';
					}



					//pest control


					elseif ($_GET['id'] == "Pest_dashboard") {
						include 'pest/pest_dashboard.php';
					} elseif ($_GET['id'] == "Pest") {
						include 'pest/incidence/pest.php';
					} elseif ($_GET['id'] == "Pest_add") {
						include 'pest/incidence/pest_add.php';
					} elseif ($_GET['id'] == "Pest_draft") {
						include 'pest/incidence/pest_draft.php';
					} elseif ($_GET['id'] == "gap") {
						include 'pest/gap/gap.php';
					} elseif ($_GET['id'] == "gap_add") {
						include 'pest/gap/gap_add.php';
					} elseif ($_GET['id'] == "agency_view") {
						include 'pest/agency/agency_view.php';
					} elseif ($_GET['id'] == "agency") {
						include 'pest/agency/agency.php';
					} elseif ($_GET['id'] == "agency_add") {
						include 'pest/agency/agency_add.php';
					} elseif ($_GET['id'] == "agency_active") {
						include 'pest/agency/active.php';
					} elseif ($_GET['id'] == "operator") {
						include 'pest/agency/operator_add.php';
					} elseif ($_GET['id'] == "visit") {
						include 'pest/visit/visit.php';
					} elseif ($_GET['id'] == "visit_add") {
						include 'pest/visit/visit_add.php';
					} elseif ($_GET['id'] == "trend") {
						include 'pest/trend/trend.php';
					}
					//pest end


					elseif ($_GET['id'] == "premedical") {
						include 'premedical_detail.php';
					} elseif ($_GET['id'] == "stockc") {
						include 'precord/stockc.php';
					} elseif ($_GET['id'] == "stockc1") {
						include 'precord/stockc1.php';
					} elseif ($_GET['id'] == "stockc2") {
						include 'precord/stock2.php';
					} elseif ($_GET['id'] == "stockcadd") {
						include 'precord/stockcadd.php';
					} elseif ($_GET['id'] == "dailyattempt") {
						include 'dailyattempted.php';
					} elseif ($_GET['id'] == "rawhalal") {
						include 'rawhalal.php';
					} elseif ($_GET['id'] == "rawhalal2") {
						include 'rawhalal2.php';
					} elseif ($_GET['id'] == "rawhalal1") {
						include 'rawhalal1.php';
					} elseif ($_GET['id'] == "rawhalal3") {
						include 'rawhalal3.php';
					} elseif ($_GET['id'] == "flavouradd4") {
						include 'tracemp/flavouradd4.php';
					} elseif ($_GET['id'] == 'cookingccp') {

						include 'chokdee_precord/cookingccp.php';
					} elseif ($_GET['id'] == 'savouryproduction') {

						include 'chokdee_precord/savouryproduction.php';
					} elseif ($_GET['id'] == 'savouryproduction1') {

						include 'chokdee_precord/savouryproduction1.php';
					} elseif ($_GET['id'] == 'cookingccp1') {

						include 'chokdee_precord/cookingccp1.php';
					} elseif ($_GET['id'] == 'addcookingccp') {

						include 'chokdee_precord/addcookingccp.php';
					} elseif ($_GET['id'] == 'cookingccpreport') {

						include 'chokdee_precord/cookingccpreport.php';
					} elseif ($_GET['id'] == 'cookingccpsignature') {

						include 'chokdee_precord/cookingccpsignature.php';
					} elseif ($_GET['id'] == 'blastchiller') {

						include 'chokdee_precord/blastchiller.php';
					} elseif ($_GET['id'] == 'blastchiller1') {

						include 'chokdee_precord/blastchiller1.php';
					} elseif ($_GET['id'] == 'blastchilleradd') {

						include 'chokdee_precord/blastchilleradd.php';
					} elseif ($_GET['id'] == 'blastchillerreport') {

						include 'chokdee_precord/blastchillerreport.php';
					} elseif ($_GET['id'] == 'blastchillersignature') {

						include 'chokdee_precord/blastchillersignature.php';
					} elseif ($_GET['id'] == 'freezing') {

						include 'chokdee_precord/freezing.php';
					} elseif ($_GET['id'] == 'freezingadd') {

						include 'chokdee_precord/freezingadd.php';
					} elseif ($_GET['id'] == 'freezing1') {

						include 'chokdee_precord/freezing1.php';
					} elseif ($_GET['id'] == 'freezingreport') {

						include 'chokdee_precord/freezingreport.php';
					} elseif ($_GET['id'] == 'freezingsignature') {

						include 'chokdee_precord/freezingsignature.php';
					} elseif ($_GET['id'] == 'addmeatproduction') {

						include 'chokdee_precord/addmeat-production.php';
					} else if ($_GET['id'] == 'wasterecord') {
						include 'precord/wasterecord.php';
					} else if ($_GET['id'] == 'wasterecord1') {
						include 'precord/wasterecord1.php';
					} else if ($_GET['id'] == 'wasterecord3') {
						include 'precord/wasterecordpdf.php';
					} else if ($_GET['id'] == 'wastesign') {
						include 'precord/wastesign.php';
					} else if ($_GET['id'] == 'viewtemp1') {
						include 'viewtemp1.php';
					} else if ($_GET['id'] == 'cookingpdf') {
						include 'cookingpdf.php';
					} else if ($_GET['id'] == 'addcookingtemp') {
						include 'addcookingtemp.php';
					}

					//vehicle delivery
					else if ($_GET['id'] == 'vehicledelivery') {
						include 'precord/vehicledelivery.php';
					} else if ($_GET['id'] == 'vehicledelivery1') {
						include 'precord/vehicledelivery1.php';
					} else if ($_GET['id'] == 'deliverysignx') {
						include 'precord/vehiclesignx.php';
					} else if ($_GET['id'] == 'vehicledeliverypdf') {
						include "precord/vehicledeliverypdf.php";
					} else if ($_GET['id'] == 'vehicledelivery2') {
						include 'precord/vehicledelivery2.php';
					} else if ($_GET['id'] == 'managersign') {
						include 'precord/managersign.php';
					}


					//body work

					else if ($_GET['id'] == 'Vehiclebody') {
						include 'precord/Vehicle.php';
					} else if ($_GET['id'] == 'Vehicleadd') {
						include 'precord/Vehicleadd.php';
					} else if ($_GET['id'] == 'vsign') {
						include 'precord/vsign.php';
					} else if ($_GET['id'] == 'vcsign') {
						include 'precord/vcsign.php';
					} else if ($_GET['id'] == 'Vehiclereport') {
						include 'precord/Vehiclereport.php';
					} elseif ($_GET['id'] == 'viewnclog') {
						include 'viewnclog.php';
					} elseif ($_GET['id'] == 'viewnclog1') {
						include 'viewnclog1.php';
					}
					//section tabs
					elseif ($_GET['id'] == 'sectiontabs') {
						include 'section/sectiontabs.php';
					}
					elseif ($_GET['id'] == 'sectiontabsadd') {
						include 'section/sectiontabsadd.php';
					}elseif ($_GET['id'] == 'sectiontabsview') {
						include 'section/sectiontabsview.php';
					}
					//additional management
					elseif ($_GET['id'] == 'sectionadditional') {
						include 'section/aditionalmanage.php';
					}elseif ($_GET['id'] == 'sectionadditionalview') {
						include 'section/viewaddmanage.php';
					}
					elseif ($_GET['id'] == 'subsectabsview') {
						include 'section/subsectabsview.php';
					}
					elseif ($_GET['id'] == 'subsectabsadd') {
						include 'section/subsectabsadd.php';
					}


					//user certificate
					elseif ($_GET['id'] == 'usercertificate') {
						include 'usercertificate.php';
					}
					elseif ($_GET['id'] == 'usermgmt') {
						include 'usermgmt.php';
						
					}
					elseif ($_GET['id'] == 'userviewc') {
						include 'userviewc.php';
					}elseif ($_GET['id'] == 'userviewc1') {
						include 'userviewc1.php';
					}elseif ($_GET['id'] == 'kpipdf') {
						include 'KPI/KPIpdf.php';
					}
					elseif ($_GET['id'] == 'staffreport') {
						include 'staffreport.php';
					}
					?>

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
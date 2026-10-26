<?php 
date_default_timezone_set("Europe/London");
include 'connection.php';
session_start();

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
				<!-- User avatar dropdown -->
				<div class="dropdown">
					<div class="user col align-self-end">
						<i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome:
							<?php echo $user; ?> (<?php echo $access; ?>)</i>
					</div>
				</div>
			</div>
		</div>

		<div class="side-content-wrap">
			<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">

				<ul class="navigation-left">
					<li class="nav-item active"><a class="nav-item-hold" href="admin.php?id=1"><i class="fa fa-list"
								style="font-size:34px; color:pink;"></i><span class="nav-text">Dashboard</span></a>
						<div class="triangle"></div>
					</li>
					<li class="nav-item" data-item="section"><a class="nav-item-hold" href="#"><i class="fa fa-list"
								style="font-size:34px; color:#188BB1"></i><span class="nav-text">Section
								Management</span></a>
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
							<li class="nav-item active"><a class="nav-item-hold" href="<?php echo $qr['weblink']; ?>"><i
										class="fa fa-list" style="font-size:34px; color:<?php echo $qr['color']; ?>"></i><span
										class="nav-text">
										<?php echo $qr['name']; ?> <?php echo $qr['name1']; ?></span></a>
								<div class="triangle"></div>
							</li>

					<?PHP
						}
					}
					?>

					<li class="nav-item"><a class="nav-item-hold" href="logged.php"><i class="fa fa-sign-out"
								style="font-size:34px; color:#990000"></i><span class="nav-text">Log Out</span></a>
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
						<li class="nav-item dropdown-sidemenu"><a href=""><i class="fa fa-list"
									style="font-size:18px; margin-left: 5px;color:#188BB1"></i><span class="item-name"
									style="font-size:14px; margin-left: 5px;">Section
									<?php echo $secdata['testid']; ?></span>
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
									<li><a href="admin.php?id=sectiontabs&ssid=<?php echo $ssid; ?>">Section
											<?php echo $subcdata['sid']; ?></a></li>
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
				} else if ($_GET['id'] == 'viewdailychecks') {
					include 'viewdailychecks.php';
				} else if ($_GET['id'] == 'viewdailychecks1') {
					include 'viewdailychecks1.php';
				} else if ($_GET['id'] == 'dailychecksadd') {
					include 'dailycheck_add.php';
				} else if ($_GET['id'] == 'dailyviewques') {
					include 'dailyviewques.php';
				} else if ($_GET['id'] == 'dailycheckedit') {
					include 'dailycheckedit.php';
				} else if ($_GET['id'] == 'checkmachine') {
					include 'checkmachine.php';
				}
				//upload daily checks
				else if ($_GET['id'] == 'dailychecksview') {
					include 'dailycheck_main.php';
				} else if ($_GET['id'] == 'dailychecksadd') {
					include 'dailycheck_add.php';
				} else if ($_GET['id'] == 'dailyviewques') {
					include 'dailyviewques.php';
				} else if ($_GET['id'] == 'dailycheckedit') {
					include 'dailycheckedit.php';
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
				}
				//
				else if ($_GET['id'] == 'ppm') {
					include 'ppm.php';
				} else if ($_GET['id'] == 'ppm1') {
					include 'ppm1.php';
				} else if ($_GET['id'] == 'ppmmgmt') {
					include 'ppmmgmt.php';
				} else if ($_GET['id'] == 'addppm') {
					include 'addppm.php';
				} else if ($_GET['id'] == 'ppmreport') {
					include 'ppmreport.php';
				} else if ($_GET['id'] == 'machineverify') {
					include 'machineverify.php';
				} else if ($_GET['id'] == 'mverify') {
					include 'mverify.php';
				} else if ($_GET['id'] == 'ppmraise') {
					include 'ppmraise.php';
				} else if ($_GET['id'] == 'addraise') {
					include 'addraise.php';
				} else if ($_GET['id'] == 'ppmraise1') {
					include 'ppmraise1.php';
				} else if ($_GET['id'] == 'raise1') {
					include 'raise1.php';
				} else if ($_GET['id'] == 'raisesign') {
					include 'raisesign.php';
				} else if ($_GET['id'] == 'raiseverify') {
					include 'raiseverify.php';
				} else if ($_GET['id'] == 'raisereport') {
					include 'raisereport.php';
				} else if ($_GET['id'] == 'raisereport1') {
					include 'raisereport1.php';
				} else if ($_GET['id'] == 'raisereportverify') {
					include 'raisereportverify.php';
				} else if ($_GET['id'] == 'ppmdash') {
					include 'ppm/ppmdash.php';
				} else if ($_GET['id'] == 'mrequest') {
					include 'ppm/mrequest.php';
				} else if ($_GET['id'] == 'mcomplete') {
					include 'ppm/mcomplete.php';
				} else if ($_GET['id'] == 'upcommingppm') {
					include 'ppm/upcommingppm.php';
				} else if ($_GET['id'] == 'overdueppm') {
					include 'ppm/overdueppm.php';
				} else if ($_GET['id'] == 'ppmtrending') {
					include 'ppm/ppmtrending.php';
				} else if ($_GET['id'] == 'ppmraiseview') {
					include 'ppm/ppmraiseview.php';
				} else if ($_GET['id'] == 'mcomplete1') {
					include 'ppm/mcomplete1.php';
				} else if ($_GET['id'] == 'mcompview') {
					include 'ppm/mcompview.php';
				} else if ($_GET['id'] == 'rcomplete1') {
					include 'ppm/rcomplete1.php';
				} else if ($_GET['id'] == 'rcompview') {
					include 'ppm/rcompview.php';
				} else if ($_GET['id'] == 'ppmtrending1') {
					include 'ppm/ppmtrending1.php';
				} else if ($_GET['id'] == 'ppmtrendings') {
					include 'ppmtrendings.php';
				}

				//
				//
				else if ($_GET['id'] == 'uploadspec') {
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
				// marination/
				else if ($_GET['id'] == "marination") {
					include 'marination/marination.php';
				} else if ($_GET['id'] == "addmarination") {
					include 'marination/addmarination.php';
				} else if ($_GET['id'] == "addmarination1") {
					include 'marination/addmarination1.php';
				} else if ($_GET['id'] == "viewmarination") {
					include 'marination/viewmarination.php';
				} else if ($_GET['id'] == "addmarinationn1") {
					include 'marination/addmarinationn1.php';
				} else if ($_GET['id'] == "goods1") {
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
				} else if ($_GET['id'] == "pattemptaudits") {
					include $_GET['id2'] . '/pattemptaudits.php';
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
				} else if ($_GET['id'] == "supplier-management1") {
					include 'rmservice/rawsupplier.php';
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

				//temperature checks
				//micro trending 
				elseif ($_GET['id'] == 'microadd') {

					include 'micro/microadd.php';
				} elseif ($_GET['id'] == 'microview') {

					include 'micro/microview.php';
				} elseif ($_GET['id'] == 'microview1') {

					include 'micro/microview1.php';
				} elseif ($_GET['id'] == 'microedit') {

					include 'micro/microedit.php';
				} elseif ($_GET['id'] == 'microtrending') {

					include 'micro/microtrending.php';
				} elseif ($_GET['id'] == 'microtattempt') {

					include 'micro/microtattempt.php';
				} elseif ($_GET['id'] == 'microtrendingview') {

					include 'micro/microtrendingview.php';
				} elseif ($_GET['id'] == 'microassignadd') {

					include 'micro/microassignadd.php';
				} elseif ($_GET['id'] == 'microassign') {

					include 'micro/microassign.php';
				} elseif ($_GET['id'] == 'microtrend') {

					include 'micro/microtrend.php';
				} elseif ($_GET['id'] == 'microtrend1') {

					include 'micro/microtrend2.php';
				} elseif ($_GET['id'] == 'microraise') {

					include 'micro/microraise.php';
				} elseif ($_GET['id'] == 'microsign') {

					include 'micro/microsign.php';
				} elseif ($_GET['id'] == 'microjustify') {

					include 'micro/justification.php';
				}
				//micro trendi 

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


				//upload daily checks
				else if ($_GET['id'] == 'dailychecksview') {
					include 'dailycheck_main.php';
				} else if ($_GET['id'] == 'dailychecksadd') {
					include 'dailycheck_add.php';
				} else if ($_GET['id'] == 'dailyviewques') {
					include 'dailyviewques.php';
				} else if ($_GET['id'] == 'dailycheckedit') {
					include 'dailycheckedit.php';
				}
				//end daily checks
				else if ($_GET['id'] == 'email_tracking') {
					include 'emailtracking/email.php';
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
					include 'productspec_add.php';
				} else if ($_GET['id'] == 'productspecviewques') {
					include 'productspec_viewques.php';
				} else if ($_GET['id'] == 'productspecedit') {
					include 'productspec_edit.php';
				} else if ($_GET['id'] == 'dashboardnew') {
					include 'dashboardnew.php';
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
				else if ($_GET['id'] == '') {
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
					include 'form/weight.php';
				} else if ($_GET['id'] == 'weightadd') {
					include 'form/weightadd.php';
				} else if ($_GET['id'] == 'weightsign') {
					include 'form/weightsign.php';
				} else if ($_GET['id'] == 'weight1') {
					include 'form/weight1.php';
				} else if ($_GET['id'] == 'weightreport') {
					include 'form/weightreport.php';
				} else if ($_GET['id'] == 'weightadd1') {
					include 'form/weightadd1.php';
				} else if ($_GET['id'] == 'weightverify') {
					include 'form/weightverify.php';
				}
				//weightdate
				else if ($_GET['id'] == 'weightdate') {
					include 'form/weightdate.php';
				} else if ($_GET['id'] == 'weightscale') {
					include 'form/weightscale.php';
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





				//	potato usage
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
				//		Frying information
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
				elseif ($_GET['id'] == "dailyattempt") {
					include 'dailyattempted.php';
				} elseif ($_GET['id'] == "dailyattempt1") {
					include 'dailyattempted1.php';
				} else if ($_GET['id'] == 'dailychecksview') {
					include 'dailycheck_main.php';
				} else if ($_GET['id'] == 'dailychecksadd') {
					include 'dailycheck_add.php';
				} else if ($_GET['id'] == 'dailyviewques') {
					include 'dailyviewques.php';
				} else if ($_GET['id'] == 'dailycheckedit') {
					include 'dailycheckedit.php';
				} else if ($_GET['id'] == 'verifysign') {
					include 'verificationsign.php';
				} else if ($_GET['id'] == 'verifysign1') {
					include 'verificationsign1.php';
				} else if ($_GET['id'] == 'verifysign2') {
					include 'verificationsign2.php';
				} else if ($_GET['id'] == 'dailychecksview') {
					include 'dailycheck_main.php';
				} else if ($_GET['id'] == 'dailychecksadd') {
					include 'dailycheck_add.php';
				} else if ($_GET['id'] == 'dailyviewques') {
					include 'dailyviewques.php';
				} else if ($_GET['id'] == 'dailycheckedit') {
					include 'dailycheckedit.php';
				} else if ($_GET['id'] == 'daily') {
					include 'daily.php';
				} else if ($_GET['id'] == 'viewdaily') {
					include 'viewdaily.php';
				} else if ($_GET['id'] == 'viewpdf') {
					include 'viewpdf.php';
				} elseif ($_GET['id'] == "premedical") {
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
				} elseif ($_GET['id'] == 'viewnclogg') {
					include 'viewnclogg.php';
				} elseif ($_GET['id'] == 'viewnclogg1') {
					include 'viewnclogg1.php';
				}
				//section tabs
				elseif ($_GET['id'] == 'sectiontabs') {
					include 'section/sectiontabs.php';
				} elseif ($_GET['id'] == 'sectiontabsadd') {
					include 'section/sectiontabsadd.php';
				} elseif ($_GET['id'] == 'sectiontabsview') {
					include 'section/sectiontabsview.php';
				}
				//additional management
				elseif ($_GET['id'] == 'sectionadditional') {
					include 'section/aditionalmanage.php';
				} elseif ($_GET['id'] == 'sectionadditionalview') {
					include 'section/viewaddmanage.php';
				} elseif ($_GET['id'] == 'subsectabsview') {
					include 'section/subsectabsview.php';
				} elseif ($_GET['id'] == 'subsectabsadd') {
					include 'section/subsectabsadd.php';
				}
				//user certificate
				elseif ($_GET['id'] == 'usercertificate') {
					include 'usercertificate.php';
				} elseif ($_GET['id'] == 'usermgmt') {
					include 'usermgmt.php';
				} elseif ($_GET['id'] == 'userviewpro') {
					include 'userviewpro.php';
				} elseif ($_GET['id'] == 'userviewc') {
					include 'userviewc.php';
				} elseif ($_GET['id'] == 'userviewc1') {
					include 'userviewc1.php';
				} elseif ($_GET['id'] == 'kpireport') {
					include 'KPI/KPIpdf.php';
				} elseif ($_GET['id'] == 'staffreport') {
					include 'staffreport.php';
				} elseif ($_GET['id'] == 'dailycheckallergen') {
					include 'dailycheckallergen.php';
				}


				//raw material delisted
				elseif ($_GET['id'] == 'rawmaterialmgmt') {
					include 'rawmaterialmgmt.php';
				} else if ($_GET['id'] == "supplier-management1") {
					include 'rmservice/rawsupplier.php';
				} elseif ($_GET['id'] == 'rawmateriald') {
					include 'rawmateriald.php';
				} elseif ($_GET['id'] == 'delistsupplier') {
					include 'rmservice/delistsupplier.php';
				} elseif ($_GET['id'] == 'rawmaterialc') {
					include 'rawmaterialc.php';
				} elseif ($_GET['id'] == 'supplierassesment') {
					include 'rmservice/supplierassesment.php';
				} elseif ($_GET['id'] == 'serviceassesment') {
					include 'rmservice/serviceassesment.php';
				} elseif ($_GET['id'] == 'service-detail') {
					include 'rmservice/service-detail.php';
				} elseif ($_GET['id'] == 'supplier-detail') {
					include 'rmservice/supplier-detail.php';
				}


				//sufan form  stationary record
				else if ($_GET['id'] == 'stationary') {

					include 'precord/mldetect1.php';
				} else if ($_GET['id'] == 'stationaryadd') {
					include 'precord/mldetect.php';
				} else if ($_GET['id'] == 'stationarypdf') {

					include 'precord/mlmeatspdf.php';
				} else if ($_GET['id'] == 'ssign') {
					include 'precord/mlsign.php';
				}
				//wastage record
				else if ($_GET['id'] == 'wastage') {
					include 'precord/wastage.php';
				} else if ($_GET['id'] == 'wastage1') {
					include 'precord/wastage1.php';
				} else if ($_GET['id'] == 'wastagepdf') {
					include 'precord/wastagepdf.php';
				} else if ($_GET['id'] == 'wastageview') {
					include 'precord/wastageview.php';
				}

				//ingredient record
				else if ($_GET['id'] == 'ingredient') {
					include 'precord/ingredient.php';
				} else if ($_GET['id'] == 'ingredient1') {
					include 'precord/ingredient1.php';
				} else if ($_GET['id'] == 'ingredientview') {
					include 'precord/ingredientview.php';
				} else if ($_GET['id'] == 'ingredientsign') {
					include 'precord/ingredientsign.php';
				} else if ($_GET['id'] == 'ingredientpdf') {
					include 'precord/ingredientpdf.php';
				}
				//
				else if ($_GET['id'] == 'dustraw') {
					include 'marination/dustraw.php';
				} else if ($_GET['id'] == 'dustraw1') {
					include 'marination/dustraw1.php';
				} else if ($_GET['id'] == 'dailysign1') {
					include 'dailysign1.php';
				} else if ($_GET['id'] == 'dailyverify') {
					include 'dailyverify.php';
				}
				//
				elseif ($_GET['id'] == 'recipe') {
					include 'precord/recipe.php';
				} elseif ($_GET['id'] == 'recipe1') {
					include 'precord/recipe1.php';
				} elseif ($_GET['id'] == 'recipe2') {
					include 'precord/recipe2.php';
				} elseif ($_GET['id'] == 'recipe3') {
					include 'precord/recipe3.php';
				} elseif ($_GET['id'] == 'recipereport') {
					include 'precord/recipereport.php';
				} elseif ($_GET['id'] == 'recipesign') {
					include 'precord/recipesign.php';
				}

				//
				elseif ($_GET['id'] == 'coagoods') {
					include 'goodsin/coagoods.php';
				} elseif ($_GET['id'] == 'machines') {
					include 'precord/machines.php';
				} elseif ($_GET['id'] == 'machines1') {
					include 'precord/machines1.php';
				} elseif ($_GET['id'] == 'machines2') {
					include 'precord/machines2.php';
				} elseif ($_GET['id'] == 'calibrationeq') {
					include 'calibrationeq.php';
				} elseif ($_GET['id'] == 'calibrationeq1') {
					include 'calibrationeq1.php';
				} elseif ($_GET['id'] == 'calibrationeq2') {
					include 'calibrationeq2.php';
				} elseif ($_GET['id'] == 'calibrationeq3') {
					include 'calibrationeq3.php';
				} elseif ($_GET['id'] == 'calibrationeq4') {
					include 'calibrationeqdelist.php';
				} elseif ($_GET['id'] == 'calibrationview') {
					include 'calibrationview.php';
				} elseif ($_GET['id'] == 'calibrationvreport') {
					include 'calibrationvreport.php';
				}


				/// zenbox trace
				elseif ($_GET['id'] == 'zendrecord') {
					include 'zendboxg/record.php';
				} elseif ($_GET['id'] == 'zenpack') {
					include 'zendboxg/pack.php';
				} elseif ($_GET['id'] == 'zenpackadd') {
					include 'zendboxg/packadd.php';
				} elseif ($_GET['id'] == 'zenpackpdf') {
					include 'zendboxg/packpdf.php';
				} elseif ($_GET['id'] == 'zenprod') {
					include 'zendboxg/prod.php';
				} elseif ($_GET['id'] == 'zenprodadd') {
					include 'zendboxg/prodadd.php';
				} elseif ($_GET['id'] == 'zenprodadd1') {
					include 'zendboxg/prodadd1.php';
				} elseif ($_GET['id'] == 'zenprodpdf') {
					include 'zendboxg/prodpdf.php';
				} elseif ($_GET['id'] == 'zenprodseal') {
					include 'zendboxg/seal.php';
				} elseif ($_GET['id'] == 'zendseal') {
					include 'zendboxg/seal.php';
				} elseif ($_GET['id'] == 'zendsealadd') {
					include 'zendboxg/sealadd.php';
				} elseif ($_GET['id'] == 'zendsealpdf') {
					include 'zendboxg/sealpdf.php';
				} elseif ($_GET['id'] == 'zendbox') {
					include 'zendboxg/box.php';
				} elseif ($_GET['id'] == 'zendboxadd') {
					include 'zendboxg/boxadd.php';
				} elseif ($_GET['id'] == 'zendboxpdf') {
					include 'zendboxg/boxpdf.php';
				}

				///product specs
				elseif ($_GET['id'] == 'productspec') {
					include 'productspecs/productspec.php';
				} elseif ($_GET['id'] == 'productspec1') {
					include 'productspecs/productspec1.php';
				} elseif ($_GET['id'] == 'productspec2') {
					include 'productspecs/productspec2.php';
				} elseif ($_GET['id'] == 'productspec3') {
					include 'productspecs/productspec3.php';
				} elseif ($_GET['id'] == 'productspecadd') {
					include 'productspecs/productspecsadd.php';
				} elseif ($_GET['id'] == 'productspecadd1') {
					include 'productspecs/productspecsadd1.php';
				} elseif ($_GET['id'] == 'microbio') {
					include 'productspecs/microbio.php';
				} elseif ($_GET['id'] == 'microbio1') {
					include 'productspecs/microbio1.php';
				} elseif ($_GET['id'] == 'microbio2') {
					include 'productspecs/microbio2.php';
				} elseif ($_GET['id'] == 'prodspec') {
					include 'productspecs/prodspec.php';
				} elseif ($_GET['id'] == 'prodspec1') {
					include 'productspecs/prodspec1.php';
				} elseif ($_GET['id'] == 'prodspec2') {
					include 'productspecs/prodspec2.php';
				} elseif ($_GET['id'] == 'prodspec3') {
					include 'productspecs/prodspec3.php';
				} elseif ($_GET['id'] == 'prodspecview') {
					include 'productspecs/prodspecview.php';
				} elseif ($_GET['id'] == 'prodspecviewr') {
					include 'productspecs/prodspecviewr.php';
				} elseif ($_GET['id'] == 'prodspecr') {
					include 'productspecs/prodspecr.php';
				}

				//
				//internal nc
				else if ($_GET['id'] == "internal_complaintmgmt") {
					include 'internal_complaintmgmt.php';
				} else if ($_GET['id'] == "internal_detailview") {
					include 'internal_detailview.php';
				}

				//glass and plastic
				else if ($_GET['id'] == "glassplasticview") {
					include 'glassplastic/glassplastic.php';
				} else if ($_GET['id'] == "glassplastic1") {
					include 'glassplastic/glassplastic1.php';
				} else if ($_GET['id'] == "glassplastic2") {
					include 'glassplastic/glassplastic2.php';
				} else if ($_GET['id'] == "glassplastic_review") {
					include 'glassplastic/glassplastic_review.php';
				} else if ($_GET['id'] == "glassplastic3") {
					include 'glassplastic/glassplastic3.php';
				} else if ($_GET['id'] == "glasspreport") {
					include 'glassplastic/glassreport.php';
				}

				//internal audit nc
				elseif ($_GET['id'] == 'riskk') {
					include 'risk/risk.php';
				} elseif ($_GET['id'] == 'riskk1') {
					include 'risk/riskk1.php';
				} elseif ($_GET['id'] == 'riskreport') {
					include 'risk/riskreport.php';
				} elseif ($_GET['id'] == 'riskreport1') {
					include 'risk/riskreport1.php';
				} elseif ($_GET['id'] == 'update') {
					include 'risk/update.php';
				} elseif ($_GET['id'] == 'old') {
					include 'risk/old.php';
				}

				//daily raw product
				elseif ($_GET['id'] == 'dailyrawadd') {
					include 'dailyrawadd.php';
				} elseif ($_GET['id'] == 'dailyrawview') {
					include 'dailyrawview.php';
				} elseif ($_GET['id'] == 'dailyrawview1') {
					include 'dailyrawview1.php';
				} elseif ($_GET['id'] == 'dailyrawpdf') {
					include 'dailyrawpdf.php';
				} elseif ($_GET['id'] == 'dailyrawpro') {
					include 'dailyrawpro.php';
				} elseif ($_GET['id'] == 'dailyrawpro1') {
					include 'dailyrawpro1.php';
				} elseif ($_GET['id'] == 'dailyrawpro2') {
					include 'dailyrawpro2.php';
				}

				//// zend reciepe
				else if ($_GET['id'] == "zendrecp") {
					include 'zendboxg/zendrecp.php';
				} else if ($_GET['id'] == "zendrecpadd") {
					include 'zendboxg/zendrecpadd.php';
				} else if ($_GET['id'] == "zendrecpadd1") {
					include 'zendboxg/zendrecpadd1.php';
				} else if ($_GET['id'] == "zendrecpview") {
					include 'zendboxg/zendrecpview.php';
				} else if ($_GET['id'] == "zendrecpaddm") {
					include 'zendboxg/zendrecpaddm.php';
				} else if ($_GET['id'] == "zendrecpreport") {
					include 'zendboxg/zendrecpreport.php';
				} else if ($_GET['id'] == 'dailychecks') {
					include 'dailychecks.php';
				} else if ($_GET['id'] == 'dailychecks1') {
					include 'dailychecks1.php';
				} else if ($_GET['id'] == 'dailychecks3') {
					include 'dailychecks3.php';
				} else if ($_GET['id'] == 'dailycheckss') {
					include 'dailycheckss.php';
				} else if ($_GET['id'] == 'dailytemp') {
					include 'dailytemp.php';
				} else if ($_GET['id'] == 'closingchecks1') {
					include 'closingchecks1.php';
				} else if ($_GET['id'] == 'dailytemp2') {
					include 'dailytemp2.php';
				} else if ($_GET['id'] == 'dailychecks4') {
					include 'dailychecks4.php';
				} else if ($_GET['id'] == 'dailychecksdetail') {
					include 'dailychecksdetail.php';
				} else if ($_GET['id'] == 'over') {
					include 'form/overall/over.php';
				} else if ($_GET['id'] == 'overall') {
					include 'form/overall/overall.php';
				} else if ($_GET['id'] == 'indicator') {
					include 'form/overall/indicator.php';
				} else if ($_GET['id'] == 'indicatoradd') {
					include 'form/overall/indicatoradd.php';
				}


				//paper work

				// elseif ($_GET['id'] == 'pw_qsmetal') {
				// 	include 'paperwork/qsmetal.php';
				// } elseif ($_GET['id'] == 'paperwork') {
				// 	include 'paperwork/paperwork.php';
				// } elseif ($_GET['id'] == 'pw_qsmetaladd') {
				// 	include 'paperwork/qsmetaladd.php';
				// } elseif ($_GET['id'] == 'pw_qsmetalsign') {
				// 	include 'paperwork/qsmetalsign.php';
				// } elseif ($_GET['id'] == 'pw_qsmetalview') {
				// 	include 'paperwork/qsmetalview.php';
				// } elseif ($_GET['id'] == 'pw_qsmetalmanage') {
				// 	include 'paperwork/qsmetalmanage.php';
				// } elseif ($_GET['id'] == 'pw_qsmetalcheckr') {
				// 	include 'paperwork/qsmetalcheckr.php';
				// } elseif ($_GET['id'] == 'pw_scaleing') {
				// 	include 'paperwork/pw_scaleing.php';
				// } elseif ($_GET['id'] == 'pw_scaleingadd') {
				// 	include 'paperwork/pw_scaleingadd.php';
				// } elseif ($_GET['id'] == 'pw_scaleingview') {
				// 	include 'paperwork/pw_scaleingview.php';
				// } elseif ($_GET['id'] == 'pw_scaleingadd1') {
				// 	include 'paperwork/pw_scaleingadd1.php';
				// } elseif ($_GET['id'] == 'pw_scaleingverify') {
				// 	include 'paperwork/pw_scaleingverify.php';
				// } elseif ($_GET['id'] == 'pw_scaleingsign') {
				// 	include 'paperwork/pw_scaleingsign.php';
				// } elseif ($_GET['id'] == 'pw_tempmj') {
				// 	include 'paperwork/pw_tempmj.php';
				// } elseif ($_GET['id'] == 'pw_tempmjadd') {
				// 	include 'paperwork/pw_tempmjadd.php';
				// } elseif ($_GET['id'] == 'pw_tempmjsigns') {
				// 	include 'paperwork/pw_tempmjsigns.php';
				// } elseif ($_GET['id'] == 'pw_tempmjsign') {
				// 	include 'paperwork/pw_tempmjsign.php';
				// } elseif ($_GET['id'] == 'pw_tempmjview') {
				// 	include 'paperwork/pw_tempmjview.php';
				// } elseif ($_GET['id'] == 'pw_tempmjverify') {
				// 	include 'paperwork/pw_tempmjverify.php';
				// } elseif ($_GET['id'] == 'dailycal') {
				// 	include 'dailycal/dailycal.php';
				// } elseif ($_GET['id'] == 'dailycal1') {
				// 	include 'dailycal/dailychecks1.php';
				// } elseif ($_GET['id'] == 'dailycal2') {
				// 	include 'dailycal/closingchecks1.php';
				// } elseif ($_GET['id'] == 'dailycalreportc') {
				// 	include 'dailycal/verificationsign2.php';
				// } elseif ($_GET['id'] == 'dailycalreport') {
				// 	include 'dailycal/verificationsign.php';
				// } elseif ($_GET['id'] == 'calupsign') {
				// 	include 'dailycal/upsign.php';
				// }


				// ///blade checks
				// elseif ($_GET['id'] == 'bladechecks') {
				// 	include 'precord/bladechecks.php';
				// } elseif ($_GET['id'] == 'bladechecksadd') {
				// 	include 'precord/bladechecksadd.php';
				// } elseif ($_GET['id'] == 'bladechecksign') {
				// 	include 'precord/bladechecksign.php';
				// } elseif ($_GET['id'] == 'bladecheckpdf') {
				// 	include 'precord/bladecheckpdf.php';
				// }

				// //distribution mixing
				// elseif ($_GET['id'] == 'dist_mixing') {
				// 	include 'precord/dist_mixing.php';
				// } elseif ($_GET['id'] == 'dist_mixingadd') {
				// 	include 'precord/dist_mixingadd.php';
				// } elseif ($_GET['id'] == 'dist_mixingview') {
				// 	include 'precord/dist_mixingview.php';
				// } elseif ($_GET['id'] == 'dist_mixsign') {
				// 	include 'precord/dist_mixsign.php';
				// } elseif ($_GET['id'] == 'dist_pest') {
				// 	include 'precord/dist_pest.php';
				// } elseif ($_GET['id'] == 'dist_pest1') {
				// 	include 'precord/dist_pest1.php';
				// } elseif ($_GET['id'] == 'dist_filter') {
				// 	include 'precord/dist_filter.php';
				// } elseif ($_GET['id'] == 'dist_filter1') {
				// 	include 'precord/dist_filter1.php';
				// } elseif ($_GET['id'] == 'dist_filtsign') {
				// 	include 'precord/dist_filtsign.php';
				// } elseif ($_GET['id'] == 'dist_homo') {
				// 	include 'precord/dist_homo.php';
				// } elseif ($_GET['id'] == 'dist_cooling') {
				// 	include 'precord/dist_cooling.php';
				// } elseif ($_GET['id'] == 'dist_coolsign') {
				// 	include 'precord/dist_coolsign.php';
				// } elseif ($_GET['id'] == 'dist_mixverify') {
				// 	include 'precord/dist_mixverify.php';
				// } elseif ($_GET['id'] == 'dist_mixreport') {
				// 	include 'precord/dist_mixreport.php';
				// } elseif ($_GET['id'] == 'dist_check') {
				// 	include 'precord/dist_check.php';
				// }


				//miill fepm
				elseif ($_GET['id'] == 'magnate') {
					include 'mill/magnate.php';
				} elseif ($_GET['id'] == 'magnate1') {
					include 'mill/magnate1.php';
				} elseif ($_GET['id'] == 'mmagnate') {
					include 'mill/mmagnate.php';
				} elseif ($_GET['id'] == 'magnatepdf') {
					include 'mill/magnatepdf.php';
				} elseif ($_GET['id'] == 'magnet') {
					include 'mill/magnet.php';
				}


				//merge report
				elseif ($_GET['id'] == 'merge_report') {
					include 'dailycal/merge_report.php';
				} elseif ($_GET['id'] == 'mergesign') {
					include 'dailycal/mergesign.php';
				}

				///
				elseif ($_GET['id'] == 'rawmaterialdata') {
					include 'rawlabel/rawmaterialdata.php';
				} elseif ($_GET['id'] == 'rawmaterialdata1') {
					include 'rawlabel/rawmaterialdata1.php';
				} elseif ($_GET['id'] == 'rawmaterialdata2') {
					include 'rawlabel/rawmaterialdata2.php';
				} elseif ($_GET['id'] == 'rawmaterialdata3') {
					include 'rawlabel/rawmaterialdata3.php';
				} elseif ($_GET['id'] == 'rawmaterialdata4') {
					include 'rawlabel/rawmaterialdata4.php';
				} elseif ($_GET['id'] == 'rawmaterialdata5') {
					include 'rawlabel/rawmaterialdata5.php';
				}

				///// qr view page for goods in 
				else if ($_GET['id'] == 'qrview') {
					include 'goodsin/qrview.php';
				} else if ($_GET['id'] == 'storein') {
					include 'goodsin/storein.php';
				} else if ($_GET['id'] == 'storein1') {
					include 'goodsin/storein1.php';
				}

				// sleve issue
				else if ($_GET['id'] == 'sleeve') {
					include 'form/sleveissue.php';
				} else if ($_GET['id'] == 'sleveissueadd') {
					include 'form/sleveissueadd.php';
				} else if ($_GET['id'] == 'sleveissueadd1') {
					include 'form/sleveissueadd1.php';
				} else if ($_GET['id'] == 'sleveissueadd2') {
					include 'form/sleveissueadd2.php';
				} else if ($_GET['id'] == 'issuersign') {
					include 'form/issuersign.php';
				} else if ($_GET['id'] == 'sleveissueview') {
					include 'form/sleveissueview.php';
				} else if ($_GET['id'] == 'sleveverify') {
					include 'form/sleveverify.php';
				} else if ($_GET['id'] == 'verifysleve') {
					include 'form/verifysleve.php';
				} else if ($_GET['id'] == "form") {
					include 'form/form.php';
				}
				// scale callibration
				else if ($_GET['id'] == "internal") {
					include 'form/internal.php';
				} else if ($_GET['id'] == "addinternal") {
					include 'form/addinternal.php';
				} else if ($_GET['id'] == "internalpdf") {
					include 'form/internalpdf.php';
				} else if ($_GET['id'] == "internaldate") {
					include 'form/internaldate.php';
				} else if ($_GET['id'] == "insign") {
					include 'form/insign.php';
				} else if ($_GET['id'] == 'update1') {
					include 'form/update.php';
				}

				//product inner outer lable
				elseif ($_GET['id'] == 'product1') {
					include 'form/product1.php';
				} elseif ($_GET['id'] == 'product') {
					include 'form/product.php';
				} elseif ($_GET['id'] == 'proview') {
					include 'form/proview.php';
				} elseif ($_GET['id'] == 'prosign') {
					include 'form/mas.php';

					// ORGAN 
				} elseif ($_GET['id'] == 'organ') {
					include 'form/organ.php';
				} elseif ($_GET['id'] == 'organs') {
					include 'form/organs.php';
				} elseif ($_GET['id'] == 'organ1') {
					include 'form/organ1.php';
				} elseif ($_GET['id'] == 'organreport') {
					include 'form/organreport.php';
				}

				// marshwoord yogurt
				// elseif ($_GET['id'] == 'yogurt') {
				// 	include 'form/yogurt.php';
				// } elseif ($_GET['id'] == 'yogurtadd') {
				// 	include 'form/yogurtadd.php';
				// } elseif ($_GET['id'] == 'yogurt1') {
				// 	include 'form/yogurt1.php';
				// } elseif ($_GET['id'] == 'yogurtplaningreport') {
				// 	include 'form/yogurtplaningreport.php';
				// } elseif ($_GET['id'] == 'yogurtview') {
				// 	include 'form/yogurtview.php';
				// } elseif ($_GET['id'] == 'yogurtview1') {
				// 	include 'form/yogurtview1.php';
				// } elseif ($_GET['id'] == 'yogurtproduction') {
				// 	include 'form/production.php';
				// } elseif ($_GET['id'] == 'yogurtproductionadd') {
				// 	include 'form/productionadd.php';
				// } elseif ($_GET['id'] == 'yogurtproduction1') {
				// 	include 'form/yogurtproduction1.php';
				// } elseif ($_GET['id'] == 'yogurtproductionview') {
				// 	include 'form/yogurtproductionview.php';
				// } elseif ($_GET['id'] == 'yogurtreport') {
				// 	include 'form/yogurtreport.php';
				// } elseif ($_GET['id'] == 'yogurtpackaging') {
				// 	include 'form/yogurtpackaging.php';
				// } elseif ($_GET['id'] == 'yogurtpackagingadd') {
				// 	include 'form/yogurtpackagingadd.php';
				// } elseif ($_GET['id'] == 'yogurtpackagingadd') {
				// 	include 'form/yogurtpackagingadd.php';
				// }

				///////////////////////////////
				elseif ($_GET['id'] == 'check') {
					include 'check/check.php';
				} elseif ($_GET['id'] == 'hca') {
					include 'check/hca.php';
				} elseif ($_GET['id'] == 'pack') {
					include 'check/pack.php';
				} elseif ($_GET['id'] == 'cookings') {
					include 'check/cookings.php';
				} elseif ($_GET['id'] == 'qc') {
					include 'check/qc.php';
				} elseif ($_GET['id'] == 'goodsins') {
					include 'check/goodsins.php';
				}

				/// weight 
				elseif ($_GET['id'] == 'weightcontrol') {
					include 'precord/weightcontrol.php';
				} elseif ($_GET['id'] == 'weightcontroladd') {
					include 'precord/weightcontroladd.php';
				} elseif ($_GET['id'] == 'weightcontrol1') {
					include 'precord/weightcontrol1.php';
				} elseif ($_GET['id'] == 'weightcontroladd1') {
					include 'precord/weightcontroladd1.php';
				} elseif ($_GET['id'] == 'weightcontrol2') {
					include 'precord/weightcontrol2.php';
				} elseif ($_GET['id'] == 'weightcontrolend') {
					include 'precord/weightcontrolend.php';
				} elseif ($_GET['id'] == 'weightcontrolsign') {
					include 'precord/weightcontrolsign.php';
				} elseif ($_GET['id'] == 'weightcontrolreport') {
					include 'precord/weightcontrolreport.php';
				} elseif ($_GET['id'] == 'weightcontrolcomment') {
					include 'precord/weightcontrolcomment.php';
				} else if ($_GET['id'] == 'newmetal') {
					include 'precord/newmetal.php';
				} else if ($_GET['id'] == 'newmetal1') {
					include 'precord/newmetal1.php';
				} else if ($_GET['id'] == 'newmetal2') {
					include 'precord/newmetal2.php';
				} else if ($_GET['id'] == 'newmetal3') {
					include 'precord/newmetal3.php';
				} else if ($_GET['id'] == 'newmetalreport') {
					include 'precord/newmetalreport.php';
				} else if ($_GET['id'] == "marination") {
					include 'marination/marination.php';
				} else if ($_GET['id'] == "addmarination") {
					include 'marination/addmarination.php';
				} else if ($_GET['id'] == "addmarination1") {
					include 'marination/addmarination1.php';
				} else if ($_GET['id'] == "viewmarination") {
					include 'marination/viewmarination.php';
					// } else if ($_GET['id'] == "addmarinationn1") {
					// 	include 'marination/addmarinationn1.php';
				} else if ($_GET['id'] == 'dough') {
					include 'precord/dough.php';
				} else if ($_GET['id'] == 'adddough') {
					include 'precord/adddough.php';
				} else if ($_GET['id'] == 'doughpdf') {
					include 'precord/doughpdf.php';
				} elseif ($_GET['id'] == 'doughsign') {
					include 'precord/doughsign.php';
				} elseif ($_GET['id'] == 'dough1') {
					include 'precord/dough1.php';
				} elseif ($_GET['id'] == 'doughsign1') {
					include 'precord/doughsign1.php';
				} elseif ($_GET['id'] == 'check') {
					include 'check/check.php';
				} elseif ($_GET['id'] == 'hca') {
					include 'check/hca.php';
				} elseif ($_GET['id'] == 'pack') {
					include 'check/pack.php';
				} elseif ($_GET['id'] == 'cookings') {
					include 'check/cookings.php';
				} elseif ($_GET['id'] == 'qc') {
					include 'check/qc.php';
				} elseif ($_GET['id'] == 'goodsins') {
					include 'check/goodsins.php';
				}

				// deforest
				else if ($_GET['id'] == 'defrostpdf') {
					include 'defrost/defrostpdf.php';
				} else if ($_GET['id'] == 'defrost') {
					include 'defrost/defrostadd.php';
				} else if ($_GET['id'] == 'defrost1') {
					include 'defrost/defrost.php';
				} else if ($_GET['id'] == 'defrost2') {
					include 'defrost/defrost2.php';
				} else if ($_GET['id'] == 'defrostdate') {
					include 'defrost/defrostdate.php';
				} else if ($_GET['id'] == 'defrostsignature') {
					include 'defrost/defrostsignature.php';
				} else if ($_GET['id'] == 'defrostedit') {
					include 'defrost/defrostedit.php';
					// }else if ($_GET['id'] == 'fscsurvey') {
					// 	include 'test8/fsc-management.php';
				} else if ($_GET['id'] == 'fscsurvey') {
					include 'fscsurvey/fscsurvey.php';
				}

				//critical issue
				else if ($_GET['id'] == "internal_complaintmgmt1") {
					include 'critical/internal_complaintmgmt.php';
				} else if ($_GET['id'] == "internal_detailview1") {
					include 'critical/internal_detailview.php';
				}

				///  frozon product
				else if ($_GET['id'] == "frozen") {
					include 'frozen/frozen.php';
				} else if ($_GET['id'] == "fmarination") {
					include 'frozen/marination.php';
				} else if ($_GET['id'] == "faddmarination") {
					include 'frozen/addmarination.php';
				} else if ($_GET['id'] == "faddmarination1") {
					include 'frozen/addmarination1.php';
				} else if ($_GET['id'] == "fviewmarination") {
					include 'frozen/viewmarination.php';
				} else if ($_GET['id'] == "faddmarinationn1") {
					include 'frozen/addmarinationn1.php';
				} else if ($_GET['id'] == "fstorage") {
					include 'frozen/storage.php';
				} else if ($_GET['id'] == "faddstorage") {
					include 'frozen/addstorage.php';
				} else if ($_GET['id'] == "fproduction") {
					include 'frozen/production.php';
				} else if ($_GET['id'] == "fproduction1") {
					include 'frozen/production1.php';
				} else if ($_GET['id'] == "faddproduction") {
					include 'frozen/addproduction.php';
				} else if ($_GET['id'] == "fcooking") {
					include 'frozen/cooking.php';
				} else if ($_GET['id'] == "fcooking1") {
					include 'frozen/cooking1.php';
				} else if ($_GET['id'] == "fcooking2") {
					include 'frozen/cooking2.php';
				} else if ($_GET['id'] == "fcooling") {
					include 'frozen/cooling.php';
				} else if ($_GET['id'] == "fpacking") {
					include 'frozen/packing.php';
				} else if ($_GET['id'] == "fpacking1") {
					include 'frozen/packing1.php';
				} else if ($_GET['id'] == "fblast") {
					include 'frozen/blast.php';
				} else if ($_GET['id'] == "fblast1") {
					include 'frozen/blast1.php';
				} else if ($_GET['id'] == "fboxing") {
					include 'frozen/boxing.php';
				} else if ($_GET['id'] == "fboxing1") {
					include 'frozen/boxing1.php';
				} else if ($_GET['id'] == "fdispatch") {
					include 'frozen/dispatch.php';
				} else if ($_GET['id'] == "yogurtmccp") {
					include 'yogurtn/yogurtccp.php';
				} else if ($_GET['id'] == "yogurtmweight") {
					include 'yogurtn/yogurtweight.php';
				} else if ($_GET['id'] == "yogurtmlabel") {
					include 'yogurtn/yogurtlabelling.php';
				} else if ($_GET['id'] == "yogurtlsign") {
					include 'yogurtn/yogurtlsign.php';
				} else if ($_GET['id'] == "yogurtmpdf") {
					include 'yogurtn/yogurtpdf.php';
				}



				////fry section in sounas
				else if ($_GET['id'] == "frysection") {
					include 'frysounas/frysection.php';
				} else if ($_GET['id'] == "fryrecp") {
					include 'frysounas/marination.php';
				} else if ($_GET['id'] == "addfryrecp") {
					include 'frysounas/addmarination.php';
				} else if ($_GET['id'] == "addfryrecp1") {
					include 'frysounas/addmarination1.php';
				} else if ($_GET['id'] == "viewfryrecp") {
					include 'frysounas/viewmarination.php';
				} else if ($_GET['id'] == "addfryrecpn1") {
					include 'frysounas/addmarinationn1.php';
				}

				/// fry section end

				//goods intake
				else if ($_GET['id'] == "stockin") {
					include 'stockin/stockin.php';
				} else if ($_GET['id'] == "stockdetail") {
					include 'stockin/stock.php';
				} else if ($_GET['id'] == "stockdetail1") {
					include 'stockin/stock1.php';
				} else if ($_GET['id'] == "confirm-stock") {
					include 'stockin/confirm-stock.php';
				} else if ($_GET['id'] == "addstock") {
					include 'stockin/add-stock.php';
				} else if ($_GET['id'] == "request-stock") {
					include 'stockin/request-stock.php';
				} else if ($_GET['id'] == "confirm-request") {
					include 'stockin/confirm-request.php';
				} else if ($_GET['id'] == "request-record") {
					include 'stockin/request-record.php';
				} else if ($_GET['id'] == "stock-flow") {
					include 'stockin/stock-flow.php';
				} else if ($_GET['id'] == "product-flow") {
					include 'stockin/product-flow.php';
				} else if ($_GET['id'] == "tranfer-summary") {
					include 'stockin/tranfer-summary.php';
				} else if ($_GET['id'] == "request-flow") {
					include 'stockin/request-flow.php';
				} else if ($_GET['id'] == "recieved-request") {
					include 'stockin/recieved-request.php';
				} else if ($_GET['id'] == "stock-wastage") {
					include 'stockin/stock-wastage.php';
				}else if ($_GET['id'] == "wastage-flow") {
					include 'stockin/wastage-flow.php';
				}

				//traceability
				else if ($_GET['id'] == 'trace') {
					include 'trace/trace.php';
				} else if ($_GET['id'] == 'trace1') {
					include 'trace/trace1.php';
				} else if ($_GET['id'] == 'trace2') {
					include 'trace/trace2.php';
				} else if ($_GET['id'] == 'traceview') {
					include 'trace/traceview.php';
				} elseif ($_GET['id'] == 'reciepereport') {
					include 'trace/reciepereport.php';
				} else if ($_GET['id'] == 'bakingreport') {
					include 'trace/bakingreport.php';
				} else if ($_GET['id'] == 'coolingreport') {
					include 'trace/coolingreport.php';
				} else if ($_GET['id'] == 'packagingreport') {
					include 'trace/packagingreport.php';
				} else if ($_GET['id'] == 'metalreport') {
					include 'trace/metalreport.php';
				} else if ($_GET['id'] == 'boxingreport') {
					include 'trace/boxingreport.php';
				} else if ($_GET['id'] == 'goodsreport') {
					include 'trace/goodsreport.php';
				} else if ($_GET['id'] == 'goodsinreport') {
					include 'trace/goodsinreport.php';
				} else if ($_GET['id'] == 'trace_supplier') {
					include 'trace/supplier_detail.php';
				} else if ($_GET['id'] == 'massbalance') {
					include 'trace/massbalance.php';
				} elseif ($_GET['id'] == 'boxingpo') {
					include 'trace/boxingpo.php';
				}
				//traceability end





				?>

			</div>
			<script src="dist-assets/js/plugins/jquery.smartWizard.min.js"></script>
			<script src="dist-assets/js/plugins/datatables.min.js"></script>
			<script src="dist-assets/js/scripts/datatables.script.min.js"></script>
			<script src="dist-assets/js/plugins/dropzone.min.js"></script>
			<script src="dist-assets/js/scripts/dropzone.script.min.js"></script>


</body>

</html>
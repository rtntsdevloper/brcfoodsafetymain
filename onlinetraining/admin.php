<?php
date_default_timezone_set("Europe/London");
include'../connection.php';
session_start();
if(!isset($_SESSION['user']))
{
?>
<script>
window.open('../logged.php','_self');
</script>
<?php

}
else
{
$user=$_SESSION['user'];
$access=$_SESSION['access'];
$_SESSION['headingname']="BRCGS FOOD SAFETY Version 9";

 $headingname=$_SESSION['headingname'];
}


$sqq=mysqli_query($con,"select * from tblstaff where uname='$user'");
$hjj=mysqli_fetch_array($sqq);
 $_SESSION['staffid']=$hjj['id'];

   $staffid=$_SESSION['staffid'];
?>
<!DOCTYPE html>
<html lang="en" dir="">
<head>
	<meta charset="utf8">

    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> RTNTS - Web Portal </title>

    <link rel="shortcut icon" href="../favicon.ico">
	
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="../dist-assets/css/plugins/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist-assets/css/plugins/datatables.min.css" />
	
    <script src="../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
   
    <script src="../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../dist-assets/js/scripts/script.min.js"></script>
    <script src="../dist-assets/js/scripts/sidebar.large.script.min.js"></script>
    <script src="../dist-assets/js/plugins/echarts.min.js"></script>
    <script src="../dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="../dist-assets/js/plugins/datatables.min.js"></script>
	<script src="../dist-assets/js/scripts/form.validation.script.min.js"></script>
    <script src="../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
	<script src="../dist-assets/js/plugins/sweetalert2.min.js"></script>
	 
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large" >
        <div class="main-header">
           
                <img src="../images/logo1.png" alt="" width="70" style="margin-left:20px">            
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
                     <i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome: <?php echo $user;?> </i> </div>
                </div>
            </div>
        </div>
		
     <div class="side-content-wrap">
     <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
     <ul class="navigation-left">
     <li class="nav-item" ><a class="nav-item-hold" href="admin.php?id=1"> <i class="fa fa-bank" style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
       </li>
                   
                    <li class="nav-item"><a class="nav-item-hold" href="../logged.php" ><i class="fa fa-sign-out" style="font-size:34px"></i><span class="nav-text">Log Out</span></a>
                        <div class="triangle"></div>
                    </li>
       </ul>
       </div>
          
            <div class="sidebar-overlay"></div>
</div>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
		    <?php
		
			if($_GET['id']=="1")
			{
			include 'dashboard.php';
			}
			else if($_GET['id']=="level2")
			{
			include 'level2.php';
			}
			else if($_GET['id']=="moddetail")
			{
			include 'moddetail.php';
			}
			else if($_GET['id']=="starttest")
			{
			include 'starttest.php';
			}
			else if($_GET['id']=="level2result")
			{
			include 'level2result.php';
			}
 else if($_GET['id'] =='procedure')
 {
 include 'procedure.php';
 }
 
 else if($_GET['id'] =='procedure1')
 {
 include 'procedure1.php';
 }
 else if($_GET['id'] =='proceduretest')
 {
 include 'proceduretest.php';
 }
  else if($_GET['id'] =='proceduretest3')
 {
 include 'proceduretest3.php';
 }
 else if($_GET['id'] =='warehouse')
 {
 include 'warehouse.php';
 }
  else if($_GET['id'] =='warehouse1')
 {
 include 'warehouse1.php';
 }
  else if ($_GET['id']=="start_test")
			{
			include 'start_test.php';
			}
		 ?>
                        </div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="dist-assets/js/plugins/datatables.min.js"></script>
    <script src="dist-assets/js/scripts/datatables.script.min.js"></script>
</body>

</html>
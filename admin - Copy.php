<?php
include'connection.php';
session_start();
if(!isset($_SESSION['user']))
{
header('location:index.php');
}
else
{
$user=$_SESSION['user'];
$access=$_SESSION['access'];
}
?>
<!DOCTYPE html>


<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> RTNTS - Web Portal </title>
	
	<link rel="shortcut icon" href="images/logo1.png">
	
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
	 
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <div class="logo">
                <img src="images/logo1.png" alt="">            </div>
          <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">
                <!-- Mega menu -->
                <div class="dropdown mega-menu d-none d-md-block">
                   Regal Technical and Training Solutions Limited                </div>
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
                    
					 <li class="nav-item" data-item="brccompliance"><a class="nav-item-hold" href="#"><i class="fa fa-list-alt" style="font-size:34px"></i><span class="nav-text">
					 Compliance</span></a>
                        <div class="triangle"></div>
                    </li>
					
                    <li class="nav-item" data-item="sessions"><a class="nav-item-hold" href="#"><i class="fa fa-user" style="font-size:34px"></i><span class="nav-text">Staff Management</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item active" data-item="others"><a class="nav-item-hold" href="#"><i class="fa fa-sticky-note" style="font-size:34px"></i><span class="nav-text">Audit Management</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item"><a class="nav-item-hold" href="logged.php" ><i class="fa fa-sign-out" style="font-size:34px"></i><span class="nav-text">Log Out</span></a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>
            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <!-- Submenu Dashboards-->
                <!-- chartjs-->
               
			    <ul class="childNav" data-parent="brccompliance">
                    <li class="nav-item"><a href="admin.php?id=brccompliance"><i class="fa fa-file"></i>&nbsp;<span class="item-name">General Compliance</span></a></li>
                </ul>
				
                <ul class="childNav" data-parent="sessions">
                    <li class="nav-item"><a href="admin.php?id=umgmt"><i class="fa fa-user text-center"></i> &nbsp;<span class="item-name">User List</span></a></li>
                    <li class="nav-item"><a href="admin.php?id=umgmt"><i class="fa fa-user"></i> &nbsp;<span class="item-name">Add User</span></a></li>
                    <li class="nav-item"><a href="admin.php?id=umgmt"><i class="fa fa-user"></i>&nbsp; <span class="item-name">Edit User</span></a></li>
                </ul>
				
                <ul class="childNav" data-parent="others">
                    <li class="nav-item"><a href="admin.php?id=auditmgmt"><i class="fa fa-file"></i>&nbsp;<span class="item-name">Attempt Audit</span></a></li>
                    <li class="nav-item"><a href="admin.php?id=auditalert"><i class="fa fa-file"></i>&nbsp;<span class="item-name">Corrective Actions</span></a></li>
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
			else if ($_GET['id']=="audit")
			{
			include 'audit.php';
			}
			else if ($_GET['id']=="viewmore")
			{
			include 'viewmore.php';
			}
			else if ($_GET['id']=="umgmt")
			{
			include 'umgmt.php';
			}
			else if ($_GET['id']=="adduser")
			{
			include 'adduser.php';
			}
			else if ($_GET['id']=="cmgmt")
			{
			include 'cmgmt.php';
			}
			else if ($_GET['id']=="umgmt1")
			{
			include 'umgmt1.php';
			}
			else if ($_GET['id']=="edituser")
			{
			include 'edituser.php';
			}
			else if ($_GET['id']=="cmgmt1")
			{
			include 'cmgmt1.php';
			}
			else if ($_GET['id']=="editcompany")
			{
			include 'editcompany.php';
			}
			else if ($_GET['id']=="audits")
			{
			include 'audits.php';
			}
			else if ($_GET['id']=="viewdetail")
			{
			include 'viewdetail.php';
			}
			else if ($_GET['id']=="training")
			{
			include 'training.php';
			}
			else if ($_GET['id']=="training1")
			{
			include 'training1.php';
			}
			else if ($_GET['id']=="viewdata")
			{
			include 'viewdata.php';
			}
			else if ($_GET['id']=="machine")
			{
			 include 'machine.php';
			}
								else if ($_GET['id']=="report")
								{
									 include 'reportt.php';
								}
								
								else if ($_GET['id']=="adddetail")
								{
									 include 'adddetails.php';
								}
								else if ($_GET['id']=="view")
								{
									 include 'view.php';
								}
								
								else if ($_GET['id']=="editdetail")
								{
									 include 'editdetail.php';
								}
								else if ($_GET['id']=="test")
								{
									 include 'test.php';
								}
								
								else if ($_GET['id']=="corrective")
								{
									 include 'corrective.php';
								}
								else if ($_GET['id']=="addnew")
								{
									 include 'addnew.php';
								}
								else if ($_GET['id']=="correctivedetail")
								{
									 include 'correctivedetail.php';
								}
								else if ($_GET['id']=="savesign")
								{
									 include 'savesign.php';
								}
								else if ($_GET['id']=="archive")
								{
									 include 'archive.php';
								}
								
								else if ($_GET['id']=="machinee")
								{
									 include 'machinee.php';
								}
								else if ($_GET['id']=="viewdetails")
								{
									 include 'viewdetails.php';
								}
								else if ($_GET['id']=="archivee")
								{
									 include 'archivee.php';
								}
								else if ($_GET['id']=="auditmgmt")
								{
									 include 'auditmgmt.php';
								}
								else if ($_GET['id']=="audit1")
								{
									 include 'audit1.php';
								}
								else if ($_GET['id']=="auditalert")
								{
									 include 'auditalert.php';
								}
								else if ($_GET['id']=="brccompliance")
								{
									 include 'brccompliance.php';
								}
								
								else if ($_GET['id']=="brccompliance1")
								{
									 include 'brccompliance1.php';
								}
								
								else if ($_GET['id']=="brccompliance2")
								{
									 include 'brccompliance2.php';
								}
								else if ($_GET['id']=="brccompliance3")
								{
									 include 'brccompliance3.php';
								}
								else if ($_GET['id']=="brccompliance4")
								{
									 include 'brccompliance4.php';
								}
								else if ($_GET['id']=="try")
								{
									 include 'try.php';
								}
								else if ($_GET['id']=="auditprogress")
								{
									 include 'auditprogress.php';
								}
								else if ($_GET['id']=="auditdetail")
								{
									 include 'auditdetail.php';
						 		}
			                   ?>
				   
				   
				   </div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->


	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	 
</body>

</html>
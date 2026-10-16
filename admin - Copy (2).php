 <?php
 date_default_timezone_set("Europe/London");
 include'connection.php';
 session_start();
 if(!isset($_SESSION['user']) || $_SESSION['user']=="")
 {
?>
<script>
window.open('index.php','_self');
</script>
 <?php
 }
 else
 {                                  
 $user=$_SESSION['user'];
 $access=$_SESSION['access'];
 $headingname=$_SESSION['headingname'];
 $tabs=$_SESSION['tabs'];
 }
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
       .modalk
        {
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
          .center
          {
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
    .center img
       {
        height: 128px;
        width: 128px;
       }
</style>
</head>


<body class="text-left" >

<div class="modalk" style="display: none">
    <div class="center">
        <img alt="" src="loader.gif" />
    </div>
</div>

    <div class="app-admin-wrap layout-sidebar-large" >
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
                     <i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome: <?php echo $user;?> (<?php echo $access;?>)</i> </div>
                </div>
            </div>
        </div>
		
     <div class="side-content-wrap">
     <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
     <ul class="navigation-left">
     <li class="nav-item" ><a class="nav-item-hold" href="admin.php?id=1"> <i class="fa fa-bank" style="font-size:34px; color:#0099CC"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
       </li>
                    <?php
$string = $tabs;
$array = explode(";", $string);
$data = array();
foreach($array as $arr)
{
  $sq=mysqli_query($con,"select * from tbltabs where sno='$arr' and navbar='yes'");
 
  while($qr=mysqli_fetch_array($sq))
   {
?>
				 <li  class="nav-item active" ><a class="nav-item-hold" href="<?php echo $qr['weblink'];?>" ><i class="fa fa-list" style="font-size:34px; color:<?php echo $qr['color'];?>"></i><span class="nav-text">
				 <?php echo $qr['name'];?> <?php echo $qr['name1'];?></span></a>
                        <div class="triangle"></div>
                    </li>
					
          <?PHP
		  }
		  }
		  ?>
					
                    <li class="nav-item"><a class="nav-item-hold" href="logged.php" ><i class="fa fa-sign-out" style="font-size:34px; color:#990000"></i><span class="nav-text">Log Out</span></a>
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
                    <li class="nav-item"><a href="admin.php?id=adduser"><i class="fa fa-user"></i> &nbsp;<span class="item-name">Add User</span></a></li>
                    <li class="nav-item"><a href="admin.php?id=umgmt"><i class="fa fa-user"></i>&nbsp; <span class="item-name">Edit User</span></a></li>
                </ul>
				
                <ul class="childNav" data-parent="others">
                    <li class="nav-item"><a href="admin.php?id=auditdetail"><i class="fa fa-file"></i>&nbsp;<span class="item-name">Attempt Audit</span></a></li>
                   
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
			else if ($_GET['id']=="cmgmt")
			{
			include 'cmgmt.php';
			}
			else if ($_GET['id']=="umgmt1")
			{
			include 'umgmt1.php';
			}
			else if ($_GET['id']=="umgmt")
			{
			include 'umgmt.php';
			}
			else if ($_GET['id']=="adduser")
			{
			include 'adduser.php';
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
								else if ($_GET['id']=="auditor")
								{
									 include 'auditor.php';
						 		}
								else if ($_GET['id']=="addauditor")
								{
									 include 'addauditor.php';
						 		}								
								else if ($_GET['id']=="viewauditor")
								{
									 include 'viewauditor.php';
						 		}
								else if ($_GET['id']=="auditorassign")
								{
									 include 'auditorassign.php';
						 		}
								else if ($_GET['id']=="auditorassign1")
								{
									 include 'auditorassign1.php';
						 		}
								else if ($_GET['id']=="auditeemgmt")
								{
									 include 'auditeemgmt.php';
						 		}
								else if ($_GET['id']=="addauditee")
								{
									 include 'addauditee.php';
						 		}
								else if ($_GET['id']=="ncview")
								{
									 include 'ncview.php';
						 		}
								else if ($_GET['id']=="ncview1")
								{
									 include 'ncview1.php';
						 		}
								else if ($_GET['id']=="editauditor")
								{
									 include 'editauditor.php';
						 		}
								
								else if ($_GET['id']=="editauditee")
								{
									 include 'editauditee.php';
						 		}
								else if ($_GET['id']=="auditreport")
								{
									 include 'auditreport.php';
						 		}
								else if ($_GET['id']=="glutenfree")
								{
									 include 'glutenfree.php';
						 		}
								else if ($_GET['id']=="glutenfree1")
								{
									 include 'glutenfree1.php';
						 		}
								else if ($_GET['id']=="glutenfreeupload")
								{
									 include 'glutenfreeupload.php';
						 		}
								else if ($_GET['id']=="viewdetail")
								{
									 include 'viewdetail.php';
						 		}
								else if ($_GET['id']=="auditreport")
								{
									 include 'auditreport.php';
						 		}
								else if ($_GET['id']=="gmp")
								{
									 include 'gmp.php';
						 		}
								else if ($_GET['id']=="gmp1")
								{
									 include 'gmp1.php';
						 		}
								else if ($_GET['id']=="ques")
								{
									 include 'ques.php';
						 		}
								else if ($_GET['id']=="ques1")
								{
									 include 'ques1.php';
						 		}
								else if ($_GET['id']=="staffdetail")
								{
									 include 'staffdetail.php';
						 		}
								else if ($_GET['id']=="gmpaudit")
								{
									 include 'gmpaudit.php';
						 		}
								else if ($_GET['id']=="gmpaudit1")
								{
									 include 'gmpaudit1.php';
						 		}
								else if ($_GET['id']=="gmpaudit2")
								{
									 include 'gmpaudit2.php';
						 		}
								else if ($_GET['id']=="addaudit")
								{
									 include 'addaudit.php';
						 		}
								else if ($_GET['id']=="addaudit1")
								{
									 include 'addaudit1.php';
						 		}
								else if ($_GET['id']=="viewaudit")
								{
									 include 'viewaudit.php';
						 		}
								else if ($_GET['id']=="allowaudit")
								{
									 include 'allowaudit.php';
						 		}
								else if ($_GET['id']=="gmpauditt")
								{
									 include 'gmpauditt.php';
						 		}
								else if ($_GET['id']=="gmpnc")
								{
									 include 'gmpnc.php';
						 		}
								else if ($_GET['id']=="gmpnc1")
								{
									 include 'gmpnc1.php';
						 		}
								else if ($_GET['id']=="amgmt")
								{
									 include 'amgmt.php';
						 		}
								else if ($_GET['id']=="viewallreport")
								{
									 include 'viewallreport.php';
						 		}
								else if ($_GET['id']=="fscsurveytrendings")
								{
									 include 'fscsurveytrendings.php';
						 		}
								else if ($_GET['id']=="fscsurveytrending")
								{
									 include 'fscsurveytrending.php';
						 		}
								else if($_GET['id'] =='procedure')
 {
 include 'procedure.php';
 }
 else if($_GET['id'] =='procedure1')
 {
 include 'procedure1.php';
 }
 else if($_GET['id'] =='addprocedure')
 {
 include 'addprocedure.php';
 }
 else if($_GET['id'] =='proceduretraining')
 {
 include 'proceduretraining.php';
 }
 else if($_GET['id'] =='proceduredetail')
 {
 include 'proceduredetail.php';
 }
else if($_GET['id'] =='addproceduretraining')
 {
 include 'addproceduretraining.php';
 }
 else if($_GET['id'] =='addproceduredetail')
 {
 include 'addproceduredetail.php';
 }
 else if($_GET['id'] =='viewdocument')
 {
 include 'viewdocument.php';
 }
  else if($_GET['id'] =='addstaffprocedure')
 {
 include 'addstaffprocedure.php';
 }
else if($_GET['id'] =='addstaffprocedure1')
 {
 include 'addstaffprocedure1.php';
 }
	else if($_GET['id'] =='editpocedure')
 {
   include 'editpocedure.php';
 }
 else if($_GET['id'] =='recordsmgmt')
 {
 include 'recordsmgmt.php';
 }
 	else if($_GET['id'] =='additionalmgmt')
 {
 include 'additionalmgmt.php';
 }
 else if($_GET['id'] =='addaditional')
 {
 include 'addaditional.php';
 }
 else if($_GET['id'] =='addrecord')
 {
 include 'addrecord.php';
 }
 else if($_GET['id'] =='editbrccompliance')
 {
 include 'editbrccompliance.php';
 }
  else if($_GET['id'] =='attemptnewaudit')
  {
  include 'attemptnewaudit.php';
  }
  else if($_GET['id'] =='goodsin')
  {
  include 'goodsin.php';
  }
	 else if($_GET['id'] =='addnewgoods')
  {
  include 'addnewgoods.php';
  }
  else if($_GET['id'] =='goodsindetail')
  {
  include 'goodsindetail.php';
  }
  else if($_GET['id'] =='dailychecks')
 {
 include 'dailychecks.php';
 }
 else if($_GET['id'] =='dailychecks1')
 {
 include 'dailychecks1.php';
 }
 else if($_GET['id'] =='dailychecks3')
 {
 include 'dailychecks3.php';
 }
 else if($_GET['id'] =='dailycheckss')
 {
 include 'dailycheckss.php';
 }
 else if($_GET['id'] =='dailytemp')
 {
 include 'dailytemp.php';
 }
  else if($_GET['id'] =='closingchecks1')
  {
    include 'closingchecks1.php';
  }	
  else if($_GET['id'] =='dailytemp2')
  {
    include 'dailytemp2.php';
  }	
  else if($_GET['id'] =='dailychecks4')
  { 
 include 'dailychecks4.php';
 }
  else if($_GET['id'] =='dailychecksdetail')
  { 
 include 'dailychecksdetail.php';
 }
   else if($_GET['id'] =='uploadcsv')
  { 
   include 'uploadcsv.php';
   }
   else if($_GET['id'] =='uploadcsv1')
  { 
   include 'uploadcsv1.php';
   }
	 else if($_GET['id'] =='addnewgoods2')
  {
  include 'addnewgoods2.php';
  }
  else if($_GET['id'] =='addnewgoods3')
  {
  include 'addnewgoods3.php';
  }
  else if($_GET['id'] =='addnewgoods4')
  {
  include 'addnewgoods4.php';
  }
  else if($_GET['id'] =='addnewgoods7')
  {
  include 'addnewgoods7.php';
  }
  else if($_GET['id'] =='complaintmgmt')
  {
     include 'complaintmgmt.php';
  }
  else if($_GET['id'] =='viewcomplaintdetail')
  {
  include 'viewcomplaintdetail.php';
  }
  else if($_GET['id'] =='goods')
  {
  include 'goodsin/goods.php';
  }
  else if($_GET['id'] =='1addnewgoods2')
  {
  include 'goodsin/1addnewgoods2.php';
  }
  else if($_GET['id'] =='goodsdetail')
  {
  include 'goodsin/goodsdetail.php';
  }
   else if($_GET['id']=='goodseditdetail')
  {
  include 'goodsin/goodseditdetail.php';
  }
   else if($_GET['id'] =='1addnewgoods21')
  {
  include 'goodsin/1addnewgoods21.php';
  }
  							else if($_GET['id']=="genratelabel")
								 {
								include 'genratelabel.php';
								}
								else if($_GET['id']=="goodsout")
								 {
								include 'goodsin/goodsout.php';
								}
								else if($_GET['id']=="goodsout1")
								 {
								include 'goodsin/goodsout1.php';
								}
								else if($_GET['id']=="goodsoutdetail")
								 {
								include 'goodsin/goodsoutdetail.php';
								}
									else if($_GET['id']=="gmptrending")
								 {
								include 'gmptrending.php';
								}
								else if($_GET['id']=="brctrending")
								 {
								include 'brctrending.php';
								}
								else if($_GET['id']=="knowledge")
								 {
								include 'knowledge.php';
								}
								else if($_GET['id']=="goodsoutedit")
								 {
								include 'goodsin/goodsoutedit.php';
								}
								else if($_GET['id']=="knowledgemgmt")
								 {
								include 'knowledgemgmt.php';
								}
								else if($_GET['id']=="knowledgehub")
								 {
								include 'knowledgehub.php';
								}
								else if($_GET['id']=="legislation")
								 {
								include 'legislation.php';
								}
								else if($_GET['id']=="legislationdetail")
								 {
								include 'legislationdetail.php';
								}
								else if($_GET['id']=="alerts")
								 {
								include 'alerts.php';
								}
								else if($_GET['id'] =='recordsmgmt')
 {
 include 'recordsmgmt.php';
 }
 	else if($_GET['id'] =='additionalmgmt')
 {
 include 'additionalmgmt.php';
 }
 else if($_GET['id'] =='addaditional')
 {
 include 'addaditional.php';
 }
 else if($_GET['id'] =='addrecord')
 {
 include 'addrecord.php';
 }
 else if($_GET['id'] =='editbrccompliance')
 {
 include 'editbrccompliance.php';
 }
 
  else if($_GET['id'] =='ppm')
 {
 include 'ppm.php';
 }
 else if($_GET['id'] =='ppm1')
 {
 include 'ppm1.php';
 }
 else if($_GET['id'] =='ppmmgmt')
 {
 include 'ppmmgmt.php';
 }
 else if($_GET['id'] =='addppm')
 {
 include 'addppm.php';
 }
 else if($_GET['id'] =='uploadspec')
 {
 include 'goodsin/uploadspec.php';
 }
 else if($_GET['id'] =='viewspec')
 {
 include 'goodsin/viewspec.php';
 }
 else if($_GET['id'] =='specdetail')
 {
 include 'goodsin/specdetail.php';
 }
 
								
								
								else if($_GET['id']=="editaccess")
								 {
								include 'editaccess.php';
								}
								else if($_GET['id']=="adminmgmt")
								 {
								include 'adminmgmt.php';
								}
								else if($_GET['id']=="addadmin")
								 {
								include 'addadmin.php';
								}
								else if($_GET['id']=="editadmin")
								 {
								include 'editadmin.php';
								}
								else if($_GET['id']=="emailmgmt")
								 {
								include 'emailmgmt.php';
								}
								else if($_GET['id']=="addemail")
								 {
								include 'addemail.php';
								}
								else if($_GET['id']=="editgmp")
								 {
								include 'editgmp.php';
								}
								
								else if($_GET['id']=="addlegislation")
								 {
								include 'addlegislation.php';
								}
								
								else if($_GET['id']=="marination")
								{
								include 'marination/marination.php';
								}
								else if($_GET['id']=="addmarination")
								{
								include 'marination/addmarination.php';
								}
								else if($_GET['id']=="addmarination1")
								{
								include 'marination/addmarination1.php';
								}
								else if($_GET['id']=="viewmarination")
								{
								include 'marination/viewmarination.php';
								}
								else if($_GET['id']=="addmarinationn1")
								{
								include 'marination/addmarinationn1.php';
								}
								
								else if($_GET['id']=="goods1")
								{
								include 'goods1.php';
								}
								else if($_GET['id']=="prodmgmt")
								{
								include 'prodmgmt.php';
								}
								 else if($_GET['id'] =='viewspecc')
 {
 include 'viewspec.php';
 }

 else if($_GET['id'] =='addlegislationn')
 {
 include 'addlegislationn.php';
 }
                               
		 else if($_GET['id']=="alertcategory")
								 {
								include 'alertcategory.php';
								}					   
							   
							    else if($_GET['id']=="legislationcategory")
								 {
								include 'legislationcategory.php';
								}					   
							   
							   
							      else if($_GET['id']=="goodsoutt")
								 {
								include $_GET['id2'].'/goodsoutt.php';
								}
								else if($_GET['id']=="goodsoutt1")
								 {
								include $_GET['id2'].'/goodsoutt1.php';
								}
								else if($_GET['id']=="ggoodsoutdetail")
								 {
								include $_GET['id2'].'/ggoodsoutdetail.php';
								}
								else if($_GET['id']=="baking")
								 {
								include $_GET['id2'].'/baking.php';
								}
								else if($_GET['id']=="baking1")
								 {
								include $_GET['id2'].'/baking1.php';
								}
								else if($_GET['id']=="cooling")
								 {
								include $_GET['id2'].'/cooling.php';
								}
								else if($_GET['id']=="cooling1")
								 {
								include $_GET['id2'].'/cooling1.php';
								}

                                  else if($_GET['id']=="packing")
								 {
								include $_GET['id2'].'/packing.php';
								}
                               else if($_GET['id']=="packing1")
								 {
								include $_GET['id2'].'/packing1.php';
								}

                                  else if($_GET['id']=="metal")
								 {
								include $_GET['id2'].'/metal.php';
								}
							   else if($_GET['id']=="metal1")
								 {
								include $_GET['id2'].'/metal1.php';
								}
								
                                 else if($_GET['id']=="boxing")
								 {
								include $_GET['id2'].'/boxing.php';
								}
							   else if($_GET['id']=="boxing1")
								 {
								include $_GET['id2'].'/boxing1.php';
								}
								 else if($_GET['id']=="production")
								 {
								include $_GET['id2'].'/production.php';
								}
							   else if($_GET['id']=="production1")
								 {
								include $_GET['id2'].'/production1.php';
								}

 else if($_GET['id']=="boxingg")
								 {
								include $_GET['id2'].'/boxingg.php';
								}
								else if ($_GET['id'] == "addrawmaterial")
								 {
            include 'rawmaterial.php';
        }
		 else if ($_GET['id'] == "addrawmaterial1")
		  {
            include 'rawmaterial1.php';
        } 
		elseif ($_GET['id'] == "editrawmaterial") 
		{
            include 'editrawmaterial.php';
        } 
		elseif ($_GET['id'] == "editrawsupplier") 
		{
            include 'editrawsupplier.php';
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
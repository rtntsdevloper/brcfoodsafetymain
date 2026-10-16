<?php
date_default_timezone_set("Europe/London");
include'connection.php';

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

<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>


</head>

<body class="text-left">
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
                   
                </div>
            </div>
        </div>
		
     <div class="side-content-wrap">
     <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
     <ul class="navigation-left">
     <li class="nav-item" ><a class="nav-item-hold" href="#"> <i class="fa fa-bank" style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
       </li>
                   
       </ul>
       </div>
           
            <div class="sidebar-overlay"></div>
</div>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
	<div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                   
                          <div class="header">
                            <h4 class="title">Concept Patisserie - Questionnaire </h4>
							<br/>
							
							
  </div>
							
                            <div class="content">
                                <form name="form1" onSubmit="return checkReq()" action="mainn2" method="post" enctype="multipart/form-data">
                                    <div class="row">
										   <div class="col-lg-4 col-md-6 col-sm-6">
                        <a href="vistor.php">  <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-sticky-note" style="font-size:54px; color:#3399CC"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Visitor</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Questionnaire</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
                    <div class="col-lg-4 col-md-6 col-sm-6">
                          <a href="premedical.php"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-sticky-note" style="font-size:54px; color:#E81766"></i>
                                <div style="margin-left:20px; margin-top:10px">
                                    <p style="font-size:12px">Pre-Medical</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Questionnaire</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					<div class="col-lg-4 col-md-6 col-sm-6">
                          <a href="medical.php"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-sticky-note" style="font-size:54px; color:#CC9900"></i>
                                <div style="margin-left:20px; margin-top:10px">
                                    <p class="" style="font-size:12px">Employee-Medical</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Questionnaire</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    </div>
					
					
  
  </div>
</div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 
</body>

</html>
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

<link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css" />

	 
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
                 <a href="gmpauditnc.php?sno=<?php echo $_GET['sno1'];?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
						
		     	<?php
			
				$sno=$_GET['sno'];
				$query=mysqli_query($con,"select * from tblgmpaudit3 where id='$sno'");
				$query1=mysqli_fetch_array($query);
				
				$rid=$_GET['sno1'];
				
				$sql=mysqli_query($con,"select * from tblgmpaudit2 where id='$rid'");
				$row=mysqli_fetch_array($sql);
			
				
				
											    $sh=mysqli_query($con,"select * from tblauditor where id='$row[auditor]'");
                                                $hj=mysqli_fetch_array($sh);
												?>

				<?php
												 
											    $sh13=mysqli_query($con,"select * from tblauditee where id='$row[auditee]'");
                                                $hj13=mysqli_fetch_array($sh13);
												
				  $total3=mysqli_query($con,"select * FROM tblauditsection where id='$row[audit]'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM tblauditsection1 where sid='$row[audit]' and id='$row[sid]'");
				   $subtest=mysqli_fetch_array($total2);
				   
				   	?> 
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
                             <h4 class="card-title mb-3" style="color:#0000FF"><?php echo $addtest['name'];?> NC  Detail</h4>
								
                          <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="card-body text-center">
                                                <div ><img src="auditordoc/<?php echo $hj['userimg'];?>" alt="" width="70" /></div>
                                              
											   <button class="btn btn-primary btn-rounded"> Auditor: <?php echo $hj['name'];?></button>
                                                <p class="mt-0">Contact: <?php echo $hj['contact'];?></p>
                                                <p>Email: <?php echo $hj['email'];?></p>
                                               
                                            </div>
                                        </div>
                                   
                                             <div class="card card-profile-1 mb-4">
                                              <div class="card-body text-center">
                                                <div >
												<img src="auditordoc/<?php echo $hj13['img'];?>" alt=""  width="70" />
												</div>
                                              
											   <button class="btn btn-primary btn-rounded"> Auditee: <?php echo $hj13['name'];?></button>
                                                <p class="mt-0">Contact: <?php echo $hj13['contact'];?></p>
                                                <p>Email: <?php echo $hj13['email'];?></p>
												
                                               
                                               
                                            </div>
                                        </div>
                                    </div>
									
									<?php
											    $sh4=mysqli_query($con,"select * from tblgmpaudit3 where id='$sno'");
                                                $hj4=mysqli_fetch_array($sh4);
												$mch=mysqli_num_rows($sh4);
												if($mch<=0)
												{}
												else
												{
												?> 
												
							<div class="col-md-8">
								<div class="card card-profile-1 mb-8">
								  <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									<tr><th><?php echo $addtest['name'];?> </th></tr>
									<tr><th><?php echo $subtest['name'];?> </th></tr>
									<tr><td>Audit date: <?php echo date("d-m-Y", strtotime($row['date']));?> </td></tr>
									
									
									<?php
									if($hj4['deliver']!="0000-00-00" || $hj4['deliver']!="")
									{
									?>
									
									<tr><td> Completion date agreed: <?php echo date("d-m-Y", strtotime($hj4['deliver']));?> </td></tr>
									<?php
									}
									?>
									<tr><td>Comment: <?php echo $hj4['cmnt'];?> </td></tr>
									<tr><td>Action Required: <?php echo $hj4['action'];?> </td></tr>
									
									<?php
									if($hj4['img']!="")
									{
									?>
									<tr>
									<td>Document: &nbsp;
									<?php
									$string = $hj4['img'];
$tags1 = explode(';' , $string);
$i=0;
foreach($tags1 as $key1)
  {
  $i++;
   $info5= new SplFileInfo($key1);
  $tpe5=$info5->getExtension();
  if($tpe5!="")
  {
  ?>
												<a href="auditpic/<?php echo $key1;?>" target="_blank" style="color:#0033FF"><?php echo $key1;?></a>
												
												<br/>
												<?php
												}
												}
												?>
												
									</td>
												</tr>
												<?php
												}
												?>
												
												
												
												<?php
												 $sh6=mysqli_query($con,"select * from tblaction1 where sno='$sno'");
                                               while($hj6=mysqli_fetch_array($sh6))
												{
												$string1 = $hj6['comment'];
   $array1 = explode(";", $string1);
												?>
												<tr><td><h5 style="color:#993300">Auditee Response:</h5></td></tr>
												<?php
												if($hj6['status3']=="root")
												{
												?>
												
						 <tr><td>Root Cause 1: <?php echo $array1[0];?><br/>Root Cause 2: <?php echo $array1[1];?><br/> Root Cause 3: <?php echo $array1[2];?><br/>Root Cause 4: <?php echo $array1[3];?><br/>Root Cause 5: <?php echo $array1[4];?> </td></tr>
						 
						 <?php
						 }
						 else
						 {
						 ?>
						 <tr><td> Comment:<?php echo $hj6['comment'];?></td></tr>
						 <?php
						 }
						 ?>
						  <tr><td>Corrective Action: <?php echo $hj6['corrective'];?></td></tr>
						  
						 
						 
												
						 <tr><td>Document:  <a href="auditpic/<?php echo $hj6['img'];?>" style="color:#0000FF" target="_blank"><?php echo $hj6['img'];?></a></td></tr>
						 
						 <tr><td><h5 style="color:#993300">Auditor Response:</h5></td></tr>
						 
						 <tr><td>Status: <?php echo $hj6['ans'];?></td></tr>
						 
						 <tr><td>Auditor Comment: <?php echo $hj6['cmnt'];?></td></tr>
												
						 
									<?php
									}
									?>
											
									<?php
								if($hj4['status']=="Rejected" )
												{
												?>
								    <form name="form3" action="" method="post" class="pt-3" enctype="multipart/form-data">
								
									<tr><td>Comment: <textarea class="form-control" name="rt" required></textarea></td></tr>
									<tr><td>Upload Document: <input type="file" class="form-control" name="img1"></td></tr>
									<tr><td><button type="submit" class="btn btn-info" name="submit3">Submit</button></td></tr>
									</form>
									<?php
									}
									?>
											
												
									</table>
									</div>
									</div>
									</div>
									
									
									</div>
									
									<?php
			
				$rtsw=mysqli_query($con,"select * from tblaction1 where sno='$sno' order by id desc limit 1");
				$rtsw1=mysqli_fetch_array($rtsw);
				
				$string = $rtsw1['comment'];
   $array = explode(";", $string);
				?>
				
									<?php
												if($hj4['status']=="Waiting" || $hj4['status']=="waiting"  || $hj4['status']=="Rejected")
												{
												?>
								 <div class="breadcrumb">
                    <h1>Root Cause Analysis</h1>
                    <ul>
                       
                        <li>| Give your response</li>
                    </ul>
                </div>
                
				
                    
				<form name="form1" action="" method="post" class="pt-3" enctype="multipart/form-data">
						
                <div class="row">
                    <div class="col-md-12">
                        <!--  SmartWizard html -->
                        <div id="smartwizard">
                            <ul>
                                <li><a href="#step-1">Step 1<br /><small>Question 1 why?</small></a></li>
                                <li><a href="#step-2">Step 2<br /><small>Question 2 why?</small></a></li>
                                <li><a href="#step-3">Step 3<br /><small>Question 3 why?</small></a></li>
                                <li><a href="#step-4">Step 4<br /><small>Question 4 why?</small></a></li>
								<li><a href="#step-5">Step 5<br /><small>Question 5 why?</small></a></li>
								<li><a href="#step-6">Concluded<br /><small></small></a></li>
                            </ul>
                            <div>
							
                                <div id="step-1">
                                    <h3 class="border-bottom border-gray pb-2">
									<textarea class="form-control" name="root1" placeholder="Explain Why?" required></textarea>
                                </div>
                                <div id="step-2">
                                
                                    <div><textarea class="form-control" name="root2" placeholder="Explain Why?" required></textarea></div>
                                </div>
                                <div id="step-3">
                                   <textarea class="form-control" name="root3" placeholder="Explain Why?"></textarea>
                                </div>
                                <div id="step-4">
                                        <textarea class="form-control" name="root4" placeholder="Explain Why?"></textarea>
                              
                            </div>
							
							<div id="step-5">
                                        <textarea class="form-control" name="root5" placeholder="Explain Why?"></textarea>
                              
                            </div>
							
							
							<div id="step-6">
                                    <h5> Corrective Action</h5>
                                    <textarea class="form-control" name="corrective" required></textarea>
									<br/>
									
									 <h5 >Upload Document: </h5>
									  <input type="hidden" class="form-control" name="imgg" value="">
									  
                                   <input type="file" class="form-control" name="img">
                             
                            </div>
                        </div>
                    </div>
					
               </form>
           <script language="javascript">
		   "use strict";

$(document).ready(function () {
  // Step show event
  $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition)
   {
 $("#Button").addClass('disabled');
      $("#Button1").addClass('disabled');
 
	
	if(stepNumber>="2")
	{
	 $("#Button").removeClass('disabled');
    $("#Button1").removeClass('disabled');
	}
	
    if (stepPosition === 'first')
	 {
	  
      $("#prev-btn").addClass('disabled');
    } 
	else if (stepPosition === 'final') 
	{
	$("#Button").removeClass('disabled');
    $("#Button1").removeClass('disabled');
   
      $("#next-btn").addClass('disabled');
    } 
	else
	 {
	
	
      $("#prev-btn").removeClass('disabled');
      $("#next-btn").removeClass('disabled');
    }
  }); // Toolbar extra buttons

  var btnFinish = $('<button type="button" name="dS" id="Button"  ></button>').text('Concluded').addClass('btn btn-info').on('click', function () 
 {
  window.open('#step-6','_self');
  });
  var btnCancel = $('<button type="submit" name="submit" id="Button1"></button>').text('Submit').addClass('btn btn-danger').on('click', function () 
  {
   // $('#smartwizard').smartWizard("reset");
  }); // Smart Wizard

  $('#smartwizard').smartWizard({
    selected: 0,
    theme: 'default',
    transitionEffect: 'fade',
    showStepURLhash: true,
    toolbarSettings: {
     
      toolbarButtonPosition: 'end',
      toolbarExtraButtons: [btnFinish, btnCancel]
    }
  }); // External Button Events

  $("#reset-btn").on("click", function () {
    // Reset wizard
    $('#smartwizard').smartWizard("reset");
    return true;
  });
  $("#prev-btn").on("click", function () {
    // Navigate previous
    $('#smartwizard').smartWizard("prev");
    return true;
  });
  $("#next-btn").on("click", function () {
    // Navigate next
    $('#smartwizard').smartWizard("next");
    return true;
  });
  $("#theme_selector").on("change", function () {
    // Change theme
    $('#smartwizard').smartWizard("theme", $(this).val());
    return true;
  }); // Set selected theme on page refresh

  $("#theme_selector").change();
});</script>
									<?php
									}
									?>
									
									
									
                               </div></div></div></div>
								
    <!-- ============ Search UI End ============= -->
	 
</body>

</html>
<?php
							   if(isset($_POST['submit']))
							   {
							   $user=$_SESSION['user'];
							   $sn=$_GET['sno'];
							   $cmnt=$_POST['root1'].";".$_POST['root2'].";".$_POST['root3'].";".$_POST['root4'].";".$_POST['root5'].";";
							   $rt=mysqli_real_escape_string($con,$cmnt);
							   $corrective=mysqli_real_escape_string($con,$_POST['corrective']);
							   
							   if($_FILES['img']['name']=="")
							   {
							    $img=$_FILES['img']['name'];
							   }
							   else
							   {
							   $img=$sn.$_FILES['img']['name'];
							   move_uploaded_file($_FILES['img']['tmp_name'],'auditpic/'.$img);
							   }
							   
							   $date=date("Y-m-d");
							   
							   $ghjkl=mysqli_query($con,"insert into tblaction1 (sno,comment,date,user,img,corrective,status3)values('$sn','$rt','$date','$user','$img','$corrective','root')");
							   
							   
					$sd=mysqli_query($con,"select * from tblaction1 where sno='$sn' order by id desc limit 1");
							$sd1=mysqli_fetch_array($sd);
							 $snid=$sd1['id'];
							 
							   //$jk1=mysqli_query($con,"update tblroster set status1='closedoff' where sno='$_GET[sno1]'");
							   
							   ?>
							   <script language="javascript">
							   window.open('gmpauditnc2.php?sno=<?php echo $_GET['sno'];?>&sno1=<?php echo $_GET['sno1'];?>&snid=<?php echo $snid;?>','_self');
							   </script>
							    
				                 <?php
				                  }
				                  ?>
								  
								   <?php
							   if(isset($_POST['submit3']))
							   {
							   $user=$_SESSION['user'];
							   $sn=$_GET['sno'];
							   $cmnt=$_POST['rt'];
							   $rt=mysqli_real_escape_string($con,$cmnt);
							   
							   
							   if($_FILES['img']['name']=="")
							   {
							    $img=$_FILES['img']['name'];
							   }
							   else
							   {
							   $img=$sn.$_FILES['img']['name'];
							   move_uploaded_file($_FILES['img']['tmp_name'],'auditpic/'.$img);
							   }
							   
							   $date=date("Y-m-d");
							   
							   $ghjkl=mysqli_query($con,"insert into tblaction1 (sno,comment,date,user,img)values('$sn','$rt','$date','$user','$img')");
							   
							   
				             	$sd=mysqli_query($con,"select * from tblaction1 where sno='$sn' order by id desc limit 1");
						    	$sd1=mysqli_fetch_array($sd);
							    $snid=$sd1['id'];
							 
							   //$jk1=mysqli_query($con,"update tblroster set status1='closedoff' where sno='$_GET[sno1]'");
							   
							   ?>
							   <script language="javascript">
							     window.open('gmpauditnc2.php?sno=<?php echo $_GET['sno'];?>&sno1=<?php echo $_GET['sno1'];?>&snid=<?php echo $snid;?>','_self');
							   </script>
							    
				                 <?php
				                  }
				                  ?>
							  
								  <?php
								  }
								  ?>
								  
	<script src="dist-assets/js/plugins/jquery.smartWizard.min.js"></script>
    <script src="dist-assets/js/plugins/datatables.min.js"></script>
    <script src="dist-assets/js/scripts/datatables.script.min.js"></script>
	<script src="dist-assets/js/plugins/dropzone.min.js"></script>
    <script src="dist-assets/js/scripts/dropzone.script.min.js"></script>
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
                  						
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
								<?php
				$sno=$_GET['sno'];
				$sql2=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno' ");
				$row2=mysqli_fetch_array($sql2);
				$tid=$row2['audit'];
				$sid=$row2['sid']; 
				
				$auditdate=date("d-m-Y", strtotime($row2['date']));
				 
				  $auditee=mysqli_query($con,"select * from tblauditee where id='$row2[auditee]'");
                  $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$row2[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM tblauditsection where id='$tid'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM tblauditsection1 where sid='$tid' and id='$sid'");
				   $subtest=mysqli_fetch_array($total2);
				  
				  
				  $total=mysqli_query($con,"SELECT * FROM tblauditsection2 where sid='$tid' and ssid='$sid'");
				  $subtest1=mysqli_fetch_array($total);
				  
                           $total1=mysqli_num_rows($total);
				?>
                             <h4 class="card-title mb-3" style="color:#0000FF"> <?php echo $addtest['name'];?> NC  Detail</h4>
								
                           
								 <div class="row">
                                    
								
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												<th scope="col">Date</th>
                                                <th scope="col">Auditor</th>
												 <th scope="col">Subject</th>
												 <th scope="col">Question</th>
												 <th scope="col">Ans</th>
												 <th scope="col">Status</th>
                                                 <th scope="col">Action</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$df=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno'");
										$gh=mysqli_fetch_array($df);
										
										$sh1=mysqli_query($con,"select * from tblgmpaudit3 where  sno='$sno' and status='waiting'");
										$i=0;
                                        while($hj1=mysqli_fetch_array($sh1))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y", strtotime($gh['date']));?></td>
                                               <td><?php echo $auditor1['name'];?> </td>
                                                <td> <?php echo  $subtest['name']; ?> </td>
												 <td> <?php echo $hj1['ques'] ;?>   </td>
												 <td> <?php echo $hj1['ans'] ;?>   </td>
											   
											     <td> 
												 <?php 
												 if($hj1['status']=="closedoff")
												 {
												 echo "Evidence is submitted";
												 }
												 else
												 {
												  echo $hj1['status'];
												 }
												 
												 ?>  
												 </td>
                                                <td>
												<?php
												if($hj1['ans']=="Compliant" || $hj1['ans']=="Not Applicable")
												{
												}
												else
												{
												?>
      <a href="gmpauditnc1.php?sno=<?php echo $hj1['id'];?>&sno1=<?php echo $_GET['sno'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a>
                                                   <?php
												   }
												   ?>
                                                </td>
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div>
                         </div></div></div></div></div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 
</body>

</html>
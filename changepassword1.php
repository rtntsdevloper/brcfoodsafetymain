<?php
 date_default_timezone_set("Europe/London");
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
 $headingname=$_SESSION['headingname'];
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


<style type="text/css">
<!--
.style1 {color: #0033FF}
-->
</style>
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
     <li class="nav-item" >
	 <a class="nav-item-hold" href="#"> 
	 <i class="fa fa-bank" style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
       </li>
	   
	   
	   <li class="nav-item" >
	 <a class="nav-item-hold" href="logged.php"> 
	 <i class="fa fa-sign-out" style="font-size:34px"></i><span class="nav-text">Logout</span></a>
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
Change Your Password	
<br/></br>					
                            <div class="content">
							<?php
							
							if($access=="Auditor")
							{
							
							$sq=mysqli_query($con,"select * from tblauditor where name='$user'");
							$row=mysqli_fetch_array($sq);
							?>
                               <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								<input type="hidden" name="sno" value="<?php echo $row['id'];?>"  />
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  value="<?php echo $row['name'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Username</label>
                                            <input class="form-control" id="validationTooltip02" type="text"   value="<?php echo $row['user'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										</div></br>			
										<div class="form-row">
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Current Password</label>
                              <input class="form-control" id="validationTooltip02" type="password" placeholder="Current Password"  required="required" name="pwd" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">New Password</label>
                     <input class="form-control" id="validationTooltip02" type="password" placeholder="New Password"  required="required" name="pwd1" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
                                      </div>
									
									   
                                </br>	
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
				
<?php
}
							else if($access=="Auditee")
							{
							
							$sq1=mysqli_query($con,"select * from tblauditee where name='$user'");
							$row1=mysqli_fetch_array($sq1);
							?>
                               <form class="needs-validation" novalidate="novalidate" method="post" action=""  name="form1" enctype="multipart/form-data">
								<input type="hidden" name="sno1" value="<?php echo $row1['id'];?>"  />
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  value="<?php echo $row1['name'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Username</label>
                                            <input class="form-control" id="validationTooltip02" type="text"   value="<?php echo $row1['uname'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										</div></br>			
										<div class="form-row">
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Current Password</label>
                              <input class="form-control" id="validationTooltip02" type="password" placeholder="Current Password"  required="required" name="pwdd" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">New Password</label>
                     <input class="form-control" id="validationTooltip02" type="password" placeholder="New Password"  required="required" name="pwdd1" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
                                      </div>
									
									   
                                </br>	
                                    <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
                                </form>
				
<?php
}
else if($access=="Admin")
							{
							
							$sq2=mysqli_query($con,"select * from tbladmin where name='$user'");
							$row2=mysqli_fetch_array($sq2);
							?>
                               <form class="needs-validation" novalidate="novalidate" method="post" action=""  name="form2" enctype="multipart/form-data">
								<input type="hidden" name="sno2" value="<?php echo $row2['id'];?>"  />
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  value="<?php echo $row2['name'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Username</label>
                                            <input class="form-control" id="validationTooltip02" type="text"   value="<?php echo $row2['username'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										</div></br>			
										<div class="form-row">
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Current Password</label>
                              <input class="form-control" id="validationTooltip02" type="password" placeholder="Current Password"  required="required" name="pwdd2" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">New Password</label>
                     <input class="form-control" id="validationTooltip02" type="password" placeholder="New Password"  required="required" name="pwdd12" value="" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
                                      </div>
                                </br>	
                              <button class="btn btn-primary" type="submit" name="submit2">Submit </button>
                                </form>
				
<?php
}
?>


  </div>
</div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  
</body>

</html>

<?php
if(isset($_POST['submit']))
{
$sno=$_POST['sno'];
$pwd=$_POST['pwd'];
$pwd1=$_POST['pwd1'];
$sqq=mysqli_query($con,"select * from tblauditor where id='$sno' and (pwd='$pwd' && pwd!='$pwd1')");
$match=mysqli_num_rows($sqq); 
if($match>=1)
{
$up=mysqli_query($con,"update tblauditor set pwd='$pwd1' , userstatus='change' where id='$sno'");

?>
<script language="javascript">
alert("Successfully updated!");
window.open('logged.php','_self');
</script>
<?php
}
else
{
?>
<script language="javascript">
alert("Current password is wrong!");
window.open('changepassword1.php','_self');
</script>
<?php
}
}
?>





<?php
if(isset($_POST['submit1']))
{
$sno1=$_POST['sno1'];
$pwdd=$_POST['pwdd'];
$pwdd1=$_POST['pwdd1'];
$sqq1=mysqli_query($con,"select * from tblauditee where id='$sno1' and (pwd='$pwdd' && pwd!='$pwdd1')");
$match1=mysqli_num_rows($sqq1); 
if($match1>=1)
{
$up1=mysqli_query($con,"update tblauditee set pwd='$pwdd1' , userstatus='change' where id='$sno1'");

?>
<script language="javascript">
alert("Successfully updated!");
window.open('logged.php','_self');
</script>
<?php
}
else
{
?>
<script language="javascript">
alert("Current password is wrong!");
window.open('changepassword1.php','_self');
</script>
<?php
}
}
?>




<?php
if(isset($_POST['submit2']))
{
$sno2=$_POST['sno2'];
$pwdd2=$_POST['pwdd2'];
$pwdd12=$_POST['pwdd12'];
$sqq2=mysqli_query($con,"select * from tbladmin where id='$sno2' and (pwd='$pwdd2' && pwd!='$pwdd12')");
$match2=mysqli_num_rows($sqq2); 
if($match2>=1)
{
$up2=mysqli_query($con,"update tbladmin set pwd='$pwdd12' , userstatus='change' where id='$sno2'");

?>
<script language="javascript">
alert("Successfully updated!");
window.open('logged.php','_self');
</script>
<?php
}
else
{
?>
<script language="javascript">
alert("Current password is wrong!");
window.open('changepassword1.php','_self');
</script>
<?php
}
}
?>
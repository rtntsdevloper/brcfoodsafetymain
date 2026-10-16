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
     <li class="nav-item" ><a class="nav-item-hold" href="admin.php?id=1"> <i class="fa fa-bank" style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
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
                            <h4 class="title"> Food Safety Culture Questionnaire </h4>
							<br/>
							
							<p style="color:#009933">This questionnaire is to be completed annually by ALL staff, senior management will analysis the responses and amend the business strategy or food safety cultural programme as necessary in accordance with QP1.1.2 – Food Safety Culture Plan<br/><br/>

We are interested in your thoughts of our company, strategy and where we are in relation to the business maintaining a food safety culture. Please take the time to complete the questionnaire honestly.<br/><br/>

Select one option for each question. You can write details in the comment box to support your answer.
</p>

                            </div>
							
							
                            <div class="content">
                                <form name="form1" onSubmit="return checkReq()" action="mainn1" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                                 <label id="error">Name</label>
                                      <input type="text" class="form-control border-input" placeholder="Name" name="name" required >
                                                 </div>
                                        </div>
                                       
                                    

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Job Role</label>
                                                <input type="text" class="form-control border-input" placeholder="Designation"  name="des" required>
                                            </div>
                                        </div>
										
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Employee Photo</label>
                                                <input type="file" class="form-control border-input"   name="img" required accept="image/*,.jpg,.gif,.png,.jpeg">
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
										 <label>Enter Captcha</label>
	  
	   <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
        <label for='message'>Enter the code above here :</label>
        <br>
        <input id="captcha_code" name="captcha_code" type="text">
        <br>
        Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
										</div></div>
										<?php
										
										include 'connection.php';
										$j=0;
										$sf=mysqli_query($con,"select distinct correct from competency");
										while($ro=mysqli_fetch_array($sf))
										{
										$j++;
										?>
										
										<div class="col-md-12">
                                            <div class="form-group">
                                                <h3 style="color:#FF0000; text-align:center"><?php echo $j;?>. <?php echo $ro['correct'];?></h3>
                                            </div>
                                        </div>
										
										<?php
										$sql=mysqli_query($con,"select * from competency where correct='$ro[correct]'");
										while($row=mysqli_fetch_array($sql))
										{
										 $i=$row['id']-1;
										?>
										
										<input type="hidden" name="qid[]" value="<?php echo $row['id'];?>"> 
										<input type="hidden" name="ques[]" value="<?php echo $row['ques'];?>"> 
										<input type="hidden" name="correct[]" value="<?php echo $row['correct'];?>">
										<input type="hidden" name="ansc[]" value="<?php echo $row['ansc'];?>">
										
									<div class="col-md-12">
                                    <div class="form-group">
                                    <label style="color:#0000FF">
									
									<?php echo $i+1;?>.
                                    <?php echo $row['ques'];?>
									
									</label>
                                            </div>
                                        </div>
										
							<div class="col-md-6">
                            <div class="form-group">
                           <input type="radio"    name="a<?php echo $i;?>" value="<?php echo $row['ansa'];?>"> <?php echo $row['ansa'];?><br/>
						   <input type="radio"   name="a<?php echo $i;?>" value="<?php echo $row['ansb'];?>"> <?php echo $row['ansb'];?><br/>
						   <input type="radio"   name="a<?php echo $i;?>" value="<?php echo $row['ansc'];?>"> <?php echo $row['ansc'];?><br/>
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Comment</label>
                                                <textarea class="form-control border-input"   name="cmnt<?php echo $i;?>"></textarea>
												
                                            </div>
                                        </div>
										<div class="col-md-12">
                                            <div class="form-group" id="error<?php echo $i;?>" style="color:#FF0000">
                                                
												
                                            </div>
                                        </div>
										<?php
										}
										}
										?>
                                    </div>

                                        <div class="text-center">
                                          <button type="submit" name="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
                                          </div>
                                       <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
					
					<script>
function checkReq() 
{
 var n=<?php echo $i;?>;
for (var t3=0; t3<=n;t3++) 
{
var y=t3;
var e=y+1;
var boxes = document.getElementsByName("a"+y);
for (var x = 0;x<=boxes.length; x++) 
{   
    if(boxes[0].checked==false && boxes[1].checked==false && boxes[2].checked==false )
	{
	document.getElementById('error'+y).innerHTML="*Please choose one option for question no."+e+" *";
    boxes[x].focus();
    return false;
     }   
     else
      {
    document.getElementById('error'+y).innerHTML="";
       }
	   }
       }
	
        }
</script>


  
  </div>
</div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 
</body>

</html>
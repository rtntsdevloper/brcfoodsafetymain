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
                    <div class="user col align-self-end">
                     <i class="fa fa-user-circle" style="color:#188BB1; font-size:16px"> Welcome: <?php echo $user;?> </i> </div>
                </div>
            </div>
        </div>
		
     <div class="side-content-wrap">
     <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
     <ul class="navigation-left">
     <li class="nav-item" >
	 <a class="nav-item-hold" href="logged.php"> <i class="fa fa-bank" style="font-size:34px"></i><span class="nav-text">Logout</span></a>
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
                            <h4 class="title">Product List</h4>
							<br/>
							
                            </div>
							
							
                            <div class="content">
                                <form name="form1" onSubmit="return checkReq()" action="addsnclproduct" method="post" enctype="multipart/form-data">
                                    <div class="row">
									
									
<script>
function prod(str)
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("chkproduct").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","snclproduct1.php?q="+str,true);
xmlhttp.send();  
  }
</script>


									 <div class="col-md-4">
                                      <div class="form-group">
                                                 <label id="error">Select Category</label>
                                      <select type="text" class="form-control border-input"  name="cate" required onChange="return prod(this.value)" >
									  <option>Please Select</option>
									  <?php
									  $sql=mysqli_query($con,"select distinct cate,cate1  from tblsnclproduct order by cate ASC");
									  while($row=mysqli_fetch_array($sql))
									  {
									  ?>
									   <option value="<?php echo $row['cate1'];?>"><?php echo $row['cate'];?></option>
									   <?php
									   }
									   ?>
									  </select>
                                                 </div>
                                        </div>
									
                                     <div class="col-md-4">
                                      <div class="form-group" id="chkproduct">
                                                 <label id="error">Select Product</label>
                                      <input type="text" class="form-control border-input"   disabled="disabled" >
                                                 </div>
                                        </div>
                                       

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Quantity</label>
                                                <input type="text" class="form-control border-input"   name="qty"  required>
                                            </div>
                                        </div>
										
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Use By</label>
                                                <input type="date" class="form-control border-input"   name="useby" required >
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Batch Code</label>
                                                <input type="text" class="form-control border-input"   name="batch" required >
                                            </div>
                                        </div>
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Weight</label>
                                                <input type="text" class="form-control border-input"   name="weight" required >
                                            </div>
                                        </div>
										
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label >Upload Pics</label>
                                                <input type="file" class="form-control border-input"   name="img[]"  multiple required accept="image/*,.jpg,.gif,.png,.jpeg">
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label >Comment</label>
                                                <textarea  class="form-control border-input"   name="cmnt"></textarea>
                                            </div>
                                        </div>
										
                                    </div>

                                        <div class="text-center">
                                          <button type="submit" name="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
                                          </div>
                                       <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>  <div class="card-body">
							
						
                                <div class="table-responsive">
                                  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Use By</th>
												<th scope="col">Weight</th>
												<th scope="col">Batch Code</th>
                                                <th scope="col">Photo</th>
												<th scope="col">Edit</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblsnclproduct1 where name!='' and img!=''");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										
										 $sql2=mysqli_query($con,"select * from tblsnclproduct where id='$row[name]'");
 $row2=mysqli_fetch_array($sql2);

										?>
                                            <tr>
                                                <td scope="row"><?php echo $i;?></td>
                                                <td><?php echo $row2['cate'];?></td>
                                               <td><?php echo $row2['name'];?></td>
                                                <td><?php echo $row['qty'];?> </td>
												
												<td><?php echo date('d-m-Y', strtotime($row['useby']));?> </td>
												<td><?php echo $row2['weight'];?> </td>
                                                <td><?php echo $row['batchcode'];?></td>
												 <td>
												 <?php
	 $string1 = $row['img'];
   $string1= rtrim($string1, ";");
   $tags1 = explode(';' , $string1);
   $counters = 0;
  foreach($tags1 as $key1)
  {  
    $info1 = new SplFileInfo($key1);
   $tpe1=$info1->getExtension();
   
  if($tpe1=="jpg" || $tpe1=="jpeg" || $tpe1=="png" || $tpe1=="PNG")
    {
	?>
	
	<a href="productlist/<?php echo $key1;?>" target="_blank"><?php echo $key1;?></a>
	<?php
	}}
	?>
	</td>
	
	 <td>
	 <a href="#" class='modalButton' data-target="#new-task-modal1" data-toggle="modal"  data-qid='<?php echo $row2['id'];?>'>
	 <button class="btn btn-danger" >Edit</button></a>
	 
	 </td>
	 
	 
												 </tr>
												 
												 
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
				
				
				<script>
    $('.modalButton').click(function()
	{
	    var qid = $(this).attr('data-qid');
	
        $.ajax({url:"editsnclproduct.php?qid="+qid,cache:false,success:function(result)
		{
        $("#modal-body2").html(result);
        }});
        });
		
	</script> 
	            
	 <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal1">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom" >
                    <h3 class="modal-title" id="exampleModalCenterTitle">Edit Detail</h3>
					
                </div>
				 
							 <div id="modal-body2">
								<?php
								 include 'editsnclproduct.php';   
								?>         
						</div>
                            </div>
                        </div>
						
						
  </div>
</div>
        <!-- PAGINATION CONTROL -->
    <!-- ============ Search UI End ============= -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  	<script src="dist-assets/js/plugins/jquery.smartWizard.min.js"></script>
   <script src="dist-assets/js/plugins/datatables.min.js"></script>
    <script src="dist-assets/js/scripts/datatables.script.min.js"></script>
	 <script src="dist-assets/js/plugins/dropzone.min.js"></script>
    <script src="dist-assets/js/scripts/dropzone.script.min.js"></script>
	
</body>

</html>
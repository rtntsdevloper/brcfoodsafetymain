	<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
 <script type="text/javascript" src="js/jquery.signature.min.js"></script>
 <script type="text/javascript" src="js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.signature.css">			
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>
<?php
$sno=$_GET['sno'];
$sq=mysqli_query($con,"select * from tblprocedure where id='$sno'");
$gh=mysqli_fetch_array($sq);

$sq1=mysqli_query($con,"select * from tblmodule1 where id='$gh[module]'");
$gh1=mysqli_fetch_array($sq1);

$sq12=mysqli_query($con,"select * from tbldept1 where id='$gh[dept]'");
$gh2=mysqli_fetch_array($sq12);


?><div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=procedure"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">

                        <div class="col-md-4">
                           <div class="full white_shd">
                              <div class="full graph_head">
                               Module : <?php echo $gh1['name'];?>
							   <br/>
							    Department : <?php echo $gh2['dept'];?>
							   <br/>
							   							  
							    Section Name: <?php echo $gh['name'];?>
							   <br/>
							Date: <?php echo date('d-m-Y',strtotime($gh['date']));?>
							<br/>
							Version: <?php echo $gh['version'];?>
                              </div>
                           
                           </div>
                        </div>
						
						<div class="col-md-8">
                           <div class="full white_shd">
                              <div class="full graph_head">
							  
              <object data="procedures/<?php echo $gh['img'];?>" type="application/pdf" width="100%" height="1200px"></object>
					 
                              </div>
                           </div>
						   
						</div>
					   
                               </div> 
							
							
							
							
							
							 <!-- The Modal -->
							 
							
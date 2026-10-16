
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>FSC Survey </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=ques"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                             <h4 class="card-title mb-3">FSC Survey</h4>
								
                              
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                           
												<th scope="col">Section: <?php echo $_GET['sno'];?></th>												
                                            </tr>
                                        </thead>
                                        <tbody>
									
										<?php
									include '../connection.php';
										
										$sql=mysqli_query($con,"select distinct ques from competency3 where correct='$_GET[sno]'");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr><td style="color:#0033FF"><?php echo $row['ques'];?></td></tr>
											<?php
											$sql1=mysqli_query($con,"select distinct ans, cmnt from competency3 where correct='$_GET[sno]' and ques='$row[ques]'");
											$j=0;
										while($row1=mysqli_fetch_array($sql1))
										{
										$j++;
										?>
												
												 <tr> 
												 <td><?php echo $j;?>: <?php echo $row1['ans'];?>
												 
												 <br/>
												 <?php 
												 if($row1['cmnt']!="")
												 {
												 ?>
												Comment: <?php echo $row1['cmnt'];?>
												<?php
												}
												?>
												 
												 </td></tr>
												 
                                                
											   
                            
							 
                                            
                                           <?php
										   }
										   }
										   ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
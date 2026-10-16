 <?php 
$sno=$_GET['sno'];


$sql1=mysqli_query($con,"select * from tbl_micortrend where id='$sno'");
$row1=mysqli_fetch_array($sql1);
								
?>

                <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Micro Trending</a></li>
                        <li>Micro Trending Sub-Section</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=microview"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<div class="card-title"> Section: <?php echo $row1['name'];?></div>
			
					
					                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="card card-profile-1 mb-4">
                                      <div class="card-body">
                                      <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                      <thead>
                                       <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
												<th scope="col">Sample No.</th>
												<th scope="col">Location</th>
												<th scope="col">Area</th>
												<th scope="col">Frequency</th>
                                                <th scope="col">Edit</th>
												 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										 
										 $sql2=mysqli_query($con,"select * from tbl_micortrend1 where sid='$sno'");
										  $i=0;
                                         while($row2=mysqli_fetch_array($sql2))
										 {
										 $i++;
										 ?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row2['name'];?></td>
                                                <td><?php echo $row2['sampleno'];?></td>
                                                
                                                <td><?php echo $row2['location'];?></td>
                                                <td><?php echo $row2['area'];?></td>
                                                <td><?php echo $row2['frequency'];?></td>
												  
												 <td>
											      <a href="admin.php?id=microedit&sno=<?php echo $row2['id'];?>" >
												  <span class="badge badge-info">Edit</span></a>
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
									</div></div>
									
									
									
									
									
                               </div></div></div></div>
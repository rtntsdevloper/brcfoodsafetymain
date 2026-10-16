
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
							
							
                             <h4 class="card-title mb-3">FSC Survey Detail</h4>
								
                              
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												<th scope="col">Date</th>
												<th scope="col">Name</th>
												<th scope="col">Job Role</th>
												<th scope="col">Image</th>
                                             
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
									
										include '../connection.php';
										$sql=mysqli_query($con,"select distinct date,name, des,img from competency3");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
												  <td><?php echo date('d-m-Y',strtotime($row['date']));?></td>
												  <td><?php echo $row['name'];?></td>
												   <td><?php echo $row['des'];?></td>
												  
													 <td><img src="../pic/<?php echo $row['img'];?>" width="70" /></td>
                            
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
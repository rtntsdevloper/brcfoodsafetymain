<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Machinery Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                             <h4 class="card-title mb-3">Machinery Management</h4>
								
                              
								
                             <div class="table-responsive">
                             <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                             <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Make</th>
                                                <th scope="col">Code</th>
												<th scope="col">Location</th>
                                                <?php
                                                if($access=='Admin')
                                                {
                                                ?>
                                                <th scope="col">Calibration</th>
                                                <?php
                                                }
                                                ?>
                                                <th scope="col">View</th>
                                                
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblequipment where calbap='Yes' and status='Active'");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['name'];?></td>
                                               <td><?php echo $row['make'];?></td>
                                                <td><?php echo $row['code'];?> </td>
	
                                                <td><?php echo $row['location'];?></td>
												<?php
												  if($access=='Admin')
                                                {
                                                ?>
                                                <td> <a href="admin.php?id=calibrationeq1&sno=<?php echo $row['id'];?>" class="btn btn-primary">Update Calibration</a></td>
                                                <?php
                                                }
                                                ?>
												
									<td>
									 <a href="admin.php?id=calibrationeq2&sno=<?php echo $row['id'];?>">
												<button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
												</a></td>
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

</div>
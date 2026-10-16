
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
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=staffdetail"><button class="btn btn-danger" style="float:right; margin-left:15px">Staff Detail</button></a>
							
                             <h4 class="card-title mb-3">FSC Survey Detail</h4>
								
                              
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												<th scope="col">Section</th>
                                             
                                                 <th scope="col">Action</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
									
										include 'connection.php';
										$sql=mysqli_query($con,"select distinct correct from competency");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
												  <td><?php echo $row['correct'];?></td>
                             <td>
						
							 
							 <a href="admin.php?id=ques1&sno=<?php echo $row['correct'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a></td>
							 
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
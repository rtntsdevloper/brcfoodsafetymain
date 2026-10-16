


<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Inspection Detail</li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
						
							
                             <h4 class="card-title mb-3">Inspection Detail</h4>
								
                           
								
                                <div class="table-responsive">
                                  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date </th>
                                                <th scope="col">Inspection Type</th>
                                                <th scope="col">View</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblissues  order by date asc");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date('d-m-Y',strtotime($row['date']));?></td>
                                               <td><?php echo $row['inspection'];?></td>
                                              
												<td>
												 <a href="admin.php?id=viewcustomerdetail1&sno=<?php echo $row['id'];?>&sno1=<?php echo $row['customer'];?>">
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
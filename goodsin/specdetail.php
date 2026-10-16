<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Specification Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
						
                             <h4 class="card-title mb-3">Specification Management</h4>
								
                              
								
                                <div class="table-responsive">
                                  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Supplier</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">View</th>
                                                
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblspecdetail");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										
										
				$sq11=mysqli_query($con,"select * from tblrawmaterial where id='$row[product]'");
				$row1=mysqli_fetch_array($sq11);
				
				$sq12=mysqli_query($con,"select * from tblrawsupplier where supid='$row[supp]'");
				$row2=mysqli_fetch_array($sq12);
				
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
												 <td><?php echo $row2['supname'];?></td>
                                                <td><?php echo $row1['pname'];?></td>
                                              
                                            
												<td>
												 <a href="admin.php?id=viewspec&sno=<?php echo $row['product'];?>">
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
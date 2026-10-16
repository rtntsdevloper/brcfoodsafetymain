
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Product Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
				
		
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="table dataTable-collapse" id="sales_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												  <th scope="col">Product Id</th>
                                                <th scope="col">Product Code</th>
												 <th scope="col">Product Name</th>
												  <th scope="col">Product Type</th>
												 <th scope="col">Shelf Life</th>
												 <th scope="col">View Spec</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										$sql=mysqli_query($con,"select * from tblproduct");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										
										
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['prodid'];?></td>
                                                <td><?php echo $row['prodcode'];?></td>
                                                <td><?php echo $row['name'];?></td>
												 <td><?php echo $row['ptype'];?></td>
												 <td><?php echo $row['slife'];?></td>
											   
											   
                                                <td>
												
                                            <a href="admin.php?id=viewspecc&sno=<?php echo $row['id'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a>
                                                </td>
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
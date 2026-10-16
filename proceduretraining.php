<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Trainings</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=procedure"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							 <a href="admin.php?id=addproceduretraining"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
							
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                  <thead>
				         <tr>
						 
				 <th></th>
                       <th>Date</th>
                       <th>Trainer</th>
					   <th>Total Staff</th>
                    
                   <th>View</th>
                 </tr>
					</thead>
					<tbody>
					         <?php
							 
							  $sql=mysqli_query($con,"select * from tblproceduretraining");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
							 
							?>
                      <tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
					  <td><?php echo $row['auditor']; ?></td>
					   <td><?php echo $row['totalstaff']; ?></td>
                   
					  <td><a href="admin.php?id=proceduredetail&sno=<?php echo $row['id'];?>"><button class="btn btn-danger">View</button></a></td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
<div class="main-content">
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
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							 <a href="admin.php?id=addprocedure"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
							
							 <a href="admin.php?id=proceduretraining">
							 <button class="btn btn-warning" style="float:right; margin-left:15px">Procedure Training</button></a>
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
				         <tr>
						 
				 <th></th>
                       <th>Date</th>
                       <th>Name</th>
                       <th>Module</th>
					   <th>Department</th>
                       <th>Version</th>
                        <th>View</th>
						 <th>Edit</th>
                 </tr>
					</thead>
					<tbody>
					         <?php
							  $sql=mysql_query("select * from tblprocedure");
							  $i=0;
						      while($row=mysql_fetch_array($sql))
						       {
							 $i++;
							 
							 $sq1=mysql_query("select * from tblmodule1 where id='$row[module]'");
$gh1=mysql_fetch_array($sq1);

$sq12=mysql_query("select * from tbldept1 where id='$row[dept]'");
$gh2=mysql_fetch_array($sq12);
					
					?>
                      <tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
					  <td><?php echo $row['name']; ?></td>
                      <td><?php echo $gh1['name']; ?></td>
					   <td><?php echo $gh2['dept']; ?></td>
                      <td><?php echo $row['version']; ?></td>
					  <td><a href="admin.php?id=procedure1&sno=<?php echo $row['id'];?>"><button class="btn btn-danger">View</button></a></td>
					  <td><a href="admin.php?id=editpocedure&sno=<?php echo $row['id'];?>"><button class="btn btn-danger">Edit</button></a></td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
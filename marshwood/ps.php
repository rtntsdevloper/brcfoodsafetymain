
<div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Product Specification
							   <a href="admin.php?id=1"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
                           </div>
                        </div>
                     </div>
					
                     <!-- row -->
                  <div class="row">
                                    
									
									
								
								  <div class="table-responsive">

				   <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
											 <tr>
					  <th> </th>
                  
                        <th>Product Id </th>
                        <th >Product Code</th>
                        <th >Product Name</th>
						<th >Original Spec</th>
                        <th >View Spec</th>
						<th >Specification</th>
						  <th >Edit Spec</th>
                        
						
                    </tr>
					</thead>
					<tbody>
					         <?php
						
							$sql=mysqli_query($con,"select * from tblproduct1");
							$i=0;
						    while($row=mysqli_fetch_array($sql))
						     {
							 $i++;
							?>
                      <tr>
					  <td><?php echo $i;?></td>
					 
                        <td><?php echo $row['prodid']; ?></td>
                       <td><?php echo $row['prodcode']; ?></td>
                       <td><?php echo $row['prodname']; ?></td>
					   
					
					    <td>
						<?php
						if($row['spec']!='')
						{
						?>
						<a href="orgspec/<?php echo $row['spec']; ?>" target="_blank"> <button  class="btn btn-success" >
						View</button></a>
						<?php
						}
						?>
						</td>
						
						
						<td> <a href="admin.php?id=viewspec1&pid=<?php echo $row['prodid']; ?>">
					   <button  class="btn btn-primary" >View</button></a></td>
                       <td>
					  <?php
					  if($row['status1']=="")
					  {
					  ?>
					  <a href="admin.php?id=ps1&pid=<?php echo $row['prodid']; ?>">
					   <button  class="btn btn-danger" >Pending</button></a>
					   <?php
					   }
					  else if($row['status1']=="Accepted")
					  {
					  ?>
					  <a href="admin.php?id=viewspec1&pid=<?php echo $row['prodid']; ?>">
					   <button  class="btn btn-success" ><?php echo $row['status1'];?></button></a>
					   <?php
					   }
					   else
					   {
					   ?>
					     <a href="admin.php?id=ps1&pid=<?php echo $row['prodid']; ?>">
					   <button  class="btn btn-warning" ><?php echo $row['status1'];?></button></a>
					   <?php
					   }
					   ?>
					   
					   
					   </td>
                    <td>
					<?php
					 if($row['status1']!="Accepted")
					  {
					  ?>
					<a href="admin.php?id=ps1&pid=<?php echo $row['prodid']; ?>">
					   <button  class="btn btn-info" >Edit</button></a>
					   <?php
					   }
					   ?></td>
                </tr>
					<?php
					}
					
					?>
					  
	                                        
	                                    </tbody>
                                    </table>
									
                            </div></div>  </div> </div> 
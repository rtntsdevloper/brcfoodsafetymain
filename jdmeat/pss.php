              
			     <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Product Specifications
							  
							   <a href="admin.php?id=1"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
                           </div>
                        </div>
                     </div>
                  
				  
					
				
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
					 
				    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                       <thead>
					 <tr>
                        <th></th>
                        <th>Product Code</th>
                        <th>Name</th>
						<th >Original Spec</th>
                        <th>Action</th>
                      </tr>
					 
					</thead>
                                       <tbody>
       <?php
	  $sqlu=mysqli_query($con,"select * from tblproduct1 where status1='waiting' ");
	  $i=0;
	  while($ru = mysqli_fetch_array($sqlu))
	  {
	  $i++;
?>
												         <tr>
		                                                <td><?php echo $i;?></td>
														<td><?php echo $ru['prodcode'];?></td>
														<td><?php echo $ru['prodname'];?></td>
												
					   
					    <td>
						<?php
						if($ru['spec']!='')
						{
						?>
						<a href="orgspec/<?php echo $ru['spec']; ?>" target="_blank"> <button  class="btn btn-success" >
						View</button></a>
						<?php
						}
						?>
						</td>
                                                        <td> 
										<a href="admin.php?id=jdpss1&pid=<?php echo $ru['prodid'];?>&id2=<?php echo $_GET['id2'];?>">
 <button type="button" rel="tooltip" title="View Detail" class="btn btn-danger btn-simple btn-xs">View</button></a>
														</td>
														
													</tr>
													<?php
													}
													?>      </tbody>
                                    </table>
									
                            </div></div>  </div> </div> 
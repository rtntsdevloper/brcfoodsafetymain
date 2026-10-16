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
							
							<a href="admin.php?id=goodsin"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=uploadcsv1"><button class="btn btn-info" style="float:right; margin-left:15px">Upload CSV</button></a>
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
				              <tr>
						 
			          	  <th>
				    </th>
                       <th>Date</th>
                       <th>Document Number</th>
                       <th>CSV</th>
                         </tr>
					              </thead>
					            <tbody>
					         <?php
							  $sql=mysqli_query($con,"select * from tblcsv order by date desc");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
					           ?>
                      <tr>
					   <td><?php echo $i;?></td>
					   <td><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
					   <td><?php echo $row['po']; ?></td>
                       <td><a href="csvdoc/<?php echo $row['img'];?>" target="_blank" > <?php echo $row['img'];?></a></td>
					  </tr>
					
					<?php
					   }
					?>
					</tbody>
                     </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
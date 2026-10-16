
<?php
  $cid=$_GET['cid'];
  ?><div class="main-content">
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
							
							<a href="admin.php?id=addnewgoods&cid=<?php echo $cid;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
				         <tr>
						 
				 <th></th>
                       
                       <th>Supplier Code</th>
                       <th>Supplier</th>
					
					   <th>View</th>
                      
                 </tr>
					</thead>
					<tbody>
					         <?php
							  $csv=$_GET['sno'];
							 
							  $sql=mysqli_query($con,"select distinct adr1,suppcode from tblticcosupplier where img='$csv'");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
					?>
                      <tr>
					  <td><?php echo $i;?></td>
					 
					  <td><?php echo $row['suppcode']; ?></td>
                      <td><?php echo $row['adr1']; ?></td>
					  <td><a href="admin.php?id=addnewgoods4&sno=<?php echo  $csv;?>&cid=<?php echo $cid;?>"><button class="btn btn-primary">View</button></a></td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
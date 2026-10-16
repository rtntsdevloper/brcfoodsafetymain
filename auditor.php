<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Auditor Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=addauditor"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Auditor Management</h4>
								
                                <p>List of auditors</p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Username</th>
												
												 <th scope="col">Status</th>
                                                <th scope="col">Action</th>
												<th scope="col">Edit/ Delete</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblauditor");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['name'];?></td>
                                               <td><?php echo $row['contact'];?></td>
                                                <td><?php echo $row['email'];?> </td>
												<td><?php echo $row['user'];?> </td>
											
                                                <td>
												<?php
												if($row['status']=="Inactive")
												{
												?>
												<span class="badge badge-danger"><?php echo $row['status'];?></span>
												<?php
												}
												else
												{?>
												<span class="badge badge-success"><?php echo $row['status'];?></span>
												
												<?php
												}?>
												</td>
        <td><?php
												if($row['status']=="Inactive")
												{
												}
												else
												{
												?>
												<a href="admin.php?id=viewauditor&sno=<?php echo $row['id'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a><?php
												}
												?>   </td>
		
		 <td><?php
												if($row['status']=="Inactive")
												{
												}
												else
												{
												?><a href="admin.php?id=editauditor&sno=<?php echo $row['id'];?>"><span class="badge badge-warning">Edit </span> </a><?php
												}
												?><br/> 
		 
		 
		 <a href="deleteauditor.php?id=<?php echo $row['id'];?>" onclick="return confirm('Are You Sure!')"> <span class="badge badge-danger">Delete</span></a>
		 
		 </td>
		
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
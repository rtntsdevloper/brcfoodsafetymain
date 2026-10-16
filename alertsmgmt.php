<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Admin Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=alerts"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
							<a href="admin.php?id=1"><button class="btn btn-warning" style="float:right; margin-left:15px">Category Detail</button></a>
							
							
                             <h4 class="card-title mb-3">Alerts Management</h4>
							
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
												<th scope="col">Description</th>
                                                <th scope="col">Weblink</th>
                                                <th scope="col">Category</th>
												<th scope="col">Type</th>
												 <th scope="col">Delete</th>
												
												 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql1=mysqli_query($con,"select * from tblalerts order by date asc");
										$i=0;
								while($row=mysqli_fetch_array($sql1))
										{
										$i++;
										
										$sql2=mysqli_query($con,"select * from tblalert1 where id='$row[status]'");
								        $row2=mysqli_fetch_array($sql2);
								
								
										?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date('d-m-Y',strtotime($row['date']));?></td>
                                               <td><?php echo $row['ques'];?></td>
                                                <td><a href="<?php echo $row['weblink'];?>" target="_blank"> <span class="badge badge-info">View Link</span></a></td>
												 <td><?php echo $row['category'];?> </td>
												  <td><?php echo $row2['name'];?> </td>
												  <td><a href="delalerts.php?sno=<?php echo $row['id'];?>" onclick="return confirm('Are You Sure?')">
												  <span class="badge badge-danger">Delete</span></a></td>
												  
                                             
												  
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
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Audit Management </li>
                    </ul>
</div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=addaudit1"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Knowledge Management</h4>
								
                                <p>List of audits</p>
								
                                <div class="table-responsive">
                                <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                             <th scope="col">Section </th>
							 <th scope="col">View </th>
                                                
                                            </tr>
                                        </thead>
                                      
									  <tbody>
									  <?php
									  $sql=mysqli_query($con,"select * from tblauditsection");
									  $t=1;
									  while($row=mysqli_fetch_array($sql))
									  {
									  ?>
                                            <tr>
                                                <td><?php echo $t;?></td>
                                                <td><?php echo $row['name'];?></td>
                                                <td>
												<?php
									  $sql2=mysqli_query($con,"select * from tblauditsection1 where sid='$row[id]'");
									  $g=1;
									  while($row2=mysqli_fetch_array($sql2))
									  {
									  ?>
									  <?php echo $g;?> . <?php echo $row2['name'];?> <br />
									  <?php
									  $g++;
									   }
									  ?>
												 </td>
												 <td><a href="admin.php?id=viewaudit&sno=<?php echo $row['id'];?>">
												 <button class="btn btn-danger">View</button></a> 
												 
												 </th>
                                            </tr>
											<?php
											$t++;
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
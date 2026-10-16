          <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Auditor Assignment </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=auditorassign1"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Auditor Assignment</h4>
								
                                <p> List of audits </p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									
                                   
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												  <th scope="col">Date</th>
                                                <th scope="col">Auditor</th>
                                                <th scope="col">Auditee</th>
												 <th scope="col">Subject</th>
                                                 <th scope="col">Action</th>
												  <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblroster");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y", strtotime($row['date']));?></td>
                                               <td>
											     <?php
											    $sh=mysqli_query($con,"select * from tblauditor where id='$row[auditor]'");
                                                $hj=mysqli_fetch_array($sh);
												echo $hj['name'];
												?>

											   </td>
                                                <td><?php
											    $sh13=mysqli_query($con,"select * from tblauditee where id='$row[auditee]'");
                                                $hj13=mysqli_fetch_array($sh13);
												echo $hj13['name'];
												?> </td>
												
												
												 <td>
											     <?php
											    $sh1=mysqli_query($con,"select * from subtest where sid='$row[sid]'");
                                                $hj1=mysqli_fetch_array($sh1);
												echo $hj1['subtest'];
												?>

											   </td>
											   
											   
                             <td><a href="admin.php?id=auditdetail"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a></td>
							 
							  <td>
							  <?php
							  if($access=="Admin")
							  {
							  ?>
							  <a href="deletedetail.php?sno=<?php echo $row['id'];?>" onclick="return confirm ('Are You Sure?');"><button class="btn btn-danger" type="button"><i class="fa fa-close"></i></button></a>
							  <?php
							  }
							  ?>
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
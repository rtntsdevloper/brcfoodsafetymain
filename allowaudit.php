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
							<a href="admin.php?id=gmpaudit"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Auditor Assignment</h4>
								
                                <p>Listt of users</p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												  <th scope="col">Date</th>
                                                <th scope="col">Auditor</th>
                                                <th scope="col">Auditee</th>
												 <th scope="col">Subject</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblgmpaudit2");
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
											   
                                                <td>
												 <?php
											    $sh13=mysqli_query($con,"select * from tblauditee where id='$row[auditee]'");
                                                $hj13=mysqli_fetch_array($sh13);
												echo $hj13['name'];
												  ?>
												</td>
												
												 <td>
											     <?php
											    $sh1=mysqli_query($con,"select * from tblauditsection where id='$row[audit]'");
                                                $hj1=mysqli_fetch_array($sh1);
												echo $hj1['name'];
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
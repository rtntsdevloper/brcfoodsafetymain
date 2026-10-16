<?php
$sq=mysqli_query($con,"select * from tblauditee where name='$user'");
$qu=mysqli_fetch_array($sq);
?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Audit Details </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							
                             <h4 class="card-title mb-3">Audit Detail</h4>
								
                              
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												<th scope="col">Assigned Audit Date</th>
												<th scope="col">Attempted Audit Date</th>
                                                <th scope="col">Auditor</th>
                                                <th scope="col">Auditee</th>
												 <th scope="col">Subject</th>
                                                 <th scope="col">Action</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if($access=="Admin")
										{
										$sql=mysqli_query($con,"select * from tblroster where  status1!='waiting' order by date DESC");
										}
										else
										{
										$sql=mysqli_query($con,"select * from tblroster where auditee='$qu[id]' and status1!='waiting' order by date DESC");
										}
								
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
												 <td><?php echo date("d-m-Y", strtotime($row['date']));?></td>
                                                <td><?php echo date("d-m-Y", strtotime($row['auditdate']));?></td>
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
											   
											   
                             <td>
						
							 
							 <a href="admin.php?id=ncview&sno=<?php echo $row['id'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a></td>
							 
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
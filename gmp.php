<?php
$sq=mysqli_query($con,"select * from tblauditee where name='$user'");
$qu=mysqli_fetch_array($sq);


$sq1=mysqli_query($con,"select * from tblauditor where name='$user'");
$qu1=mysqli_fetch_array($sq1);
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
												<th scope="col">Audit Date</th>
                                                <th scope="col">Auditor</th>
                                                <th scope="col">Auditee</th>
												<th scope="col">Audit</th>
                                                 <th scope="col">Action</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										if($access=="Auditor")
										{
										$sql=mysqli_query($con,"select * from tblgmpaudit2 where auditor='$user' ");
										}
										else if($access=="Auditee")
										{
										$sql=mysqli_query($con,"select * from tblgmpaudit2 where auditee='$user' ");
										}
									    else 
										{
										$sql=mysqli_query($con,"select * from tblgmpaudit2  ");
										}
										
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
												
														
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
												 <td><?php echo date("d-m-Y", strtotime($row['date']));?></td>
                                                <td><?php echo $row['auditor'];?></td>
                                                <td><?php echo $row['auditee'];?></td>
												
												
												 <td>
											     <?php
											      $sh1=mysqli_query($con,"select * from tblgmpaudit where id='$row[audit]'");
                                                  $hj1=mysqli_fetch_array($sh1);
												  echo $hj1['name'];
												?>
                                              
											   
                             <td>
						
							 
							 <a href="admin.php?id=gmp1&sno=<?php echo $row['id'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a></td>
							 
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
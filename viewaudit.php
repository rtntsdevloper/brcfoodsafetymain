 <?php 
$sno=$_GET['sno'];
$ssid=$_GET['ssid'];
$sql=mysqli_query($con,"select * from tblauditsection where id='$sno'");
$row=mysqli_fetch_array($sql);

$sql1=mysqli_query($con,"select * from tblauditsection1 where sid='$sno' and id='$ssid'");
$row1=mysqli_fetch_array($sql1);
								
?>

                <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Detail</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=addaudit"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<div class="card-title"> Section: <?php echo $row['name'];?></div>
			
					
					                  <div class="row">
                                      <div class="col-md-12">
                                      <div class="card card-profile-1 mb-4">
                                      <div class="card-body">
                                      <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                      <thead>
                                       <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Sub-Section</th>
												<th scope="col">Question</th>
												<th scope="col">Image</th>
												<th scope="col">Edit</th>
												<th scope="col">Delete</th>
												 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										 
										 $sql2=mysqli_query($con,"select * from tblauditsection2 where sid='$sno' and ssid='$ssid'");
										  $i=0;
                                         while($row2=mysqli_fetch_array($sql2))
										 {
										 $i++;
										 ?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row1['name'];?></td>
                                                <td><?php echo $row2['ques'];?></td>
                                                
												  <td><img src="gmpreport/<?php echo $row2['img'];?>" width="70"></td>
												  
												 <td>
											      <a href="admin.php?id=editgmp&sno=<?php echo $row2['id'];?>&sid=<?php echo $sno;?>&ssid=<?php echo $ssid;?>" >
												  <span class="badge badge-info">Edit</span></a>
												  </td>
												  
												  <td>
											      <a href="delgmpques?sno=<?php echo $row2['id'];?>" onclick="return confirm('Are You Sure?')">
												  <span class="badge badge-danger">Delete</span></a>
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
									</div></div>
									
									
									
									
									
                               </div></div></div></div>
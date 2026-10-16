<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Dashboard</a></li>
                        <li>Home</li>
                    </ul>
                </div>
                <div class="separator-breadcrumb border-top"></div>
                <div class="row">
                    <!-- ICON BG-->
					<?php
					$sql=mysqli_query($con,"select * from tblonlinetraining");
					while($roes=mysqli_fetch_array($sql))
					{
					?>
					  <div class="col-lg-6 col-md-6 col-sm-6">
                          <a href="admin.php?id=level2&tid=<?php echo $roes['id'];?>"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
                                 <p class="text-muted mt-2 mb-0"><?php echo $roes['name'];?></p>
                            </div>
                        </div></a>
                    </div>
			
				<?php
				}
				?>
				
				  <div class="col-lg-6 col-md-6 col-sm-6">
                          <a href="admin.php?id=procedure"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
                                 <p class="text-muted mt-2 mb-0">Procedure Training</p>
                            </div>
                        </div></a>
                    </div>
					
					
					
					
					<div class="col-lg-6 col-md-6 col-sm-6">
                          <a href="admin.php?id=warehouse"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
                                 <p class="text-muted mt-2 mb-0">Warehouse & Workforce Safety checklist</p>
                            </div>
                        </div></a>
                    </div>
					
					
					
					</div></div>
				 <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
												<th scope="col">Date</th>
                                                <th scope="col">Score</th>
                                                <th scope="col">Result</th>
                                                <th scope="col">Certificate</th>
												
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblresult where staffid='$staffid' ");
										$i=0;
										$match=mysqli_num_rows($sql);
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										
										$bn=mysqli_query($con,"select * from tblstaff where id='$staffid'");
										$jk=mysqli_fetch_array($bn);
										
										$dt="";
										if($match>=1)
										{
										   $dt=date('d-m-Y',strtotime($row['curdate']));
										}
										
										$bn1=mysqli_query($con,"select * from tblonlinetraining where id='$row[tid]'");
										$jk1=mysqli_fetch_array($bn1);
										
										
										?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $jk['fname'];?> <?php echo $jk['lname'];?></td>
												<td><?php echo $dt;?></td>
                                               <td><?php echo $row['score'];?></td>
                                                <td><?php echo $row['result'];?> </td>
												<td>
												<?php
												if($row['result']=="Pass")
												{
												$name=ucfirst($jk['fname'])." ".ucfirst($jk['lname']);
												?>
												<a href="../MyPDF/<?php echo $name;?>-<?php echo $row['batchcode'];?>-<?php echo $row['curdate'];?>.pdf" target="_blank"><button class="btn btn-success">View</button></a>
												<?php
												}?> </td>
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
                                </div>
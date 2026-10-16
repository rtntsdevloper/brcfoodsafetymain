<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Auditor Management</a></li>
                        <li>View Auditor Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=auditor"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<div class="card-title"> Auditor Detail</div>
				
				
				<?php
				$sno=$_GET['sno'];
				$sq=mysqli_query($con,"select * from tblauditor where id='$sno'");
				$row=mysqli_fetch_array($sq);
				?>			
							
							 <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="card-body text-center">
                                                <div ><img src="auditordoc/<?php echo $row['userimg'];?>" alt="" width="100" /></div>
                                                 <div ><img src="auditordoc/<?php echo $row['sign'];?>" alt="" width="100" /></div>
                                              
                                                <p class="mt-0">Contact: <?php echo $row['contact'];?></p>
                                                <p>Email: <?php echo $row['email'];?></p>
												  <p>Username: <?php echo $row['user'];?></p>
                                                <button class="btn btn-primary btn-rounded"> <?php echo $row['name'];?></button>
                                               
                                            </div>
                                        </div>
                                    </div>
									<div class="col-md-8">
									 <div class="card card-profile-1 mb-8">
								<iframe src="auditordoc/<?php echo $row['cert'];?>" height="600"></iframe>
									</div>
									</div>
									
									
									</div>
									
									
									
									
                               </div></div></div></div>
                               
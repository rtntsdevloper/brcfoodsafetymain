
                <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Knowledge Hub Certificate</a></li>
                       
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=uploadcert1"><button class="btn btn-success" style="float:right; margin-left:15px">Add New</button></a>
							<a href="admin.php?id=knowledgehub"><button class="btn btn-danger" style="float:right; margin-left:15px">Go Back</button></a>
							
							<div class="card-title"> Knowledge Hub Certificates</div>
				
				<?php
			
				$sq=mysqli_query($con,"select * from tblknowledge");
				$row=mysqli_fetch_array($sq);
				
				?>			
							
					<div class="row">
                                  
									
									
									<div class="col-md-12">
									   
									
									
									 <div class="card card-profile-1 mb-12" >
									
								    <img src="images/<?php echo $row['name'];?>"  ></div>
									
									
									</div>
									
									
									
									
									
									</div>
									
									
									</div>
									
									
									
									
                               </div></div></div></div>
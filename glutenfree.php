<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Management</a></li>
                        <li>Gluten Free</li>
                    </ul>
                </div>
				
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3">Gluten Free</h4>
								<p>List of sections</p>
                         
                        <div class="card text-left">
                         
                              
                                <ul class="list-group">
								<?php
								$sq=mysqli_query($con,"select * from glutenfree where typee='gluten'");
								$i=0;
								while($row=mysqli_fetch_array($sq))
								{
								$i++;
								?>
                                   <a href="admin.php?id=glutenfree1&sno=<?php echo $row['id'];?>"> <li class="list-group-item"><?php echo $i;?>. <?php echo $row['name'];?></li></a>
                                   
									<?php
									}
									?>
                                </ul>
                          
                        </div>
                    
                          
                            </div>
                        </div>
</div>


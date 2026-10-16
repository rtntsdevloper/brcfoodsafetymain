<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Defrost Record </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=precord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=freeze1"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Frozen Record</h4>
								
                                <p>List of Record</p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Trace Code (Batch code\UBD)</th>
												
												 <th scope="col">Temprature</th>
                                                <th scope="col">Date Moved to Freezer for Freezing</th>
												<th scope="col">Signed By: </th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblfreeze");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['date'];?></td>
                                               <td><?php echo $row['product'];?></td>
                                                <td><?php echo $row['qty'];?> </td>
												<td><?php echo $row['trace'];?> </td>
											
                                                <td><?php echo $row['temp'];?> </td>
                                                <td><?php echo $row['moved'];?> </td>
                                                <td><?php echo $row['sign'];?> </td>
		 
		 
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
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Auditee Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=addauditee"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Auditee Management</h4>
								
                                <p>List of auditees</p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
												<th scope="col"></th>
                                                <th scope="col">Signature</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Username</th>
												<th scope="col">Department</th>
												 <th scope="col">Status</th>
												 
												  <th scope="col">Edit/ Delete</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblauditee");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['name'];?></td>
                                                <td><img src="auditordoc/<?php echo $row['img'];?>" alt="" width="100" /></td>
												<td><img src="auditordoc/<?php echo $row['sign'];?>" alt="" width="100" /></td>
                                               <td><?php echo $row['contact'];?></td>
                                                <td><?php echo $row['email'];?> </td>
												<td><?php echo $row['uname'];?> </td>
												
							 <td>
							<?php 
												 $string = $row['dept'];
$tags1 = explode(';' , $string);
$j=0;
foreach($tags1 as $key1)
  {
  $j++;
  if($key1!="")
  {
												$sh12=mysqli_query($con,"select * from tbldept where id='$key1'");
                             $hj12=mysqli_fetch_array($sh12);
							 echo $j.". ". $hj12['name']."</br>";
							 }
							 }
							 ?> 
							 </td>
											 
                                                <td><span class="badge badge-success"><?php echo $row['status'];?></span></td>
												  <td>
												 <a href="admin.php?id=editauditee&sno=<?php echo $row['id'];?>">
												 <span class="badge badge-info">Edit</span></a>
												  
												  
												  <br/>
												<a href="delauditee?sno=<?php echo $row['id'];?>" onclick="return confirm('Are You Sure?')">
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
                    </div>
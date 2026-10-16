<?php

$admingo = mysqli_query($con,"SELECT * FROM `tbltabs` WHERE `name` ='admin' and `status1` =''");
$admingo1 = mysqli_fetch_array($admingo);

$aid = $admingo1['sno'];

$tabarray = explode(";", $_SESSION['tabs']);
if(!in_array($aid, $tabarray)){
    ?>
    <script language="javascript">
    window.open('admin.php?id=1','_self');
    </script>
    <?php
}


?>







<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Admin Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=addadmin"><button class="btn btn-danger" style="float:right">Add New</button></a>
                             <h4 class="card-title mb-3">Admin Management</h4>
								
                               
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
												<th scope="col">Username</th>
                                                <th scope="col">Password</th>
                                                <th scope="col">Access</th>
												 <th scope="col">Status</th>
												 <th scope="col">Edit</th>
												 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbladmin");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                             <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['name'];?></td>
                                               <td><?php echo $row['username'];?></td>
                                                <td><?php echo $row['pwd'];?> </td>
												 <td><?php echo $row['status'];?> </td>
												  <td><a href="deladmin?sno=<?php echo $row['id'];?>" onclick="return confirm('Are You Sure?')">
												  <span class="badge badge-danger">Delete</span></a></td>
												  
                                               <td><a href="admin.php?id=editadmin&sno=<?php echo $row['id'];?>">
												  <span class="badge badge-info">Edit</span></a></td>
												  
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
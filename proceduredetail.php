<?php
 $sno=$_GET['sno'];
 
 ?>
 
 <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Trainings</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							   <a href="admin.php?id=proceduretraining"><button class="btn btn-info" style="float:right">Go Back</button></a>
				   
				    <a href="admin.php?id=addstaffprocedure&sno=<?php echo $_GET['sno'];?>"><button class="btn btn-primary" style="float:right; margin-right:5px">Add Procedure</button></a>
					
				 <a href="admin.php?id=addproceduredetail&sno=<?php echo $_GET['sno'];?>"><button class="btn btn-warning" style="float:right; margin-right:5px">Add Staff</button></a>
					
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                 <thead>
				         <tr>
						 
				 <th></th>
                       <th>Date</th>
                       <th>Staff Name</th>
                       <th></th>
					   <th>Procedure</th>
					   <th>Result</th>
					   <th>Score</th>
					   <th>Document</th>
                   
                 </tr>
					</thead>
					<tbody>
					         <?php
							
							  $sql=mysqli_query($con,"select * from tblproceduretraining1 where pid='$sno'");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
							 
							  $sql1=mysqli_query($con,"select * from tblstaff where id='$row[uid]'");
						      $rows=mysqli_fetch_array($sql1);
							 
							 
							 $sql2=mysqli_query($con,"select * from tblproceduretraining where id='$sno'");
						      $row2=mysqli_fetch_array($sql2);
							  
							   $sql3=mysqli_query($con,"select * from tblprocedure where id='$row[procedure1]'");
						      $row3=mysqli_fetch_array($sql3);
							  
							   $sql4=mysqli_query($con,"select * from tblresult1 where tid='$row[procedure1]' and  staffid='$row[uid]' order by sno desc limit 1");
						      $row4=mysqli_fetch_array($sql4);
							?>
                      <tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo date('d-m-Y',strtotime($row2['date'])); ?></td>
					  <td><?php echo $rows['fname']; ?> <?php echo $rows['lname']; ?></td>
					  <td><img src="student/<?php echo $rows['img']; ?>" width="100"  /></td>
                      <td><?php echo $row3['name']; ?></td>
					  <td><?php echo $row4['result']; ?></td>
					  <td><?php echo $row4['score']; ?></td>
					  <td>
					  <?php
					  if($row['status']=="Completed")
					  {
					  ?>
					  
					  <a href="admin.php?id=viewdocument&sno=<?php echo $row['procedure1'];?>&sno1=<?php echo $row['id'];?>&staffid=<?php echo $row['uid'];?>"><button class="btn btn-danger">View</button></a>
					  <?php
					  }
					  ?>
					  </td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
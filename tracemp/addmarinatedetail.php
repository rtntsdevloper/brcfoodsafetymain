	  
	   <?php
	   session_start();
       include 'connection.php';
	     $d1=$_POST['d1'];
	   $p1=$_POST['p1'];
	  
	  ?>     
	  
	  
	  <?php
	  if($d1!="" && $p1=="")     
	  {
	  ?>             
	  
	      
	  <table id="bootstrap-data-table" class="table table-striped table-bordered">
	  <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											 <th>Batchcode</th>
                                            <th>Name</th>
											 <th>Use By</th>
											<th>Quantity</th>
											 <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
									$sql=mysqli_query($con,"select * from tblmarination where date='$d1' order by batchcode DESC");
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									 $useby= date('d-m-Y', strtotime($row['useby1']));

									?>
									
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row['date']));?></td>
										  <td style="color:#0000FF"><?php echo $row['batchcode'];?></td>
										    <td>
											<?php 
											$sql1=mysqli_query($con,"select * from tblrecipe where id='$row[name]'");
											$rows=mysqli_fetch_array($sql1);
											echo $rows['name'];
											?>
											</td>
											 <td style="color:#0000FF"><?php echo $useby;?></td>
                                            <td><?php echo $row['quantity'];?> Kg</td>
											<td> 
											<a href="admin.php?id=viewmarination&sno=<?php echo $row['id'];?>"> 
											<button type="button" class="btn btn-info btn-sm" >View </button></a>
											</td>
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
										</table>
										<?php
										}
										?>
										
										
										
										
										
										 <?php
	   if($d1!="" && $p1!="")     
	  {
	  ?>             
	  
	      
	  <table id="bootstrap-data-table" class="table table-striped table-bordered">
	  <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											 <th>Batchcode</th>
                                            <th>Name</th>
											 <th>Use By</th>
											<th>Quantity</th>
											 <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
									$sql=mysqli_query($con,"select * from tblmarination where date='$d1' and name='$p1' order by batchcode DESC");
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									 $useby= date('d-m-Y', strtotime($row['useby1']));

									?>
									
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row['date']));?></td>
										  <td style="color:#0000FF"><?php echo $row['batchcode'];?></td>
										    <td>
											<?php 
											$sql1=mysqli_query($con,"select * from tblrecipe where id='$row[name]'");
											$rows=mysqli_fetch_array($sql1);
											echo $rows['name'];
											?>
											</td>
											 <td style="color:#0000FF"><?php echo $useby;?></td>
                                            <td><?php echo $row['quantity'];?> Kg</td>
											<td> 
											<a href="admin.php?id=viewmarination&sno=<?php echo $row['id'];?>"> 
											<button type="button" class="btn btn-info btn-sm" >View </button></a>
											</td>
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
										</table>
										<?php
										}
										?>
										
										
										
										
										
										
										
										
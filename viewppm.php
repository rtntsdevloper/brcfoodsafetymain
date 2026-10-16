<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Machinery Management </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=ppmmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3">Machinery Management</h4>
								<?php
	$sno=$_GET['sno'];
	
	$sql=mysqli_query($con,"select * from tblequipment where id='$sno'");
	$row=mysqli_fetch_array($sql);
	?>
                               
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                   
                                <tbody>
								  <tr><th scope="col">Equipment Code</th> <td><?php echo $row['code'];?></td></tr>
                                                <tr><th scope="col">Make</th><td><?php echo $row['make'];?></td></tr>
                                                <tr><th scope="col">Equipment Name</th><td><?php echo $row['name'];?></td></tr>
                                                <tr><th scope="col">Is equipment being services Internally or Externally?</th><td><?php echo $row['service'];?></td></tr>
												<tr><th scope="col">Site</th><td><?php echo $row['site'];?></td></tr>
                                                <tr><th scope="col">Location</th><td><?php echo $row['location'];?></td></tr>
												<tr><th scope="col">Frequency</th><td><?php echo $row['frequency'];?></td></tr>
												
									
							  </tbody></table>
									
									<h3 align="center" style="color:#009999"> Maintenance Detail</h3>
									 <table id="data-table-basic" class="table table-striped">
                                <tbody>
								<?php
								$sqll=mysqli_query($con,"select * from tblequipment1 where eid='$sno'");
								$i=0;
								while($rows=mysqli_fetch_array($sqll))
								{
								$i++;
								?>
								
								<?php
								if($rows['status1']=="Done")
								{
								
								?>
								<tr> 
								<td colspan="8" style="color:#FF0000">Previous History</td>
								</tr>
								<tr>
								<td><?php echo $i;?>)</td>
								<td>Last Maintenance done on <br/> <?php echo date("d-m-Y",strtotime($rows['date']));?></td>
								<td>Stat Time: <br/> <?php echo date('d-m-Y H:i',strtotime($rows['stime']));?> </td>
								<td>End Time: <br/> <?php echo date('d-m-Y H:i',strtotime($rows['etime']));?> </td>
								<td>Production Required: <br/> <?php echo $rows['production'];?> </td>
								
								<td>
								Completed By: <br/> <?php echo $rows['completedby'];?><br/>
								<img src="signature/<?php echo $rows['completesign'];?>.png" width="160" alt="" /></td>
								<td>Verified By: <br/> <?php echo $rows['verifiedby'];?> <br/>
								<img src="signature/<?php echo $rows['verifysign'];?>.png" width="160" alt="" /></td>	</tr>
								
								<tr> 
								<td colspan="8" >PPM Job Description To be filled by Engineer : <?php echo $rows['description'];?></td>
								</tr>
								
								<?php
								}
								else if ($rows['status1']!="Completed")
								{
								?>
								<tr> 
								<td colspan="8" style="color:#FF0000">Next Maintaince Detail</td>
								</tr>
								<tr>
								<td><?php echo $i;?>)</td>
								<td>Next maintenance to be done </td>
								<td><?php echo date("d-m-Y",strtotime($rows['date']));?></td>
							
								</tr>
								<?php
								
								}
								}
								?>
								</tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
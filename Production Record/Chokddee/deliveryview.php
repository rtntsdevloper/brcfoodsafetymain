<?php

$pid = $_GET['tid'];


?>

<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

					<a href="admin.php?id=delivernote_add&tid=<?php echo $pid;?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
                    <a href="admin.php?id=delivery&tid=<?php echo $pid;?>"><button class="btn btn-warning" style="float:right; margin-left:15px">View Report</button></a>




					<h4 class="card-title mb-5">Delivery And Delivery Vehicle Condition Log</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date & Time of Dispatch</th>
										<th>Customer Name</th>
										<th>Customer Invoice</th>
										<th>Vehicle Inspection</th>  
										<th>Product Visual Inspection</th>
                                        <th>Temperature of Vehicle</th>
                                        <th>Delivery Sent By</th>
                                        <th>Driver Name</th>
                                        <th>Vehicle Reg. No.</th>
										<th>Attempt By</th>
                                       
									</tr>
								</thead>
								<tbody>

                                <?php
                                $sq=mysqli_query($con, "SELECT * FROM tbldelivery where tid='$pid' ORDER BY Date desc");
                              $i=0;
                              $i++;
                                
                                ?>
                                <?php while ($row=mysqli_fetch_assoc($sq)) { ?>
<tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row['Date']))." ".$row['ttime'] ;  ?></td>
                                    <td><?php echo $row['cname'];  ?></td>
                                    <td><?php echo $row['cinvoice']; ?></td>
                                    <td><?php echo $row['vehcheck']; ?></td>
                                    <td><?php echo $row['prodcheck'];  ?></td>
                                    <td><?php echo $row['tempvehicle'];  ?><sup>o</sup>C</td>
                                    <td><?php echo $row['deliverysent'];  ?></td>
                                    <td><?php echo $row['drivername'];  ?></td>
                                    <td><?php echo $row['vehiclereg'];  ?></td>
									<td><?php echo $row['add_by'];  ?></td>
                                    
</tr>
                                    <?php } ?>

									
								</tbody>
							</table>
						</div>
					</div>





				</div>
			</div>
		</div>
	</div>
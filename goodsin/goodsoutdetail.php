
<?php
$sno=$_GET['sno'];

$sql4=mysqli_query($con,"select * from tblgdn where id='$sno'");
$sql5=mysqli_fetch_array($sql4);

$cust=mysqli_query($con,"select * from tblcustomer where id='$sql5[customer]'");
$cust1=mysqli_fetch_array($cust);

?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods Out Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
				 <a href="admin.php?id=goodsout"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				  <a href="pdf/<?php echo $sql5['gdn'];?>.pdf" target="_blank"><button class="btn btn-info" style="float:right; margin-left:15px">Download Report</button></a>
                             <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GDN NO : <?php echo $sql5['gdn'];?></strong></h4>
								
                           
								 <div class="row">
                                   
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											
                                           	<th>Product</th>
											<th>Quantity</th>
											 <th> Use By </th>
											 <th> GDN Batchcode </th>
											  <th> Edit </th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sno=$_GET['sno'];
								$sql3=mysqli_query($con,"select  t1.pname AS pname, t3.*,t3.cdate AS cdte, t4.*, t4.qty AS c1 ,t4.id as sno1  from tblrawmaterial t1, tblgdn t3 , tblgdn1 t4 where t1.id=t4.product and t3.gdn=t4.gdn  and t3.id='$sno' ");

									$i=0;
									while($row1=mysqli_fetch_array($sql3))
									{
									$i++;
									
									

									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row1['cdte']));?></td>
										
								<td><?php echo $row1['pname'];?></td>
							<td><?php echo $row1['c1'];?></td>
							<td><?php echo date('d-m-Y',strtotime($row1['useby']));?></td>
							<td><?php echo $row1['batchcode'];?></td>
						<td><a href="admin.php?id=goodsoutedit&sno1=<?php echo $row1['sno1'];?>&sno=<?php echo $sno;?>"><button class="btn btn-danger">Edit</button></a></td>
                                          </tr>
										    <?php
										}
										?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
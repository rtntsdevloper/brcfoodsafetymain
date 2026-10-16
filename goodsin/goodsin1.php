<?php 
include '../connection.php';?>
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										<th></th>
										   <th>Date</th>
											<th>Supplier</th>
											<th>GRN No</th>
											<th>Invoice</th>
											 <th>Detail</th>
											
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
									
								    $d1=$_POST['d1'];
									$d2=$_POST['d2'];
									$s1=$_POST['s1'];
									$p1=$_POST['p1'];
									
									if($d1=="" && $d2=="" && $s1!="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno2 where supid='$s1'");
									}
									
									else if($d1!="" && $d2!="" && $s1=="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno2 where (cdate BETWEEN '$d1' and '$d2')");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno2 where (cdate BETWEEN '$d1' and '$d2') and supid='$s1'");
									}
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									$sql2=mysqli_query($con,"select * from tblrawsupplier where supid='$row[supid]' ");
									$row2=mysqli_fetch_array($sql2)
									
									
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										<td><?php echo date('d-m-Y', strtotime($row['cdate']));?></td>
										
										    <td><?php echo $row2['supname'];?></td>
                                            <td><?php echo $row['grnno'];?></td>
											
											 <td><?php echo $row['po'];?></td>
											<td> 
											<a href="admin.php?id=goodsdetail&sno=<?php echo $row['id'];?>"> 
											 <button type="button" class="btn btn-info btn-sm" >View </button></a>
											
											</td>
											
                                          </tr>
										    <?php
										     }
									 if($d1!="" && $d2!="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrn1 where (cdate BETWEEN '$d1' and '$d2') and product='$p1'");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrn1 where (cdate BETWEEN '$d1' and '$d2') and supplier='$s1'   and product='$p1'");
									}
									else if($d1=="" && $d2=="" && $s1!="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrn1 where supplier='$s1'   and product='$p1'");
									}
									else if($d1=="" && $d2=="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrn1 where product='$p1'");
									}
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									$sql2=mysqli_query($con,"select * from tblrawsupplier where supid='$row[supplier]' ");
									$row2=mysqli_fetch_array($sql2);
									
									$sql3=mysqli_query($con,"select * from tblgrnno2 where grnno='$row[grncode]' ");
									$row3=mysqli_fetch_array($sql3)
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										<td><?php echo date('d-m-Y', strtotime($row['cdate']));?></td>
										
										    <td><?php echo $row2['supname'];?></td>
                                            <td><?php echo $row3['grnno'];?></td>
											
											 <td><?php echo $row3['po'];?></td>
							<td> <a href="admin.php?id=goodsdetail&sno=<?php echo $row3['id'];?>"> 
											 <button type="button" class="btn btn-info btn-sm" >View </button></a>
											
											</td>
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
                                    </table>
								
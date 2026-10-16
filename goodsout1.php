
                                   
									
									
								 <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											<th>GDN No</th>
											<th>Customer</th>
											<th>Invoice</th>
											 <th>Detail</th>
											
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									include 'connection.php';
									
									$d1=$_POST['d1'];
									$d2=$_POST['d2'];
									$s1=$_POST['s1'];
									$p1=$_POST['p1'];
									$b1=$_POST['b1'];
									
									if($b1!='')
									{
									$sql3=mysqli_query($con,"select * from tblgdn1 where batchcode='$b1'");
									$i=0;
									while($rows3=mysqli_fetch_array($sql3))
									{
										$i++;
									$gdn=$rows3['gdn'];
									
									$sqlo=mysqli_query($con,"select * from tblgdn where gdn='$gdn'");
									$rowo=mysqli_fetch_array($sqlo);
									
								
									
									$sql2o=mysqli_query($con,"select * from tblcustomer where id='$rowo[customer]'");
									$rowso=mysqli_fetch_array($sql2o);
									
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($rowo['cdate']));?></td>
										
										   
                                            <td><?php echo $rowo['gdn'];?></td>
											<td><?php echo $rows3['name'];?></td>
											
											 <td><a href="invoice/<?php echo $rowo['po'];?>" target="_blank" style="color:#0000FF"><?php echo $rowo['po'];?></a></td>
											<td> 
											<a href="admin.php?id=goodsoutdetail&sno=<?php echo $rowo['id'];?>"> 
											<button type="button" class="btn btn-info btn-sm" >View </button></a>
											
											</td>
											
                                          </tr>
										    <?php
										     }
										      
									}
									else
									{
									
									if($d1=="" && $d2=="" && $s1!="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where customer='$s1'");
									}
									else if($d1=="" && $d2=="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where po='$p1'");
									}
									else if($d1!="" && $d2!="" && $s1=="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where (cdate BETWEEN '$d1' and '$d2')");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where cdate BETWEEN ('$d1' and '$d2') and customer='$s1'");
									}
									else if($d1!="" && $d2!="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where cdate BETWEEN ('$d1' and '$d2') and po='$p1'");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgdn where cdate BETWEEN ('$d1' and '$d2') and customer='$s1' and po='$p1'");
									}
									
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									
									$sql2=mysqli_query($con,"select * from tblcustomer where id='$row[customer]'");
									$rows=mysqli_fetch_array($sql2);
									
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row['cdate']));?></td>
										
										   
                                            <td><?php echo $row['gdn'];?></td>
											<td><?php echo $rows['name'];?></td>
											
											 <td><a href="invoice/<?php echo $row['po'];?>" target="_blank" style="color:#0000FF"><?php echo $row['po'];?></a></td>
											<td> 
											<a href="admin.php?id=goodsoutdetail&sno=<?php echo $row['id'];?>"> 
											<button type="button" class="btn btn-info btn-sm" >View </button></a>
											
											</td>
											
                                          </tr>
										    <?php
										     }
											 }
										       ?>
										</tbody>
                                    </table>
								
								
								
								
								
								
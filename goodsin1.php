
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
                                          
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
									$sql=mysqli_query($con,"select * from tblgrnno where supid='$s1'");
									}
									else if($d1=="" && $d2=="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno where ordernum='$p1'");
									}
									else if($d1!="" && $d2!="" && $s1=="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno where orderdate BETWEEN ('$d1' and '$d2')");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1=="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno where orderdate BETWEEN ('$d1' and '$d2') and supid='$s1'");
									}
									else if($d1!="" && $d2!="" && $s1=="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno where orderdate BETWEEN ('$d1' and '$d2') and ordernum='$p1'");
									}
									else if($d1!="" && $d2!="" && $s1!="" && $p1!="" )
									{
									$sql=mysqli_query($con,"select * from tblgrnno where orderdate BETWEEN ('$d1' and '$d2') and supid='$s1'   and ordernum='$p1'");
									}
									
									
									
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row['date']));?></td>
										
										   
                                            <td><?php echo $row['grnno'];?></td>
											
											 <td><a href="invoice/<?php echo $row['img1'];?>" target="_blank" style="color:#0000FF"><?php echo $row['img1'];?></a></td>
											<td> 
											<a href="admin.php?id=goodsindetail&sno=<?php echo $row['id'];?>"> 
											<button type="button" class="btn btn-info btn-sm" >View </button></a>
											
											</td>
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
                                    </table>
								
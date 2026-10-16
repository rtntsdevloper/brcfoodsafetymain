<?php
include 'connection.php';
$sno=$_GET['sno'];
$rid=$_GET['rid'];


$sql=mysqli_query($con,"delete from saveaudit  where id='$sno'");

?>
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									<thead>
                                            <th>Id</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                            <th>Delete</th>
                                        </thead>
                                        <tbody>
										<?php
										
					$query3=mysqli_query($con,"select * from saveaudit where sno='$rid' and notes!=''");
					$i=1;
							while($rows3=mysqli_fetch_array($query3))
							{
                                   ?>         <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $rows3['curdate'];?></td>
                    <td><?php echo $rows3['notes'];?></td>
                    <td><a href="#" onclick="return bnm2(<?php echo $rows3['id'];?>);"><i class="fa fa-trash" ></i></a></td>     
                                            </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody></table>
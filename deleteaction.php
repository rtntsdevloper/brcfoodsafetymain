<?php
include 'connection.php';
$sno=$_GET['sno'];
$rid=$_GET['rid'];

$sqlg=mysqli_query($con,"select *  from action  where id='$sno'");
$hj=mysqli_fetch_array($sqlg);
$fid=$hj['fid'];
$qid=$hj['ques'];

$sql=mysqli_query($con,"delete from action  where id='$sno'");


$sqlg1=mysqli_query($con,"select *  from action  where sno='$rid'");
$hj1=mysqli_num_rows($sqlg1);
if($hj1<=0)
{
?>
<script>
 document.getElementById('t1'+<?php echo $qid;?>).value="";
 
 </script>
 <?php
 }
 ?>
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Index</th>
                                            <th>Due</th>
                                            <th>Title</th>
											<th>Severity</th>
											<th>Delete</th>
											
                                            
                                        </thead>
                                        <tbody>
										<?php
					 include 'connection.php';
					 $query1=mysqli_query($con,"select * from action where sno='$rid' and fid='$fid' and ques='$qid'");
					 $i=1;
					 while($rows1=mysqli_fetch_array($query1))
					  {
                      ?>  
				   <tr>
                     <td><?php echo $rows1['fid'];?></td>
                     <td><?php echo $rows1['deliver'];?></td>
                     <td><?php echo $rows1['title'];?></td>
					 <td><?php echo $rows1['action'];?></td>
					  <td><a href="#" onclick="return bnm1(<?php echo $rows1['id'];?>);"><i class="fa fa-trash" ></i></a></td>
				  
                   </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody></table>
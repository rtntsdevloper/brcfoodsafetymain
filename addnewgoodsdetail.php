<?php
include 'connection.php';
$date=$_POST['d1'];
$cid=$_POST['cid'];
?>
			    
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
				         <tr>
						 
				 <th></th>
                       <th>Date</th>
                       <th>Document Number</th>
                       <th>CSV</th>
					   <th>View</th>
                      
                 </tr>
					</thead>
					<tbody>
					         <?php
							
							  $sql=mysqli_query($con,"select * from tblcsv where status!='Done' and date='$date' order by date desc");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
					           ?>
                      <tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
					  <td><?php echo $row['po']; ?></td>
                      <td><a href="csvdoc/<?php echo $row['img'];?>" target="_blank" > <?php echo $row['img'];?></a></td>
					  <td><a href="admin.php?id=addnewgoods3&sno=<?php echo $row['id'];?>&cid=<?php echo $cid;?>"><button class="btn btn-primary">View</button></a></td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
								
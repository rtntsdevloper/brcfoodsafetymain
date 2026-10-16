<?php
session_start();
include 'connection.php';
$sno=$_GET['sno'];
$sno1=$_GET['sno1'];


$jk=mysqli_query($con,"select * from  tblprocedurestaff where uid='$sno' and pid='$sno1'");
$match=mysqli_num_rows($jk);
if($match>=1)
{
}
else
{
$sql=mysqli_query($con,"insert into tblprocedurestaff (pid,uid)values('$sno1','$sno')");
}
?>
			<div class="table_section padding_infor_info">
                                 <div>
				    <table class="table" style="overflow:scroll">
                     <thead>
				        <tr>
				        <th></th>
					    <th></th>
                        <th>First Name </th>
                        <th>Last Name</th>
                        <th>User Name</th>
                        <th>Password</th>
						
                        </tr>
					</thead>
					<tbody>
		                    <?php
 	                        $sqll=mysqli_query($con,"select * from tblprocedurestaff where pid='$sno1'");
							$i=0;
						     while($row1=mysqli_fetch_array($sqll))
						     {
							 
							 $gh=mysqli_query($con,"select * from tblstaff where id='$row1[uid]'");
							 $gh1=mysqli_fetch_array($gh);
							 $i++;
							 
							 
							?>
                      <tr>
					   <td><?php echo $i;?></td>
					   <td></td>
					   <td><?php echo $gh1['fname']; ?></td>
                       <td><?php echo $gh1['lname']; ?></td>
                       <td><?php echo $gh1['uname']; ?></td>
                       <td><?php echo $gh1['pwd']; ?></td>
					 
					   
                    </tr>
					<?php
					}
					?>
				
				 </tbody>
                 </table>
					</div></div>
							
							 
							 <!-- The Modal -->
							 
							
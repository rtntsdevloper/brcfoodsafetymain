<?php
session_start();
include 'connection.php';
$sno=$_GET['sno'];
$sno1=$_GET['sno1'];


$jk=mysql_query("select * from  tblprocedurestaff where uid='$sno' and pid='$sno1'");
$match=mysql_num_rows($jk);
if($match>=1)
{
}
else
{
$sql=mysql_query("insert into tblprocedurestaff (pid,uid)values('$sno1','$sno')");
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
 	                        $sqll=mysql_query("select * from tblprocedurestaff where pid='$sno1'");
							$i=0;
						     while($row1=mysql_fetch_array($sqll))
						     {
							 
							 $gh=mysql_query("select * from tblstaff where id='$row1[uid]'");
							 $gh1=mysql_fetch_array($gh);
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
							 
							
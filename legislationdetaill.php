<?php
include 'connection.php';
 $date1=$_POST['d1'];
 $date2=$_POST['d2'];
 $s1=$_POST['s1'];
?>

<?php
if($date1!="" && $date2=="" && $s1=="")
{
?>
 <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col"></th>
												 <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbllegislation where  date='$date1'  order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['name'];?>  
											   </td>
											   
				   <td><a href="addlegislation.php?sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">Add Detail</button></a> </td>
											   
                                                <td><a href="admin.php?id=legislationdetail&sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">View Detail</button></a> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
else if($date1!="" && $date2!="" && $s1=="")
{
?>
 <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col"></th>
												 <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbllegislation where date BETWEEN '$date1' AND '$date2'order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['name'];?>  
											   </td>
											   
				   <td><a href="addlegislation.php?sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">Add Detail</button></a> </td>
											   
                                                <td><a href="admin.php?id=legislationdetail&sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">View Detail</button></a> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
else if($date1!="" && $date2!="" && $s1!="")
{
?>
  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col"></th>
												 <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbllegislation where (date BETWEEN '$date1' AND '$date2') and cate='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['name'];?>  
											   </td>
											   
				   <td><a href="addlegislation.php?sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">Add Detail</button></a> </td>
											   
                                                <td><a href="admin.php?id=legislationdetail&sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">View Detail</button></a> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
else if($date1!="" && $date2=="" && $s1!="")
{
?>
  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col"></th>
												 <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbllegislation where date='$date1' and cate='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['name'];?>  
											   </td>
											   
				   <td><a href="addlegislation.php?sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">Add Detail</button></a> </td>
											   
                                                <td><a href="admin.php?id=legislationdetail&sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">View Detail</button></a> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
else if($date1=="" && $date2=="" && $s1!="")
{
?>
  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col"></th>
												 <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tbllegislation where cate='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['name'];?>  
											   </td>
											   
				   <td><a href="addlegislation.php?sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">Add Detail</button></a> </td>
											   
                                                <td><a href="admin.php?id=legislationdetail&sno=<?php echo $row['id'];?>" ><button class="btn btn-info btn-rounded m-1" type="button">View Detail</button></a> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
?>
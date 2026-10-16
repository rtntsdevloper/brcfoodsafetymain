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
 <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblalerts where date='$date1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            
													<tr>
														<td><?php echo $i; ?></td>
														<td>

															<?php
															if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
																echo "Additional Documents";
															} else {
																echo $row23['typee'];
															}
															?></td>
														<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
														<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

														<td>
															<?php
															if ($row23['issuedate'] != '0000-00-00') {
																echo date('d-m-Y', strtotime($row23['issuedate']));
															}
															?>
														</td>

														<td><?php echo $row23['ver']; ?></td>
														<td><?php echo $row23['authrisedby']; ?></td>
														<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

														<td>
															<?php
															if ($access == "Admin") {
															?>
																<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
																</br> </br>
																<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
															<?php
															}
															?>

														</td>

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
 <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblalerts where date BETWEEN '$date1' AND '$date2' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            
													<tr>
														<td><?php echo $i; ?></td>
														<td>

															<?php
															if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
																echo "Additional Documents";
															} else {
																echo $row23['typee'];
															}
															?></td>
														<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
														<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

														<td>
															<?php
															if ($row23['issuedate'] != '0000-00-00') {
																echo date('d-m-Y', strtotime($row23['issuedate']));
															}
															?>
														</td>

														<td><?php echo $row23['ver']; ?></td>
														<td><?php echo $row23['authrisedby']; ?></td>
														<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

														<td>
															<?php
															if ($access == "Admin") {
															?>
																<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
																</br> </br>
																<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
															<?php
															}
															?>

														</td>

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
 <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblalerts where (date BETWEEN '$date1' AND '$date2') and category='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            
													<tr>
														<td><?php echo $i; ?></td>
														<td>

															<?php
															if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
																echo "Additional Documents";
															} else {
																echo $row23['typee'];
															}
															?></td>
														<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
														<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

														<td>
															<?php
															if ($row23['issuedate'] != '0000-00-00') {
																echo date('d-m-Y', strtotime($row23['issuedate']));
															}
															?>
														</td>

														<td><?php echo $row23['ver']; ?></td>
														<td><?php echo $row23['authrisedby']; ?></td>
														<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

														<td>
															<?php
															if ($access == "Admin") {
															?>
																<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
																</br> </br>
																<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
															<?php
															}
															?>

														</td>

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
 <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblalerts where date='$date1' and category='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['ques'];?>
											   <?php
											   if($row['weblink']!="")
											   {
											   ?>
											   
								 <a href="<?php echo $row['weblink'];?>" target="_blank"><button class="btn btn-warning btn-rounded m-1" type="button">View</button></a>
											   <?php
											   }
											   ?>
											   </td>
                                                <td><?php echo $row['category'];?> </td>
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
 <table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">
										
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from tblalerts where category='$s1' order by date DESC");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y",strtotime($row['date']));?> </td>
                                               <td><?php echo $row['ques'];?>
											   <?php
											   if($row['weblink']!="")
											   {
											   ?>
											   
								 <a href="<?php echo $row['weblink'];?>" target="_blank"><button class="btn btn-warning btn-rounded m-1" type="button">View</button></a>
											   <?php
											   }
											   ?>
											   </td>
                                                <td><?php echo $row['category'];?> </td>
												</tr>
												<?php
												}
												?>
												</tbody></table>
<?php
}
?>
<?php

ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');
				
				$sno=$_GET['sno']; 
				  
				   $sql2=mysqli_query($con,"select * from tblroster where id='$sno' ");
				$row2=mysqli_fetch_array($sql2);
				
				 $tid=$row2['tid'];
				 $sid=$row2['sid']; 
				 
				  $sql9=mysqli_query($con,"select * from saveaudit where sno='$sno'  and (ans!='Compliant' || ans!='Not Applicable' || ans!='')");
				  $sqq9=mysqli_num_rows($sql9);
				  
				  
				
				$auditdate=date("d-m-Y", strtotime($row2['auditdate']));
				  
				 
				  $auditee=mysqli_query($con,"select * from tblauditee where id='$row2[auditee]'");
                                                $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$row2[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM addtest1 where testid='$tid'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM subtest where tid='$tid' and sid='$sid'");
				  $subtest=mysqli_fetch_array($total2);
				  
				  
				  $total=mysqli_query($con,"SELECT * FROM subtest1 where tid='$row2[tid]' and sid='$row2[sid]'");
				  $subtest1=mysqli_fetch_array($total);
				  
				  
                           $total1=mysqli_num_rows($total);




$ns=mysqli_query($con,"SELECT * FROM saveaudit where sno='$sno'  and ans='Not Applicable'");
$ns1=mysqli_num_rows($ns);


$total1=$total1-$ns1;

$complete=mysqli_query($con,"SELECT * FROM saveaudit where sno='$sno' and ans='Compliant'");
$complete1=mysqli_num_rows($complete);
 $complete2=round($complete1/$total1*100);
 
 
 


$pending=mysqli_query($con,"SELECT * FROM saveaudit where sno='$sno' and  ans='Major'");
$pending1=mysqli_num_rows($pending);
$pending2=round($pending1/$total1*100);

$progres=mysqli_query($con,"SELECT * FROM saveaudit where sno='$sno' and ans='Minor'");
$progres1=mysqli_num_rows($progres);
$progres2=round($progres1/$total1*100);

$na=mysqli_query($con,"SELECT * FROM  saveaudit where sno='$sno' and ans='Critical'");
$na1=mysqli_num_rows($na);
 $na2=round($na1/$total1*100);


?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				<?php
				$sno=$_GET['sno'];
				$rows=mysqli_query($con,"select t1.* , t2.* , t3.*  from addtest1  t1, subtest1  t2, tblroster  t3  where  t3.id='$sno' and t1.testid=t3.tid and t2.sid=t3.sid");
				$row=mysqli_fetch_array($rows);
				
				?>
				
				<?php
											    $sh=mysqli_query($con,"select * from tblauditor where id='$row[auditor]'");
                                                $hj=mysqli_fetch_array($sh);
											
												?>

											  <?php
											    $sh13=mysqli_query($con,"select * from tblauditee where id='$row[auditee]'");
                                                $hj13=mysqli_fetch_array($sh13);
												?> 
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							<?php
							if($access=="Auditee")
							{
							?>
							<a href="admin.php?id=auditreport"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<?php
							}
							
					else
					{
					?>
							<a href="admin.php?id=auditdetail"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<?php
							}
							?>
				<a href="ncreport1.php?sno=<?php echo $sno;?>" target="_blank"><button class="btn btn-warning" style="float:right; margin-left:15px">View Report</button></a>
							
							
							<?php
							if($sqq9>=1)
							{
							?>
				<a href="ncreport.php?sno=<?php echo $sno;?>" target="_blank"><button class="btn btn-danger" style="float:right; margin-left:15px">NC Report</button></a>
				<?php
				}
				?>
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												  <th scope="col">Date</th>
                                                <th scope="col">Auditor</th>
                                               
												 <th scope="col">Subject</th>
												 <th scope="col">Ans</th>
												 <th scope="col">Status</th>
                                                 <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$df=mysqli_query($con,"select * from tblroster where id='$sno'");
										$gh=mysqli_fetch_array($df);
										
										$sql=mysqli_query($con,"select * from subtest1 where sid='$gh[sid]'");
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
										
										if($row['ssid']!="")
										{
										$fid=$row['ssid'];
										}
										else
										{
										$fid=$row['fid'];
										}
										
										$sh1=mysqli_query($con,"select * from saveaudit where fid='$fid' and ques='$row[cid]' and sno='$sno'");
                                        $hj1=mysqli_fetch_array($sh1);
										?>
                                            <tr>
                                                <th scope="row">
												<?php echo $i;?>
												</th>
                                                <td><?php echo date("d-m-Y", strtotime($gh['auditdate']));?></td>
                                               <td><?php echo $hj['name'];?> </td>
                                                <td> <?php echo $fid; ?> <?php echo $row['clause']; ?> </td>
												
												 <td> <?php echo $hj1['ans'] ;?>   </td>
											   
											     <td> 
												 <?php 
												 
												 if($hj1['status']=="closedoff")
												 {
												 echo "Evidence is submitted";
												 }
												 else
												 {
												  echo $hj1['status'];
												 }
												 
												 ?>  </td>
											   
                                                <td>
												<?php
												if($hj1['ans']=="Compliant" || $hj1['ans']=="Not Applicable")
												{
												}
												else
												{
												?>
                                            <a href="admin.php?id=ncview1&sno=<?php echo $hj1['id'];?>&sno1=<?php echo $_GET['sno'];?>&fid=<?php echo $row['fid'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a>
                                                   <?php
												   }
												   ?>
                                                </td>
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
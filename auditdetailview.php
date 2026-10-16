<?php
session_start();
include 'connection.php';
$sid=$_GET['sid'];

            	$sql2=mysqli_query($con,"select * from tblroster where id='$sid' ");
				$row2=mysqli_fetch_array($sql2);
				$date=date("Y-m-d");
				
				
				
				
			  $sq=mysqli_query($con,"select * from addtest1 where testid='$row2[tid]' ");
			  $row=mysqli_fetch_array($sq);
				
			  $sh=mysqli_query($con,"select * from tblauditor where id='$row2[auditor]'");
              $hj=mysqli_fetch_array($sh);
			  
			  $shj=mysqli_query($con,"select * from saveaudit where tid='$row2[tid]' and sid='$row2[sid]' and (ans='Critical' or ans='Major' or ans='Minor') and sno='$sid' ");
              $hjj=mysqli_fetch_array($shj);
			  
			  $match=mysqli_num_rows($shj);
				
               ?>
                         <div class="modal-dialog" role="document" style="width:50%" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle1"><?php echo $row['subject'];?> </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                            <div class="modal-body">
                           <?php
						   $sh11=mysqli_query($con,"select * from subtest where sid='$row2[sid]'");
                           $hj11=mysqli_fetch_array($sh11);
			               ?>
							 * <?PHP echo  $hj11['subtest'];?>						
			
                            </div>
							   <div class="row" style="margin:20px">
								<div class="col-lg-6 col-md-6 col-sm-6"> 
								<img src="auditordoc/<?php echo $hj['userimg'];?>" alt="" width="70" /><br/>
                           <p class="mt-0">Auditor: <?php echo $hj['name'];?></p>
                            <p class="mt-0">
							 <?php
							$aud11=mysqli_query($con,"select * from tblauditee where id='$row2[auditee]'");
                                                $bud11=mysqli_fetch_array($aud11);
												?>
												<img src="auditordoc/<?php echo $bud11['img'];?>" alt="" width="70"  />
												<br/>
												Auditee:
												<?php echo $bud11['name']; ?></p>
							  <p class="mt-0">
							  <?php
							  if($row2['date']>$date && $row2['status1']=="waiting")
				{
				$color="#2473AB";
				$txt="Due";
				$bg="36, 115, 171";
				?>
				 Audit Status: &nbsp; <span class="badge badge-light" style="background:#2473AB;color:#FFFFFF">Due</span>
				 <?php
				}
				else if($row2['date']<$date && $row2['status1']=="waiting")
				{
				$color="#C10000";
				$txt="Over Due";
				$bg="193,0,0";
				?>
				 Audit Status: &nbsp; <span class="badge badge-light" style="background:#C10000;color:#FFFFFF">Over Due</span>
				 <?php
				}
				else
				{
				?>
				 Audit Status: &nbsp; <span class="badge badge-light" style="background:<?php echo $row2['bgcolor'];?>;color:#FFFFFF"><?php echo $row2['status'];?></span>
				 <?php
				}
				?>
							 
							  </p>	
							  <?php
							  $user=$_SESSION['user'];
                              $access=$_SESSION['access'];

							  if($row2['status1']=="waiting" && $access=="Auditor" && $hj['name']==$user )
							  {
							  ?>
							  <p class="mt-0"> 
							 <a href="admin.php?id=audit1&sno=<?php echo $row2['tid'];?>&sid=<?php echo $row2['sid'];?>&rid=<?php echo $sid;?>" style="cursor:pointer">
							  <button class="btn btn-primary">Click Here</button>	</a>	</p>	
							  <?php
							  }
							  ?>
							  </div>
								
								<div class="col-lg-6 col-md-6 col-sm-6">
								<h5>Audit Detail</h5>
								<?php
								if($row2['auditdate']=="0000-00-00" || $row2['auditdate']=="")
								{
								?>
								 <p class="mt-0"><button class="btn btn-info">Attempt on: Not attempt yet</button>	</p>
								<?php
								}
								else
								{
								?>
								  <p class="mt-0"><button class="btn btn-info">Attempt on: <?php echo date("d-m-Y", strtotime($row2['auditdate']));?></button>	</p>
								  <?php
								  }
								  ?>
								  <?php
								
								  if(($access=="Auditee" && $bud11['name']==$user) || ($access=="Auditor" && $hj['name']==$user )  && $row2['status1']!="waiting")
								  {
								  
								  ?>
					<a href="admin.php?id=ncview&sno=<?php echo $sid;?>"> <p class="mt-0"><button class="btn btn-danger">Total NC: <?php echo $match;?></button>	</p>	</a>			
										
										<?php
										}
										else
										{
										?>
										<p class="mt-0"><button class="btn btn-danger">Total NC: <?php echo $match;?></button>	</p><?php
										}
										
										?>		</div></div>
								
														 
                                                               </div>
									
											
                    </div>
                </div>
				
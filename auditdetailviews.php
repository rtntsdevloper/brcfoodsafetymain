<?php
session_start();
include 'connection.php';
 $sid=$_GET['sid'];
 $month=$_GET['month'];
  $auditor=$_GET['auditor'];
   $date=$_GET['year'];
   $year=date("Y",strtotime($date));

            	
				
			  $sq=mysqli_query($con,"select * from addtest1 where testid='$sid' ");
			  $row=mysqli_fetch_array($sq);
			
				
               ?>
                         <div class="modal-dialog" role="document" id="modaldialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle1"><?php echo $row['subject'];?> </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                           
                           <?php
						     $sql2=mysqli_query($con,"select * from tblroster where tid='$sid' and month='$month' and year(date)='$year' and auditor='$auditor'");
				             while( $row2=mysqli_fetch_array($sql2))
				              {
							 
						   $sh11=mysqli_query($con,"select * from subtest where tid='$row2[tid]' and sid='$row2[sid]'");
                         $hj11=mysqli_fetch_array($sh11);
						
			               ?>
						    <div class="modal-body">
							  <ul class="list-group">
                                   <a href="#" data-toggle="modal" class='modalButton1'  data-target="#myModal1"  data-fid='<?php echo $row2['id'];?>' > 
							   <li class="list-group-item"><?php echo $hj11['sid'];?> . <?PHP echo  $hj11['subtest'];?>
							   
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
								
								</li></a>
							   
							
									</ul>
							 
						
							 
							  </div>					
			<?php
			}
			?>
                           
							   
														 
                                                               </div>
									
											
                    </div>
               
				 <script>
    $('.modalButton1').click(function()
	{
	  document.getElementById("modaldialog").style.display = "none";
	 
        var teacherid = $(this).attr('data-fid');
		
		
        $.ajax({url:"auditdetailview.php?sid="+teacherid,cache:false,success:function(result)
		{
		  
             $("#modal-body2").html(result);
        }});
    });
	</script>
	
	
		  <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1" aria-hidden="true">
                        
							 <div class="modal-body" id="modal-body2">
								<?php
								include 'auditdetailview.php';   
								?>         
						</div>
                           
                    </div>

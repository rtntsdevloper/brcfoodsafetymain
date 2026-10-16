<?php 
$sno=$_GET['sno'];
?>

                <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">User Management</a></li>
                        <li>View User Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=umgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<div class="card-title"> User Detail</div>
				
				<?php
				$sno=$_GET['sno'];
				$sq=mysqli_query($con,"select * from tblstaff where id='$sno'");
				$row=mysqli_fetch_array($sq);
				
				$sq1=mysqli_query($con,"select * from tblresult where staffid='$sno' order by tid desc limit 1");
				$match=mysqli_num_rows($sq1);
				$row1=mysqli_fetch_array($sq1);
				
			$cert=ucfirst($row['fname'])." ".ucfirst($row['lname'])."-".$row1['batchcode']."-".$row1['curdate'];
			
	
			  $filename = "MyPDF/".$cert.".pdf";

					if (file_exists($filename)) 
					{
					$cert=ucfirst($row['fname'])." ".ucfirst($row['lname'])."-".$row1['batchcode']."-".$row1['curdate'];
					} 
					else if(!file_exists($filename)) 
					{
					$cert=ucfirst($row['fname'])." ".ucfirst($row['lname'])."-Level 2 Award in Food Safety and Hygiene in Manufacturing-".$row1['curdate'];
					}
		
		
		
				?>			
							
					<div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="card-body text-center">
                                             <div>
												<img src="student/<?php echo $row['img'];?>" alt="" width="100" />
												</div>
                                       <p class="mt-0"> Name: <?php echo $row['fname'];?> <?php echo $row['lname'];?></p>
                                       <p>Department: <?php echo $row['department'];?></p>
										<p>Job Title: <?php echo $row['jobtitle'];?></p>
										<p>Pay Roll No: <?php echo $row['payroll'];?></p>
										<?php
										
										if($match<=0 && $row['cert']=="" )
										{
										?>
										<button class="btn btn-gray btn-rounded">Training result not found!</button>
										<?php
										}
										?>
										 <?php
										if($match>=1)
										{
										 ?>
										 <p>Date: <?php echo date('d-m-Y',strtotime($row1['curdate']));?></p>
										 <p>Score: <?php echo $row1['score'];?></p>
										 <p>Result: <?php echo $row1['result'];?></p>
										  	  
										  <?php
										  if($row1['result']=="Pass")
										  {
										  ?>
										  <a href="MyPDF/<?php echo $cert;?>.pdf" download><button class="btn btn-primary btn-rounded">Download Certificate</button></a>
										  <?php
										  }
										  ?>
											  <?php
											  }
											  ?>
                                               
                                            </div>
                                        </div>
                                    </div>
									
									<script>
									function cal()
									{
									 document.getElementById('cert1').style.display = "none";
									  document.getElementById('cert2').style.display = "block";
									 
									}
									
									function cal1()
									{
									 document.getElementById('cert2').style.display = "none";
									  document.getElementById('cert1').style.display = "block";
									 
									}
									</script>
									<div class="col-md-8">
									    <?php
										  if($row1['result']=="Pass" )
										  {
										  ?>
									<button class="btn btn-info btn-rounded" onclick="return cal();">Level 2 Award in Food Safety</button>
									<?php
									}
									?>
									
									<?php
									if($row['cert']!="")
									{
									?>
									<button class="btn btn-primary btn-rounded" onclick="return cal1();">Other</button>
									<?php
									}
									?>
									
									
									
									 <div class="card card-profile-1 mb-12" >
									  <?php
									 if($row1['result']=="Pass")
									 {
									 ?>
								    <iframe src="MyPDF/<?php echo $cert;?>.pdf" height="600" id="cert2" ></iframe>
									<iframe src="student/<?php echo $row['cert'];?>" height="600" id="cert1" style="display:none" ></iframe>
									<?php
									}
									else if($row['cert']!="")
									{
									?>
									<iframe src="MyPDF/<?php echo $cert;?>.pdf" height="600" id="cert2"  style="display:none" ></iframe>
									<iframe src="student/<?php echo $row['cert'];?>" height="600" id="cert1" ></iframe>
									<?php
									}
									?>
									 
									
									</div>
									
									
									
									
									
									</div>
									
									
									</div>
									
									
									
									
                               </div></div></div></div>
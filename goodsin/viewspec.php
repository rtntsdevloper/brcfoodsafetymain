<?php 
$sno=$_GET['sno'];
?>

                <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Specification Detail</a></li>
                        <li>View  Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=specdetail"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<div class="card-title"> View Detail</div>
				
				<?php
				$sno=$_GET['sno'];
				$sq=mysqli_query($con,"select * from tblrawmaterial where id='$sno'");
				$row=mysqli_fetch_array($sq);
				
				$sq1=mysqli_query($con,"select * from tblspecdetail where product='$sno'");
				$row1=mysqli_fetch_array($sq1);
			
				
		
		
		
				?>			
							
					<div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="card-body text-center">
                                             
                                       <p class="mt-0"> Product: <?php echo $row['pname'];?></p>
                                        <p>Product Code: <?php echo $row['pcode'];?></p>
										<p>Approved By: <?php echo $row1['uploadby'];?></p>
										<p>Approved On: <?php echo date('d-m-Y',strtotime($row1['date']));?></p>
									<div>
												<img src="specdetail/<?php echo $row1['sign'];?>" alt="" width="100" />
												</div>
                                               
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
									  
									
									
									
									 <div class="card card-profile-1 mb-12" >
									 
									<iframe src="specdetail/<?php echo $row1['spec'];?>" height="600" id="cert2"   ></iframe>
								
									
									
									</div>
									
									
									
									
									
									</div>
									
									
									</div>
									
									
									
									
                               </div></div></div></div>
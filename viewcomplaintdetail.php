
   <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_arrows.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_circles.min.css" />
    <link rel="stylesheet" href="dist-assets/css/plugins/smart.wizard/smart_wizard_theme_dots.min.css" />

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Complaint Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				<?php
				$sno=$_GET['sno'];
				$query=mysqli_query($con,"select * from tblnewcomplaint where id='$sno'");
				$row=mysqli_fetch_array($query);
				?>
				
				
				
		
			 <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
						<a href="admin.php?id=complaintmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="card-body text-center">
                                             
                                              
											<p class="mt-0"> Customer Name: <?php echo $row['customer'];?></p>
                                                <p class="mt-0">Contact: <?php echo $row['contact'];?></p>
                                                <p>Email: <?php echo $row['email'];?></p>
                                               
                                            </div>
                                        </div>
                                   
                                    </div>
									<div class="col-md-8">
									 <div class="card card-profile-1 mb-8">
								  <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
										<tr><th>Date of Complaint: <?php echo date('d-m-Y',strtotime( $row['compdate']));?> </th></tr>
									<tr><th>Product: <?php echo $row['product'];?> </th></tr>
									<tr><th>Product Code : <?php echo $row['pcode'];?></th></tr>
									<tr><th>Batch: <?php echo $row['batch'];?> </th></tr>
									<tr><th>Category: <?php echo $row['category'];?> </th></tr>
									<tr><th>UB/BB: <?php echo date('d-m-Y',strtotime($row['useby']));?> </th></tr>
										<tr><th>Issue: <?php echo $row['issue'];?> </th></tr>
											<tr><td><img src="complaint/<?php echo $row['img'];?>" width="100" /> </td></tr>
									
									
									</tr>
									<?php
											if($row['status']=="Done" )
											{
											
											$queryr=mysqli_query($con,"select * from tblnewcomplaint1 where sno='$sno'");
											$row1=mysqli_fetch_array($queryr);
											?>
											<tr><th>Verified product name: <?php echo $row1['pname'];?> </th></tr>
											<tr><th>Product Code: <?php echo $row1['pcode'];?> </th></tr>
											<tr><th>Investigation detail: <?php echo $row1['rootcause'];?> </th></tr>
											<tr><th>Corrective action: <?php echo $row1['corrective'];?> </th></tr>
											<?php 
											if(!empty($row1['preventive'])){
												?>
												<tr><th>Preventive action: <?php echo $row1['preventive'];?> </th></tr>
												<?php
											}

											?>
											
											<tr><th> <img src="complaint/<?php echo $row1['img'];?>" width="100" /> </th></tr>
											
											<?php
											}
											else if($row['status']=="waiting" && $access == "Admin")
											{
											?>
									
									
									
									
										<form name="form2" action="" method="post" class="pt-3" enctype="multipart/form-data">
										<input type="hidden" name="sno" value="<?php echo $sno;?>" />
								   <tr><td><h5 style="color:#993300">Investigation:</h5></td></tr>
								 <tr><td>Verify product name: <input type="text" class="form-control" name="product" required /></td></tr>
									<tr><td>Product Code: <input type="text" class="form-control" name="code" required /></td></tr>
								    <tr><td>Investigation detail : <textarea  class="form-control" name="rootcause" required ></textarea></td></tr>
									<tr><td>Corrective action: <textarea  class="form-control" name="corrective" required ></textarea></td></tr>
									<!-- <tr><td>Preventive action: <textarea  class="form-control" name="prevent" required ></textarea></td></tr> -->
									<tr><td>Photo if any: <input type="file" class="form-control" name="file"/></td></tr>
									
									
									<tr><td><input type="submit" class="btn btn-danger" name="submit" /></td></tr>
									
									</form>
									<?php
									}
									
									?>
									
								
									</table>
									</div>
									</div>
									</div>
									
									
									</div>
									
									<?php
									if(isset($_POST['submit']))
									{
									$date=date('Y-m-d');
									$sno=$_POST['sno'];
									$product=$_POST['product'];
									$code=$_POST['code'];
									$rootcause=$_POST['rootcause'];
									$corrective=$_POST['corrective'];

									$file=$_FILES['file']['name'];
									move_uploaded_file($_FILES['file']['tmp_name'],'complaint/'.$file);
									
									
									$ft=mysqli_query($con,"INSERT INTO tblnewcomplaint1(sno, pname, pcode, rootcause, corrective,img, status, date, user) VALUES ('$sno', '$product', '$code', '$rootcause', '$corrective','$file', 'Done', '$date', '$user')");
									$jk=mysqli_query($con, "update tblnewcomplaint set status='Done' where id='$sno'");
									
									?>
									<script language="javascript">
									window.open('admin.php?id=complaintview&sno=<?php echo $sno; ?>','_self');
									</script>
									<?php
									}
									?>
								
									
									
                               </div></div></div></div>
							   
						
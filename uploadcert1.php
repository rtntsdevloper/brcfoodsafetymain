<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Knowledge Hub Certificates</a></li>
                        
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=uploadcert"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Knowledge Hub Certificates</div>
								
       <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								
                                    <div class="form-row">
										 
										
										 <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Upload Cert</label>
                                            <input class="form-control" id="img" type="file"  required name="img"   accept="image/*"/>
                                            <div class="invalid-tooltip" id="supperror3">
                                            Please fill the field.
                                            </div>
                                           </div>
										</div>
										
                                    <button class="btn btn-primary" type="submit"  name="submit">Submit </button>
                               
                           
                     </form></div></div></div></div>
					 
					 
					 <?php
					 if(isset($_POST['submit']))
					 {
					
					$gh=mysqli_query($con,"delete from tblknowledge ");
					 $csv="cert".$_FILES['img']['name'];
					 
					 move_uploaded_file($_FILES['img']['tmp_name'],"images/".$csv);
				
$Connection=mysqli_query($con,"INSERT INTO tblknowledge (name) VALUES ('$csv')");

					 
					 
					 ?>
					<script >
				window.open('admin.php?id=uploadcert','_self');
					</script> 
					 <?php
					 }
					 
					 ?>
					 
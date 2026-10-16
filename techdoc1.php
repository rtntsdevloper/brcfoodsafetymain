<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Technical Document</li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=uploadreport"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3">Technical Document</h4>
								
                               
								
                               <div class="card-body">
      
		  <form name="form1" method="post" action="" enctype="multipart/form-data" >
                        <div class="row">					
                    <div class="col-md-12">
					
													
													<div class="col-6">
                    <label id="error">Date</label> 
					<div class="input-group">
				<input type="date" name="date" class="form-control" required >
					
                                                    </div>
                                                    </div>
													
					
												<div class="col-6">
                    <label id="error">Title</label> 
					<div class="input-group">
					 <input  name="title" type="text" class="form-control" required >
                                                    </div>
                                                    </div>
													
													<div class="col-6">
                    <label id="error">Version</label> 
					<div class="input-group">
					 <input  name="ver" type="text" class="form-control" required >
                                                    </div>
                                                    </div>
													
													
													
													
													<div class="col-6">
                    <label id="error">Upload Report</label> 
					<div class="input-group">
					 <input  name="file" type="file" class="form-control" required >
                                                    </div>
                                                    </div>	
													
												
													<div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														 
                                                    <button class="btn btn-info" type="submit" name="submit" value="submit">Submit</button>
                                                    </div>
                                                    </div>
											
												</div></div></div>
												
												   </form>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<?php
					if(isset($_POST['submit']))
					{
					$date=$_POST['date'];
					$ver=$_POST['ver'];
					$title=$_POST['title'];
					$rand=date('dmy').rand(10,100);
					$img=$rand.$_FILES['file']['name'];
					$user=$_SESSION['user'];
					
					move_uploaded_file($_FILES['file']['tmp_name'],"customerreport/".$img);
					
					$sql=mysqli_query($con,"insert into tblreport(date,title,img,user,ver)values('$date','$title','$img','$user','$ver')")
					
					?>
					<script language="javascript">
					window.open('admin.php?id=techdoc','_self')
					</script>
					
					<?php
					}
					?>
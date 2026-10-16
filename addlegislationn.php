<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Home / Knowledge Hub  </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
		
		<div  class="col-xl-12" style="margin-bottom:20px">
	
		<a href="admin.php?id=legislation"><button type="submit" class="btn  btn-danger" style="float:right;margin-left:15px">Go Back</button></a>
		
		
		 <a href="admin.php?id=legislationcategory"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
	</div>
		

	

<div class="col-sm-12">
                <div class="card">
                 
            <div class="card-body">
      
		  <form name="form1" method="post" action="" >
                        <div class="row">					
                    <div class="col-md-12">
					
					
					<div class="col-6">
                    <label id="error">Select Category</label> 
					<div class="input-group">
					<select name="category" class="form-control" required >
					<option value="">Select</option>
					<?php
										$sql2=mysqli_query($con,"select *  from tbllegislationcate");
											while($rows=mysqli_fetch_array($sql2))
											{
											?>
											<option value="<?php echo $rows['id'];?>"> <?php echo $rows['name'];?></option>
											
											<?php
											}
											?>
					</select>
                                                    </div>
                                                    </div>
													
													
						<div class="col-6">
                    <label id="error">Date</label> 
					<div class="input-group">
					<input name="date" type="date" class="form-control" required >
                                                    </div>
                                                    </div>
													
													
				    													<div class="col-6">
                    <label id="error">Title</label> 
					<div class="input-group">
					<input name="title" type="text" class="form-control" required >
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
											   </div></div></div>
											    
												
												<?php
												if(isset($_POST['submit']))
												{
												$date=$_POST['date'];
												$category=$_POST['category'];
												$title=mysqli_real_escape_string($con,$_POST['title']);
												
												$sql=mysqli_query($con,"insert into tbllegislation(date,name,cate)values('$date','$title','$category')");
												?>
												<script language="javascript">
												window.open('admin.php?id=legislation','_self');
												</script>
												
												<?php
												}
												?>
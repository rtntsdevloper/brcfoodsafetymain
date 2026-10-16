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
		
		<div class="col-xl-12" style="margin-bottom:20px">
		 <a href="admin.php?id=alertsmgmt"><button type="submit" class="btn  btn-danger" style="float:right;margin-left:15px">Go Back</button></a>
		
	    </div>
		

	

<div class="col-sm-12">
                <div class="card">
                  <?php
		  if(isset($_GET['msg']))
		{
		?>
		 <div style="color:#FF0000; text-align:center; font-size:18px"> Supplier Already Exist! </div><br/>
		 <?php
		  }
		  ?>
            <div class="card-body">
      
		  <form name="form1" method="post" action="alerts1" >
             <div class="row">					
                    <div class="col-md-12">
					
					<div class="col-6">
                    <label id="error">Category</label> 
					<div class="input-group">
					<select name="category" class="form-control" required >
					<option value="">Select</option>
					<?php
														$sql2=mysqli_query($con,"select *  from tblalert1 where status='alerts'");
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
                    <label id="error">Description</label> 
					<div class="input-group">
					<textarea name="description" class="form-control" required ></textarea>
                                                    </div>
                                                    </div>
													
													<div class="col-6">
                    <label id="error">Type</label> 
					<div class="input-group">
					 <input  name="type" type="text" class="form-control" required >
                                                    </div>
                                                    </div>
													
					<div class="col-6">
                    <label id="error">Link</label> 
					<div class="input-group">
					<input name="link" type="text" class="form-control"  >
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
											    
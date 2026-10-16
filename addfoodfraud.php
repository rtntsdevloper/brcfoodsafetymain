<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="editor.js"></script>

		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="editor.css" type="text/css" rel="stylesheet"/>
      <!-- / Mega menu -->
           
<div class="main-content">
<div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                   <ul>
                        <li><a href="">Home</a></li>
                        <li>Food Fraud and Adulteration</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=foodfraud"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                               
			
			   		<form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">	
					<div class="col-6">
                    <label id="error">Date</label> 
					<div class="input-group">
					<input name="date" type="date" class="form-control" required >
                                                    </div>
                                                    </div>
													
													
					<div class="col-6">
                    <label id="error">Select Category</label> 
					<div class="input-group">
					<select name="category[]" class="form-control" required  multiple="multiple">
					<option value="">Select</option>
					<?php
										$sql2=mysqli_query($con,"select *  from tblalert1 where status='foodfraud'");
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
                    <label id="error">Select Country</label> 
					<div class="input-group">
					<select name="country" class="form-control" required >
					<option value="">Select</option>
					<?php
										$sql3=mysqli_query($con,"select *  from tblcountry");
											while($row3=mysqli_fetch_array($sql3))
											{
											?>
											<option value="<?php echo $row3['id'];?>"> <?php echo $row3['name'];?></option>
											
											<?php
											}
											?>
					</select>
                                                    </div>
                                                    </div>
					  
					  
													
					<div class="col-12">
                    <label id="error">Description</label> 
					<div class="input-group">
					<textarea id="txtEditor" ></textarea> 
							<textarea id="message" name="message" style="display:none" ></textarea>
                                                    </div>
                                                    </div>
													
													<div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														 
                                                    <input class="btn btn-info" type="submit" name="submit" value="Submit">
                                                    </div>
                                                    </div>
										
												</form>
												</div></div></div></div>
		
	 <script language="javascript" type="text/javascript">        
    $(document).ready( function() 
	{
    $("input:submit").click(function(){
    $('#message').text($('#txtEditor').Editor("getText"));
	//document.getElementById("form").submit();
    });        
    });
    </script>
	
	<?php
	if(isset($_POST['submit']))
	{
	$date=$_POST['date'];
	$category=$_POST['category'];
	$country=$_POST['country'];
	$detail=$_POST['message'];
	
	$tid=count($_POST['category']);

	
	 $sourcePath1 = $_POST['category'][0];
	
	 $sql=mysqli_query($con,"insert into tblfoodfraud(date,category,detail,state)values('$date','$sourcePath1','$detail','$country')");
	
	
	$sq=mysqli_query($con,"select * from tblfoodfraud order by id desc limit 1");
	$sq1=mysqli_fetch_array($sq);

     for($h=1 ; $h < $tid ; $h++ )
	 {
	  $sourcePath = $_POST['category'][$h];
	 $sq2=mysqli_query($con,"insert into tblfoodfraud1(sno,cate)values('$sq1[id]','$sourcePath')");
	 } 



	
	?>
	<script language="javascript">
	window.open('admin.php?id=foodfraud','_self');
	</script>
	<?php
	}
	?>
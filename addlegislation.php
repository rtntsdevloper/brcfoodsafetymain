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
                        <li>Legislation Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=legislation"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                               
				<form name="form1" id="form" method="post" enctype="multipart/form-data" action="addlegislation2" >
				<input name="sno" type="hidden" class="form-control" value="<?php echo $_GET['sno'];?>" >							
				   			
													
					<div class="col-6">
                    <label id="error">Title</label> 
					<div class="input-group">
					 <input  name="title" type="text" class="form-control" required >
                      </div>
                      </div>
													
					<div class="col-12">
                    <label id="error">Description</label> 
					<div class="input-group">
					<textarea id="txtEditor" ></textarea> 
							<textarea id="message" name="message" style="display:none"></textarea>
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
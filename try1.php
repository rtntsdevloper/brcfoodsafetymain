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
		<link href="editor.css" type="text/css" rel="stylesheet"/>	</head>
	<body>
	<form name="form1" id="form" method="post" enctype="multipart/form-data" action="addlegislation2" >
		<div class="container-fluid">
			<div class="row">
				<h2 class="demo-text">LineControl Demo</h2>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 nopadding">
							<textarea id="txtEditor" ></textarea> 
							<textarea id="message" name="message" ></textarea>

						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="submit" name="submit" >
		<div class="container-fluid footer">
			<p class="pull-right">&copy; Suyati Technologies <script>document.write(new Date().getFullYear())</script>. All rights reserved.</p>
		</div>
	</body>
	</form>
</html>




    <script language="javascript" type="text/javascript">        
    $(document).ready( function() 
	{
    $("input:submit").click(function(){
    $('#message').text($('#txtEditor').Editor("getText"));
    });        
    });

    </script>
       
</div>
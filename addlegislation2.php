<?php
	
	    include 'connection.php';
		$title=$_POST['title'];
		$sno=$_POST['sno'];
		$detail=$_POST['message'];
		
		$sql=mysqli_query($con,"insert into tbllegislation1(sno,name,description)values('$sno','$title','$detail')");
		
		?>
		
		<script language="javascript">
		window.open('admin.php?id=legislation','_self');
		</script>
		
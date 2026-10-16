
							
							<?php
							session_start();
						include 'connection.php';	
						$sno=$_POST['sno'];
							 $name=$_POST['name'];
							 $detail=$_POST['detail'];
							 $linkk=$_POST['linkk'];
							 $document=$_FILES['document']['name'];
							 $typee=$_POST['typee'];
							
							move_uploaded_file($_FILES['document']['tmp_name'],"document/".$document);
							//$snoo=$_POST['snoo'];
							
								
							
						if($document=="")
						{
		$sql=mysqli_query($con,"update tbldetail set section='$name', detail='$detail', typee='$typee', linkk='$linkk' where id='$sno'");
		}
		else if($document!="")
						{
		$sql=mysqli_query($con,"update tbldetail set section='$name', detail='$detail',  typee='$typee', linkk='$linkk',img='$document' where id='$sno'");
		}
		
		?>
		
		
		
							
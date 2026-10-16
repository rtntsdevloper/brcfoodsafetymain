
							
							<?php
							session_start();
						include 'connection.php';	
							 $name=$_POST['name'];
							 $detail=$_POST['detail'];
							 $linkk=$_POST['linkk'];
							 $document=$_FILES['document']['name'];
							
							move_uploaded_file($_FILES['document']['tmp_name'],"document/".$document);
							//$snoo=$_POST['snoo'];
							
							 $sid=$_POST['sid'];
								$tid=$_POST['tid'];
									$fid=$_POST['fid'];
									$typee=$_POST['typee'];
									
							
							 $date=date("Y-m-d");
							 $user=$_SESSION['user'];
							
							
							
		$sql=mysqli_query($con,"INSERT INTO tbldetail (tid, sid, fid, section, detail, img, user, date, typee, linkk) VALUES ('$tid', '$sid', '$fid', '$name', '$detail', '$document', '$user', '$date', '$typee', '$linkk')");
		
		echo "Data uploaded successfully";
		?>
		
		
		
							
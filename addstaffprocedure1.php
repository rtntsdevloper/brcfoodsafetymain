<script language="javascript">
function cal()
{
if(document.form1.tab1.checked==false && document.form1.tab2.checked==false && document.form1.tab3.checked==false && document.form1.tab4.checked==false)
{
document.getElementById("error4").style.color = "red";

document.getElementById('error4').innerHTML="Please select tab access";
return false;
}
else if(document.form1.position.value=="")
{
document.getElementById("error3").style.color = "red";

document.getElementById('error3').innerHTML="Please enter position";
document.form1.position.focus();
return false;
}
else
{
return true;
}
}

</script>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Training Detail
						</a></li>
                        <li>Add Procedure</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							  <a href="admin.php?id=addstaffprocedure&sno=<?php echo $_GET['sno1'];?>"><button class="btn btn-info" style="float:right">Go Back</button></a>
							
                             
								<?php
								if(isset($_GET['msg']))
								{
								?>
								<div class="card-title" style="color:#FF0000">Already exist</div>
								<?php
								}
								?>
                                        <form class="form-horizontal" method="post" action="" name="form1" onsubmit="return cal();" enctype="multipart/form-data">
							
								
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Select Staff</label>
                                      
				<select name="name" class="form-control" required>
             
              <?php
		
			  $xy = mysqli_query($con,"select * from tblstaff where id='$_GET[sno]'");
			  while($xy1 = mysqli_fetch_array($xy))
			  {
			  ?>
              <option value="<?php echo $xy1['id'];?>"><?php echo $xy1['fname'];?> <?php echo $xy1['lname'];?></option>
              <?php
			 }
			 ?>
            </select>
                                            <div class="invalid-tooltip">
                                                Please select module

                                            </div>
                                        </div>
               <div class="col-md-4 mb-3">
               <label for="validationTooltip02">Select Procedure</label>
											
           <select name="procedure[]" class="form-control" required multiple="multiple">
              <option value="">Please Select</option>
			   
              <?php
		
			  $xy1 = mysqli_query($con,"select * from tblprocedure");
			  while($xy11 = mysqli_fetch_array($xy1))
			  {
			  ?>
              <option value="<?php echo $xy11['id'];?>"><?php echo $xy11['name'];?> </option>
              <?php
			 }
			 ?>
            </select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                        </div>
                                       
								
										
									
									
									</div>
									   
                                
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                       <?php
						if(isset($_POST['submit']))
						{
						$pid=$_GET['sno1'];
						$name=$_GET['sno'];
						
						$pro=count($_POST['procedure']);

 for($h=0 ; $h < $pro ; $h++ )
	 {
	  $pro1 = $_POST['procedure'][$h];
	
	  
	


						$query=mysqli_query($con,"INSERT INTO tblproceduretraining1 ( pid, uid, procedure1) VALUES ( '$pid', '$name', '$pro1')");
						}
						?>
						<script language="">
						window.open('admin.php?id=proceduredetail&sno=<?php echo $_GET['sno1'];?>','_self');
						</script>
						
						<?php

						}
						?>
						
						
						
						
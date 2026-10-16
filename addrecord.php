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

									
    <script>
function showHint(str)
 {
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  xmlhttp.open("GET", "tblgetclause.php?q=" + str);
  xmlhttp.send();
  }
}
</script>


<script>
function showHint1(str,str1)
 {
  if (str.length == 0) {
    document.getElementById("txtHint1").innerHTML = "";
    return;
  } else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      document.getElementById("txtHint1").innerHTML = this.responseText;
    }
  xmlhttp.open("GET", "tblgetclause1.php?q=" + str + "&tid="+ str1);
  xmlhttp.send();
  }
}
</script>


<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Records Upload</a></li>
                        <li>Add Records</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							 <a href="admin.php?id=additionalmgmt">
							 <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                              
								
								<?php
								if(isset($_GET['msg']))
								{
								?>
								<div class="card-title" style="color:#FF0000">Already exist</div>
								<?php
								}
								?>
                                      <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data" id="uuploadForm3<?php echo $i;?>" name=""> 
		  
								 
								  
                                    <div class="form-row" id="refresh">
									 	<div id="uuploadStatus3<?php echo $i;?>"></div>

									 <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01"> Type</label>
                                            <select class="form-control" id="validationTooltip01" type="text"  required="required" name="typee">
											<option value="Compliance">Records</option>
											</select>
                                            <div class="invalid-tooltip">
                                                Please fill the field.
                                            </div>
                                        </div>
										
	
		<div class="col-md-4 mb-3">
        <label for="validationTooltip02">Section</label>
	   <select name="p1" class="form-control" required onchange="showHint(this.value)"> 
	   <option value="">Please Select</option>
	
	    <?php
	    $xy = mysqli_query($con,"select * from addtest1");
	    while($xy1 = mysqli_fetch_array($xy))
	    {
	    ?>
	    <option value="<?php echo $xy1['testid'];?>"><?php echo $xy1['subject'];?></option>
        <?php
	     }
	    ?>
		
	    </select>
    
	<div class="invalid-tooltip">
    Please fill the field.
     </div>
                                        </div>
                                  
									
									 
									
                                        <div class="col-md-4 mb-3" id="txtHint">
                                            <label for="validationTooltip03"> Select Sub-Section</label>
                                          <select class="form-control" required disabled="disabled">
              <option value="">Please Select</option>
                 </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid password.
                                            </div>
                                       
                                     </div>		
									
									
									
                                        <div class="col-md-4 mb-3" id="txtHint1">
                                            <label for="validationTooltip03"> Select Clause</label>
                                          <select class="form-control" required disabled="disabled">
               <option value="">Please Select</option>
                 </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid password.
                                            </div>
                            			
                                     </div>		
									 
									 
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  required="required" name="name" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.
                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Detail</label>
                                            <textarea class="form-control" id="validationTooltip01" required="required" name="detail"></textarea>
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Link if any</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  name="linkk" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
											<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Upload Document</label>
                                            <input class="form-control" id="validationTooltip01" type="file"   name="document" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
                                    </div>
      <button class="btn btn-primary" type="submit" id="submitt" name="submitt">  Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                             <?php
						if(isset($_POST['submitt']))
						{
						 $name=$_POST['name'];
							 $detail=$_POST['detail'];
							 $linkk=$_POST['linkk'];
							 $document=$_FILES['document']['name'];
							
							move_uploaded_file($_FILES['document']['tmp_name'],"document/".$document);
							//$snoo=$_POST['snoo'];
							
						
									$typee=$_POST['typee'];
									
							 $date=date("Y-m-d");
							 $user=$_SESSION['user'];
							$p1=$_POST['p1'];
						$p2=$_POST['p2'];
						$p3="";
						
						foreach($_POST['p3'] as $selected)
  {
	   $p3.= $selected.";";
							
							
		$sql=mysqli_query($con,"INSERT INTO tbldetail (tid, sid, fid, section, detail, img, user, date, typee, linkk) VALUES ('$p1', '$p2', '$selected', '$name', '$detail', '$document', '$user', '$date', '$typee', '$linkk')");
		}
						
						?>
						<script language="">
						window.open('admin.php?id=recordsmgmt','_self');
						</script>
						<?php
						}
						?>
						
						
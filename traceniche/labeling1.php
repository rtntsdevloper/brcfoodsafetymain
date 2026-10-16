<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Traceability</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
						
												
				
			       <div class="row mb-12">
                   <div class="col-md-12 mb-12">
                   <div class="card text-left">
                   <div class="card-body">
					
				  <a href="admin.php?id=labeling&id2=<?php echo $_GET['id2'];?>"> <button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>
                   <h4 class="card-title mb-3">Labeling </h4>
								
								<form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip01">Date/Time</label>
                                            <input class="form-control" id="validationTooltip01" type="datetime-local"   required="required" name="date" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Select Product Batchcode</label>
                                            <select class="form-control" name="product" required >
											<option>Please Select</option>
											<?php
											$sqli=mysqli_query($con,"select * from tblmarination where status='Done'");
											while($row=mysqli_fetch_array($sqli))
											{
											?>
											<option value="<?php echo $row['batchcode'];?>"><?php echo $row['batchcode'];?></option>
											<?php
											}
											?>
											</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                        </div>
                                       
									  
	<script>
function cal(str)
{

if (str=="")
  {
  document.getElementById("chkproduct1").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("chkproduct1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo $_GET['id2'];?>/metal2.php?q="+str,true);
xmlhttp.send();  
  }
</script>
										<div class="col-md-6">
                                            <label for="validationTooltip02">Test Type</label>
                                            <select class="form-control" id="testtype"  required="required" name="testtype"  onchange="return cal(this.value)" >
											<option value="">Please Select</option>
											<option value="Beginning">Beginning</option>
											<option value="Every Hour">Every Hour</option>
											<option value="End of Production">End of Production</option>
											<option value="Change of Shift">Change of Shift</option>
											
											</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">
Is Correct packaging have been used? (if no enter comment)</label>
                                            <select class="form-control" id="ans"  required="required" name="ans"   >
											<option value="">Please Select</option>
											<option value="Yes">Yes</option>
											<option value="No">No</option>
										
											
											</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">
Comment</label>
                                         <textarea name="cmnt" placeholder="If no what correction need?" class="form-control"></textarea>
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										</div>
										
										
										<br/>
										</div>
										
										
										
										 </div>
									
                                   <br/>
                                       <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
									</div>
									
									
                               </div></div></div></div>
	  <?php
if(isset($_POST['submit']))
{
$date=$_POST['date'];
$product=$_POST['product'];
$testtype=$_POST['testtype'];
$cmnt=$_POST['cmnt'];

$user=$_SESSION['user'];

 $ans=$_POST['ans'];
 
 


$sql=mysqli_query($con,"INSERT INTO tbllabeling (datetime,productbatch,testtype,ans,cmnt,user) VALUES ('$date', '$product','$testtype','$ans','$cmnt','$user')");
?>
<script language="javascript">
window.open('admin.php?id=labeling&id2=<?php echo $_GET['id2'];?>','_self');
</script>
<?php
}
?>
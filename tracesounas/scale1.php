<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Scale Calibration</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
						
			 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
       
									
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=scale&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>
						
							
                             <h4 class="card-title mb-3">Scale Calibration</h4>
								
									
								<form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip01">Date/Time</label>
                                            <input class="form-control" type="datetime-local"   required="required" name="date" id="date" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
 </div>
 



                      <div class="col-md-6">
                                            <label for="validationTooltip02"> Enter Scale </label>
                                             <input class="form-control"  type="number"  name="scale" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                           </div>
										   
										
										  <div class="col-md-6">
                                            <label for="validationTooltip02">Enter Weight</label>
                                            <input class="form-control"  type="number"  name="weight"   />
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                        </div>
										
										
										 <div class="col-md-6">
                                            <label for="validationTooltip02">Left Top</label>
                                            <input class="form-control"  type="number"  name="r1"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										<div class="col-md-6">
                                            <label for="validationTooltip02">Right Top</label>
                                            <input class="form-control"  type="number"  name="r2"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Left Bottom</label>
                                            <input class="form-control"  type="number"  name="r3"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Right Bottom</label>
                                            <input class="form-control"  type="number"  name="r4"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										
										<div class="col-md-6">
                                            <label for="validationTooltip02">Centre</label>
                                            <input class="form-control"  type="number"  name="r5"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										 </div>
										 <br/>
									 <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
									</div>
									
									
 <?php
if(isset($_POST['submit']))
{
$date=$_POST['date'];
$scale=$_POST['scale'];
$weight=$_POST['weight'];

$ans=$_POST['r1'].";".$_POST['r2'].";".$_POST['r3'].";".$_POST['r4'].";".$_POST['r5'].";";


$user=$_SESSION['user'];

 


$sql=mysqli_query($con,"INSERT INTO tblscale (date,testpiece,scale,ans,user) VALUES ('$date', '$weight','$scale','$ans','$user')");
?>
<script language="javascript">
window.open('admin.php?id=scale&id2=<?php echo $_GET['id2'];?>','_self');
</script>
<?php
}
?>
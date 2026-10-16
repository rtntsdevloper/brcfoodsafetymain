<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit</a></li>
                        <li>Add Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
						
                                <div class="card-title">Audit</div>
								
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								
                                        <div class="form-row" id="txtHint">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Select Date</label>
                                            <input name="date" type="date" class="form-control" id="validationTooltip03"   required="required"  />
                                            <div class="invalid-tooltip">
                                               Please provide a valid date.

                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="form-row" id="txtHint">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03"> Auditor </label>
                                       	<select name="auditor" class="form-control"  required>
											<option value="">Please Select</option>
											<?php
											$sql1=mysqli_query($con,"select * from tblauditor where name='$user'");
											while($row1=mysqli_fetch_array($sql1))
											{
											?>
                                            <option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
											<?php
											}
											?>
											</select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.
                                            </div>
                                        </div>
										
                                     </div>		
									 
									        <div class="form-row" id="txtHint">
                                            <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03"> Auditee Name</label>
                                            <select name="auditee" class="form-control"  required>
											<option value="">Please Select</option>
											<?php
											$sql=mysqli_query($con,"select * from tblauditee");
											while($row=mysqli_fetch_array($sql))
											{
											?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
											<?php
											}
											?>
											</select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.
                                            </div>
                                        </div>
										
                                     </div>		
									 
									 
						<div class="form-row" id="txtHint">
                          <div class="col-md-4 mb-3">
                               <label for="validationTooltip03">Select Audit</label>
                                <select class="form-control" name="audit" required>
								<option value="">Please Select</option>
								<?php
								$sql=mysqli_query($con,"select * from tblauditsection1 where sid='$_GET[tid]'");
								while($row=mysqli_fetch_array($sql))
								{
								?>
								  <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
								<?php
								}
								?> 
								</select>
                               <div class="invalid-tooltip">
                                  Please select
                                 </div>
                                        </div>
										
                                     </div>		
								
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>	</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


<?php
if(isset($_POST['submit']))
{
$user=$_SESSION['user'];
$auditee=$_POST['auditee'];
$auditor=$_POST['auditor'];
$date=$_POST['date'];
$audit=$_POST['audit'];




$gh=mysqli_query($con,"select * from tblauditsection1 where id='$audit'");
$gh1=mysqli_fetch_array($gh);

$hh=mysqli_query($con,"select * from tblauditsection where id='$gh1[sid]'");
$hh1=mysqli_fetch_array($hh);



$sql=mysqli_query($con,"INSERT INTO tblgmpaudit2 (auditor, auditee, date,audit,sid,auditsection,auditsection1) VALUES ('$auditor','$auditee','$date','$gh1[sid]','$audit','$hh1[name]','$gh1[name]')");

?>
<script language="javascript">
 window.open('admin.php?id=gmpauditt&tid=<?php echo $_GET['tid'];?>','_self');
</script>
<?php
  }
?>

	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Audit Management </li>
                    </ul>
                </div>
				 
           
                         
				 <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Audit Management</div>
							
                                <form class="needs-validation" novalidate="novalidate" method="post" action="">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationTooltip01">Select Date</label>
                                            <input class="form-control" id="validationTooltip01" type="date"   required="required" name="date" max="<?php echo date("Y-m-d");?>" />
                                            <div class="invalid-tooltip">
                                                Please select date.

                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationTooltip02">Auditee Name</label>
                                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Auditee name"  required="required" name="auditee" />
                                            <div class="invalid-tooltip">
                                               Please provide a valid auditee name.

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
$date=$_POST['date'];
$auditee=$_POST['auditee'];
$user=$_SESSION['user'];
$_SESSION['auditee']=$auditee;
$_SESSION['user']=$user;

$sql=mysqli_query($con,"INSERT INTO tblaudit (auditee,date,user) VALUES ( '$auditee', '$date', '$user')");
?>
<script language="javascript">
window.open('admin.php?id=audit','_self');
</script>
<?php
}
?>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">User Management</a></li>
                        <li>Add User</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=umgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Add User</div>
								<?php
								if(isset($_GET['msg']))
								{
								?>
								<div class="card-title" style="color:#FF0000">User already exist</div>
								<?php
								}
								?>
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">First name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name"  required="required" name="fname" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Last name</label>
                                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Last name"  required="required" name="lname" />
                                            <div class="invalid-tooltip">
                                               Please provide a valid last name.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">User name</label>
                                            <input name="uname" type="text" class="form-control" id="validationTooltip03" placeholder="User name"  required="required" />
                                            <div class="invalid-tooltip">
                                               Please provide a valid username.

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03">Password</label>
                                            <input class="form-control" id="validationTooltip04" type="password" placeholder="password" required="required"  name="pwd" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip04">Department</label>
                                            <input name="department" type="text" class="form-control" id="validationTooltip05" placeholder="Department" required="required" />
                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip05">Job Title</label>
                                            <input name="jobtitle" type="text" class="form-control" id="validationTooltip06" placeholder="Job Title" required="required" />
                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>
										 <div class="col-md-4 mb-3">
                                            <label for="validationTooltip05">Email</label>
                                            <input name="email" type="email" class="form-control" id="validationTooltip06" placeholder="Email" />
                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>
										
										<div class="col-md-4 mb-3">
                                            <label for="validationTooltip05">User Photo</label>
                                            <input name="img" type="file" class="form-control" id="validationTooltip07"  required="required" accept="image/jpeg,jpg" />
                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>
										
										<div class="col-md-4 mb-3">
                                            <label for="validationTooltip05">Pay Roll No</label>
                                            <input name="payroll" class="form-control" id="validationTooltip08" type="text" placeholder="Pay Roll No" required="required" >
                                            <div class="invalid-tooltip">
                                               Please fill the field

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
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$uname=$_POST['uname'];
$email=$_POST['email'];
$pwd=$_POST['pwd'];
$department=$_POST['department'];
$jobtitle=$_POST['jobtitle'];
$payroll=$_POST['payroll'];
$img=$_FILES['img']['name'];
move_uploaded_file($_FILES['img']['tmp_name'],"student/".$img);
$user=$_SESSION['user'];

$fg=mysqli_query($con,"select * from tblstaff where uname='$uname'");
$match=mysqli_num_rows($fg);
if($match>=1)
{
?>
<script language="javascript">
window.open('admin.php?id=adduser&msg=1','_self');
</script>

<?php
}
else
{
$sql=mysqli_query($con,"INSERT INTO tblstaff ( fname, lname, uname, pwd, department, payroll, img,jobtitle,addby,email) VALUES ( '$fname', '$lname', '$uname', '$pwd', '$department', '$payroll', '$img','$jobtitle','$user','$email')");
?>
<script language="javascript">
window.open('admin.php?id=umgmt','_self');
</script>
<?php
}
}
?>
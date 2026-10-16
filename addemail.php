<div class="main-content">
<div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Email  Management</a></li>
                        <li>Add Email</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=adminmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Add Email</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name"  required="required" name="name" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Email</label>
                                            <input class="form-control" id="validationTooltip02" type="email" placeholder="Email"  required="required" name="email" />
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
$name=$_POST['name'];
$email=$_POST['email'];

$fg=mysqli_query($con,"select * from tblemail where email='$email'");
$match=mysqli_num_rows($fg);
if($match>=1)
{
?>
<script language="javascript">
alert("Already Exist!");
window.open('admin.php?id=addemail','_self');
</script>
<?php
}
else 
{
$sql=mysqli_query($con,"INSERT INTO tblemail (name, email) VALUES ('$name', '$email')");
?>
<script language="javascript">
window.open('admin.php?id=emailmgmt','_self');
</script>
<?php
}
}
?>
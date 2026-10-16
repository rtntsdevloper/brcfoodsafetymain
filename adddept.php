<div class="main-content">
<div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Department  Management</a></li>
                        <li>Add Department</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=deptmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Add Department</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name"  required="required" name="name" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

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

$fg=mysqli_query($con,"select * from tbldept where name='$name'");
$match=mysqli_num_rows($fg);
if($match>=1)
{
?>
<script language="javascript">
alert("Already Exist!");
window.open('admin.php?id=adddept','_self');
</script>
<?php
}
else 
{
$sql=mysqli_query($con,"INSERT INTO tbldept (name) VALUES ('$name')");
?>
<script language="javascript">
window.open('admin.php?id=deptmgmt','_self');
</script>
<?php
}
}
?>
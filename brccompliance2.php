	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">BRC Compliance</a></li>
                        <li>General Compliance</li>
                    </ul>
                </div>
				       <div class="col-md-6">
                        <div class="card text-left">
                            <div class="card-body">
							<a href="admin.php?id=brccompliance"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                                <h4 class="card-title mb-2">BRC Compliance | General Compliance</h4>
                                 <form class="needs-validation" novalidate="novalidate" method="post" action="">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name"  required="required" name="name" />
                                            <div class="invalid-tooltip">
                                                Please fill the name.
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
							$date=date("Y-m-d");
							$user=$_SESSION['user'];
							
							$fg=mysqli_query($con,"select * from tblcompliance where name='$name'");
							$match=mysqli_num_rows($fg);
							if($match>=1)
							{						
							?>
							<script language="javascript">
							alert("Already Exist");
							</script>
							<?php
							}
							else
							{
							$sql=mysqli_query($con,"insert into tblcompliance(name,date,user)values('$name','$date','$user')");
							}
							?>
							<script language="javascript">
							window.open("admin.php?id=brccompliance",'_self');
							</script>
							<?php
							}
							?>
							
							
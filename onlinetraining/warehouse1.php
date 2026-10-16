
<div class="container">
<div class="main-content ">
                <div class="breadcrumb ">
                    <!-- <h1 class="mr-2"><?php echo $headingname;?></h1> -->
                    <ul>
                        <li><a href="">Fill The Form</a></li>
                       
                    </ul>
                </div>
				 <div class="col-lg-12" style="margin-top:100px;">
                        <div class="card my-5" >
                            <div class="card-body">
							<a href="admin.php?id=warehouse"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Attempt test</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        
                                        <div class="col-md-12 mb-3">
                                            <label for="validationTooltip02">Unit No</label>
                                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Unit No"  required="required" name="unit_no" />
                                            <div class="invalid-tooltip">
                                               Please provide a valid Unit No

                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationTooltip02">Location</label>
                                            <input name="location" type="text" class="form-control" id="validationTooltip03" placeholder="Location"  required="required" />
                                            <div class="invalid-tooltip">
                                               Please provide a valid Location

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationTooltip03">Contract No</label>
                                            <input class="form-control" id="validationTooltip04" type="text" placeholder="Contract No" required="required"  name="contractno" />
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
                </div></div>
                </div></div>
                     <?php
                                            
                                                  ?>
                                                  <?php
                                                  if(isset($_POST['submit'])){
                                                 
                                                    $a = $_POST['company_name'];
                                                    $b = $_POST['unit_no'];
                                                    $c = $_POST['location'];
                                                    $d = $_POST['contractno'];
                                                     $u=$_SESSION['uname'];
                                                 
                                                    $query = "INSERT into `attempt` (`company_name`, `unit_no`, `location`, `contractno`,`username`) values ('Shankar', '$b', '$c', '$d','$staffid')";
                                                    $result = mysqli_query($con, $query);
                                                    if ($result)
													 {
                                                        // echo  'data';    
                                                        // header('location:gmp.php');
                                                        echo "<script>
                                                    
                                                        document.location.href='admin.php?id=warehouse';
                                                        </script>";
                                            
                                                    } 


                                                  }
                                                  ?>
                                                 
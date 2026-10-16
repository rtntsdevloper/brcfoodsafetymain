
<?php
$sno=$_GET['sno'];
$audit=$_GET['audit'];
?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">GMP Audit</a></li>
                        <li>Add Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=gmpaudit"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">GMP Audit</div>
								
								<?php
								$sql=mysqli_query($con,"select * from tblgmpaudit");
								while($row=mysqli_fetch_array($sql))
								{
								?>
                         
                                        <div class="form-row" id="txtHint">
                                        <div class="col-md-4 mb-3">
                                            
                                            <a href="admin.php?id=gmpaudit2&sno=<?php echo $_GET['sno'];?>&sno1=<?php echo $row['id'];?>">
											<input  type="button"  id="validationTooltip03" value="<?php echo $row['name'];?>" class="btn btn-info"  />
											</a>
                                            
                                        </div>
                                    </div>
									<?php
									}
								    ?>
                                    
									 
								
                                   
                            </div>
                        </div>
                    </div>
                </div>



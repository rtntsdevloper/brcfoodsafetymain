<?php 
include 'connection.php';
$sno=$_GET['sno'];
$mn=mysqli_query($con,"select * from tbldetail where id='$sno'");
$rows=mysqli_fetch_array($mn);
				?>	
				
		 
                                <div class="card-title">Edit Detail
								</div>
								<div class="document">
								 <div id="uploadStatus"> </div>
                             <form class="needs-validation" novalidate="novalidate" method="post" action="uploadcompliance" enctype="multipart/form-data"  id="uploadForm"> 
						      <input type="hidden" name="sno" value="<?php echo $sno;?>"  />
								  
                                    <div class="form-row" id="refresh">
									 
									 <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Select Type</label>
                                            <select class="form-control" id="validationTooltip01" type="text"  required="required" name="typee">
											<option value="<?php echo $rows['typee'];?>"><?php echo $rows['typee'];?></option>
											
											
											</select>
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  required="required" name="name" value="<?php echo $rows['section'];?>" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Detail</label>
                                            <textarea class="form-control" id="validationTooltip01" required="required" name="detail"><?php echo $rows['detail'];?></textarea>
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Link if any</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  name="linkk" value="<?php echo $rows['linkk'];?>"  />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
											<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Upload Document: <a href="document/<?php echo $rows['img'];?>" target="_blank"><span style="color:#FF0000"><?php echo $rows['img'];?></span></a> </label>
											
                                            <input class="form-control" id="validationTooltip01" type="file"   name="document" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
                                    </div>
                                    <button class="btn btn-primary" type="submit" id="submit" name="submit">Submit </button>
                                </form>
								</div>
                           
                   
					
					
					
					 </div>
                       
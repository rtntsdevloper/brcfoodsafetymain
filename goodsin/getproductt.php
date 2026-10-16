 <?php 
 include '../connection.php';
 $sno=$_GET['q'];
 $sql=mysqli_query($con,"select * from tblrawmaterial where id='$sno'");
 $row=mysqli_fetch_array($sql);
 
 $sq11=mysqli_query($con,"select * from tblspecdetail where product='$sno'");
				$row1=mysqli_fetch_array($sq11);
 
 
 ?>
<input type="hidden" name="prodname" id="prodname" value="<?php echo $row['pname'];?>" />
<input type="hidden" name="temp" id="temp" value="<?php echo $row['temp'];?>" />

<input type="hidden" name="uom1" id="uom1" value="<?php echo $row['shelflife'];?>" />

<input type="hidden" name="uom2" id="uom2" value="<?php echo $row['shelflife1'];?>" />

<input type="hidden" name="uomm" id="uomm" value="<?php echo $row['uom'];?>" />

<input type="hidden" name="killdate1" id="killdate1" value="<?php echo $row['killdate'];?>" />



<div class="col-3">
   <label for="x_card_code" class="control-label mb-1">Select Location</label>
   <div class="input-group">
<select class="form-control" id="chiller">
												   <option value="<?php echo $row['chiller'];?>"><?php echo $row['chiller'];?> </option>
												  </select></div></div>


					
													
													<?php
													if($row['chiller']=="Ambient")
													{
													?>
										<input name="postcode" type="hidden" class="form-control"   id="killdate" value="N/A">
													<?php
													}
													else
													{
													?>
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1">Product Temperature</label>
                                                    <div class="input-group">
													 
                                <input  name="postcode" type="text" class="form-control"   id="killdate" max=<?php echo date('Y-m-d');?> onchange="return ck(this.value,'<?php echo $row['chiller'];?>')">
                                      <span class="input-group-text" id="basic-addon1"><sup>o</sup>C</span>                  
							</div>
                                                    </div>
													<?php
													
													}
													?>
													
													
													<?php
													if($row['shelflife']=="N/A")
													{
													?>
													 <input  name="postcode" type="hidden" class="form-control"  id="useby"  value="N/A" >
													  <input  type="hidden" class="form-control"  id="stype"  value="" >
													 <?php
													}
													else
													{
													?>
													
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1">Use By/Best Before</label>
                                                    <div class="input-group">
													 <select id="stype" class="form-control">
													 <option value="">Please Select</option>
													 <option value="UB">UB</option>
													 <option value="BB">BB</option>
													  <option value="N/A">N/A</option>
													 </select>
                                                    </div>
                                                    </div>
													
													
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1" id="perror1">Select date</label>
                                                    <div class="input-group">
								<input  name="postcode" type="date" class="form-control"  id="useby" min=<?php echo date('Y-m-d');?>  onchange="return prod2(this.value);" >
                                                    
													</div>
                                                    </div>
													
													<?php
													}
													?>
													
													
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1" id="perror1">View Specification</label>
                                                    <div class="input-group">
							<a href="http://conceptp.rtnts.com/TCP/specdetail/<?php echo $row1['spec'];?>" target="_blank"><button type="button" class="btn btn-primary" > View </button></a>
                                                        </div>
                                                    </div>
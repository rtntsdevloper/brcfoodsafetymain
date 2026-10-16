 <?php 
 include 'connection.php';
 $sno=$_GET['q'];
   $sno1=$_GET['str1'];
 $sql=mysqli_query($con,"select * from tblrawmaterial where id='$sno'");
 $row=mysqli_fetch_array($sql);
 
  $sql3=mysqli_query($con,"select * from tblrawsupplier where supid='$sno1'");
 $row3=mysqli_fetch_array($sql3);



 ?>
 <input type="hidden" name="supname" id="supname" value="<?php echo $row3['supname'];?>" />

<input type="hidden" name="prodname" id="prodname" value="<?php echo $row['pname'];?>" />
<input type="hidden" name="temp" id="temp" value="<?php echo $row['temp'];?>" />

<input type="hidden" name="uom1" id="uom1" value="<?php echo $row['shelflife'];?>" />

<input type="hidden" name="uom2" id="uom2" value="<?php echo $row['shelflife1'];?>" />

<input type="hidden" name="uomm" id="uomm" value="<?php echo $row['uom'];?>" />

<input type="hidden" name="killdate1" id="killdate1" value="<?php echo $row['killdate'];?>" />



<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1">Select Chiller/Freezer</label>
                                                    <div class="input-group">
													 
<select class="form-control" id="chiller">
													 
													   <option value="<?php echo $row['chiller'];?>"><?php echo $row['chiller'];?> </option>
													  
													   </select></div></div>


<?php
													if($row['temp']=="N/A")
													{
													?>
													 <input  name="postcode" type="hidden" class="form-control"  id="ptemp" placeholder="&deg;C"  value="N/A" >
													<?php
													}
													else
													{
													?>
													
													
                                                  <div class="col-3" >
                                                    <label for="x_card_code" class="control-label mb-1" id="perror">Product Temperature</label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="number" class="form-control"  id="ptemp" placeholder="&deg;C"  onchange="return prod1();" >

                                                        </div>
                                                    </div>
													<?php
													}
													?>
													
													
													<?php
													if($row['killdate']=="No")
													{?>
													
													 <input  name="postcode" type="hidden" class="form-control"   id="killdate" value="0000-00-00">
													<?php
													
													}
													else
													{
													?>
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1">Kill Date</label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="date" class="form-control"   id="killdate" max=<?php echo date('Y-m-d');?>>
                                                        </div>
                                                    </div>
													<?php
													}
													?>
													
													
													<?php
													if($row['shelflife']=="N/A")
													{
													?>
													 <input  name="postcode" type="hidden" class="form-control"  id="useby"  value="0000-00-00" >
													  <input  type="hidden" class="form-control"  id="stype"  value="" >
													 <?php
													}
													else
													{
													?>
													
													
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1">Use By/ Best Before</label>
                                                    <div class="input-group">
													 
                                                     <select id="stype" class="form-control">
													 <option value="">Please Select</option>
													 <option value="UB">UB</option>
													 <option value="BB">BB</option>
													 </select>
                                                        </div>
                                                    </div>
													
													
													<div class="col-3">
                                                    <label for="x_card_code" class="control-label mb-1" id="perror1">Shelflife </label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="date" class="form-control"  id="useby" min=<?php echo date('Y-m-d');?>  onchange="return prod2(this.value);" >
                                                        </div>
                                                    </div>
													
													
													<?php
													}
													?>
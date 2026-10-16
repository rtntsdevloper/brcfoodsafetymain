<?php
include 'connection.php';
  $str=$_GET['q'];
 $sno=$_GET['sno'];
?>
<strong class="card-title"> * Recipe</strong>  
		
		<br/><br/>
 <div class="row" id="row2">
			<?php

					$sql=mysqli_query ($con,"select * from tblrecipe where id='$sno'");
					$rows=mysqli_fetch_array($sql);
				
			 ?>
		
		<input type="hidden" class="form-control" name="sno"  value="<?php echo $sno;?>"/>
		<input type="hidden" class="form-control" name="qt"  value="<?php echo $str;?>"/>
											   
												<div class="col-12">
											
                                                 <input type="text" class="form-control" name="qtys" id="qtys"  value="<?php echo $str;?> Kg" disabled="disabled"/>
                                                </div>
												
						
						 
												</div>
												 <div class="row" style="margin-top:10px" >
												<div class="col-12"></div>
						<?php
						$sql1=mysqli_query ($con,"select * from tblrecipe1 where tid='$sno'");
						$i=0;
						while($rows1=mysqli_fetch_array($sql1))
						{
					
						
						  $totqty=$str*1000;
						$total=$rows1['qty'];
						 $total1=round($total*$totqty,3);
						
						if($rows1['qty1']=="1")
						{
						$total1=$str;
						$qtyr="Kg";
						}
						else
						{
						if($total1>=1000)
						{
						 $total1=round($total1/1000,3);
						$qtyr="Kg";
						}
						else
						{
						$qtyr="G";
						}
						}
						
						
						?>
						<input type="hidden" name="ans[]" value="<?php echo $rows1['name'];?>" />
						<input type="hidden" class="form-control"  name="totalqty[]" value="<?php echo $total1;?>" />
						<input type="hidden" class="form-control"  name="qtyr[]" value="<?php echo $qtyr;?>" />
						<input type="hidden" class="form-control"  name="ingredient1[]" value="<?php echo $rows1['name'];?>" />
                     
													
						<div class="col-3">
						  <label for="cc-exp" class="control-label mb-1">Ingredient</label>
								<input type="text" class="form-control"  value="<?php echo $rows1['name'];?>: <?php echo $total1;?> <?php echo $qtyr;?>	" disabled="disabled" />	
						 </div>
						
						<div class="col-3">
                       <label for="cc-exp" class="control-label mb-1">UB/BB</label>
					   		<select class="form-control" name="ub<?php echo $i;?>" required>
							<option value="">UB/BB</option>
							<option value="UB">UB</option>
							<option value="BB">BB</option>
							</select>	
						 </div>
						
						<div class="col-3">
                          <label for="cc-exp" class="control-label mb-1">Select Date</label>
							<input type="date" class="form-control"  name="day<?php echo $i;?>" min="<?php echo date("Y-m-d");?>" required />
						 </div>
						
						
						<div class="col-3">
                       <label for="x_card_code" class="control-label mb-1" id="qused<?php echo $i;?>"> Quantity Used </label>
					   <input type="hidden" value="<?php echo $total1;?>" name="checkqty<?php echo $i;?>"  id="checkqty<?php echo $i;?>" />
								<input type="number" class="form-control"  id="qtyy<?php echo $i;?>" name="qtyy<?php echo $i;?>" step="any" required 
								onchange="return checkqtyy(this.value,<?php echo $i;?>)" />
						 </div>
						
						
						
							<?php
												$i++;
													}
													?>
													</div>
													<br/>
													 <strong class="card-title"> * Detail</strong>  
													 
													<div class="row" style="margin-top:10px" >
												
												
												<div class="col-6">
                       <label for="x_card_code" class="control-label mb-1" id="tempchk">Enter Start Time </label> 
								<input type="time" class="form-control"  id="stime" name="stime" required  />
						</div>	
						
						<div class="col-6">
                       <label for="x_card_code" class="control-label mb-1" id="tempchk">Enter End Time </label> 
								<input type="time" class="form-control"  id="etime" name="etime" required  />
						</div>	
						
														 
														  
												<div class="col-4">
                       <label for="x_card_code" class="control-label mb-1" id="tempchk">Enter Temperature </label> 
								<input type="text" class="form-control"  id="temp" name="temp" required  onchange="return tempcheck(this.value)" placeholder="Temperature &deg;C"/>
						</div>	
                                            
											
											<div class="col-4">
                       <label for="x_card_code" class="control-label mb-1"> Tray Batchcode </label>
								<input type="text" class="form-control" name="tray"  required placeholder="Tray Batchcode" />
						 </div>
						
						<div class="col-4">Top Film Batchcode
                       <label for="x_card_code" class="control-label mb-1"></label>
						<input type="text" class="form-control"  name="wrap"  required placeholder="Top Film Batchcode" />
						 </div>
						</div>
						
						 <strong class="card-title"> * Checks</strong> 	
						<div class="row" style="margin-top:10px" >
						<?php
						$sql=mysqli_query($con,"select * from tblques1");
						$j=0;
						while($rowss=mysqli_fetch_array($sql))
						{
						
						?>
										   
											  
											 
											   		 
														  <div class="col-6">
                                                        <label for="cc-exp" class="control-label mb-1"> <?php echo $rowss['ques'];?></label>
                                                </div>
												
                                                <div class="col-2">
                                                    <label for="x_card_code" class="control-label mb-1">
													 <input type="hidden"  id="t1<?php echo $j;?>" value="<?php echo $rowss['ansa'];?>" />
													<select class="form-control" name="anss[]" id="s1<?php echo $j;?>" required  onchange="return changetextbox(<?php echo $j;?>)" >
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													</select>
													</label>
                                                  
                                                    </div>
													
								  <div class="col-4">
                                 <label for="x_card_code" class="control-label mb-1">
								 <textarea class="form-control" name="cmnt[]" id="s2<?php echo $j;?>" required disabled="disabled" placeholder="Enter Comment" ></textarea>
								 
								 
								 </label>
                                                    
                                                    </div>
												<?php
												$j++;
												}
?>		<div class="input-group">
										     <button class="btn btn-info" type="submit" name="submit" >Submit</button>
                                                   </div>
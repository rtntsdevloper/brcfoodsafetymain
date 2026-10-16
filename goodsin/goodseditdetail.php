<?php
$gid=$_GET['gid'];
$sno=$_GET['sno'];
	$sql3=mysqli_query($con,"select * from tblgrn1 where id='$gid'");
	$row3=mysqli_fetch_array($sql3);
						
						
						$sql2=mysqli_query($con,"select * from tblrawmaterial where id='$row3[product]'");
            $row2=mysqli_fetch_array($sql2);					
?>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods In Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
				<a href="admin.php?id=goodsdetail&sno=<?php echo $sno;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GRN NO : <?php echo $row3['grncode'];?></strong></h4>
                           
								 <div class="row">
                                    
									<form  name="form1" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">					
               
                      
                                                    <div class="col-6">
                                                    <label for="cc-exp" class="control-label mb-1">Select Product</label> 
                                                       
														 <div class="input-group">
														
                                            <select class="form-control" name="product"  >
													
														 <?php
											$sql3=mysqli_query($con,"select * from tblrawmaterial where id='$row3[product]'");
											while($rows3=mysqli_fetch_array($sql3))
											{
											?>
											<option value="<?php echo $rows3['id'];?>"> <?php echo $rows3['pname'];?></option>
											
											<?php
											}
											
											?>
														</select>
                                                    </div>
                                                    </div>
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Total Boxes</label>
                                                    <div class="input-group">
													 
                                                        <input  name="box" type="number" class="form-control" value="<?php echo $row3['box'];?>">
                                                        </div>
                                                    </div>
													
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Quantity</label>
                                                    <div class="input-group">
													 
                                                        <input  name="qty" type="number" class="form-control"   id="qty" value="<?php echo $row3['qty'];?>">
                                                        </div>
                                                    </div>
													
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Batch Code</label>
                                                    <div class="input-group">
													 
                                                        <input  name="batchcode" type="text" class="form-control"  id="batchcode" value="<?php echo $row3['batchcode'];?>" >
                                                        </div>
                                                    </div>
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Select Chiller/Freezer</label>
                                                    <div class="input-group">
													 
<select class="form-control" id="chiller" name="chiller">
													 
													   <option value="<?php echo $row3['chiller'];?>"><?php echo $row3['chiller'];?> </option>
													  
													   </select></div></div>


					
													
													<?php
													if($row2['killdate']=="No")
													{
													?>
													
													 <input  name="killdate" type="hidden" class="form-control"   id="killdate" value="N/A">
													<?php
													
													}
													else
													{
													?>
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Kill Date</label>
                                                    <div class="input-group">
													 
                                                        <input  name="killdate" type="date" class="form-control"   id="killdate" max=<?php echo date('Y-m-d');?> value="<?php echo $row3['killdate'];?>">
                                                        </div>
                                                    </div>
													<?php
													}
													?>
													
													
													<?php
													if($row2['shelflife']=="N/A")
													{
													?>
													
													  <input  type="hidden" class="form-control"  id="stype"  value=""  name="stype">
													 <?php
													}
													else
													{
													?>
													
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1">Use By/ Best Before</label>
                                                    <div class="input-group">
													 
                                                     <select id="stype" class="form-control" name="stype">
													 <option value="<?php echo $row3['uomm'];?>"><?php echo $row3['uomm'];?></option>
													 <option value="UB">UB</option>
													 <option value="BB">BB</option>
													 </select>
                                                        </div>
                                                    </div>
													
													
													<div class="col-md-6">
                                                    <label for="x_card_code" class="control-label mb-1" id="perror1">Shelflife date</label>
                                                    <div class="input-group">
													 
                                                        <input  name="useby" type="date" class="form-control"  id="useby" min=<?php echo date('Y-m-d');?> value="<?php echo $row3['useby'];?>"   >
                                                        </div>
                                                    </div>
													<?php
													}
													?></div><br/>
 <div class="form-row">			
<div class="col-md-6">
<div class="input-group">
<input  type="submit" name="submit" class="btn btn-primary" ></div></div>							
								</form></div></div></div></div></div></div>
								
								<?php
								if(isset($_POST['submit']))
								{
								$gid=$_GET['gid'];
								$sno=$_GET['sno'];
								
								$product=$_POST['product'];
								$qty=$_POST['qty'];
								$batchcode=$_POST['batchcode'];
								$chiller=$_POST['chiller'];
								$killdate=$_POST['killdate'];
								$stype=$_POST['stype'];
								$useby=$_POST['useby'];
								$box=$_POST['box'];
								
								
								$hj=mysqli_query($con,"update tblgrn1 set qty='$qty', batchcode='$batchcode', chiller='$chiller', killdate='$killdate', uomm='$stype', useby='$useby',box='$box' where id='$gid' ")
								
								
								?>
								<script language="javascript">
								window.open('admin.php?id=goodsdetail&sno=<?php echo $sno;?>','_self')
								</script>
								
								<?php
								}
								?>
								
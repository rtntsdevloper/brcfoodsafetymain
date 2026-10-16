<?php
$sno1=$_GET['sno1'];
$sno=$_GET['sno'];
	$sql3=mysqli_query($con,"select * from tblgdn1 where id='$sno1'");
	$row3=mysqli_fetch_array($sql3);
						
					$sql4=mysqli_query($con,"select * from tblgoodsoutproduct where id='$row3[product]'");
                    $row4=mysqli_fetch_array($sql4);
	
 
  $sql1=mysqli_query($con,"select * from tblbrand where id='$row3[brandname]'");
  $row1=mysqli_fetch_array($sql1);
  
  
  				
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
				<a href="admin.php?id=goodsoutdetail&sno=<?php echo $sno;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							 <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GDN NO : <?php echo $row3['gdn'];?></strong></h4>
                            	 <div class="row">
                                    
									<form  name="form1" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">					
               
                      
                                                    <div class="col-6">
                                                    <label for="cc-exp" class="control-label mb-1">Product</label> 
                                                       
														 <div class="input-group">
														
                                            <select class="form-control" name="product"  >
											<option value="<?php echo $row4['id'];?>"> <?php echo $row4['prodname'];?></option>
											<?php
											 $sql=mysqli_query($con,"select * from tblgoodsoutproduct where cid='$row3[brandname]'");
                                             while($row=mysqli_fetch_array($sql))
											 {
											 ?>
											 <option value="<?php echo $row['id'];?>"> <?php echo $row['prodname'];?></option>
											 <?php
											 }
											 ?>

											
													</select>
                                                    </div>
                                                    </div>
													
													
													
													<div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Quantity</label>
                                                    <div class="input-group">
													 
                                                        <input  name="qty" type="number" class="form-control"   id="qty" value="<?php echo $row3['qty'];?>">
                                                        </div>
                                                    </div>
													
													<div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Batchcode</label>
                                                    <div class="input-group">
													 
                                                        <input  name="batchcode" type="text" class="form-control"   id="batchcode" value="<?php echo $row3['batchcode'];?>">
                                                        </div>
                                                    </div>
													
													<div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Best Before</label>
                                                    <div class="input-group">
													 
                                                        <input  name="bb" type="date" class="form-control"   id="bb" value="<?php echo $row3['useby'];?>">
                                                        </div>
                                                    </div>
													</div></br>
 <div class="form-row">			
<div class="col-md-6">
<div class="input-group">
<input  type="submit" name="submit" class="btn btn-primary" ></div></div>							
								</form></div></div></div></div></div></div>
								
								<?php
								if(isset($_POST['submit']))
								{
								$sno1=$_GET['sno1'];
								$sno=$_GET['sno'];
								$qty=$_POST['qty'];
								$batchcode=$_POST['batchcode'];
								$useby=$_POST['bb'];
								
								$product=$_POST['product'];
								
								$hj=mysqli_query($con,"update tblgdn1 set qty='$qty', batchcode='$batchcode', useby='$useby',product='$product' where id='$sno1' ")
								
								
								?>
								<script language="javascript">
								window.open('admin.php?id=goodsoutdetail&sno=<?php echo $sno;?>','_self')
								</script>
								
								<?php
								}
								?>
								
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods In Management</a></li>
                        <li>Goods In</li>
                    </ul>
                </div>
				
				<script>
function getsupplier(str)
{

if (str=="")
  {
  document.getElementById("product").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("product").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getproducts.php?q="+str,true);
xmlhttp.send();  
  }
</script>
								<script>
			  function cal()
			  {
			   if(document.getElementById("po").value=="")
			  {
			  document.getElementById("supperror2").innerHTML="* Please  enter  PO number";
	          document.getElementById("po").focus();
			  }
			  else if(document.getElementById("img").value=="")
			  {
			  document.getElementById("supperror3").innerHTML="* Please  upload invoice";
	          document.getElementById("img").focus();
			  }
			  else
			  {
			  
			  document.getElementById("po").disabled = true;
			  document.getElementById("div1").style.display = "block";
              document.getElementById("div1").focus();
			  }		
			  }

			  </script>
			  
			  <?php
			  
									$sno=$_GET['sno'];
									
									$cid=$_GET['cid'];
									
									?>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=addnewgoods3&sno=<?php echo $sno;?>&cid=<?php echo $cid;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Goods In</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="addnewgoods5" enctype="multipart/form-data">
								
                                    <div class="form-row">
									 <div class="col-md-1 mb-3">
                                            <label for="validationTooltip01" style="color:#0000FF">Sno</label>
                                     
                                        </div>
										
									 <div class="col-md-2 mb-3">
                                            <label for="validationTooltip01" style="color:#0000FF">Date</label>
                                     
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationTooltip02" style="color:#0000FF" >Product Code</label>
                                         
                                         
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationTooltip02" style="color:#0000FF" >Product</label>
                                        
                                        </div>
                                   
                                   
                                        <div class="col-md-1 mb-3">
                                            <label for="validationTooltip03" style="color:#0000FF" >Quantity</label>
                                         
                                        </div>
										 <div class="col-md-2 mb-3">
                                            <label for="validationTooltip03" style="color:#0000FF" >Received</label>
                                      
                                        </div>
										 <div class="col-md-2 mb-3">
                                            <label for="validationTooltip03" style="color:#0000FF">Comment </label>
                                            
                                        </div>
										
									<?php
								
									$sql=mysqli_query($con,"select * from tblticcosupplier where img='$sno' and pcode!=''");
									$j=0;
									while($row=mysqli_fetch_array($sql))
									{
									?>
									  <input type="hidden" name="cid" value="<?php echo $cid;?>" />
								      <input type="hidden" name="item[]" value="<?php echo $row['id'];?>" />
									  <input type="hidden" name="sno" value="<?php echo $sno;?>" />
									
									  <input type="hidden" name="suppcode" value="<?php echo $row['suppcode'];?>" />
									
									 <div class="col-md-1 mb-3">
                                            <label for="validationTooltip01" style="color:#CC0000">Item: <?php echo $j+1;?></label>
                                         
                                           
                                        </div>
										
										
										
                                        <div class="col-md-2 mb-3">
                                            <label for="validationTooltip01"><?php echo $row['orderdate'];?></label>
                                         
                                           
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationTooltip02"><?php echo $row['pcode'];?></label>
                                         
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationTooltip02"><?php echo $row['product'];?></label>
                                          
                                        </div>
                                   
                                   
                                        <div class="col-md-1 mb-3">
                                            <label for="validationTooltip03"><?php echo $row['qty'];?> </label>
                                      
                                        </div>
										 <div class="col-md-2 mb-3">
                                         
                                            <input type="radio" name="r1<?php echo $j;?>" value="yes" /> Yes 
											  <input type="radio" name="r1<?php echo $j;?>" value="no" /> No 
                                           
                                        </div>
										 <div class="col-md-2 mb-3">
                                         
                                            <input type="text"  name="cmnt<?php echo $j;?>" class="form-control" placeholder="Comment if any" >
                                          
                                        </div>
                                       <?php
											$j++;
										     }
										    ?>
									   
						
										
                                   </div>
									 <div class="form-row">
									 <div class="col-md-6">
                                            <label for="validationTooltip01" style="color:#0000FF">Are there more products on this vehicle?  Yes / No</label>
                                     <select class="form-control" name="status" required>
									 <option value="">Please Select</option>
									 <option value="Yes">Yes</option>
									 <option value="No">No</option>
									 </select>
									  <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div></div>
									
									<br/>
									
                                    <button class="btn btn-primary" type="submit" name="submit">Submit & Next </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



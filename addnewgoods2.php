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
			  
			  
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=goodsin"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Goods In</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="addnewgoods6" enctype="multipart/form-data">
                                    <div class="form-row">
									
									 <div class="col-md-3 mb-3">
                                            <label for="validationTooltip02">Vehicle Registration No</label>
                                           <input type="text"   name="truck" class="form-control"  id="truck" required  placeholder="if any"  />
                                            <div class="invalid-tooltip">
                                               Please fill the field

                                            </div>
                                        </div>
										
										<div class="col-md-3 mb-3">
                                            <label for="validationTooltip02">Vehicle Temperature</label>
                                            <input type="text"   name="vtemp" class="form-control"  id="vtemp"  required placeholder="if any"  />
                                            <div class="invalid-tooltip">
                                              Please fill the field.

                                            </div>
                                        </div>
										
                                        <div class="col-md-3 mb-3">
                                            <label for="validationTooltip01"> Product Temperature: </label>
                                          <input type="text"   name="ptemp" class="form-control"  id="ptemp" required placeholder="if any"  />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
                                        
                                       
                                   
                                   
                                        <div class="col-md-3 mb-3">
                                            <label for="validationTooltip03">Any Document</label>
                                            <input class="form-control" id="validationTooltip04" type="file"   name="img" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
                                       
									   
						<?php
						$sql=mysqli_query($con,"select * from tblques2");
						$i=0;
						while($rows=mysqli_fetch_array($sql))
						{
						
						?>
		<script language="javascript">
		function changetextbox(y)
        {
      var sum=y+1;
      var s2 = document.getElementById('s1'+y).value;
	  var cmnt = document.getElementById('s2'+y).value;
	  var tid = document.getElementById('t1'+y).value;
	 
      var phpvalue=<?php echo $i;?>;
 
	if(s2==tid)
	{
	//document.getElementById("s1"+sum).disabled = false;
	//document.getElementById("ans").value = "accept";

	document.getElementById("s2"+y).disabled = true;
	
	return false;
	
	}
	
	
	else if(s2!=tid)
	{
	for(var n=y;n<=phpvalue;n++)
	{
	//document.getElementById("s1"+n).disabled = true;
	//document.getElementById("s1"+n).value = "";
	document.getElementById("s2"+y).disabled = false;
	//document.getElementById("ans").value = "reject";
	}
	return false;
	}
	else
	{
	//document.getElementById("save").style.display = "block"; 
	return true;
	
	}
	
	}
					  </script>
					  
										<div class="col-md-4 mb-3">
                                            <label for="validationTooltip05"></label>
                                            <input type="text"  class="form-control"  value="<?php echo $rows['ques'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                               Please fill the field

                                            </div>
                                        </div>
										
										
										<div class="col-md-4 mb-3">
                                            <label for="validationTooltip05"></label>
                                           <input type="hidden"  id="t1<?php echo $i;?>" value="<?php echo $rows['ansa'];?>" />
											
													<select class="form-control" name="ans[]" id="s1<?php echo $i;?>" required   onchange="return changetextbox(<?php echo $i;?>)" >
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field

                                            </div>
                                        </div>
										
										
										<div class="col-md-4 mb-3">
                                            <label for="validationTooltip05"></label>
                                            <textarea class="form-control" name="cmntt[]" id="s2<?php echo $i;?>" placeholder="Comment" disabled="disabled"  required  ></textarea>
                                            <div class="invalid-tooltip">
                                               Please fill the field

                                            </div>
                                        </div>
										
										<?php
										$i++;
													}
										?>
										
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="submit">Submit & Next </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



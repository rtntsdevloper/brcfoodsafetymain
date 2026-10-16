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
						
							
                                <div class="card-title">Goods In</div>
								
                              
                                   
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
                                    
						
										
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="submit">Submit & Next </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



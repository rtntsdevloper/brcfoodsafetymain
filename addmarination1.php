
  <?php
  $sno=$_GET['sno'];
					$sqlt=mysqli_query($con,"select * from tblrecipe where id='$sno'");
					$rowt=mysqli_fetch_array($sqlt);
					?>

<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Home / Production - (Add New) </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
		
		<div  class="col-xl-12" style="margin-bottom:20px">
	
		<a href="admin.php?id=addmarination"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>
		
	</div>
		

<script >
											function tempcheck(str)
											{
											
											if(str>8)
											{
											document.getElementById("tempchk").innerHTML="* Temperature is greater than critical limit";
											 document.getElementById("tempchk").style.color = 'red';
	          document.getElementById("temp").focus();
			  document.getElementById("temp").value="";
											}
											}
											</script>	
											
											
	<script >
											function checkqtyy(str,str1)
											{
											
											var qt= document.getElementById('checkqty'+str1).value;
											var qt1= document.getElementById('qtyy'+str1).value;
											
											
											if (parseFloat(parseFloat(qt1).toFixed(2)) > parseFloat(parseFloat(qt).toFixed(2)))
											{
											
											document.getElementById('qused'+str1).innerHTML="* Enter correct qty of ingredient";
											 document.getElementById('qused'+str1).style.color = 'red';
	          document.getElementById("qused"+str1).focus();
			  document.getElementById("qtyy"+str1).value="";
											}
											else if (parseFloat(parseFloat(qt1).toFixed(2)) < parseFloat(parseFloat(qt).toFixed(2)))
											{
											
											document.getElementById('qused'+str1).innerHTML="* Enter correct qty of ingredient";
											 document.getElementById('qused'+str1).style.color = 'red';
	          document.getElementById("qused"+str1).focus();
			  document.getElementById("qtyy"+str1).value="";
											}
											}
											</script>	
										
											
	<script language="javascript">
		function changetextbox(y)
        {
    
	//document.getElementById("save").style.display = "block"; 
	//document.getElementById("reject").style.display = "none"; 
										
       var sum=y+1;
      var s2 = document.getElementById('s1'+y).value;
	  //var cmnt = document.getElementById('s2'+y).value;
	  var tid = document.getElementById('t1'+y).value;
	 
      var phpvalue=y;
 
	if(s2==tid)
	{
	document.getElementById("s2"+y).disabled = true;
	return false;
	}
	else if(s2!=tid)
	{
	for(var n=y;n<=phpvalue;n++)
	{
	document.getElementById("s2"+y).disabled = false;
	}
	return false;
	}
	else
	{
	return true;
	}
	}
					  </script>		

<div class="col-sm-12">
                <div class="card">
                 
                    <div class="card-body">
                        <h4 style="color:#3399FF">Product: <?php echo $rowt['name'];?></h4>
                       
					    <?php
		  if(isset($_GET['msg']))
		  {
		?>
		 <div style="color:#FF0000; text-align:center; font-size:18px"> Supplier Already Exist! </div><br/>
		 <?php
		  }
		  ?>
		  <script>
			  function cal()
			  {
			  if(document.getElementById("qty").value=="")
			  {
			  document.getElementById("supperror").innerHTML="* Please  enter quantity";
	          document.getElementById("qty").focus();
			  }
			  else
			  {
			  //document.getElementById("supp").disabled = true;
			  document.getElementById("qty").disabled = true;
			  document.getElementById("div1").style.display = "block";
              document.getElementById("div1").focus();
			  }		
			  
			  
			  }

			  </script>
			  
			  
			
		  
		  <form  name="form1" method="post" action="addmarination2" enctype="multipart/form-data" onsubmit="return cal()">
                    <div class="row">	
					
					
					
					
					
									
                    <div class="col-md-12">
					
				
                         
													<div class="col-6">
                                                        <label for="cc-exp" class="control-label mb-1"> Enter quantity of "PRODUCT" you want to produce in KG</label>
														 <div class="input-group">
														
		   
		   <script>
function reloadPrice()
{
var str=document.getElementById("qty").value;
 document.getElementById("qty").disabled = true;
			  document.getElementById("div1").style.display = "block";
              document.getElementById("div1").focus();

if (str=="")
  {
  document.getElementById("div1").innerHTML="";
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
    document.getElementById("div1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","addmarination3.php?q="+str+"&sno="+<?php echo $sno;?>,true);
xmlhttp.send();  
  }
</script>	
 <input type="number"  name="qty" class="form-control"  id="qty"  placeholder="Enter in kg" />
                                                    </div>
                                                    </div>
													
			<div class="col-6">
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														 
                                                       <button class="btn btn-info" type="button" onclick="return reloadPrice()">Save & Next</button>
                                                    </div>
                                                    </div>
													<br/>
		  
		  <div id="div1" style="display:none">
												   
												   </div></div></form>
											   </div></div></div>
											   
											   
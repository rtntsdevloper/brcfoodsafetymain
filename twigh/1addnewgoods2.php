<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods In Management</a></li>
                        <li>Goods In</li>
                    </ul>
                </div>
				
				<script >
				function ck(str,str1)
{

var qt="-0.1";
var qt1= "8";

var qt2= "18";


if (str1=="Chilled" && parseFloat(parseFloat(str).toFixed(2)) > parseFloat(parseFloat(qt1).toFixed(2)))
	{
	alert="Product temperature is beyond the defined limit. DO NOT accept this product, Complete a non-conformance form and carry out investigation.";
		}
		else if (str1=="Chilled" && parseFloat(parseFloat(str).toFixed(2)) < parseFloat(parseFloat(qt).toFixed(2)))
		{
		alert="Product temperature is beyond the defined limit. DO NOT accept this product, Complete a non-conformance form and carry out investigation.";
											}
												else if (str1=="Frozen" && parseFloat(parseFloat(str).toFixed(2)) < parseFloat(parseFloat(qt2).toFixed(2)))
		{
		alert="Product temperature is beyond the defined limit. DO NOT accept this product, Complete a non-conformance form and carry out investigation.";
											}
}
				
				</script>
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
xmlhttp.open("GET","goodsin/getproducts.php?q="+str,true);
xmlhttp.send();  
  }
</script>	
			  
			  
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=goods"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                               
                       
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
			  if(document.getElementById("date").value=="")
			  {
			  document.getElementById("supperror").innerHTML="* Please  select date";
	          document.getElementById("date").focus();
			  }
			  
			 else if(document.getElementById("supp").value=="")
			  {
			  document.getElementById("supperror").innerHTML="* Please  select supplier";
	          document.getElementById("supp").focus();
			  }
			  else if(document.getElementById("po").value=="")
			  {
			  document.getElementById("supperror").innerHTML="* Please  enter  GDN number";
	          document.getElementById("po").focus();
			  }
			  else
			  {
			  document.getElementById("supp").disabled = true;
			  document.getElementById("po").disabled = true;
			  document.getElementById("div1").style.display = "block";
              document.getElementById("div1").focus();
			  }		
			  
			  
			  }

			  </script>
		  
		  <form  name="form1" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">					
                    <div class="col-md-12">
                           <strong class="card-title"> * Select Supplier</strong>
						   
						   <div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1">Select Date</label>
														 <div class="input-group">
														  
                                                        <input type="date"  name="date" class="form-control"  id="date" />
                                                    </div>
                                                    </div>
						   
                            <div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1" id="supperror" style="color:#FF0000"></label>
														 <div class="input-group">
														
                                                        <select class="form-control" name="supp" id="supp" onchange="getsupplier(this.value)" >
														<option value="">Please Select</option>
														<?php 
														$sql=mysqli_query($con,"select * from tblrawsupplier order by supname ASC ");
														while($row=mysqli_fetch_array($sql))
														{
														?>
														
														<option value="<?php echo $row['supid'];?>"><?php echo $row['supname'];?></option>
														<?php
														}
														?>
														</select>
                                                    </div>
                                                    </div>
													
													
													<div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1">Enter Invoice No</label>
														 <div class="input-group">
														  
                                                        <input type="text"  name="po" class="form-control"  id="po" />
                                                    </div>
                                                    </div>
													
													
													
													<div class="col-6">
                                                    
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														 
                                                       <button class="btn btn-info" type="button" onclick="return cal();">Save & Next</button>
                                                    </div>
                                                    </div>
												
													<br/>
		  
		  <div id="div1" style="display:none">
		 <strong class="card-title"> * Vehicle Checks</strong>  
		
		<br/><br/>
                        <div class="form-row" id="row2">
					
						<?php
						$sql=mysqli_query($con,"select * from tblques2");
						$i=0;
						while($rows=mysqli_fetch_array($sql))
						{
						
						?>
		<script language="javascript">
		function changetextbox(y)
        {
    
	document.getElementById("save").style.display = "block"; 
	document.getElementById("reject").style.display = "none"; 
										
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
											    <div  class="col-md-6">
                                                        <label for="cc-exp" class="control-label mb-1"> <?php echo $rows['ques'];?></label>
                                                </div>
												
                                                <div  class="col-md-2">
                                                    <label for="x_card_code" class="control-label mb-1">
													
											         <input type="hidden"  id="t1<?php echo $i;?>" value="<?php echo $rows['ansa'];?>" />
													<select class="form-control" name="ans[]" id="s1<?php echo $i;?>" required   onchange="return changetextbox(<?php echo $i;?>)" >
													<option value="">Please Select</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													</select>
													
													
													</label>
                                                  
                                                    </div>
													
													<div  class="col-md-4">
                                 <label for="x_card_code" class="control-label mb-1">
								 <textarea class="form-control" name="cmnt[]" id="s2<?php echo $i;?>" disabled="disabled"  required ></textarea>
								 
								 
								 </label>
                                                    
                                                    </div>
													<?php
												$i++;
													}
													?>
													
                                               </div>
											   
											   <script>
											   function cal1()
											   {
											   var phpvalue1=<?php echo $i;?>;
										  // var y=t3;
                                               // var boxes = document.getElementById('s1'+y).value;
												// var tid = document.getElementById('t1'+y).value;
//alert(document.getElementById('s10').value);
										
										 if(document.getElementById('s10').value!="Yes" || document.getElementById('s11').value!="No" || document.getElementById('s12').value!="No" || document.getElementById('s13').value!="No" )
										{
										//alert("d");
										document.getElementById("reject").style.display = "block"; 
										document.getElementById("save").style.display = "none"; 
										document.getElementById("div2").style.display = "none";
										document.getElementById("supp").disabled = false;
										document.getElementById("po").disabled = false;
										return false;
										}
										else
										{
										//alert("e");
										document.getElementById("save").style.display = "block"; 
										document.getElementById("reject").style.display = "none"; 
										document.getElementById("div2").style.display = "block";
										}
										
											   
											   }
											   </script>
											   
											 
											   	<div class="col-6">
                                                <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
										     <button class="btn btn-info"  id="save" onclick="return cal1()" type="button" >Save & Next</button>
											 <button class="btn btn-danger"  id="reject"  type="submit" name="submit2"  style="display:none" >Reject</button>
                                                    </div>
                                                    </div>
											   </div> 
											   <br/>
											   
											   <?php
											   if(isset($_POST['submit2']))
											   {
											   $supp=$_POST['supp'];
											   $po=$_POST['po'];
											   
 $ansc=count($_POST['ans']);
 
 $tp="";
 $tp1="";
for($i=0;$i< $ansc;$i++)
{
$tp.=mysqli_real_escape_string($con,$_POST["ans"][$i].";");
$tp1.=mysqli_real_escape_string($con,$_POST["cmnt"][$i].";");
}

		   
		  $hjk=mysqli_query($con,"INSERT INTO tblreject ( supp,ans,cmnt,ponumber) VALUES ( '$supp','$tp', '$tp1', '$po')");
		  ?>
		  <script language="javascript">
		  window.open('admin.php?id=11','_self');
		  </script>
		  
		  <?php
		  
		   }
	   ?>
											   
											   <div  class="form-row" id="div2" style="display:none" >
											   <div>
											     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $("#add-row").click(function()
		{
           var product = $("#product").val();
		   var prodname = $("#prodname").val();
            var chiller = $("#chiller").val();
			var totalbox = $("#totalbox").val();
			var qty = $("#qty").val();
			var batchcode = $("#batchcode").val();
			var ptemp = $("#ptemp").val();
			var vtemp = $("#vtemp").val();
			var killdate = $("#killdate").val();
			var useby = $("#useby").val();
			var stype = $("#stype").val();
			var uom1 = $("#uom1").val();
			var killdate1 = $("#killdate1").val();
			var temp = $("#temp").val();
			var uomm = $("#uomm").val();
			
			//var bb = $("#bb").val();
			
	if(product=="")
	{
	document.getElementById("error").innerHTML="* Please select the product";
	document.getElementById("product").focus();
	}
	else if(chiller=="")
	{
	document.getElementById("error").innerHTML="* Please select the chiller/freezer";
	document.getElementById("chiller").focus();
	}
	else if(totalbox=="")
	{
	document.getElementById("error").innerHTML="* Please enter total box";
	document.getElementById("totalbox").focus();
	}
	else if(qty=="")
	{
	document.getElementById("error").innerHTML="* Please enter quantity";
	document.getElementById("qty").focus();
	}
	
	else if(killdate1!="No" && killdate=="")
	{
	document.getElementById("error").innerHTML="* Please enter kill date";
	document.getElementById("killdate").focus();
	}
	
	else if(uom1!="N/A" && stype=="")
	{
	document.getElementById("error").innerHTML="* Please select useby / best before ";
	document.getElementById("stype").focus();
	}
	
	else if(uom1!="N/A" && useby=="")
	{
	document.getElementById("error").innerHTML="* Please enetr shelflife date ";
	document.getElementById("useby").focus();
	}
	
	else
	{
	     var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='hidden' name='product[]' value='"+ product +"'>"+ prodname +"</td><td><input type='hidden' name='chiller[]' value='"+ chiller +"'>"+ chiller +"</td><td><input type='hidden' name='totalbox[]' value='"+ totalbox +"'>"+ totalbox +"</td><td><input type='hidden' name='qty[]' value='"+ qty +"'>"+ qty+uomm+"</td><td><input type='hidden' name='batchcode[]' value='"+ batchcode +"'>"+ batchcode +"</td><td><input type='hidden' name='killdate[]' value='"+ killdate +"'>"+ killdate +"</td><td><input type='hidden' name='stype[]' value='"+stype+"'> <input type='hidden' name='uomm[]' value='"+uomm+"'> <input type='hidden' name='useby[]' value='"+ useby +"'>"+ stype+": "+ useby +"</td></tr>";
			
            $("table tbody").append(markup);
			document.getElementById("sub").style.display="block";
			document.getElementById("supp").disabled=false;
			document.getElementById("po").disabled=false;
			document.getElementById("product").value="";
			document.getElementById("chiller").value="";
			document.getElementById("totalbox").value="";
			document.getElementById("qty").value="";
			document.getElementById("batchcode").value="";
			//document.getElementById("ptemp").value="";
			//document.getElementById("vtemp").value="";
			document.getElementById("killdate").value="";
			document.getElementById("useby").value="";
			document.getElementById("uom1").value="";
			document.getElementById("killdate1").value="";
			document.getElementById("temp").value="";
			document.getElementById("uomm").value="";
			//document.getElementById("bb").value="";
			
			
			
			
			}
        });
        
        // Find and remove selected table rows
        $("#delete-row").click(function()
		{
            $("table tbody").find('input[name="record"]').each(function()
			{
            	if($(this).is(":checked"))
				{
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>


											   <strong class="card-title"> * Product Information</strong>
										
											   <br/> <br/>
											   	   <strong class="card-title" style="color:#FF0000" id="error"> </strong>
											   <div class="row">
											    <div class="col-md-6">
                                                   <label for="x_card_code" class="control-label mb-1">Select Product</label>
                                                    <div class="input-group" >
													 
													 
 <script>
function prod(str)
{

if (str=="")
  {
  document.getElementById("chkproduct").innerHTML="";
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
    document.getElementById("chkproduct").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","goodsin/getproductt.php?q="+str,true);
xmlhttp.send();  
  }
</script>

<script>
function prod11()
{
let x = $("#temp").val();
let y = $("#ptemp").val();

if(y > x)
{
    document.getElementById("perror").innerHTML="* Temperature is beyond critical limit";
	document.getElementById("ptemp").focus();
	document.getElementById("ptemp").value="";
	document.getElementById("perror ").style.color="red";
}
else
{
 document.getElementById("perror").innerHTML="Product Temperature";

document.getElementById("perror").style.color="black";
}

  }
</script>


<script>
function prod2(str)
{

var days=document.getElementById("uom1").value;
var days1=document.getElementById("uom2").value;


if (str=="")
  {
  document.getElementById("perror1").innerHTML="";
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
    document.getElementById("perror1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","goodsin/getproductts.php?q="+str+"&days="+days+"&days1="+days1,true);
xmlhttp.send();  
  }

  
</script>



                                                       <select class="form-control" id="product" onchange="prod(this.value)">
													   <option value="">Please Select</option>
													 
													   </select>
													   <div id="des"></div>
                                                        </div>
                                                    </div>
													
													
													
													<div class="col-md-3">
                                                    <label for="x_card_code" class="control-label mb-1">Total Boxes</label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="number" class="form-control"  id="totalbox" >
                                                        </div>
                                                    </div>
													
													
													<div class="col-md-3">
                                                    <label for="x_card_code" class="control-label mb-1">Quantity</label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="number" class="form-control"   id="qty">
                                                        </div>
                                                    </div>
													
													
													<div class="col-md-3">
                                                    <label for="x_card_code" class="control-label mb-1">Batch Code</label>
                                                    <div class="input-group">
													 
                                                        <input  name="postcode" type="text" class="form-control"  id="batchcode" >
                                                        </div>
                                                    </div>
													
													
													</div>
													
													<div class="row" id="chkproduct" >
													
													
													</div>
													
													
													  </div>
											   
											   											   
											    <br/>
												<button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add </button>
											   <br/><br/>
												<div class="form-row" >
												<table id="bootstrap-data-table" class="table table-striped table-bordered" id="tbl">
              <thead>
              <tr>
                <th></th>
                <th>Product</th>
                <th>Chiller</th>
				<th>Boxes</th>
                <th>Qty</th>
                <th>Batchcode</th>
				
                <th>Temperature</th>
				 <th>Use By/Best Before</th>
				 
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
				<td></td>
				<td></td>
                <td></td>
				<td></td>
				<td></td>
               
            </tr>
        </tbody>
    </table>
											</div>
											<br/><br/>
											
											<script language="javascript">
											function cnt()
											{
											
                                                  var dt = $("table tr").length;
                                                       if(dt<3)
													   {
													   return false;
													   }
													   else
													   {
													   return  true;
													   }
											}
											</script>
												 <button type="button" id="delete-row" class="btn btn-danger">Delete Row</button>	
												
												 <button type="submit" class="btn btn-success" style="float:right; display:none" id="sub" name="submit" onclick="return cnt();">Save & Generate GRN</button>	
												 
												</div></div></div>
												
												
												</div>
												
											   </form>
											   
											   
											   </div></div></div>

 <?php
											   if(isset($_POST['submit']))
											   {
											    $opt=rand(10,1000);
											    $cid=$_SESSION['cid'];
											    $supp=$_POST['supp'];
											    $po=$_POST['po'];
											    $date=$_POST['date'];
											      
												 $vb1=mysqli_query($con,"select * from tblrawsupplier where supid='$supp'");
											      $lastrow1=mysqli_fetch_array($vb1);
												  
												  $sagecode=$lastrow1['sagecode'];
											   
											   $vb=mysqli_query($con,"select * from tblgrnno2 where supid='$supp' and cdate='$date' ");
											   $lastrow=mysqli_num_rows($vb);
											   
											   $num=$lastrow+1;
											   $grn=$sagecode.date('dmy')."00".$opt.$num;
											   
											    $vb2=mysqli_query($con,"select * from tblgrn1 where supplier='$supp' and cdate='$date'");
											    $lastrow2=mysqli_num_rows($vb2);
												 $num2=$lastrow2+1;
											   
 $ansc=count($_POST['ans']);
 
 $tp="";
for($i=0;$i< $ansc;$i++)
{
$tp.=mysqli_real_escape_string($con,$_POST["ans"][$i].";");
}

 $cmntc=count($_POST["cmnt"]);
 $tp1="";
for($i1=0;$i1<$cmntc;$i1++)
{
$tp1.=mysqli_real_escape_string($con,$_POST["cmntc"][$i1].";");
}

           $productc=count($_POST["product"]);
		   
		   
		  $hjk=mysqli_query($con,"INSERT INTO tblgrnno2 ( grnno,  ans, cmnt, supid,cdate,po,user,consid) VALUES ( '$grn', '$tp', '$tp1', '$supp','$date','$po','$user','$cid')");
		   
		   
		   
		   $tp2="";
for($i2=0;$i2<$productc;$i2++)
{
$jk=$i2+1;
 $num2= $num2+1;
   $grnc=$grn."/".$jk;
 
$product=mysqli_real_escape_string($con,$_POST["product"][$i2]);
 $chillerc=$_POST["chiller"][$i2];
			$totalboxc=$_POST["totalbox"][$i2];
			$qtyc=$_POST["qty"][$i2];
			$batchcodec=$_POST["batchcode"][$i2];
			
			$killdatec=$_POST["killdate"][$i2];
			$usebyc=$_POST["useby"][$i2];
			$uommc=$_POST["uomm"][$i2];
			$stypec=$_POST["stype"][$i2];
			//$bbc=$_POST["bb"][$i2];
			
			if($ptempc=="undefined")
			{
			$ptempc="N/A";
			}
			
			if($killdatec=="undefined")
			{
			$killdatec="N/A";
			}
			
			if($usebyc=="undefined")
			{
			$usebyc="N/A";
			}
			
			if($usebyc=="undefined")
			{
			$usebyc="N/A";
			}
			
			if($uommc=="undefined")
			{
			$uommc="";
			}
			
$qury=mysqli_query($con,"INSERT INTO tblgrn1(cdate,supplier, product, batchcode, qty,  useby, killdate, box, grn, date,chiller,grncode,uomm) VALUES ( '$date',
			'$supp', '$product', '$batchcodec', '$qtyc', '$usebyc', '$killdatec', '$totalboxc', '$grnc', '$date', '$chillerc', '$grn','$stypec') ");
}
?>
<script language="javascript">
window.open('admin.php?id=goods','_self');
</script>
<?php
	}
	   ?>
											   
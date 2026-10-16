<div class="main-content">
<div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Upload Specification</a></li>
                        <li>Add Detail</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
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
                              
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Select Product</label>
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
										
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Select Product</label>
                                            <select class="form-control" id="product"  name="product">
											<option value="">Please Select</option>
													 
											</select>
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Approved On</label>
                                            <input name="date" type="date" class="form-control" id="validationTooltip03"   required="required" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.

                                            </div>
                                        </div>
                                    </div>
									
									
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03">Approved By</label>
                                            <input class="form-control" id="validationTooltip04" type="text"  required="required"  name="uploadby" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
                                        
										
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03">Upload Spec</label>
                                            <input class="form-control" id="validationTooltip04" type="file"  required="required"  name="img1" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
										
										 <div class="col-md-4 mb-3">
                                            <label for="validationTooltip03">Signature</label>
                                            <input class="form-control" id="validationTooltip04" type="file"  required="required"  name="img" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										</div>
										
										
										
                                  
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


<?php
if(isset($_POST['submit']))
{
$supp=$_POST['supp'];
$product=$_POST['product'];
$date=$_POST['date'];
$uploadby=$_POST['uploadby'];

$img=$_FILES['img']['name'];
 $gh=move_uploaded_file($_FILES['img']['tmp_name'],"specdetail/".$img);


$img1=$_FILES['img1']['name'];
$gh1=move_uploaded_file($_FILES['img1']['tmp_name'],"specdetail/".$img1);


 
$sql=mysqli_query($con,"INSERT INTO tblspecdetail (supp, product, date, uploadby, sign, spec) VALUES ('$supp', '$product', '$date', '$uploadby', '$img', '$img1')");
?>
<script language="javascript">
window.open('admin.php?id=viewspec&sno=<?php echo $product;?>','_self');
</script>
<?php
}
?>
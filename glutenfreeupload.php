<?php
$sid=$_GET['sid'];

$hj=mysqli_query($con,"select * from glutenfree1 where sid='$sid'");
$hj1=mysqli_fetch_array($hj);
?>

<script>
function showHint(str,qid,tid,sid,ssid) 
{
  if (str.length == 0) 
  {
    document.getElementById("txtHint"+qid).innerHTML = "";
    return;
  } else 
  {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint"+qid).innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "savestatus.php?ans=" + str +"&tid="+ tid + "&sid="+sid + "&ssid="+ssid, true);
    xmlhttp.send();
  }
}
</script>


 <div class="main-content">
     <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">BRC Compliance</a></li>
                        <li>General Compliance</li>
                    </ul>
                </div>
				         <div class="col-md-12">
                        <div class="card text-left">
                            <div class="card-body">
							<a href="admin.php?id=brccompliance" tabindex="2"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <h4 class="card-title mb-2">General Compliance</h4>
                               
                     <div class="row">
                     <div class="row mb-4">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
						
						    <?php
							$fid="";
							$sql2=mysqli_query($con,"select * from subtest1 where sid='$sid'");
							$i=0;
							while($row2=mysqli_fetch_array($sql2))
							{
							$i++;
							?>
                            <div class="card-body">
                               <p style="color:#0066FF">
							   
							   <?php 
							   
							   if($row2['ssid']!="")
							   {
							   echo $row2['ssid'];
							   $fid=$row2['ssid'];
							   }
							   else
							   {
							 echo  $row2['fid'];
							    $fid=$row2['fid'];
							   }
							   ?>
							   
							   
							    <?php echo $row2['clause'];?></p>
								
		<ul class="nav nav-tabs" id="dropdwonTab" role="tablist">
          <li class="nav-item"> 
		  
		  <a class="nav-link " id="home-basic-tab<?php echo $i;?>" data-toggle="tab" href="#homeBasic<?php echo $i;?>" role="tab" aria-controls="homeBasic<?php echo $i;?>" aria-selected="true" tabindex="1">Add New</a></li>
		  
		  <!--------compliance---------->
    <li class="nav-item"><a class="nav-link" id="profile-basic-tab<?php echo $i;?>" data-toggle="tab" href="#profileBasic<?php echo $i;?>" role="tab" aria-controls="profileBasic<?php echo $i;?>" aria-selected="false" tabindex="3">Interpretation</a></li>
	
						
	
	  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" tabindex="4">
                                           Compliance
										</a>
                 <div class="dropdown-menu">
				 <?php
				 $sql21=mysqli_query($con,"select * from tbldetail where sid='$sid' and fid='$fid' and typee='compliance'");
							while($row21=mysqli_fetch_array($sql21))
							{
							?>
				 <a class="dropdown-item " id="dropdown1-tab<?php echo $row2['id'];?>" href="#dropdown1<?php echo $row21['id'];?>" data-toggle="tab" aria-controls="dropdown1<?php echo $row21['id'];?>" aria-expanded="true"><?php echo $row21['section'];?></a> 
				 <?php
				 }
				 ?>
				 </div>
                                    </li>
									<!--------complinace end---------->
									<!--------original---------->
									
	<li class="nav-item dropdown"><a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                          Additional Documents
										</a>
                 <div class="dropdown-menu">
				 <?php
				 $sql24=mysqli_query($con,"select * from tbldetail where sid='$sid' and fid='$fid' and typee='original'");
				 while($row24=mysqli_fetch_array($sql24))
				{
				?>
				 <a class="dropdown-item " id="dropdown2-tab<?php echo $row24['id'];?>" href="#dropdown2<?php echo $row24['id'];?>" data-toggle="tab" aria-controls="dropdown2<?php echo $row24['id'];?>" aria-expanded="true"><?php echo $row24['section'];?></a>      
				 
				 
				 <?php
				 }
				 ?>
				 </div>
                    </li>
									
									 <li class="nav-item "><a class="nav-link active" id="status-tab<?php echo $i;?>" data-toggle="tab" href="#status<?php echo $i;?>" role="tab" aria-controls="status<?php echo $i;?>" aria-selected="false">Status</a></li>
									 
									 
									 
                                </ul>
								
								<!--------original end---------->
                                <div class="tab-content" id="myTabContent">
								
								  <div class="tab-pane fade show active
								  " id="status<?php echo $i;?>" role="tabpanel" aria-labelledby="status-tab<?php echo $i;?>"> 
								  <div id="txtHint<?php echo $i;?>"> </div>

								<div style="margin:10px">
                                
								<?php 
								$jk=mysqli_query($con,"select * from tblcmp  where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$fid' order by id desc limit 1"); 
								$match=mysqli_num_rows($jk);
								$jk1=mysqli_fetch_array($jk);
								$signi="";
								if($match<=0)
								{
								$signi=0;
								}
								else
								{
								$signi=$jk1['status'];
								}
								?>
							
                               <label class="radio radio-danger">
                                    <input type="radio" name="radio<?php echo $fid;?>" value="0" onchange="showHint(this.value,'<?php echo $i;?>','<?php echo $row2['tid'];?>','<?php echo $row2['sid'];?>','<?php echo $fid;?>')"  <?php echo ($signi=="0") ?  "checked" : "" ;  ?> /><span>Not Started</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-warning">
                                    <input type="radio" name="radio<?php echo $fid;?>" value="1" onchange="showHint(this.value,'<?php echo $i;?>','<?php echo $row2['tid'];?>','<?php echo $row2['sid'];?>','<?php echo $fid;?>')" <?php echo ($signi=="1") ?  "checked" : "" ;  ?> /><span>In Process</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-success">
                                    <input type="radio" name="radio<?php echo $fid;?>" value="2" onchange="showHint(this.value,'<?php echo $i;?>','<?php echo $row2['tid'];?>','<?php echo $row2['sid'];?>','<?php echo $fid;?>')"  <?php echo ($signi=="2") ?  "checked" : "" ;  ?> /><span>Completed</span><span class="checkmark"></span>
                                </label>
								 <label class="radio radio-light">
                                    <input type="radio" name="radio<?php echo $fid;?>" value="3" onchange="showHint(this.value,'<?php echo $i;?>','<?php echo $row2['tid'];?>','<?php echo $row2['sid'];?>','<?php echo $fid;?>')"  <?php echo ($signi=="3") ?  "checked" : "" ;  ?> /><span>Not Applicable</span><span class="checkmark"></span>
                                </label>
                                  </div>
								  </div>
								  
     <div class="tab-pane fade " id="homeBasic<?php echo $i;?>" role="tabpanel" aria-labelledby="home-basic-tab<?php echo $i;?>"> 
	 
	 
	 <script type="text/javascript">
$(document).ready(function (h)
 {
	$("#uuploadForm3<?php echo $i;?>").on('submit',(function(h)
	 {
	
	    h.preventDefault();
		submitHandler: $.ajax({
        	url: "brccompliance4",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#uuploadStatus3<?php echo $i;?>").html(data);
			//$('#uuploadForm3<?php echo $i;?>').reset();
			//$('#uuploadStatus3<?php echo $i;?>').html('<span style="color:#28A74B;">Data uploaded successfully.<span>');
	    	alert("Data uploaded successfully");
			window.open('admin.php?id=brccompliance1&sno=<?php echo $_GET['sno'];?>&sid=<?php echo $_GET['sid'];?>','_self');
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	   
	}));
});
</script>


	   <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data" id="uuploadForm3<?php echo $i;?>" name=""> 
							  <input type="hidden" name="tid" value="<?php echo $_GET['sno'];?>" />
								  <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>" />
								    <input type="hidden" name="fid" value="<?php echo $fid;?>" />
								 
								  
                                    <div class="form-row" id="refresh">
									 	<div id="uuploadStatus3<?php echo $i;?>"></div>
									
									 <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Select Type</label>
                                            <select class="form-control" id="validationTooltip01" type="text"  required="required" name="typee">
											<option value="">Please Select </option>
											<option value="Original">Additional Documents</option>
											<option value="Compliance">Compliance</option>
											
											</select>
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  required="required" name="name" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Detail</label>
                                            <textarea class="form-control" id="validationTooltip01" required="required" name="detail"></textarea>
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Link if any</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  name="linkk" />
                                            <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
										
											<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Upload Document</label>
                                            <input class="form-control" id="validationTooltip01" type="file"   name="document" />
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
                                    </div>
                                    <button class="btn btn-primary" type="submit" id="submitt<?php echo $i;?>" name="submitt<?php echo $i;?>">Submit </button>
                                </form>
	  </div>
	 
	 
	 
	 
   <div class="tab-pane fade" id="profileBasic<?php echo $i;?>" role="tabpanel" aria-labelledby="profile-basic-tab<?php echo $i;?>"> 
 
							<?PHP echo  $row2['inter'];?>						
								</div>
  
  <?php
				 $sql22=mysqli_query($con,"select * from tbldetail where sid='$sid' and fid='$fid' and typee='compliance'");
							while($row22=mysqli_fetch_array($sql22))
							{
							?>
							
   <div class="tab-pane fade" id="dropdown1<?php echo $row22['id'];?>" role="tabpanel" aria-labelledby="dropdown1-tab<?php echo $row22['id'];?>" aria-expanded="true" style="tab-index:5">
                                        <p>Name:  <?php echo $row22['section'];?><br/><br/>
										 Detail:  <?php echo $row22['detail'];?><br/><br/>
										 <?php
										 if($row22['img']=="")
										 {
										 }
										 else
										 {
										 ?>
										  <a href="document/<?php echo $row22['img'];?>" target="_blank" tabindex="8" style="tab-index:5"> Attached Document:  <?php echo $row22['img'];?></a>
										    <br/><br/>
										  <?php
										  }
										  ?>
										
										  <?php
										 if($row22['linkk']=="")
										 {
										 }
										 else
										 {
										 ?>
					<a href="<?php echo $row22['linkk'];?>" target="_blank" tabindex="8" style="tab-index:5;color:#0033FF"> Check Link:  <?php echo $row22['linkk'];?></a>
										   
										   <?php
										   }
										   ?>
										  </p>
										  
										  <a href="del.php?id=<?php echo $row22['id'];?>&sno=<?php echo $_GET['sno'];?>&sid=<?php echo $_GET['sid'];?>" onclick="return confirm('Are you sure ?')">  <button class="btn btn-danger">Delete</button></a>
										  
										<a data-toggle="modal"  class='modalButton'  data-target="#myModal1" href="#<?php echo $row22['id'];?>" data-fid='<?php echo $row22['id'];?>'> <button class="btn btn-info">Edit</button></a>
										 
                                    </div>
                            <?php
							}
							?>       
   
                           <?php
				           $sql23=mysqli_query($con,"select * from tbldetail where sid='$sid' and fid='$fid' and typee='original'");
							while($row23=mysqli_fetch_array($sql23))
							{
							?>
							
   <div class="tab-pane fade" id="dropdown2<?php echo $row23['id'];?>" role="tabpanel" aria-labelledby="dropdown2-tab<?php echo $row23['id'];?>" aria-expanded="true" style="tab-index:5">
                                        <p>
										 Name:  <?php echo $row23['section'];?><br/><br/>
										 Detail:  <?php echo $row23['detail'];?><br/><br/>
										 <?php
										 if($row23['img']=="")
										 {
										 }
										 else
										 {
										 ?>
										  <a href="document/<?php echo $row23['img'];?>" target="_blank" tabindex="8" style="tab-index:5"> Attached Document:  <?php echo $row23['img'];?></a>
										    <br/><br/>
										  <?php
										  }
										  ?>
										
										  <?php
										 if($row23['linkk']=="")
										 {
										 }
										 else
										 {
										 ?>
				   <a href="<?php echo $row23['linkk'];?>" target="_blank" tabindex="8" style="tab-index:5;color:#0033FF">Check Link:  <?php echo $row23['linkk'];?></a>
										   <?php
										   }
										   ?>
										  </p>
										  
										<a href="del.php?id=<?php echo $row23['id'];?>&sno=<?php echo $_GET['sno'];?>&sid=<?php echo $_GET['sid'];?>" onclick="return confirm('Are you sure ?')">  <button class="btn btn-danger">Delete</button></a>
										
										
										<a data-toggle="modal"  class='modalButton'  data-target="#myModal1" href="#<?php echo $row23['id'];?>" data-fid='<?php echo $row23['id'];?>'> <button class="btn btn-info">Edit</button></a>
										 
										 
										 
                                    </div>
									
                            <?php
							}
							?>  
							 
							 </div>
							 </div>
                            
							<?php
							}
							?>
							
							<div class="col-md-12 mb-12">
							<h2>Fill below if done</h2>
							<form name="formm3" method="post" action="submitreport">
							<input type="hidden" name="tid" value="<?php echo $_GET['sno'];?>" />
							<input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>" />
							
							 <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Have you checked all the clauses ?</label>
                                            <input type="checkbox" name="fm1"  value="yes" required /> 
                                        </div>
										
										
										<div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Any query/feedback</label>
                                            <textarea class="form-control" id="validationTooltip01" type="file"   name="cmnt" required></textarea>
                                            <div class="invalid-tooltip">
                                              Please fill the field.
                                            </div>
                                        </div>
										
                                 
                                    <button class="btn btn-warning" type="submit"  name="submittx">Submit </button>
									</form>
									
							</div>
							
							
							
                        </div>
                    </div>
					 </div>
                    </div>
					
					
					
					<script>
    $('.modalButton').click(function(){
        var teacherid = $(this).attr('data-fid');
		
        $.ajax({url:"editbrccompliance.php?sid="+teacherid,cache:false,success:function(result)
		{
             $("#modal-body2").html(result);
        }});
    });
	</script>
	
	
					
                              <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1" aria-hidden="true">
                        <div class="modal-dialog"  >
                            <div class="modal-content"> 
							 <div class="modal-body" id="modal-body2">
								<?php
								include 'editbrccompliance.php';   
								?>         
						</div>
                            </div>
                        </div>
                    </div>     
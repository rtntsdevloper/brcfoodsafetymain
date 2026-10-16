 <?php
 $sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from glutenfree where id='$_GET[sno]'");
$row=mysqli_fetch_array($sql);
?>


<div id="txtHint" ></div>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Management</a></li>
                        <li>Gluten Free</li>
                    </ul>
                </div>
				
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
                             <h4 class="card-title mb-3"><?php echo $row['id'];?>. 	<?php echo $row['name'];?></h4>
							 
                               <div class="row">
                             <div class="col-md-12">
                        <ul class="nav nav-tabs justify-content-end mb-12" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="admin.php?id=glutenfree">Go Back</a></li>
                        </ul>
						
                        <div class="card">
						              
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                    
                                    <!-- -===== Print Area =======-->
                                   
										
                                        <div class="mt-12 mb-12 border-top"></div>
										
										<?php
									$sql2=mysqli_query($con,"select * from glutenfree1  where tid='$sno'");
									$i=0;
                                    while($row2=mysqli_fetch_array($sql2))
									{
									if($row2['ssid']!="")
									{
									$fid=$row2['ssid'];
									}
									else
									{
									$fid=$row2['sid'];
									}
                                     ?>                                                   
                                          
										  
										   <div id="print-area">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="font-weight-bold"><?php echo $fid;?>- <?php echo $row2['clause'];?></h6>
												
                                            </div>
                                        </div>
										
                                            <div class="row mb-12" style="margin:5px;">
                                        <div class="col-md-12" style="padding:5px">
										<button class="btn btn-primary" style="float:right" type="button" data-toggle="modal" 
										data-target="#exampleModalLong<?php echo $row2['id'];?>">Interpretation </button></div>
										
											
                                        </div>
									

	<div class="modal fade" id="exampleModalLong<?php echo $row2['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true" >
                    <div class="modal-dialog" role="document" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle1">Interpretation </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                            </div>
                            <div class="modal-body">
                              <?php echo $row2['inter'];?>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
                              
                           
                        </div>
                    </div>
                </div>
								
								
								</div>
										<form action="savegluten" method="post" name="form1">
											<input type="hidden" name="sno" value="<?php echo $sno;?>" />  
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-hover mb-4">
                                                    <thead class="bg-gray-300">
                                                        <tr>
														
                                                           <th></th>
                                            <th colspan="5">Outcome</th>
                                            <th>Docs</th>
											
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                    <td></td>      
                                            <td>Compliant</td>
                                            <td>Minor</td>
											  <td>Major</td>
											 <td>Critical</td>
											  <td>Not Applicable</td>
                                            <td></td>
											
											
                                          </tr>
											 <tr>
                                            <td></td>    
										<?php
				    $rty1=mysqli_query($con,"select * from savegluten where fid='$fid' and ques='$row2[qid]'");
					$matchh=mysqli_num_rows($rty1);
					if($matchh<=0)
					{
					$date=date("Y-m-d");
					
					mysqli_query($con,"INSERT INTO savegluten (date, fid, ques, tid, sid) VALUES ( '$date', '$fid', '$row2[qid]', $sno,'$row2[sid]');");
					}
					else
					{
					}
							
							$rty=mysqli_query($con,"select * from savegluten where fid='$fid' and ques='$row2[qid]'");			
					$qury=mysqli_fetch_array($rty);
										
										 $signi= $qury['ans'];	
												
										?>
										<script>
										function cal1(str,str1)
										{
										
										if(str=="Compliant" ||  str=="Not Applicable")
										{
										document.getElementById('cmnt'+str1).style.display = 'block';
										document.getElementById('taction'+str1).style.display = 'none';
										document.getElementById('cmntt'+str1).disabled = false;
										document.getElementById('date'+str1).disabled = true;
										document.getElementById('action'+str1).disabled = true;
										}
										else 
										{
										document.getElementById('cmnt'+str1).style.display = 'none';
										document.getElementById('taction'+str1).style.display = 'block';
										document.getElementById('cmntt'+str1).disabled = true;
										document.getElementById('date'+str1).disabled = false;
										document.getElementById('action'+str1).disabled = false;
										}
										}
										
										</script>
											
     <td >
   <input type="radio"  value="Compliant" id="r1<?php echo $i;?>" name="r1<?php echo $i;?>" onclick="return cal1(this.value,<?php echo $i;?>);" onchange="showHint(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"  <?php echo ($signi=="Compliant") ?  "checked" : "" ;  ?> /></td>
   
    <td ><input type="radio"  value="Minor" id="r1<?php echo $i;?>" name="r1<?php echo $i;?>" onclick="return cal1(this.value,<?php echo $i;?>);" onchange="showHint(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"  <?php echo ($signi=="Minor") ?  "checked" : "" ;  ?> /></td>
	
                                            <td ><input type="radio"  value="Major" id="r1<?php echo $i;?>" name="r1<?php echo $i;?>" onclick="return cal1(this.value,<?php echo $i;?>);" onchange="showHint(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"  <?php echo ($signi=="Major") ?  "checked" : "" ;  ?> /></td>
                                           
											<td ><input type="radio"  value="Critical" id="r1<?php echo $i;?>" name="r1<?php echo $i;?>" onclick="return cal1(this.value,<?php echo $i;?>);" onchange="showHint(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"  <?php echo ($signi=="Critical") ?  "checked" : "" ;  ?> /></td>
											<td ><input type="radio"  value="Not Applicable"id="r1<?php echo $i;?>"  name="r1<?php echo $i;?>"  onclick="return cal1(this.value,<?php echo $i;?>);" onchange="showHint(this.value,'<?php echo $row2['fid'];?>','<?php echo $row2['cid'];?>')"  <?php echo ($signi=="Not Applicable") ?  "checked" : "" ;  ?> /></td>
                                           
											<td><a data-toggle="modal"  class='modalButton'  data-target="#myModal1" href="#<?php echo $fid;?>" data-fid='<?php echo $fid;?>' data-qid='<?php echo $row2['cid'];?>'>	<i class="fa fa-file" aria-hidden="true"></i> </a></td>
                                            </tr>
											<tr>
											<td></td>
											<td colspan="4">
											<div id="cmnt<?php echo $i;?>" style="display:none"> 
											<textarea class="form-control" placeholder="Enter Comment" name="cmntt<?php echo $i;?>" id="cmntt<?php echo $i;?>" required  disabled="disabled" onchange="showHint1(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"><?php echo $qury['notes'];?></textarea>
											</div>
											
											<div id="taction<?php echo $i;?>" style="display:none"> 
											<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Completion date agreed</label>
											 <input type="date" name="date<?php echo $i;?>" id="date<?php echo $i;?>" class="form-control" required disabled="disabled" onchange="showHint2(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')" value="<?php echo $qury['deliver'];?>">
				                           <div class="invalid-tooltip">
                                                Please select date.

                                          </div>
                                        </div>
                                    </div>
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Comment if any?</label>
											 <textarea name="title<?php echo $i;?>" id="title<?php echo $i;?>"  class="form-control" onchange="showHint3(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"><?php echo $qury['title'];?></textarea>
				                            <div class="invalid-tooltip">
                                                Please provide title.

                                            </div>
                                        </div>
                                    </div>
									
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Action required</label>
				 <textarea  name="action<?php echo $i;?>" id="action<?php echo $i;?>" class="form-control" required="required" disabled="disabled" onchange="showHint4(this.value,'<?php echo $fid;?>','<?php echo $row2['cid'];?>')"><?php echo $qury['action'];?></textarea>
				                            <div class="invalid-tooltip">
                                               Action required

                                            </div>
                                        </div>
                                    </div>
									
									</div>
									</td>
											</tr>
											
										
                                                    </tbody>
                                                </table>
                                            </div>
                                           
                                        </div>
									
                                  <div class="mt-12 mb-12 border-top" id="error<?php echo $i;?>" style="color:#FF0000"></div>
									<?php
										 $i++;
										}
										?>
                                    <!-- ==== / Print Area =====--><?php
								
								?><!-- ==== / Edit Area =====--><?php
									
									?> 
									
									
									  <button class="btn btn-danger" style="margin:30px; float:right" type="submit" onclick="return checkReq();">View & Submit</button>
                                        </form>
										
										<script>

   function checkReq() 

 {
  
   

 var n=<?php echo $i;?>;

for (var t3=0; t3<n;t3++) 

{

var y=t3;

var e=y+1;

var boxes = document.getElementsByName("r1"+y);

for (var x = 0;x<=boxes.length; x++) 

{      if(boxes[0].checked==false && boxes[1].checked==false && boxes[2].checked==false && boxes[3].checked==false && boxes[4].checked==false )

	{

	document.getElementById('error'+y).innerHTML="*Please choose one option[Yes, No, NA] for question no."+e+" *";

     document.getElementById('r1'+y).focus();

    return false;
     }   
     else
      {
    document.getElementById('error'+y).innerHTML="";
       }
	   }
       }
	 }

</script>

				<script>
    $('.modalButton').click(function(){
        var teacherid = $(this).attr('data-fid');
		var qid = $(this).attr('data-qid');
		var rid= <?php echo $rid;?>;
        $.ajax({url:"saveaudit.php?sid="+teacherid+"&qid="+qid+"&rid="+rid,cache:false,success:function(result)
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
								include 'saveaudit.php';   
								?>         
						</div>
                            </div>
                        </div>
                    </div>
					
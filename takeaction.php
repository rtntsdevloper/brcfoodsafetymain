<script type="text/javascript">
$(document).ready(function (u)
 {
 $("#uploadForm1").on('submit',(function(u)
	{
		u.preventDefault();
		$.ajax({
        	url: "action",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#uploadStatus").html(data);
			$('#uploadForm1')[0].reset();
			$('#uploadStatus1').html('<span style="color:#28A74B;"> Data uploaded successfully.<span>');
			 $("#table-responsive1").html(data);
			//$('#deep'+<?php echo $_GET['qid1'];?>).html('<input type="text" value="hello">');
			 document.getElementById('t1'+<?php echo $_GET['qid1'];?>).value="Hello";
		    },
		  	error: function() 
	    	{
			
	    	} 	        
	   });
	}));
});
</script>

<script>
function demoDisplay2()
 {

  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
$('.views').show();
$('.viewdetail').hide();
}

function demoDisplay3()
 {

  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
$('.views').hide();
$('.viewdetail').show();
}

</script>

		  <button type="button" class="btn btn-warning" onclick="demoDisplay3()"  style="float:right;">History</button>
		  <button class="btn btn-info " onclick="demoDisplay2()" style="float:right; margin-right:5px"> New Action</button>
		  
	<div class="card-title">Comment</div>
	<div  class="views">
	
	<?php
	$rid=$_GET['rid'];
	
	?>
             
			                   <div id="uploadStatus1"></div>
								
                                <form class="needs-validation"  method="post" action="" id="uploadForm1">
								<input name="fid" id="fid" type="hidden" value="<?php echo $_GET['fid1'];?>" />
							    <input name="qid"  id="qid" type="hidden" value="<?php echo $_GET['qid1'];?>" />
									   <input name="rid"  id="rid" type="hidden" value="<?php echo $_GET['rid'];?>" />
								<input type="hidden" name="sno" value="<?php echo $sno;?>" />
                                    
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Expected Delivery Date</label>
											 <input type="date" name="date" id="date" class="form-control" required >
				                           <div class="invalid-tooltip">
                                                Please select date.

                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Title</label>
											 <input type="text" name="title" id="title" class="form-control" required="required"   >
				                            <div class="invalid-tooltip">
                                                Please provide title.

                                            </div>
                                        </div>
                                    </div>
									
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Action Required</label>
											 <textarea  name="action" id="action" class="form-control" required="required"></textarea>
				                            <div class="invalid-tooltip">
                                               Action required

                                            </div>
                                        </div>
                                    </div>
									
									
									
                                    <button class="btn btn-primary" type="submit" name="submit" >Submit </button>
                                </form>
                            </div>
                        
 <script>
function bnm1(y)
  {
   var r=confirm("Are you sure?")
   if (r==true)
   {
    $.ajax({
	url: "deleteaction?sno="+y+"&rid="+<?php echo $rid;?>, 
	type: "GET",
	success: function(result)
	{
      $("#table-responsive1").html(result);
    }
	});
	}
	else
   {
       //nothing to do here
   }
  };

</script>
				                   					
					
					<div class="viewdetail" style="display:none">
					<div class="table-responsive1" id="table-responsive1">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Index</th>
                                            <th>Due</th>
                                            <th>Title</th>
											<th>Severity</th>
											<th>Delete</th>
											
                                            
                                        </thead>
                                        <tbody>
										<?php
					 include 'connection.php';
					 $query1=mysqli_query($con,"select * from action where fid='$_GET[fid1]' and ques='$_GET[qid1]' and sno='$rid'");
					 $i=1;
					 while($rows1=mysqli_fetch_array($query1))
					  {
                      ?>  
				      <tr>
                     <td><?php echo $rows1['fid'];?></td>
                     <td><?php echo $rows1['deliver'];?></td>
                     <td><?php echo $rows1['title'];?></td>
					 <td><?php echo $rows1['action'];?></td>
					  <td><a href="#" onclick="return bnm1(<?php echo $rows1['id'];?>);"><i class="fa fa-trash" ></i></a></td>
				  
                   </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody></table>
					</div>
				</div>
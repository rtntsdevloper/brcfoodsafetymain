
<?php 
include 'connection.php';?>									
<script type="text/javascript">
$(document).ready(function (e)
{
	$("#uploadForm").on('submit',(function(e)
	 {
		e.preventDefault();
		$.ajax({
        	url: "upload",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$('#uploadForm')[0].reset();
			$('#uploadStatus').html('<span style="color:#28A74B;">Data uploaded successfully.<span>');
			$("#table-responsive").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>
<script>
function demoDisplay()
 {
  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
$('.document').hide();
$('.galleryy').show();
}

function demoDisplay1()
 {
  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
$('.document').show();
$('.galleryy').hide();
}

</script>

     
				<?php
				 $sid=$_GET['sid'];
				 $qid=$_GET['qid'];
				 $rid=$_GET['rid'];
				?>			
		 
		  <button type="button" class="btn btn-warning" onclick="demoDisplay()" style="float:right; margin-right:5px">History</button>
		  <button type="button" class="btn btn-info " onclick="demoDisplay1()" style="float:right; margin-right:5px">Upload Document </button>

                                <div class="card-title">Upload Document
								</div>
								<div class="document">
								 <div id="uploadStatus"> </div>
                              <form id="uploadForm" action="" method="post" class="pt-3" enctype="multipart/form-data">
								         <input type="hidden" name="sid" value="<?php echo $sid;?>" />
												<input type="hidden" name="qid" value="<?php echo $qid;?>" />
												<input type="hidden" name="rid" value="<?php echo $rid;?>" />
                                               
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Upload Document</label>
											 <input name="userImage" type="file" class="inputFile" required />
				                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                    </div>
									
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
								</div>
                           
                   
					<script>
function bnm(y,y1)
  {
   var r=confirm("Are you sure?")
   if (r==true)
   {
    $.ajax({
	url: "deletedoc?sno="+y+"&key1="+y1+"&rid="+<?php echo $rid;?>, 
	type: "GET",
	success: function(result)
	{
      $("#table-responsive").html(result);
    }
	});
	}
	else
   {
       //nothing to do here
   }
  };

</script>
					
					<div class="galleryy" id="galleryy" style="display:none">
					 <div class="table-responsive" id="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Id</th>
                                            <th>Document</th>
											 <th>Delete</th>
                                        </thead>
                                        <tbody>
										

										<?php
					$query=mysqli_query($con,"select * from saveaudit where fid='$sid' and ques='$qid' and sno='$rid' ");
					$rows=mysqli_fetch_array($query)
							
                                   ?>  
 <?php
		$string = $rows['document'];
$tags1 = explode(';' , $string);
$i=0;
foreach($tags1 as $key1)
  {
  $i++;
   $info5= new SplFileInfo($key1);
  $tpe5=$info5->getExtension();
  if($tpe5!="")
  {
  ?>       
								   <tr>
                                    <td><?php echo $i;?></td>
                                               
                    <td>
					<a href="documents/<?php echo $key1;?>" target="_blank" style="color:#0066FF"> 
					<?php echo $key1;?></a>
					 </td>
					<td><a href="#" onclick="return bnm(<?php echo $rows['id'];?>,'<?php echo $key1;?>');"><i class="fa fa-trash" ></i></a></td>
                                            </tr>
                                            <?php
					}
					}
					?>             
											
                                        </tbody></table>
					</div></div>
					 </div>
                       
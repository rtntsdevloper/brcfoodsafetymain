<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function (f)
 {
	$("#uploadForm2").on('submit',(function(f)
	 {
		f.preventDefault();
		$.ajax({
        	url: "savenotes",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#uploadStatus").html(data);
			$('#uploadForm2')[0].reset();
			$('#uploadStatus2').html('<span style="color:#28A74B;">Data uploaded successfully.<span>');
		     $("#table-responsive2").html(data);
			
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>

<script >
function demo1()
 {

  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
$('.details').hide();
$('.shows').show();
}

function demos()
 {

  //document.getElementByClass("card-body").style.display = "hidden";
    //document.getElementByClass("gallery").style.display = "visible";
	$('.shows').hide();
$('.details').show();
}

</script>


<?php 
 $rid=$_GET['rid'];?>

							
		
		  <button type="button" class="btn btn-warning " onclick="demos()" style="float:right; margin-right:5px">History</button>
		    <button class="btn btn-info " onclick="demo1()" style="float:right; margin-right:5px">Notes </button>
	
                                <div class="card-title">Comment</div>
								<div class="shows">
								 <div id="uploadStatus2"></div>
								 
                                <form class="needs-validation"  method="post" action="" id="uploadForm2">
								 <input name="fidd" id="fidd" type="hidden" value="<?php echo $_GET['fidd'];?>" />
									  <input name="qidd"  id="qidd" type="hidden" value="<?php echo $_GET['qidd'];?>" />
									    <input name="rid"  id="rid" type="hidden" value="<?php echo $rid;?>" />	   
									  
								
                                    <div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Comment</label>
											  <textarea  name="note" id="note" class="form-control" required></textarea>
				                           
                                        </div>
                                    </div>
									
									
									
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                   
		<script>
function bnm2(y)
  {
   var r=confirm("Are you sure?")
   if (r==true)
   {
    $.ajax({
	url: "deletenotes?sno="+y+"&rid="+<?php echo $rid;?>, 
	type: "GET",
	success: function(result)
	{
      $("#table-responsive2").html(result);
    }
	});
	}
	else
   {
       //nothing to do here
   }
  };

</script>			
				<div class="details" style="display:none">
				 <div class="table-responsive2" id="table-responsive2">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									<thead>
                                            <th>Id</th>
                                            <th>Date</th>
                                            <th>Notes</th>
											<th>Delete</th>
                                            
                                        </thead>
                                        <tbody>
										<?php
										include 'connection.php';
					$query3=mysqli_query($con,"select * from saveaudit where fid='$_GET[fidd]' and ques='$_GET[qidd]' and sno='$rid' and notes!=''");
					$i=1;
							while($rows3=mysqli_fetch_array($query3))
							{
                                   ?>         <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $rows3['curdate'];?></td>
                                                <td><?php echo $rows3['notes'];?></td>
                                               <td><a href="#" onclick="return bnm2(<?php echo $rows3['id'];?>);"><i class="fa fa-trash" ></i></a></td>
                                            </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody></table>
					</div></div>
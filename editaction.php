<script type="text/javascript">
$(document).ready(function (g)
 {
	$("#uploadForm3").on('submit',(function(g)
	 {
		g.preventDefault();
		$.ajax({
        	url: "saveaction",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#uploadStatus").html(data);
			$('#uploadForm3')[0].reset();
			$('#uploadStatus3').html('<span style="color:#28A74B;">Data uploaded successfully.<span>');
		
			
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>


<?php
									include 'connection.php';
						$query1=mysqli_query($con,"select * from action where  id='$_GET[tid]'");
						$rows=mysqli_fetch_array($query1);
							?>

 
	<div class="card-title">Update Action</div>	  
		  
									    	
										
                                 <div></div>
									<div id="uploadStatus3"></div>
									
									
									<form class="needs-validation"  method="post" action="" id="uploadForm3">
							<input name="fid5" id="fid5" type="hidden" value="<?php echo $rows['fid'];?>" />
									  <input name="qid5"  id="qid5" type="hidden" value="<?php echo $rows['ques'];?>" />
									   <input name="sno"  id="sno" type="hidden" value="<?php echo $rows['id'];?>" />
									   
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Severity</label>
											 <select class="form-control" name="s11" id="s11">
													<option value="<?php echo $rows['ans'];?>"><?php echo $rows['ans'];?></option>
													<option value="Major">Major</option>
													<option value="Minor">Minor</option>
													<option value="Critical">Critical</option>
													</select>
				                             <div class="invalid-tooltip">
                                                Please choose one option.

                                            </div>
                                        </div>
                                    </div>
									
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Expected Delivery Date</label>
											 <input type="date" name="date1" id="date1" class="form-control" value="<?php echo $rows['deliver'];?>" >
				                           <div class="invalid-tooltip">
                                                Please select date.

                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Title</label>
											<input type="text" name="title1" id="title1" class="form-control"  value="<?php echo $rows['title'];?>">
				                            <div class="invalid-tooltip">
                                                Please provide title.

                                            </div>
                                        </div>
                                    </div>
									
									
									<div class="form-row">
                                        <div class="col-md-12">
                                            <label for="validationTooltip01">Action Required</label>
											  <textarea  name="action1" id="action1" class="form-control" ><?php echo $rows['action'];?></textarea>
				                            <div class="invalid-tooltip">
                                               Action required

                                            </div>
                                        </div>
                                    </div>
									
									
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01"> Root Cause</label>
											  <textarea name="rootcause1" id="rootcause1" class="form-control"><?php echo $rows['root'];?></textarea>
				                            <div class="invalid-tooltip">
                                                Root Cause

                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Notes</label>
											<?php
													 $ui=mysqli_query($con,"select * from notes where aid='$rows[id]'");
													 while($lt=mysqli_fetch_array($ui))
													 {
													 ?>
													 <textarea class="form-control" disabled="disabled"><?php echo $lt['date'];?>: &nbsp;<?php echo $lt['notes'];?></textarea><?php
													 }
													 ?>
											  
				                            <div class="invalid-tooltip">
                                               Notes

                                            </div>
                                        </div>
                                    </div>
									
									
									
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01"></label>
											<textarea name="notes" id="notes" class="form-control"></textarea>
				                            <div class="invalid-tooltip">
                                                Notes

                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01"></label>
											 <input type="radio" name="r1"  value="In Progress" /> Set In Progress
											<input type="radio" name="r1" value="Complete" /> Complete Action
											<input type="radio" name="r1" value="Cancelled" /> Set In Progress
				                       <div class="invalid-tooltip">
                                                Root Cause
                                            </div>
                                        </div>
                                    </div>
									
									
                                    <button class="btn btn-primary" type="submit" name="submit" >Submit </button>
                                </form>
							
						
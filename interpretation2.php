<script type="text/javascript">
$(document).ready(function (g)
 {
	$("#uploadForm3").on('submit',(function(g)
	 {
		g.preventDefault();
		$.ajax({
        	url: "interpretation3",
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
						
						echo $_GET['sid'];
						$query1=mysqli_query($con,"select * from subtest1 where  fid='$_GET[fid]' and sid='$_GET[sid]'");
						$rows1=mysqli_fetch_array($query1);
						
						$query=mysqli_query($con,"select * from addtest1 where  testid='$rows1[tid]'");
						$rows=mysqli_fetch_array($query);
							?>

	<div class="card-title"><?php echo $rows['testid'];?> <?php echo $rows['subject'];?>
	<br/>
	<?php echo $rows1['fid'];?> <?php echo $rows1['clause'];?>
	</div>	  
		  
									    	
										
                                 <div></div>
									<div id="uploadStatus3"></div>
									
									
									<form class="needs-validation"  method="post" action="" id="uploadForm3">
						          	<input name="fid" type="hidden" value="<?php echo $_GET['fid'];?>" />
									  <input name="sid"   type="hidden" value="<?php echo $_GET['sid'];?>" />
									   
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Interpretation</label>
											 <textarea  name="name" id="name" class="form-control" required ><?php echo $rows1['inter'];?></textarea>
				                           <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
                                    </div>
									
									
									
                                    <button class="btn btn-primary" type="submit" name="submit" >Submit </button>
                                </form>
							
						
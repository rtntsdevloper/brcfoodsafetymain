<script type="text/javascript">
$(document).ready(function (g)
 {
	$("#uploadForm3").on('submit',(function(g)
	 {
		g.preventDefault();
		$.ajax({
        	url: "interpretation1",
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
						$query=mysqli_query($con,"select * from addtest1 where  testid='$_GET[tid]'");
						$rows=mysqli_fetch_array($query);
						
						$query1=mysqli_query($con,"select * from subtest where  tid='$_GET[tid]' and sid='$_GET[sid]'");
						$rows1=mysqli_fetch_array($query1);
						
						$query2=mysqli_query($con,"select * from tblinterpretation where  tid='$_GET[tid]' and sid='$_GET[sid]'");
						$rows2=mysqli_fetch_array($query2);
							?>

	<div class="card-title"><?php echo $rows['testid'];?> <?php echo $rows['subject'];?>
	<br/>
	<?php echo $rows1['sid'];?> <?php echo $rows1['subtest'];?>
	</div>	  
		  
									    	
										
                                 <div></div>
									<div id="uploadStatus3"></div>
									
									
									<form class="needs-validation"  method="post" action="" id="uploadForm3">
						          	<input name="tid" type="hidden" value="<?php echo $_GET['tid'];?>" />
									  <input name="sid"   type="hidden" value="<?php echo $_GET['sid'];?>" />
									   
									<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationTooltip01">Interpretation</label>
											 <textarea  name="name" id="name" class="form-control" required ><?php echo $rows2['name'];?></textarea>
				                           <div class="invalid-tooltip">
                                                Please fill the field.

                                            </div>
                                        </div>
                                    </div>
									
									
									
                                    <button class="btn btn-primary" type="submit" name="submit" >Submit </button>
                                </form>
							
						
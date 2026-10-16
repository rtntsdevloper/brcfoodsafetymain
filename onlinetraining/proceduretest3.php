

<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/js/jquery.signature.css">		

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>

<script language="javascript">
    jQuery(document).ready(function($) {
    // Store the window width
    var windowWidth = $(window).width();
    // Resize Event
    $(window).resize(function(){

        // Check window width has actually changed and it's not just iOS triggering a resize event on scroll
        if ($(window).width() != windowWidth) {

            // Update the window width for next time
            windowWidth = $(window).width();

            // Do stuff here

        }

        // Otherwise do nothing

    });

});</script>	
<style>
.kbw-signature { width: 400px; height: 200px;}
#signature canvas{
width: 100% !important;
height: auto;
}
.container{
margin-left: 420px;
 
}
</style>
		
			<?php
			  $sno=$_SESSION['sno'];
				 
			$fg=mysqli_query($con,"select * from tblstaff where id='$staffid'");
$fg1=mysqli_fetch_array($fg);

		?>
			  
				  			<div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Staff Signature(Sign nd continue)
							   
								 
								
							  </h2>
                           </div>
                        </div>
                     </div>
					
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head"></div>
					  <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">	
					 
					<table class="table" style="color:#FF0000; font-size:16px">
					  <thead>
					
					  <tr>
					  <td style="color:#FF0000">Staff (<?php echo $fg1['fname'];?> <?php echo $fg1['lname'];?>)</td>
					  <td style="color:#FF0000;" ></td>
					  </tr>
					  
 <tr>
<td>
<form id="uploadForm3"  method="post" action="">
	 <input type="hidden" name="sno" value="<?php echo $sno;?>" >

<div id="res" style="color:red; font-size:20px"></div>
<br/>
<div id="signature" ></div>
<br/>
<button id="clear" class="btn btn-warning">Clear Signature</button>
 <button class="btn btn-success" id="Submit" type="submit"  style="margin-left:20px">Signature & Verify</button>

<textarea id="sigpad" name="signature_image" style="display: none"></textarea>



<script type="text/javascript">
	
var signature = $('#signature').signature({syncField: '#sigpad', syncFormat: 'PNG'});
$('#clear').click(function(e) 
{
e.preventDefault();
signature.signature('clear');
$("#sigpad").val('');
});
</script>
 
 
 <script type="text/javascript">
$(document).ready(function (g)
 {
  
 $("#uploadForm3").on('submit',(function(g)
	 {
	 $("#loading").show();
		g.preventDefault();
		$.ajax({
        	url: "verifyprocedure",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#res").html(data);
			 //$("#loading").hide();
			
    window.open('admin.php?id=procedure','_self');
   
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>
					  </td>
					  </tr>
					  
					   <tr>
					  <td style="color:#FF0000"></td>
					  <td style="color:#FF0000"> 
					  
					  
					  </td>
					  </tr>
					  </thead>
					   
					  </table>
			
</div></div></div></div></div>


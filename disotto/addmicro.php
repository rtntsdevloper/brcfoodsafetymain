  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<SCRIPT>
function addMore()
{
	$("<DIV>").load("input.php", function() 
	{
	$("#product").append($(this).html());
	});	
}
function deleteRow() {
	$('DIV.product-item').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</SCRIPT>
 <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2> Microbiological Standard (Add New Section)
							      <a href="admin.php?id=ps1&pid=<?php echo $_GET['pid'];?>&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
                           </div>
                        </div>
                     </div>
					 
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
	    <form action="addmicro1" method="post" enctype="multipart/form-data" name="form1" id="form1" >
	    <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />
		<input type="hidden" name="id2" value="<?php echo $_GET['id2'];?>" />
		
	    <div class="card-content">
		<div class="row">
		<h4>Select from Below if needed</h4>
		<?php
		$sql=mysqli_query($con,"select * from tblauditsection2 where sid='18'");
		while($row=mysqli_fetch_array($sql))
		{
		?>
	    <div class="col-md-12">
		<div class="form-group label-floating">
		<input type="checkbox" name="chk[]" value="<?php echo $row['id'];?>" /> - <?php echo $row['ques'];?>
		
		</div></div>
		<?php
		}
		?>
		<h4> Add New  if needed</h4>
		
		 <div class="col-12">
         <div class="form-group">
	   <input type="button" name="add_item" value="Add More" class="btn btn-info" onClick="addMore();" />
       <input type="button" name="del_item" value="Delete" class="btn btn-danger" onClick="deleteRow();" />
                              </div>
                             </div>	
							 
							 
							 </div>
							 
							 
							<div  id="product">
                           
                             
			                  <?php require_once("input.php") ?>
                            
                             </div>		
							 
        </div>
		
		
    <button type="submit" class="btn btn-primary pull-right">Submit</button>
    <div class="clearfix"></div>
    </div>
</form>


</div></div></div></div>
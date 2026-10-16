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
                              <h2> Microbiological Standard (Delete  Section)
							      <a href="admin.php?id=ps1&pid=<?php echo $_GET['pid'];?>"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
                           </div>
                        </div>
                     </div>
					 
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
		<div class="full graph_head">
	    <form action="deletemicro1" method="post" enctype="multipart/form-data" name="form1" id="form1" >
	    <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />
	    <div class="card-content">
		<div class="row">
		<h4>Select and Delete</h4>
		<?php
		$sql=mysqli_query($con,"select * from tblmicro where pid='$_GET[pid]'");
		while($row=mysqli_fetch_array($sql))
		{
		
			$sql1=mysqli_query($con,"select * from tblauditsection2 where id='$row[qid]'");
		     $row1=mysqli_fetch_array($sql1);
		
		?>
	    <div class="col-md-12">
		<div class="form-group label-floating">
		<input type="checkbox" name="chk[]" value="<?php echo $row['qid'];?>" /> - <?php echo $row1['ques'];?>
		
		</div></div>
		<?php
		}
		?>
	
		
    <button type="submit" class="btn btn-primary pull-right" onclick="return confirm('Are You Sure?');">Delete</button>
    <div class="clearfix"></div>
    </div>
</form>


</div></div></div></div>
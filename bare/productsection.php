    <?php
	
     $pid=$_GET['pid'];

     $queryy=mysqli_query($con,"select * from tblproduct1 where prodid='$pid'");
     $queryy1=mysqli_fetch_array($queryy);
	 
     ?>
  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Product Specifications (<?php echo $queryy1['prodname'];?>)<a href="admin.php?id=ps"><button class="btn btn-info" style="float:right">Go Back</button></a> </h2>
                           </div>
                        </div>
                     </div>
     <!-- row -->
							    <div class="card">
				                <div class="col-12">
                                <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2> </h2>
                                 </div>
								   <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                    <thead>
					 <tr>
                        <th>Sec Id </th>
                        <th>Section Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
					</thead>
					 <tbody>
<?php
$i=0;
$sql = mysqli_query($con,"select * from tblauditsection where name1='spec'");
while($row=mysqli_fetch_array($sql))
{
$gh1=mysqli_query($con,"select * from tblproductdetail where  pid='$pid'");
$match1=mysqli_num_rows($gh1);
if($match1>=9)
{
$gh2=mysqli_query($con,"update tblproduct1 set status1='waiting' where prodid='$pid'");
}
$i++;
$gh=mysqli_query($con,"select * from tblproductdetail where pid='$pid' and sid='$row[id]'");
$match=mysqli_num_rows($gh);

$gh1=mysqli_fetch_array($gh);
?>                   
      
	  <tr>
		
		  <td><?php echo $i;?>  </td>
        
		  <td style="padding-left:10px"><?php echo $row['name'];?></td>

    	 <td>
		 <?php
	     if($match>=1)
	     {
	     ?>
	    <button class="btn btn-warning"><?php echo $gh1['status'];?></button>
		<?php
		}
		else
		{
		?>
		<button class="btn btn-danger">Not Started</button>
		<?php
		}
		?>
		</td>
		
	   <td>
	   <?php
	   if($match>=1)
	   {
	   ?>
	   <a href="admin.php?id=pattemptaudit&sno=<?php echo $row['id'];?>&pid=<?php echo $pid;?>">
	   <button class="btn btn-warning"><?php echo $gh1['status'];?></button></a>
	   <?php
	   }
	   else
	   {
	   ?>
	     <a href="admin.php?id=pattemptaudit&sno=<?php echo $row['id'];?>&pid=<?php echo $pid;?>"><button class="btn btn-primary">Submit</button></a>	   
	  <?php
	   }
	   ?> 
	   </td>
	   
       </tr>
	<?php
	}
	?>


                                       </tbody>
                                        </table></div></div></div> </div> 
								 
								
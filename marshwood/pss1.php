<div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Product Specifications
							   <a href="admin.php?id=pss"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
				     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                    <thead>
					 <tr>
                        <th>Sec Id </th>
                        <th>Section Name</th>
                        <th>Status</th>
                        <th>Action</th>
						<th></th>
                      </tr>
	  </thead>
	  <tbody>
<?php
$prodid=$_GET['pid'];
$sql = mysqli_query($con,"select * from tblauditsection where name1='spec'");
$i=0;
while($row=mysqli_fetch_array($sql))
{

$i++;
$gh=mysqli_query($con,"select * from tblproductdetail where pid='$prodid' and sid='$row[id]' ");
$match=mysqli_num_rows($gh);
$gh1=mysqli_fetch_array($gh);
?>                   
        <tr>
        <td><?php echo $i;?>  </td>
        <td style="padding-left:10px"><?php echo $row['name'];?></td>
        <td><button class="btn btn-warning"><?php echo $gh1['status'];?></button></td>
 	    <td> 
		<?php 
		if($gh1['status']=="Rejected")
		{
		?>
		<button class="btn btn-danger"><?php echo $gh1['status'];?></button>
		<?php
		}
		else if($gh1['status']=="Accepted")
		{
		?>
	    <button class="btn btn-success"><?php echo $gh1['status'];?></button>
		<?php
		}
		else
		{
		?>
		<a href="admin.php?id=pattemptauditt&sno=<?php echo $row['id'];?>&sno1=<?php echo $gh1['id'];?>&pid=<?php echo $prodid;?>">
	    <button class="btn btn-warning">Click Here</button></a>
		<?php
		}
		?>
	     </td>
	   
	   
	   <td><?php echo $gh1['fresponse'];?></td>
       </tr>
	<?php
	}
	?>


                                       </tbody>
                                    </table>
									
                            </div></div>  </div> </div> 
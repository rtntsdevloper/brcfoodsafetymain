<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Records Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							 <a href="admin.php?id=addrecord"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="table dataTable-collapse" id="sales_table">
                                     <thead>
				         <tr>
						 
				        <th></th>
                       <th>Section</th>
					    <th>Sub-Section</th>
                       <th>Name</th>
                       <th>Detail</th>
					   <th>Link</th>
                       <th>Document</th>
                        
						 <th>Edit</th>
                 </tr>
					</thead>
					<tbody>
	 <?php
    $sql23=mysqli_query($con,"select * from tbldetail where typee='Compliance'");
	 $i=1;
	while($row23=mysqli_fetch_array($sql23))
	 {
      $hj=mysqli_query($con,"select * from subtest where sid='$row23[sid]'");
      $hj1=mysqli_fetch_array($hj);



							?>
					
                       <tr>
					   <td><?php echo $i;?></td>
					   <td><?php echo $hj1['subtest']; ?></td>
                       <td><?php echo $row23['fid']; ?></td>
					   <td><?php echo $row23['section'];?></td>
					   <td><?php echo $row23['detail'];?></td>
					   <td><?php echo $row23['linkk'];?></td>
                       <td> <a href="document/<?php echo $row23['img'];?>" target="_blank" tabindex="8" style="tab-index:5">  
					    <?php echo $row23['img'];?></a></td>
					  <td><a href="admin.php?id=editbrccompliance&sno=<?php echo $row23['id'];?>"><button class="btn btn-danger">Edit</button></a></td>
                      </tr>
					<?php
					$i++;
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Management</a></li>
                        <li>Corrective Actions</li>
                    </ul>
                </div>
				
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                             <h4 class="card-title mb-3">Corrective Actions</h4>
								
                                <p>Listt of Non-Conformance</p>
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
										<th>Sno</th>
                                            <th>Index</th>
                                            <th>Due</th>
                                            <th>Title</th>
											<th>Severity</th>
											<th>Status</th>
                                            
                                        </thead>
                                        <tbody>
										<?php
					        $query1=mysqli_query($con,"select * from action where status='Not Started' OR status='In Progress'");
					        $i=0;
							while($rows1=mysqli_fetch_array($query1))
							{
							$i++;
                                   ?>     
				   				     <tr>
									  <td><?php echo $i;?></td>
                    <td><?php echo $rows1['fid'];?></td>
                   <td> <?php echo date("d-m-Y", strtotime($rows1['deliver']));?></td>
                    <td><?php echo $rows1['title'];?></td>
					 <td><?php echo $rows1['ans'];?></td>
					  <td>
					<a data-toggle="modal"  class='clikmodal'  data-target="#actionmodal" data-tid='<?php echo $rows1['id'];?>'> 
					  <button class="btn btn-info btn-fill"><?php echo $rows1['status'];?></button></a></td>
                                            </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
</div>

<div class="modal fade" id="actionmodal" tabindex="-1" role="dialog" aria-labelledby="actionmodal" aria-hidden="true">
                        <div class="modal-dialog"  >
                            <div class="modal-content">
							 <div class="modal-body" id="modal-body4">
                                
								<?php
								include 'editaction.php';   
								?>         
							 
                               </div>
                            </div>
                        </div>
                    </div><script>
    $('.clikmodal').click(function(){
        var tid = $(this).attr('data-tid');
		
        $.ajax({url:"editaction.php?tid="+tid,cache:false,success:function(result)
		{
            $("#modal-body4").html(result);
        }});
    });
	</script>				 

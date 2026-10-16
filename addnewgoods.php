   <?php
	$cid=$_GET['cid'];
	?>
	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
			<script language="javascript">
		function cal()
		{
		var d1= document.getElementById("d1").value;
	
		
		$.post("addnewgoodsdetail",{d1: d1,cid:<?php echo $cid;?>}, 
		function(data) 
       { 
      $("#basket").html(data);
       });
		
		}
		</script>									
				
			       <div class="row mb-12">
                   <div class="col-md-12 mb-12">
                   <div class="card text-left">
                            <div class="card-body">
							
							
							 <div class="row">
                                    
								<div class="col-4" style="margin:10px">
                                                        <label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
														 <div class="input-group">
														 
                                                        <input type="date" name="d1"  id="d1" class="form-control" required />
                                                    </div> </div>
                                                        
                                                   
													
													
													
													
													<div class="col-2" style="margin:10px">
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														  <button class="btn btn-info" style="float:right" onclick="return cal();"><li class="fa fa-list"></li> Select & Go</button>
													</div></div>
								
									</div>		
								
								
							<a href="admin.php?id=goodsin"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							
							<br/>
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive" id="basket">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
				         <tr>
						 
				 <th></th>
                       <th>Date</th>
                       <th>Document Number</th>
                       <th>CSV</th>
					   <th>View</th>
                      
                 </tr>
					</thead>
					<tbody>
					         <?php
						
							  $sql=mysqli_query($con,"select * from tblcsv where status!='Done' order by date desc");
							  $i=0;
						      while($row=mysqli_fetch_array($sql))
						       {
							 $i++;
					           ?>
                      <tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
					  <td><?php echo $row['po']; ?></td>
                      <td><a href="csvdoc/<?php echo $row['img'];?>" target="_blank" > <?php echo $row['img'];?></a></td>
					  <td><a href="admin.php?id=addnewgoods3&sno=<?php echo $row['id'];?>&cid=<?php echo $cid;?>"><button class="btn btn-primary">View</button></a></td>
                      </tr>
					<?php
					}
					
					?>
					    </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>
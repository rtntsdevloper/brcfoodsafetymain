<?php
$sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from tbllegislation where id='$sno'");
$row=mysqli_fetch_array($sql);
?>
<script language="javascript">
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Legislation Detail </li>
                    </ul>
                </div>
		
				
			 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=legislation"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
					
	  <div class="row">
				  <div class="col-md-12">
                                <h4 class="card-title mb-2">
								Date: <?php echo date("d-m-Y",strtotime($row['date']));?>   , Title: <?php echo $row['name'];?>  </h4>
                           
                                <div class="row">
                                    <div class="col-4">
                                        <div class="list-group" id="list-tab" role="tablist">
										<?php
											
											$sql=mysqli_query($con,"select * from tbllegislation1 where sno='$sno'");
											$i=0;
											while($rows=mysqli_fetch_array($sql))
											{
											$i++;
											?>
	   <?php
											if($i=="1")
											{
											?>
											
								<a class="list-group-item list-group-item-action active" id="list-home-list<?php echo $rows['id'];?>" data-toggle="list" href="#list-home<?php echo $rows['id'];?>" role="tab"  aria-controls="list-home<?php echo $rows['id'];?>"> <?php echo $rows['name'];?></a>										
										<?php
										}
										else
										{
										?>
								<a class="list-group-item list-group-item" id="list-home-list<?php echo $rows['id'];?>" data-toggle="list" href="#list-home<?php echo $rows['id'];?>" role="tab"  aria-controls="list-home<?php echo $rows['id'];?>" onclick="topFunction()"> <?php echo $rows['name'];?></a>
										<?php
										}
										}
										?>
				
			                     	</div>
                                    </div>
                                    <div class="col-8" >
                                        <div class="tab-content" id="nav-tabContent" >
										 <div class="tab-pane fade show active" id="list-home1" role="tabpanel" aria-labelledby="list-home-list1">
				
				                 <?php
								$sql2r=mysqli_query($con,"select * from tbllegislation1 where sno='$sno' order by id ASC limit 1");
								while($row2r=mysqli_fetch_array($sql2r))
								{
								?>
										<ul class="list-group">
				 <li class="list-group-item d-flex justify-content-between align-items-center">
								 <div class="col-1">
								 </div> 
								  <div class="col-11">
								  <?php echo $row2r['description'];?>   
								  </div>
								  </li></a>
                                </ul>
								  
								
									<?php
									}
									?>   
									   </div>
									   
										
				  			   <?php
							$sql2=mysqli_query($con,"select * from tbllegislation1 where sno='$sno' ");
							while($row2=mysqli_fetch_array($sql2))
							{
							?>	
					<div class="tab-pane fade" id="list-home<?php echo $row2['id'];?>" role="tabpanel" aria-labelledby="list-home-list<?php echo $row2['id'];?>">
								 <ul class="list-group">
				 <li class="list-group-item d-flex justify-content-between align-items-center">
				 <div class="col-1">
				 </div> 
				 <div class="col-11">
								
				 <?php echo $row2['description'];?>   
							
							</div>
								  </li></a>
                                </ul>
							
								
									   </div>
				<?php
				}											
				?>
                                        </div>
                                    </div>
                                </div><a href="#" onclick="topFunction()"><button class="btn btn-danger" style="float:right; margin-left:15px">&uarr; Go Top</button></a>
                            </div>
                        </div>	
                    </div></div>
					
				
	
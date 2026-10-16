 <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2">BRC Version 9</h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Audit Management</li>
                    </ul>
                </div>

 
 <div class="col-md-12">
                        <div class="card text-left">
                            <div class="card-body">
                                <h4 class="card-title mb-2">Requirements</h4>
                                <p>Each main section or subsection of the requirements in the Standard begins with a statement of intent. This sets
out the expected outcome of compliance with the requirements of that section. This forms part of the audit and
all companies must comply with the statements of intent.</p>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="list-group" id="list-tab" role="tablist">
										<?php
											
											$sql=mysql_query("select * from addtest1");
											$i=0;
											while($rows=mysql_fetch_array($sql))
											{
											$i++;
											if($rows['testid']=="1")
											{
											?>
											
<a class="list-group-item list-group-item-action active" id="list-home-list<?php echo $i;?>" data-toggle="list" href="#list-home<?php echo $i;?>" role="tab"  aria-controls="list-home<?php echo $i;?>"> 
<?php
}
else
{
?>
<a class="list-group-item list-group-item" id="list-home-list<?php echo $i;?>" data-toggle="list" href="#list-home<?php echo $i;?>" role="tab"  aria-controls="list-home<?php echo $i;?>" ></a>
<?php
}
?>

<?php echo $rows['subject'];?>

</a>
										<?php
										}
										
										?>
				
				
				
				</div>
                                    </div>
                                    <div class="col-8">
                                        <div class="tab-content" id="nav-tabContent">
										
										 
				  <div class="tab-pane fade show active" id="list-home1" role="tabpanel" aria-labelledby="list-home-list1">
				
				  <?php
								$sql2r=mysql_query("select * from subtest where tid='1'");
										while($row2r=mysql_fetch_array($sql2r))
										{
										?>
										
								  <ul class="list-group">
                                 <a href="admin.php?id=audit1&sno=<?php echo $row2r['tid'];?>&sid=<?php echo $row2r['sid'];?>" > 
								  <li class="list-group-item d-flex justify-content-between align-items-center">
								  <div class="col-1">
								 <span class="badge badge-primary badge-pill"><?php echo $row2r['sid'];?></span></div> 
								  <div class="col-11"><?php echo $row2r['subtest'];?></div>
								  </li></a>
                                   
                                </ul>
									<?php
									}
									?>   
									   </div>
									   
									   
									   
									   
										<?php
											$sql1=mysql_query("select * from subtest ");
										while($row=mysql_fetch_array($sql1))
										{
											?>
				  <div class="tab-pane fade" id="list-home<?php echo $row['tid'];?>" role="tabpanel" aria-labelledby="list-home-list<?php echo $row['tid'];?>">
				
				  <?php
								$sql2=mysql_query("select * from subtest where tid='$row[tid]' and ssid=''");
										while($row2=mysql_fetch_array($sql2))
										{
										?>
										
								  <ul class="list-group">
                                 <a href="admin.php?id=audit1&sno=<?php echo $row2['tid'];?>&sid=<?php echo $row2['sid'];?>" > 
								  <li class="list-group-item d-flex justify-content-between align-items-center">
								  <div class="col-1">
								 <span class="badge badge-primary badge-pill"><?php echo $row2['sid'];?></span></div> 
								  <div class="col-11">
								  	<?php echo $row2['subtest'];?>
								  </div></li></a>
                                   
                                </ul>
									<?php
									}
									?>   
									   </div>
											
											<?php
											}
											?>
												
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div>
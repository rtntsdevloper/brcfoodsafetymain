
	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2">BRCGS Version 9</h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>BRC Compliance</li>
                    </ul>
                </div>
				 
				 
				 <div class="col-lg-12 col-xl-12 mb-12">
                        <div class="card">
                            <div class="card-body">
                                
								<div class="ul-widget__head">
                                    <div class="ul-widget__head-label">
                                        <h3 class="ul-widget__head-title">Audits </h3>
                                    </div>
                                    <div class="ul-widget__head-toolbar">
                                      <ul class="nav nav-tabs" id="dropdwonTab" role="tablist">
                                           
                                           
									 <li class="nav-item active show"><a class="nav-link active show" data-toggle="tab" href="#1" role="tab" aria-selected="true">Senior management commitment</a></li>
									 
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#2" role="tab" aria-selected="false">The food safety plan - HACCP</a></li>
									 
									 <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#3" role="tab" aria-selected="false">Food safety and quality management system</a></li>
                                        </ul>
                                    </div>
                                </div>
								
								
                                <div class="ul-widget__body">
                                  <div class="tab-content">
									 <?php
				 $sql2=mysql_query("select * from addtest1");
							while($row2=mysql_fetch_array($sql2))
							{
							?>
                                        <div class="tab-pane" id="<?php echo $row2['testid'];?>">
										
<div class="ul-widget-s6__items">
	
	
	 <div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-warning ul-widget6__dot"></p>
                                                    </span><p class="ul-widget-s6__text">Senior management commitment
													
													<span class="badge badge-pill badge-primary m-2">1</span>
													
													
													</p><span class="ul-widget-s6__time">1</span></div>
	
	<div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-info ul-widget6__dot"></p>
                                                    </span>
							<p class="ul-widget-s6__text">Senior management commitment and continual improvement <span class="badge badge-pill badge-warning m-2">1.1</span> </p>
							
							
							
							<span class="ul-widget-s6__time">1.1</span></div>								
<?php
$sql=mysql_query("select * from subtest1 where tid='$row2[testid]'");
while($row=mysql_fetch_array($sql))
{
?>
<?php
if($row['status']=="1")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-warning ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-warning m-2">In process</span></p>
<span class="ul-widget-s6__time">Updated on 11-02-2021</span>
 </div>
 <?php
 }
 else if($row['status']=="0")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-danger ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-danger m-2">Pending </span></p>
<span class="ul-widget-s6__time">Not updated yet</span>
 </div>
<?php
}
else if($row['status']=="2")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-success ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-success m-2">Done </span></p>
<span class="ul-widget-s6__time">Updated on 11-02-2021</span>
 </div>

<?php
}
else
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-light ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-light m-2">Not Started </span></p>
<span class="ul-widget-s6__time">Not updated yet</span>
 </div>

<?php
}
?>
 <?php
 }
 ?>
 
 </div>
                                        </div>
                                      
				<?php
				}
				?>					  
									  
									  
									  
									  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
                    </div>
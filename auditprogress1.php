<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<style>

@charset "UTF-8";
.circle1 
{
  margin: -12px -12px 0;
  height: 30px;
  width: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border:1 px;
  transition: 0.4s ease; 
  border-radius: 14px;
  flex: 999;
  line-height: 14px;
   z-index:3;
}
.progresshtml > li > i 
{
   padding: 5px 10px;
  border-radius: 5px;
  border-top-left-radius: 0;
  background: #eee;
  transition: 0.5s background;
  position: absolute;
  width: 100px;
  margin: -7px 0 0 20px;
  font-style: normal;
 }
@media only screen and (min-width: 640px)
 {
  .progresshtml > li > i {
    border-top-left-radius: 5px;
    text-align: center;
  }
}
.progresshtml > li > i:after {
  transition: 0.5s border-color;
  content: "";
  display: block;
  position: absolute;
  top: 0;
  right: 100%;
  margin-right: -5px;
  border: 5px solid transparent;
  border-top-color: #eee;
}
@media only screen and (min-width: 640px) {
  .progresshtml > li > i:after {
    top: auto;
    left: 50%;
    bottom: 100%;
    right: auto;
    margin-left: -5px;
    margin-right: 0;
    border-color: transparent;
    border-bottom-color: #eee;
  }
}
@media only screen and (min-width: 640px) {
  .progresshtml > li > i {
    margin: 10px 0 0 -50px;
  }
}
.progresshtml > li > i:before {
  counter-increment: point;
  content: counter(point) ".";
}

.progresshtml {

  counter-reset: point;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  flex: 1 0;
  position: relative;
  margin: auto;
  padding: 0;
  list-style: none;
  color: #999;
}
@media only screen and (min-width: 640px) {
  .progresshtml {
    flex-direction: row;
    width: 80%; 
  }
}
.progresshtml:before, .progresshtml:after {
   content: "";
  display: block;
  position: absolute;
  left: -2px;
  top: 0;
 z-index:-1;
  
}
@media only screen and (min-width: 640px) {
  .progresshtml:before, .progresshtml:after {
    left: 0;
    top: -2px;
    height: 4px;
  }
}
.progresshtml:before {
  width: 4px;
  height: 100%;
  background: #ccc;
}
@media only screen and (min-width: 640px) {
  .progresshtml:before {
    width: 100%;
    height: 4px;
  }
}
.progresshtml:after {
  transition: 0.5s height;
  width: 4px;
  background: #f00;
}
@media only screen and (min-width: 640px) {
  .progresshtml:after {
    transition-property: width;
  }
}
.progresshtml[data-progresshtml="4"] > li:nth-child(-n+5), .progresshtml[data-progresshtml="3"] > li:nth-child(-n+4), .progresshtml[data-progresshtml="2"] > li:nth-child(-n+3), .progresshtml[data-progresshtml="1"] > li:nth-child(-n+2), .progresshtml[data-progresshtml="0"] > li:nth-child(-n+1) {
  color: #666;
}
.progresshtml[data-progresshtml="4"] > li:nth-child(-n+5):before, .progresshtml[data-progresshtml="3"] > li:nth-child(-n+4):before, .progresshtml[data-progresshtml="2"] > li:nth-child(-n+3):before, .progresshtml[data-progresshtml="1"] > li:nth-child(-n+2):before, .progresshtml[data-progresshtml="0"] > li:nth-child(-n+1):before {
  box-shadow: 0 0 0 3px #666, 0 0 0 5px #fff;
}

.progresshtml[data-progresshtml="4"] > li:nth-child(-n+4):before, .progresshtml[data-progresshtml="3"] > li:nth-child(-n+3):before, .progresshtml[data-progresshtml="2"] > li:nth-child(-n+2):before, .progresshtml[data-progresshtml="1"] > li:nth-child(-n+1):before, .progresshtml[data-progresshtml="0"] > li:nth-child(-n+0):before {
  background: #666;
}

.progresshtml[data-progresshtml="4"] > li:nth-child(5) > i, .progresshtml[data-progresshtml="3"] > li:nth-child(4) > i, .progresshtml[data-progresshtml="2"] > li:nth-child(3) > i, .progresshtml[data-progresshtml="1"] > li:nth-child(2) > i, .progresshtml[data-progresshtml="0"] > li:nth-child(1) > i {
  background:#FFCC00;
}
.progresshtml[data-progresshtml="4"] > li:nth-child(5) > i:after, .progresshtml[data-progresshtml="3"] > li:nth-child(4) > i:after, .progresshtml[data-progresshtml="2"] > li:nth-child(3) > i:after, .progresshtml[data-progresshtml="1"] > li:nth-child(2) > i:after, .progresshtml[data-progresshtml="0"] > li:nth-child(1) > i:after {
  border-top-color: #ccc;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="4"] > li:nth-child(5) > i:after, .progresshtml[data-progresshtml="3"] > li:nth-child(4) > i:after, .progresshtml[data-progresshtml="2"] > li:nth-child(3) > i:after, .progresshtml[data-progresshtml="1"] > li:nth-child(2) > i:after, .progresshtml[data-progresshtml="0"] > li:nth-child(1) > i:after {
    border-color: transparent;
    border-bottom-color: #ccc;
  }
}

.progresshtml[data-progresshtml="0"]:after {
  height: 0%;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="0"]:after {
    height: 4px;
    width: 0%;
  }
}
.progresshtml[data-progresshtml="1"]:after {
  height: 25%;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="1"]:after {
    height: 4px;
    width: 25%;
  }
}
.progresshtml[data-progresshtml="2"]:after {
  height: 50%;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="2"]:after {
    height: 4px;
    width: 50%;
  }
}
.progresshtml[data-progresshtml="3"]:after {
  height: 75%;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="3"]:after {
    height: 4px;
    width: 75%;
  }
}
.progresshtml[data-progresshtml="4"]:after {
  height: 100%;
}
@media only screen and (min-width: 640px) {
  .progresshtml[data-progresshtml="4"]:after {
    height: 4px;
    width: 100%;
  }
}
* {
  box-sizing: inherit;
}
.demo 
{
  flex: 1;
  display: flex;
  flex-direction: column;
  position: relative;
  height: 75%;
  width:100%;
  margin: auto;
  font-size: 12px;
   z-index:1;
}
@media only screen and (min-width: 640px) {
  .demo {
    height: auto;
  }
}

</style>

<div class="fg" style="height: 200vh;  box-sizing: border-box; ">

<!-- partial:index.partial.html -->
<div class="demo">

  <ol class="progresshtml" data-progresshtml="0" >
 <?php
 include 'connection.php';
		$sql=mysqli_query($con,"select * from addtest1");
		while($row=mysqli_fetch_array($sql))
		{
		?>
		<?php 
		if($row['status']=="0")
     {
	 ?>
    <li><a href="admin.php?id=auditprogress&sno=<?php echo $row['testid'];?>"><div class="circle1" style="background:#FF0000; color:#FFFFFF;   box-shadow: 0 0 0 2px #000;"><?php echo $row['testid'];?></div></a><i><?php echo $row['subject'];?></i> </li> 
	<?php
	}
	else if($row['status']=="1")
	{
	?>
	 <li><a href="admin.php?id=auditprogress&sno=<?php echo $row['testid'];?>"><div class="circle1" style="background:#FFC107; color:#FFFFFF;  box-shadow: 0 0 0 2px #000;"><?php echo $row['testid'];?></div></a><i><?php echo $row['subject'];?></i> </li> 
	<?php
	}
	else if($row['status']=="2")
	{
	?>
	 <li><a href="admin.php?id=auditprogress&sno=<?php echo $row['testid'];?>"><div class="circle1" style="background:#4CAF50; color:#FFFFFF;box-shadow: 0 0 0 2px #000;"><?php echo $row['testid'];?></div></a><i><?php echo $row['subject'];?></i> </li> 
	<?php
	}
	else
	{
	?>
	 <li><a href="admin.php?id=auditprogress&sno=<?php echo $row['testid'];?>"><div class="circle1" style="background:#CCCCCC; color:#999999"><?php echo $row['testid'];?></div></a><i><?php echo $row['subject'];?></i> </li> 
	<?php
	}
	?>
	
   
    <?php
	}
	?>
  </ol>
  

</div>
 <div class="card-body"></div> <div class="card-body"></div> <div class="card-body"></div>
   <?php
  $sql2rr=mysqli_query($con,"select * from addtest1");
  while($row2rr=mysqli_fetch_array($sql2rr))
  {
		
  							
								  $qry=mysqli_query($con,"select * from subtest1 where tid='$row2rr[testid]' ");
								   $mtch=mysqli_num_rows($qry);
									
								$tyu=mysqli_query($con,"select distinct ssid from tblcmp where tid='$row2rr[testid]'   ");
							    $yes=mysqli_num_rows($tyu);
							  
							  $tyu1=mysqli_query($con,"select * from   tblcmp where tid='$row2rr[testid]'   ");
										 $gh=mysqli_fetch_array($tyu1);
										
										//$tyu1=mysqli_query($con,"select * from tblcmp where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$row2[fid]'");
										//$no=mysqli_num_rows($tyu1);
										
										 $totalyes=round($yes*100/$mtch);
										//$totalno=round($no*100/$mtch);
									
									$datetime1 = new DateTime(date('Y-m-d'));
$datetime2 = new DateTime($gh['date']);
$interval = $datetime1->diff($datetime2);
 $interval->format('%a');									
?>
 <?php
											if($totalyes>=1)
											{
											?>   
    
	
	<a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>">
	<div class="card-body">
    <h6 class="mb-2 text-muted"><?php echo $row2rr['subject'];?></h6>
    <p class="mb-1 text-22 font-weight-light"><?php echo $totalyes;?>%</p>
    <div class="progress mb-1" style="height: 4px">
                                    <div class="progress-bar bg-warning" style="width:<?php echo $totalyes;?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div><small class="text-muted">Updated <?php echo  $interval->format('%a');?> day ago</small>
								<br/><a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>">
								<button class="btn btn-outline-warning m-1">View Report</button></a>
                            </div></a>
							
	<?php
	}
	else if($totalyes>=100)
											
											{
											?>   
    
	
	 <a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>"> <div class="card-body">
                              
							    <h6 class="mb-2 text-muted"><?php echo $row2rr['subject'];?></h6>
                                <p class="mb-1 text-22 font-weight-light"><?php echo $totalyes;?>%</p>
                                <div class="progress mb-1" style="height: 4px">
       <div class="progress-bar bg-success" style="width:<?php echo $totalyes;?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div><small class="text-muted">Updated <?php echo  $interval->format('%a');?> day ago</small>
								
								
								<br/><a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>">
								<button class="btn btn-outline-success m-1">View Report</button></a>
								
								
                            </div></a>
							
<?php
}
else if($totalyes<=0)
{
?>   
 <a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>"> 
  <div class="card-body">
                             
							   <h6 class="mb-2 text-muted"><?php echo $row2rr['subject'];?></h6>
                                <p class="mb-1 text-22 font-weight-light">0%</p>
                                <div class="progress mb-1" style="height: 4px">
                                    <div class="progress-bar bg-warning" style="width:0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div><small class="text-muted">Not Updated Yet</small>
								
								<br/><a href="admin.php?id=auditprogress&sno=<?php echo $row2rr['testid'];?>">
								<button class="btn btn-outline-warning m-1">View Report</button></a>
                            </div></a>
							
	<?php
	}
	
	}
	?>
										
<!-- partial -->
  

</div>

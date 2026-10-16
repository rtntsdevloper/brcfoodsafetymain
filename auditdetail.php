  
  
  <?php
  
    $cyear=date("Y");
	
	
  if(isset($_GET['year']))
		{
		
		$yr=$_GET['year'];
		
		
		if($yr==$cyear)
		{
		$date=$yr."-".date("m")."-01";
		}
		else
		{
		$date=$yr."-01-01";
		}
		}
		else
		{
	    $yr=date("Y");
		$date=$yr."-".date("m")."-01";
		}
		 $year=date("Y",strtotime($date));
		
		
		
		$pre=$yr-1;
		$nxt=$yr+1;
		
		
		
		
		?>
		
  <script  src="assets/style.css"></script>
						  
 <div class="main-content">
  <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Dashboard</a></li>
                        <li>Detail</li>
                    </ul>
                </div>
				
         <div class="col-md-12">
             <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=auditorassign">
							<button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
							</a>	
							
							
							
							<a href="admin.php?id=auditdetail&year=<?php echo $nxt;?>">
							<button class="btn btn-danger" style="float:right; margin-left:15px">Next Year</button>
							</a>		
							<a href="admin.php?id=auditdetail&year=<?php echo $pre;?>">
							<button class="btn btn-danger" style="float:right; margin-left:15px">Previous Year</button>
							</a>	
							
												
                                <h4 class="card-title mb-2">Details</h4>
                                <div class="row">
<link rel="stylesheet" href="assets/style.css">
<!-- partial:index.partial.html -->

<div class="row justify-content-center align-items-center"  style="margin-top:20px">
<!-- DISPLAY USER SCHEDULER-->
<div class="table-responsive">
  <div data-parse="1595877840000" id="calplaceholder" >
    <div class="cal-sectionDiv">
      <table class="table table-striped table-bordered" >
        <thead class="cal-thead">
          <tr>
            <th class="cal-viewmonth" id="changemonth">Year <?php echo $year;?></th>
            <th class="cal-toprow">Jan</th>
            <th class="cal-toprow">Feb</th>
            <th class="cal-toprow">Mar</th>
            <th class="cal-toprow weekend">Apr</th>
            <th class="cal-toprow weekend">May</th>
            <th class="cal-toprow">June</th>
            <th class="cal-toprow">July</th>
            <th class="cal-toprow">Aug</th>
            <th class="cal-toprow">Sep</th>
            <th class="cal-toprow">Oct</th>
            <th class="cal-toprow weekend">Nov</th>
            <th class="cal-toprow weekend">Dec</th>
          </tr>
        </thead>
        <tbody class="cal-tbody">
		<?php 
		 
		$sql=mysqli_query($con,"select * from addtest1");
		while($row=mysqli_fetch_array($sql))
		{
		?>
         
		 <tr id="h16">
          <td class="cal-usersheader" style="color:#fff; background-color:<?php echo $row['bgcolor'];?>; padding: 0px;"><?php echo $row['testid'];?></td>
          <td colspan="31" style="color:#FFFFFF; background-color:<?php echo $row['bgcolor'];?>;"><?php echo $row['subject'];?></td>
          </tr>
		  
		  <?php
		  $sql1=mysqli_query($con,"select distinct auditor from  tblroster where tid='$row[testid]' and year(date)='$year'");
		  while($row1=mysqli_fetch_array($sql1))
		  {
		  ?>
          <tr id="u1">
          <td class="cal-userinfo">
              <span>
			  <b style="text-decoration: underline">
			  <?php 
			  $sh=mysqli_query($con,"select * from tblauditor where id='$row1[auditor]'");
              $hj=mysqli_fetch_array($sh);
			   echo $hj['name'];
			  ?>
				</b>
			  <span></span></span>
              <div class="cal-usercounter">
                <span class="cal-userbadge badge badge-light"></span> </div>
              <div class="cal-userarrows">
                <i class="up mdi mdi-arrow-up-bold"></i><i class="down mdi mdi-arrow-down-bold"></i>  
			 </div>
			</td>
			
			
			<?php
			for($m=01; $m<=12; ++$m)
			{
			if($m>=1 && $m<=9)
			{
			$m="0".$m;
			}
			
			
			?>
			<td class="ui-droppable" data-date="1/7/2020" data-userid="1">
			 
			     <?php
				$sql2=mysqli_query($con,"select * from tblroster where auditor='$row1[auditor]'  and tid='$row[testid]' and month='$m' and year(date)='$year'");
				$row2=mysqli_fetch_array($sql2);
				$match=mysqli_num_rows($sql2);
				?>
				<?php
				if($match>=1)
				{
				$sql3=mysqli_query($con,"select * from tblroster where auditor='$row1[auditor]'  and tid='$row[testid]' and month='$m' and year(date)='$year' and status1='In Progress'");
				$match1=mysqli_num_rows($sql3);
				
				$sql4=mysqli_query($con,"select * from tblroster where auditor='$row1[auditor]'  and tid='$row[testid]' and month='$m'  and year(date)='$year' and status1='waiting'");
				$match2=mysqli_num_rows($sql4);
				
				$sql5=mysqli_query($con,"select * from tblroster where auditor='$row1[auditor]'  and tid='$row[testid]' and month='$m' and year(date)='$year' and status1='Done'");
				$match3=mysqli_num_rows($sql5);
				
				
				if($match1>=1)
				{
				//in ptorgress
				?>
				
			  <div class="drag details ui-draggable ui-draggable-handle" data-taskid="13956" data-userid="1" style="border-left:5px solid rgb(255,204,0);position:relative;">
                <h3 class="details-task" style="background:#FFCC00; color: #FFF">In Progress</h3>
                <div class="details-uren">
            <a href="#" data-toggle="modal"  class='modalButton'  data-target="#myModal2"  data-fid='<?php echo $row2['tid'];?>' data-month='<?php echo $row2['month'];?>' data-auditor='<?php echo $row1['auditor'];?>' data-year='<?php echo $date;?>' > View  <?php echo $row2['sid'];?></a>
	   </div>
              </div>
			  <?php
			  }
				else if($match2>=1)
				{
				//in waiting
				if($row2['date']>=$date)
				{
				$color="#2473AB";
				$txt="Due";
				$bg="36, 115, 171";
				}
				else if($row2['date']<$date)
				{
				$color="#C10000";
				$txt="Over Due";
				$bg="193,0,0";
				}
			
				?>
				
			<div class="drag details ui-draggable ui-draggable-handle" data-taskid="13956" data-userid="1" style="border-left:5px solid rgb(<?php echo $bg;?>);position:relative;">
                <h3 class="details-task" style="background:<?php echo $color;?>; color: #FFF"><?php echo $txt;?></h3>
                <div class="details-uren">
            <a href="#" data-toggle="modal"  class='modalButton'  data-target="#myModal2"  data-fid='<?php echo $row2['tid'];?>' data-month='<?php echo $row2['month'];?>' data-auditor='<?php echo $row1['auditor'];?>' data-year='<?php echo $date;?>' > View  <?php echo $row2['sid'];?></a>
	   </div>
              </div>
			  <?php
			  }
			  else if($match3==$match)
				{
				//in waiting
				?>
				
			  <div class="drag details ui-draggable ui-draggable-handle" data-taskid="13956" data-userid="1" style="border-left:5px solid rgb(102,153,0);position:relative;">
                <h3 class="details-task" style="background:#669900; color: #FFF">Done</h3>
                <div class="details-uren">
            <a href="#" data-toggle="modal"  class='modalButton'  data-target="#myModal2"  data-fid='<?php echo $row2['tid'];?>' data-month='<?php echo $row2['month'];?>' data-auditor='<?php echo $row1['auditor'];?>' data-year='<?php echo $date;?>'> View  <?php echo $row2['sid'];?></a>
	   </div>
              </div>
			  <?php
			  }
			  ?>
			  
			  
			  <?php
			  }
			  ?> 
			  
			  </td>
                <?php
                }
                 ?>
			 
			</tr>
			
			   <?PHP
			   }
			   ?>
			   
          </tr>
		  <?php
		  }
		  ?>
		  
		  
		  <script>
    $('.modalButton').click(function()
	{
        var teacherid = $(this).attr('data-fid');
		 var month = $(this).attr('data-month');
		  var auditor = $(this).attr('data-auditor');
		    var year = $(this).attr('data-year');
		
        $.ajax({url:"auditdetailviews.php?sid="+teacherid+"&month="+month+"&auditor="+auditor+"&year="+year,cache:false,success:function(result)
		{
             $("#modal-body3").html(result);
        }});
    });
	</script>
	
	
		  
		  <!-------2nd----------->
         
        
		
		 <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2" aria-hidden="true">
                        
							 <div class="modal-body" id="modal-body3">
								<?php
								include 'auditdetailviews.php';   
								?>         
						</div>
                           
                    </div>
		  
		  <!----------- 2nd End ->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DISPLAY MODAL: EDIT -->


<!-- DISPLAY MODAL: DELETE -->
<!-- partial -->


<?php
$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '1'");
$roww = mysqli_fetch_assoc($sqq);
  if(!empty($roww['issuedate'] && $roww['issuedate']!='0000-00-00')){
	$issueDate = date('d/m/Y', strtotime($roww['issuedate']));
}else{
	$issueDate = '';
}
?>


  						<table border="1" cellpadding="7" width="100%">
  							<tr>
  								<td width="20%">Issue date: <?php echo $issueDate; ?></td>
  								<td width="20%">Version No: <?php echo $roww['version']; ?></td>
  								<td width="20%">Authorised by: <?php echo $roww['author'];?> </td>
  							
  								<td width="20%">Doc ref : <?php echo $roww['refno']; ?></td>
  							
  								<td width="20%">Authorised by: <?php echo $roww['authoriesby']; ?></td>
  							</tr>
  						</table>
<script  src="assets/script.js"></script>


							</div></div></div></div></div>
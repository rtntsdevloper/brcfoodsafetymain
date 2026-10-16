
<?php 
$sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from tblmarination where id='$sno'");
$row=mysqli_fetch_array($sql);

$sql1=mysqli_query($con,"select * from tblrecipe where id='$row[name]'");
$rows=mysqli_fetch_array($sql1);
											
	$date= date('d-m-Y', strtotime($row['date']));
	$temp=$row['temperature'];
	$tray=$row['tray'];
	$wrap=$row['wrap'];
	$name=$rows['name'];
	$qty=$row['quantity'];
	$batchcode=$row['batchcode'];
	
	
 $useby= date('d-m-Y', strtotime($row['useby']));
											
?>
  <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Home /  Production Detail </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
		
		<div  class="col-xl-12" style="margin-bottom:20px">
		<a href="admin.php?id=marination"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>
		</div>
		

 <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 style="color:#990000"><?php echo $name;?></h4>
                        <h5 style="color:#FF0000">Used By: <?php echo $useby;?></h5>
                    </div>
					
					
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped">
							
							 <thead>
							 
                                        <tr>
										<th colspan="5"><label style="color:#0000CC">Date: </label> <?php echo $date;?>, <label style="color:#0000CC">Batchcode:</label> <?php echo $batchcode;?>, <label style="color:#0000CC">Name:</label> <?php echo $name;?>, <label style="color:#0000CC">Quantity:</label> <?php echo $qty;?> </th>
                                        </tr>
										<tr>
										<th colspan="5"><label style="color:#0000CC">Temperature:</label> <?php echo $temp;?>, <label style="color:#0000CC">Tray Batchcode:</label> <?php echo $tray;?>, <label style="color:#0000CC">Top Film Batchcode:</label> <?php echo $wrap;?> </th></tr>
										<tr><th colspan="5"><label style="color:#0000CC">Start Time:</label> <?php echo date('H:i', strtotime($row['stime']));?>, <label style="color:#0000CC">End Time:</label> <?php echo date('H:i', strtotime($row['etime']));?> </th>
                                        </tr>
                                    </thead>
									
									
									
                                <thead>
                                        <tr>
										<th></th>
										    <th>Ingredient</th>
											 <th>Quantity</th>
                                            <th>UB/BB</th>
											
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
								
									$sql1=mysqli_query($con,"select * from tblmarination1 where cid='$sno'");
									$i=0;
									while($row1=mysqli_fetch_array($sql1))
									{
									$i++;
									?>
									
									<?php
								
if($row1['product'])
$date1 =  $row1['useby'];
$date2 = $row1['useby']; 
  
  $useby="";
if ($date1 > $date2)
{ 
    $useby=$date1;
	}
else
{
    $useby=$date2; 
	}


?>

									
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo $row1['product'];?></td>
										  <td><?php echo $row1['totalqty'];?> <?php echo $row1['qty1'];?></td>
										  <td><?php echo $row1['useby'];?>: <?php echo date('d-m-Y',strtotime($row1['useby1']));?></td>
										   
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
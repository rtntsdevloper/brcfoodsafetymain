<?php
	$r=mysqli_query($con,"select * from attempt where username='$staffid'");
    $num=mysqli_num_rows($r);
    // echo $num;

?>

<div class="main-content">
                <div class="breadcrumb">
               
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>User Management </li>
                    </ul>
                </div>
                <div class="container " style="margin-top:100px;">
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                            <?php if($num<=1){?>

							<a href="admin.php?id=warehouse1"><button class="btn btn-danger" style="float:right">Attempt New </button></a><?php }?>
                             <h4 class="card-title mb-3">Test</h4>
                                <!-- <p>List of staff</p> -->
								
                                <div class="table-responsive">
                                  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Unit-no</th>
                                                <th scope="col">location</th>
                                                <th scope="col">contract no</th>
                                                <th scope="col">view</th>

											
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$sql=mysqli_query($con,"select * from attempt where username='$staffid'");
										$sqll=mysqli_query($con,"select * from response ");
                                        $ro=mysqli_fetch_array($sqll);
										$i=0;
										while($row=mysqli_fetch_array($sql))
										{
										$i++;
                                        $sqll=mysqli_query($con,"select * from response  where ide='$row[ide]'");
                                        $ro=mysqli_fetch_array($sqll);
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo $row['company_name'];?> </td>
                                               <td><?php echo $row['unit_no'];?></td>
                                                <td><?php echo $row['location'];?> </td>
												<td><?php echo $row['contractno'];?> </td>
                                                <?php if(!isset($ro['answer'])){ ?>
												<td> <a href="admin.php?id=start_test&ide=<?php echo $row['ide'];?>">
												<button class="btn btn-primary" type="button"><i class="fa fa-test">Attempt Test</i></button>
												</a> </td>
											
                                            <?php }else{?>


                                               
												<td>
												 <a href="view_test_report.php?ide=<?php echo $row['ide'];?>">
												<button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
												</a></td><?php }?>
                                            </tr>
                                           <?php
}
										   ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div></div>
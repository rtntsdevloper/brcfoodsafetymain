<?php
$sno=$_GET['sno'];
$sno1=$_GET['sno1'];
$sid=$_GET['sid'];
											
											$sql=mysqli_query($con,"select * from tblcompliance1 where id='$sno' and sno='$sno1' and sid='$sid'");
											$rows=mysqli_fetch_array($sql);
											?>
											
	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">BRC Compliance</a></li>
                        <li>General Compliance</li>
                    </ul>
                </div>
				        <div class="col-md-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=brccompliance1&sno=<?php echo $sno1;?>&sid=<?php echo $sid;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							
                                <h4 class="card-title mb-2">Name: <?php echo $rows['name'];?></h4>
                                <p>Detail: <?php echo $rows['detail'];?></p>
                                <div class="col-8 offset 2">
								
                                    <iframe src="document/<?php echo $rows['document'];?>#toolbar=0" style="width:100%;height:700px;" id="myFrame"></iframe>
                              
                                </div>
                            </div>
                        </div>
                    </div></div>
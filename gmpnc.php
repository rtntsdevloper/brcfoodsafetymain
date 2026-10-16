<?php
$sql = mysqli_query($con, "select * from tblauditsection where (name!='GMP Audit' &&  name!='GHP Audit') and name1='audit'");
while ($row = mysqli_fetch_array($sql)) {
	$sql1 = mysqli_query($con, "select * from tblauditsection2 where sid='$row[id]'");
	while ($row1 = mysqli_fetch_array($sql1)) {

		$sql5 = mysqli_query($con, "update tblauditsection2 set number='date' where id='$row1[id]' ");

		$sql2 = mysqli_query($con, "delete from tblauditsection3 where qid='$row1[id]'");
		$sql3 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1[id]','Satisfactory','Completed')");
		$sql4 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1[id]','Unsatisfactory','Completed')");
	}
}
?>


<?php
$sqlw = mysqli_query($con, "select * from tblauditsection where (name='GMP Audit' || name='GHP Audit') and name1='audit'");
while ($roww = mysqli_fetch_array($sqlw)) {
	$sql1w = mysqli_query($con, "select * from tblauditsection2 where sid='$roww[id]'");
	while ($row1w = mysqli_fetch_array($sql1w)) {


		$sql21 = mysqli_query($con, "delete from tblauditsection3 where qid='$row1w[id]'");
		$sql31 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1w[id]','Major','Waiting')");
		$sql41 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1w[id]','Minor','Waiting')");
		$sql51 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1w[id]','Compliant','Completed')");
		$sql61 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$row1w[id]','Not Applicable','Not Applicable')");
	}
}


$sqlw1 = mysqli_query($con, "select * from tblgmpaudit3");
while ($roww1 = mysqli_fetch_array($sqlw1)) {
	$gh = mysqli_query($con, "select * from tblauditsection1 where id='$audit'");
	$gh1 = mysqli_fetch_array($gh);

	$hh = mysqli_query($con, "select * from tblauditsection where id='$gh1[sid]'");
	$hh1 = mysqli_fetch_array($hh);


	$sql21 = mysqli_query($con, "update tblgmpaudit2 set auditsection='$hh1[name]', auditsection1='$gh1[name]' where id='$roww1[id]'");
}



?>


<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');

$sno = $_GET['sno'];

$sql2 = mysqli_query($con, "select * from tblgmpaudit2 where id='$sno' ");
$row2 = mysqli_fetch_array($sql2);
$tid = $row2['audit'];
$sid = $row2['sid'];


$sql9 = mysqli_query($con, "select * from tblgmpaudit3 where sno='$sno'  and ans NOT IN ( 'Compliant','Not Applicable','','Satisfactory')");
$sqq9 = mysqli_num_rows($sql9);



$auditdate = date("d-m-Y", strtotime($row2['date']));

$auditee = mysqli_query($con, "select * from tblauditee where id='$row2[auditee]'");
$auditee1 = mysqli_fetch_array($auditee);


$auditor = mysqli_query($con, "select * from tblauditor where id='$row2[auditor]'");
$auditor1 = mysqli_fetch_array($auditor);

$total3 = mysqli_query($con, "select * FROM tblauditsection where id='$tid'");
$addtest = mysqli_fetch_array($total3);


$total2 = mysqli_query($con, "select * FROM tblauditsection1 where sid='$tid' and id='$sid'");
$subtest = mysqli_fetch_array($total2);


$total = mysqli_query($con, "SELECT * FROM tblauditsection2 where sid='$tid' and ssid='$sid'");
$subtest1 = mysqli_fetch_array($total);

$total1 = mysqli_num_rows($total);


?>

<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Audit Management</a></li>
			<li>View Detail</li>
		</ul>
	</div>
	<?php
	$sno = $_GET['sno'];
	?>


	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<?php

					if (($addtest['name'] == 'GMP Audit' || $addtest['name'] == 'GHP Audit')) {
						if ($sqq9 >= 1) {
					?>
							<a href="gmpreports1.php?sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-danger" style="float:right; margin-left:15px">NC Report</button></a>
						<?php
						}
						?>


						<a href="gmpreports.php?sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-success" style="float:right; margin-left:15px">View Report</button></a>
						<?php
					} else if (($addtest['name'] != 'GMP Audit' || $addtest['name'] != 'GHP Audit')) {
						if ($sqq9 >= 1) {
						?>
							<a href="gmpreportss1.php?sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-danger" style="float:right; margin-left:15px">NC Report</button></a>
						<?php
						}
						?>


						<a href="gmpreportss.php?sno=<?php echo $sno; ?>" target="_blank"><button class="btn btn-success" style="float:right; margin-left:15px">View Report</button></a>
					<?php

					}
					?>


					<h4 class="card-title mb-3">View Detail</h4>


					<div class="row">




						<div class="table-responsive">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Date</th>
										<th scope="col">Auditor</th>
										<th scope="col">Subject</th>
										<th scope="col">Question</th>
										<th scope="col">Ans</th>
										<th scope="col">Status</th>
										<th scope="col">Action</th>

									</tr>
								</thead>
								<tbody>
									<?php
									$df = mysqli_query($con, "select * from tblgmpaudit2 where id='$sno'");
									$gh = mysqli_fetch_array($df);

									$sh1 = mysqli_query($con, "select * from tblgmpaudit3 where  sno='$sno'");
									$i = 0;
									while ($hj1 = mysqli_fetch_array($sh1)) {
										$i++;
									?>
										<tr>
											<th scope="row"><?php echo $i; ?></th>
											<td><?php echo date("d-m-Y", strtotime($gh['date'])); ?></td>
											<td><?php echo $auditor1['name']; ?> </td>
											<td> <?php echo  $subtest['name']; ?> </td>
											<td> <?php echo $hj1['ques']; ?> </td>
											<td> <?php echo $hj1['ans']; ?> </td>

											<td>
												<?php
												if ($hj1['status'] == "closedoff") {
													echo "Evidence is submitted";
												} else {
													echo $hj1['status'];
												}

												?>
											</td>
											<td>
												<?php
												if ($hj1['ans'] == "Compliant" || $hj1['ans'] == "Not Applicable") {
												} else {
												?>
													<a href="admin.php?id=gmpnc1&sno=<?php echo $hj1['id']; ?>&sno1=<?php echo $_GET['sno']; ?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a>
												<?php
												}
												?>
											</td>
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
		</div>
	</div>
<?php
include '../connection.php';
session_start();
$date1 = $_POST['d1'];
$date2 = $_POST['d2'];
$tid2 = $_POST['t2'];
$pid2 = $_POST['pid2'];

$access = $_SESSION['access'];
$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid2'");
$qu2 = mysqli_fetch_array($sq2);

?>

<?php
if ($date1 != "" && $date2 == "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Date</th>
				<th><?php echo $qu2['name']; ?></th>
				<th>Closing Checks</th>

			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from dailycheckss where tid='$tid2' && date ='$date2' ORDER BY `date` DESC");
			$i = 0;
			while ($row = mysqli_fetch_array($sql)) {
				$i++;
				$gh = mysqli_query($con, "select * from dailychecks where id='$row[name]'");
				$gh1 = mysqli_fetch_array($gh);
			?>

				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $gh1['name']; ?></td>
					<td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>

					<td>
						<a href="admin.php?id=dailychecks3&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid2; ?>&id2=<?php  echo $pid2; ?>">
							<button class="btn btn-info">View Report</button></a>
					</td>
					<td>
						<?php
						if ($row['name1'] == "2") {
						?>
							<a href="admin.php?id=dailychecks4&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid2; ?>&id2=<?php  echo $pid2; ?>">
								<button class="btn btn-warning">View Report</button></a>
						<?php
						} else {
						?>
							<a href="admin.php?id=closingchecks1&tid=<?php echo $tid2; ?>&sno=<?php echo $row['id']; ?>&id2=<?php echo $pid2; ?>">
								<button class="btn btn-danger"> Attempt Closing Checks</button></a>
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
<?php
} else if ($date1 != "" && $date2 != "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Date</th>
				<th><?php echo $qu2['name']; ?></th>
				<th>Closing Checks</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from dailycheckss where name='$tid2' && date BETWEEN '$date1' AND '$date2' order by date DESC");
			$i = 0;
			while ($row = mysqli_fetch_array($sql)) {
				$i++;
				$gh = mysqli_query($con, "select * from dailychecks where id='$row[name]'");
				$gh1 = mysqli_fetch_array($gh);
			?>

				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $gh1['name']; ?></td>
					<td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>

					<td>
						<a href="admin.php?id=dailychecks3&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid2; ?>&id2=<?php echo $pid2; ?>">
							<button class="btn btn-info">View Report</button></a>
					</td>
					<td>
						<?php
						if ($row['name1'] == "2") {
						?>
							<a href="admin.php?id=dailychecks4&sno=<?php echo $row['id']; ?>&tid=<?php echo $tid2; ?>&id2=<?php echo $pid2; ?>">
								<button class="btn btn-warning">View Report</button></a>
						<?php
						} else {
						?>
							<a href="admin.php?id=closingchecks1&tid=<?php echo $tid2; ?>&sno=<?php echo $row['id']; ?>&id2=<?php echo $pid2; ?>">
								<button class="btn btn-danger"> Attempt Closing Checks</button></a>
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
<?php
}
?>
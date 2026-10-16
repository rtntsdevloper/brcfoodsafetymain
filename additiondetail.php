<?php
include 'connection.php';
session_start();
$date1 = $_POST['d1'];
$date2 = $_POST['d2'];
$s1 = $_POST['s1'];
$access = $_SESSION['access'];
?>

<?php
if ($date1 != "" && $date2 == "" && $s1 == "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>

				<th></th>
				<th>Type</th>
				<th>Section</th>
				<th>Sub-Section</th>

				<th>Issue Date</th>
				<th>Version</th>
				<th>Authorised By</th>
				<th>Doc</th>
				<th></th>


			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from tbldetail where date='$date1' order by date DESC");
			$i = 0;
			while ($row23 = mysqli_fetch_array($sql)) {
				$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
				$hj1 = mysqli_fetch_array($hj);
				$i++;
			?>

				<tr>
					<td><?php echo $i; ?></td>
					<td>

						<?php
						if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
							echo "Additional Documents";
						} else {
							echo $row23['typee'];
						}
						?></td>
					<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
					<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

					<td>
						<?php
						if ($row23['issuedate'] != '0000-00-00') {
							echo date('d-m-Y', strtotime($row23['issuedate']));
						}
						?>
					</td>

					<td><?php echo $row23['ver']; ?></td>
					<td><?php echo $row23['authrisedby']; ?></td>
					<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

					<td>
						<?php
						if ($access == "Admin") {
						?>
							<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
							</br> </br>
							<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
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
} else if ($date1 != "" && $date2 != "" && $s1 == "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>

				<th></th>
				<th>Type</th>
				<th>Section</th>
				<th>Sub-Section</th>

				<th>Issue Date</th>
				<th>Version</th>
				<th>Authorised By</th>
				<th>Doc</th>
				<th></th>


			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from tbldetail where date BETWEEN '$date1' AND '$date2' order by date DESC");
			$i = 0;
			while ($row23 = mysqli_fetch_array($sql)) {
				$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
				$hj1 = mysqli_fetch_array($hj);
				$i++;
			?>

				<tr>
					<td><?php echo $i; ?></td>
					<td>

						<?php
						if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
							echo "Additional Documents";
						} else {
							echo $row23['typee'];
						}
						?></td>
					<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
					<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

					<td>
						<?php
						if ($row23['issuedate'] != '0000-00-00') {
							echo date('d-m-Y', strtotime($row23['issuedate']));
						}
						?>
					</td>

					<td><?php echo $row23['ver']; ?></td>
					<td><?php echo $row23['authrisedby']; ?></td>
					<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

					<td>
						<?php
						if ($access == "Admin") {
						?>
							<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
							</br> </br>
							<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
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
} else if ($date1 != "" && $date2 != "" && $s1 != "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>

				<th></th>
				<th>Type</th>
				<th>Section</th>
				<th>Sub-Section</th>

				<th>Issue Date</th>
				<th>Version</th>
				<th>Authorised By</th>
				<th>Doc</th>
				<th></th>


			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from tbldetail where (date BETWEEN '$date1' AND '$date2') and typee ='$s1' order by date DESC");
			$i = 0;
			while ($row23 = mysqli_fetch_array($sql)) {
				$i++;
				$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
				$hj1 = mysqli_fetch_array($hj);
			?>

				<tr>
					<td><?php echo $i; ?></td>
					<td>

						<?php
						if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
							echo "Additional Documents";
						} else {
							echo $row23['typee'];
						}
						?></td>
					<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
					<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

					<td>
						<?php
						if ($row23['issuedate'] != '0000-00-00') {
							echo date('d-m-Y', strtotime($row23['issuedate']));
						}
						?>
					</td>

					<td><?php echo $row23['ver']; ?></td>
					<td><?php echo $row23['authrisedby']; ?></td>
					<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

					<td>
						<?php
						if ($access == "Admin") {
						?>
							<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
							</br> </br>
							<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
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
} else if ($date1 != "" && $date2 == "" && $s1 != "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>

				<th></th>
				<th>Type</th>
				<th>Section</th>
				<th>Sub-Section</th>

				<th>Issue Date</th>
				<th>Version</th>
				<th>Authorised By</th>
				<th>Doc</th>
				<th></th>


			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from tbldetail where date='$date1' and typee='$s1' order by date DESC");
			$i = 0;
			while ($row23 = mysqli_fetch_array($sql)) {
				$i++;
				$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
				$hj1 = mysqli_fetch_array($hj);
			?>
				
				<tr>
					<td><?php echo $i; ?></td>
					<td>

						<?php
						if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
							echo "Additional Documents";
						} else {
							echo $row23['typee'];
						}
						?></td>
					<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
					<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

					<td>
						<?php
						if ($row23['issuedate'] != '0000-00-00') {
							echo date('d-m-Y', strtotime($row23['issuedate']));
						}
						?>
					</td>

					<td><?php echo $row23['ver']; ?></td>
					<td><?php echo $row23['authrisedby']; ?></td>
					<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

					<td>
						<?php
						if ($access == "Admin") {
						?>
							<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
							</br> </br>
							<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
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
} else if ($date1 == "" && $date2 == "" && $s1 != "") {
?>
	<table class="display table table-striped table-bordered" id="language_option_table" style="width:100%">

		<thead>
			<tr>

				<th></th>
				<th>Type</th>
				<th>Section</th>
				<th>Sub-Section</th>

				<th>Issue Date</th>
				<th>Version</th>
				<th>Authorised By</th>
				<th>Doc</th>
				<th></th>


			</tr>
		</thead>
		<tbody>
			<?php
			$sql = mysqli_query($con, "select * from tbldetail where typee ='$s1' order by date DESC");
			$i = 0;
			while ($row23 = mysqli_fetch_array($sql)) {
				$i++;
				$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
				$hj1 = mysqli_fetch_array($hj);
			?>
				
				<tr>
					<td><?php echo $i; ?></td>
					<td>

						<?php
						if ($row23['typee'] == "original" || $row23['typee'] == "Original") {
							echo "Additional Documents";
						} else {
							echo $row23['typee'];
						}
						?></td>
					<td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
					<td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td>

					<td>
						<?php
						if ($row23['issuedate'] != '0000-00-00') {
							echo date('d-m-Y', strtotime($row23['issuedate']));
						}
						?>
					</td>

					<td><?php echo $row23['ver']; ?></td>
					<td><?php echo $row23['authrisedby']; ?></td>
					<td><a href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>

					<td>
						<?php
						if ($access == "Admin") {
						?>
							<a href="admin.php?id=editaditional&sno=<?php echo $row23['id']; ?>"><button class="btn btn-warning" style="width:65px">Edit</button></a>
							</br> </br>
							<a href="archive.php?id=<?php echo $row23['id']; ?>" onclick="return confirm('Are You Sure?')"><button class="btn btn-danger">Delete</button></a>
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
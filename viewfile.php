<?php
include 'connection.php';

$qid = $_GET['qid'];



?>



<table id="datatable" class="table data-table table-striped">

	<?php
	$stg = mysqli_query($con, "SELECT * FROM tbldetail WHERE id = $qid");
	$stg1 = mysqli_fetch_assoc($stg);
	$hj = mysqli_query($con, "SELECT * FROM subtest WHERE sid='{$stg1['sid']}'");
	$hj1 = mysqli_fetch_array($hj);


	?>

	<tr>
		<th >Section</th>
		 <td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
                           

	</tr>

	<tr>
		<th>Sub-Section</th>
		 <td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $stg1['section']; ?><br>
		</td>

	</tr>
</table>
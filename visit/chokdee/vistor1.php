<?php
include 'connection.php';

// Set timezone to UK
date_default_timezone_set("Europe/London");

// Show current UK date and time
$time = date("H:i:s");


$random = rand(70, 7000);

$name = $_POST['name'];
$reason = $_POST['reason'];
$img = $_FILES['pic']['name'];
move_uploaded_file($_FILES['pic']['tmp_name'], "upl1/" . $img);
$orginisation = $_POST['org'];
$vehicle = $_POST['vehiclereg'];

$vd = date('dmy');
$vs = mysqli_query($con, "SELECT * FROM `visit`");
$vs1 = mysqli_num_rows($vs);
$vs2 = $vs1 + 1;

$visitcode = "Visit_" . $vd . "0" . $vs2;

$date = date('Y-m-d');
$q = mysqli_query($con, "INSERT INTO `visit`(`name`, `reason`, `pic`, `visitcode`,`register`,correct,org,vtime) VALUES ('$name','$reason','$img','$visitcode','$vehicle','$random','$orginisation','$time')");
$nk = 0;
if (!empty($_POST['ques'])) {
	for ($i = 0; $i < count($_POST['ques']); $i++) {




		$qid = $_POST['qid'][$i];
		$module = $_POST['module'][$i];
		$status = $_POST['status'][$i];
		$statuss = $_POST['statuss'][$i];

		$ques = mysqli_real_escape_string($con, $_POST['ques'][$i]);

		if ($i == 1 || $i == 2) {
			if (empty($_POST['ans'][$i])) {
				$ans = "N/A";
			} else {
				$ans = $_POST['ans'][$i];
			}
		} else {

			$ans = $_POST['ans'][$i];
		}
		$cmnt = $_POST['cmnt'][$i];

		if ($i == 12) {
			$nk  = $nk + 0;
		} elseif ($i == 16) {
			if ($ans == "No") {
				$nk = $nk + 1;
			} else {
				$nk = $nk + 0;
			}
		} elseif ($ans == 'Yes') {
			$nk = $nk + 1;
		}


		$sql = mysqli_query($con, "insert into saveques(qid,ques,cmnt,date,ans,module,status,correct,name,vcode)values('$qid','$ques','$cmnt','$date','$ans','$module','$status','$random','$name','$visitcode')");
		if($sql){
			?>
			<script>
			document.location.href='vistor2.php?nk=<?php echo$nk;?>&visit=<?php echo$visitcode;?>'
			</script>
			<?php
		}
	}
}







?>






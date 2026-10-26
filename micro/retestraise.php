<?php
include '../connection.php';
$fdm = date('Y-m-d H:i:s');
$userx = $_POST['userx'];
$mid = $_POST['mid'];
$comment = $_POST['comment'];

$msdt = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`, `reportno`, `status`, `reason`) VALUES ('$mid','$fdm','$userx','Retest','Justified','$comment')");
$insertxid = mysqli_insert_id($con);

$inscon = mysqli_query($con, "UPDATE `tbl_microtrending` SET `status`='Justified' WHERE id='$mid'");
?>
<script>
    window.location.href = "../admin.php?id=microsign&mid=<?php echo $insertxid; ?>&mid1=<?php echo $mid; ?>";
</script>
<?php
include 'connection.php';
$sno = $_GET['sno'];


$sql = mysqli_query($con, "delete from dailychecks1  where id='$sno'");

?>
<script>
    window.location.href = 'admin.php?id=dailyviewques&sno=<?php echo $_GET['tid'];if (isset($_GET['id2'])) { echo "&id2=" . $_GET['id2']; } ?>';
</script>

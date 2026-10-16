<?php
include 'connection.php';
$sourcePath = $_FILES['userImage']['tmp_name'];
$targetPath = "images/".$_FILES['userImage']['name'];
move_uploaded_file($sourcePath,$targetPath);




echo $sid=$_POST['sid'];
echo $qid=$_POST['qid'];

$dd=mysqli_query($con,"select * from auditques where fid='$sid' and cid='$qid'");
$rows=mysqli_fetch_array($dd);



echo $file=$_FILES['userImage']['name'];
$date=date("Y-m-d h:i");
$sql=mysqli_query($con,"insert into saveaudit(fid,ques,document,curdate,tid,sid)values('$sid','$qid','$file','$date','$rows[tid]','$rows[sid]')");
?>
<script language="javascript">
$('#modal').modal('hide')
</script>
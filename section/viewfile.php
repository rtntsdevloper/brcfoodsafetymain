<?php
include '../connection.php';

$qid = $_GET['qid'];

$my24 = mysqli_query($con, "select * from tbldetail where id='$qid'");
$rowd = mysqli_fetch_array($my24);

?>
<a href="document/<?php echo $rowd['img']; ?>" target="_blank" class="btn btn-info text-right my-3" style="float: right;">
    <i class="fa fa-window-maximize" style="font-size:18px;color:#FFFFFF;"></i> Full View
</a>
<embed src="document/<?php echo $rowd['img']; ?>" width="760px" height="550px" />

<?php
include 'connection.php';
$note= $_POST['note'];
  $fid=$_POST['fidd'];
 $qid=$_POST['qidd'];

$date=date("Y-m-d h:i");

$dd=mysql_query("select * from auditques where fid='$fid' and cid='$qid'");
$rows=mysql_fetch_array($dd);



$sql=mysql_query("insert into saveaudit(fid,ques,notes,curdate,tid,sid)values('$fid','$qid','$note','$date','$rows[tid]','$rows[sid]')");

 ?>
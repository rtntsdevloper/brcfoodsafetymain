<?php
include 'connection.php';
$pid=$_POST['pid'];
$itemCount1 = count($_POST["chk"]);

for($j=0;$j<$itemCount1;$j++)
{
$chk = $_POST["chk"][$j];
$sql1=mysqli_query($con,"insert into tblmicro(qid,pid)values('$chk','$pid')");
}

$itemCount = count($_POST["issue"]);
for($i=0;$i<$itemCount;$i++)
{
$isue=mysqli_real_escape_string($con,$_POST["issue"][$i]);
$sql2=mysqli_query($con,"insert into tblauditsection2(sid,ssid,ques,cmnt,status)values('18','32','$isue','yes','$pid')");

}


$gh=mysqli_query($con,"select * from tblauditsection2 where status='$pid'");
while($row=mysqli_fetch_array($gh))
{
$sql3=mysqli_query($con,"insert into tblmicro(qid,pid)values('$row[id]','$pid')");
$sql4=mysqli_query($con,"insert into tblauditsection3(qid,ans,status)values('$row[id]','Accept','text')");
$sql5=mysqli_query($con,"insert into tblauditsection3(qid,ans,status)values('$row[id]','Reject','text')");
}

$jk=mysqli_query($con,"update tblauditsection2 set status='active' where status='$pid'");
?>
  <script language="javascript">
 window.open('admin.php?id=ps1&pid=<?php echo $pid;?>&id2=<?php echo $_POST['id2'];?>','_self');
  </script>


<?php
include 'connection.php';

$sql212=mysqli_query($con,"select * from tblauditsection2");
while($row=mysqli_fetch_array($sql212))
{
$sql217=mysqli_query($con,"select * from tblauditsection3 where qid='$row[id]'");
$match=mysqli_num_rows($sql217);
if($match>=1)
{
}
else
{
$sql213=mysqli_query($con,"insert into tblauditsection3 (qid,ans,status)values('$row[id]','Compliant','Completed')");
$sql214=mysqli_query($con,"insert into tblauditsection3 (qid,ans,status)values('$row[id]','Major','waiting')");
$sql215=mysqli_query($con,"insert into tblauditsection3 (qid,ans,status)values('$row[id]','Minor','waiting')");
$sql216=mysqli_query($con,"insert into tblauditsection3 (qid,ans,status)values('$row[id]','Not Applicable','Not Applicable')");
 }
}
?>


<script language="javascript">
window.open('admin.php?id=addaudit1','_self');
</script>




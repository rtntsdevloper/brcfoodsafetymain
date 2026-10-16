  <?php
session_start();
$staffid=$_SESSION['staffid'];
include '../connection.php';
$des=$_GET['q'];
$reg=explode('.',$des);
$nam1=$reg[0];
$id=$reg[1];
$tid=$reg[2];
$qid=$reg[3];
$sq=mysqli_query($con,"select * from trainingquess where tid='$tid' and qid='$qid'");
$row=mysqli_fetch_array($sq);
$ques=$row['ques'];


if($nam1=='a')
{
$nam2=mysqli_real_escape_string($con,$row['ansa']);
}
if($nam1=='b')
{
$nam2=mysqli_real_escape_string($con,$row['ansb']);
}
if($nam1=='c')
{
$nam2=mysqli_real_escape_string($con,$row['ansc']);
}
if($nam1=='d')
{
$nam2=mysqli_real_escape_string($con,$row['ansd']);
}

$sq1=mysqli_query($con,"update user_anss set yourans='$nam2' where quesdes='$ques' and testid='$tid' and uid='$staffid'");
?>
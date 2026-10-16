<?php
include '../connection.php';
$des=$_GET['q'];
$reg=explode('.',$des);
$nam1=$reg[0];
$id=$reg[1];
$tid=$reg[2];
$qid=$reg[3];
$sq=mysqli_query($con,"select * from trainingquess1 where tid='$tid' and qid='$qid'");
$row=mysqli_fetch_array($sq);
$ques=$row['ques'];


if($nam1=='a')
{
$nam2=$row['ansa'];
}
if($nam1=='b')
{
$nam2=$row['ansb'];
}
if($nam1=='c')
{
$nam2=$row['ansc'];
}
if($nam1=='d')
{
$nam2=$row['ansd'];
}


$sq1=mysqli_query($con,"update user_anss1 set yourans='$nam2' where quesdes='$ques'");
?>
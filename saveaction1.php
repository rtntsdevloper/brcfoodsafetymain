
<?php
 include 'connection.php';
 $ans= mysqli_real_escape_string($con,$_GET['ans']);
 $qid=$_GET['qid'];

$sql=mysqli_query($con,"update saveiqques set ans='$ans' where id='$qid'");

 ?>

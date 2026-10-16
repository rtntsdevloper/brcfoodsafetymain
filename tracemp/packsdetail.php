<?php
include '../connection.php';


 $qty = $_GET['quantity'];

 $qid= $_GET['qid'];
 $batch= $_GET['batch'];
  

 $prd = mysqli_query($con,"SELECT * FROM `tbllabel` WHERE id='$qid'");
 $prd1 = mysqli_fetch_array($prd);
 $prdbatch = $prd1['recordid'];
 $prdname =$prd1['pname'];
 $bdate = $prd1['bbdate'];

 $adx = mysqli_query($con,"select * from tblouter3 where batch='$batch' and pid='$qid'");
 $adxn = mysqli_num_rows($adx);
if($adxn>0){
$qpx = mysqli_query($con,"update tblouter3 set qty='$qty' where batch='$batch' and pid='$qid'");
}else{
    
$qpx = mysqli_query($con,"INSERT INTO `tblouter3`(`batch`, `qty`, `pid`,`pname`,`pbatch`,pbdate,eid) VALUES ('$batch','$qty','$qid','$prdname','$prdbatch','$bdate','$qid')");
}


?>


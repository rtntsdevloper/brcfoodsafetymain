<?php
$id = $_GET['aid'];

$status = $_GET['ch'];

$ns1 = mysqli_query($con,"UPDATE `tb_pestagency` SET `status`='$status' WHERE id=$id");
if($ns1){
    echo "<script> 
    document.location.href='admin.php?id=agency';
   </script>";
}

?>

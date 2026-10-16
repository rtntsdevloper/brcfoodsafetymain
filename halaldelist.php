<?php
include 'connection.php';
$hid =$_GET['hid'];
$sql =mysqli_query($con,"update tblhalal set status='Archieved' where id='$hid'");
if($sql){
   ?>
<script>

    
    window.location.href="admin.php?id=rawhalal";
</script>
   <?php
}

?>
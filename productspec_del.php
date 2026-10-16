<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"delete from tblauditsection2  where id='$sno'");
if($sql){
    ?>
<script language="javascript">
window.open('admin.php?id=productspec_detail','_self');
</script>

<?php
}else{
    echo "<script>
    alert('Sorry ! Unable to delete');
    </script>";
}

?>


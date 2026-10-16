<?php
$sno = $_GET['sno'];
$sql = mysqli_query($con, "SELECT * FROM `tblequipment` where id = '$sno'");
$row = mysqli_fetch_array($sql);

if($row['status']=='Active')
{
    $status='Inactive';
}
else if($row['status']=='Inactive')
{
    $status='Active';
}

$sqlm =mysqli_query($con,"update `tblequipment` set `status`='$status' where id='$sno'");
if($sqlm){
?>

<script>
window.open("admin.php?id=ppmmgmt", "_self");
</script>
<?php
}
?>


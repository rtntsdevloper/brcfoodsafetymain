<?php
include '../connection.php';
$pname = $_GET['product'];
$sqlx = "SELECT * FROM `tblgrn1` WHERE product ='$pname'";
$resultx = mysqli_query($con, $sqlx);
?>

<option value="">Select</option>
<?php
while ($rowx = mysqli_fetch_array($resultx)) {
?>
    <option value="<?php echo $rowx['id']; ?>" data-grn="<?php echo $rowx['batchcode']; ?>" data-leftqty="<?php echo $rowx['leftqty']; ?>" data-use="<?php echo $rowx['useby']; ?>"><?php echo $rowx['grn']; ?>(<?php echo $rowx['pno']; ?>)</option>

<?php

}
?>
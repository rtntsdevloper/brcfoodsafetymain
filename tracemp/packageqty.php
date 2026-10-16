<?php
include '../connection.php';
$pid = $_GET['quantity'];



?>

<label for="validationTooltip02">Packaging Material Batch</label>
<select name="packgrn" class="form-control" onchange="pcknm(this)" id="pckgnt">
    <option>Please Select</option>
    <?php
    $qspn = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE product='$pid' and leftqty != 0");
    foreach ($qspn as $rown) {
    ?>
        <option value="<?php echo $rown['grn']; ?>" data-id="<?php echo $rown['leftqty']; ?>" ><?php echo $rown['batchcode']; ?> ( <?php echo $rown['leftqty']; ?>Kg left)</option>
    <?php
    }

    ?>
</select>
<div class="invalid-tooltip">
    Please fill the field.

</div>
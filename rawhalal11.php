<?php
include 'connection.php';
$sid = $_GET['sid'];
$rm = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE supid='$sid'");


?>
<label for="validationTooltip02">Supplier name</label>
<select class="form-control" id="validationTooltip02"
    name="rawname" required >
    <option value="">Select Raw Material</option>
    <?php while ($rows = mysqli_fetch_assoc($rm)) { ?>
        <option value="<?php echo $rows['pname']; ?>"><?php echo $rows['pname']; ?>
        </option>
    <?php
    }
    ?>
</select>
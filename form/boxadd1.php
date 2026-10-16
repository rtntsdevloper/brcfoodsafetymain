<?php
include '../connection.php';

$pid = $_GET['product'];
$nrk = mysqli_query($con, "SELECT * FROM `zendproduction` WHERE fproduct= '$pid' and `label`= 'done'");



echo '<option value="">Select Production batch</option>';
foreach ($nrk as $nrk1) {
    ?>


   <option value="<?= $nrk1['pbatch']  ?>" data-id="<?= $nrk1['id']?>" data-leftqty="<?= $nrk1['sachetleft']?>" ><?=$nrk1['pbatch']  ?></option>

    <?php
}

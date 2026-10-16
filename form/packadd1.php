<?php

include '../connection.php';

$pid = $_POST['sid'];

$nrk = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE product = '$pid' and  `zendfinish` != 'done'");

echo '<option value="">Select GRN No.</option>';

foreach ($nrk as $nrk1) {
    // echo '<option value="' . $nrk1['id'] . '">' . $nrk1['grn'] . '(' . $nrk1['qty'] . ')</option>';
 echo '<option value="' . $nrk1['id'] . '">' . $nrk1['grn']. '('.$nrk1['batchcode'].')</option>';


}


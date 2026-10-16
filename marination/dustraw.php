<?php
include 'connection.php';


// Get Flour ID



// Handle form submission
if (isset($_POST['submit'])) {

    $record = "DUST" . date("Ymdhis");
    $grn_id = intval($_POST['grn']);
    $used_qty = floatval($_POST['usedQty']);

    $grr = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE id = '$grn_id'");
    $grr = mysqli_fetch_assoc($grr);
    $leftqty = $grr['leftqty'];
    $batchcode = $grr['batchcode'];

    $remain = $leftqty - $used_qty;
    $datec = date("Y-m-d");

    // Update tblmarination
    $update1 = mysqli_query($con, "INSERT INTO `tbl_dustingrecord`( `dustid`, `grn`, `batch`, `datec`, `usedqty`, `user`) VALUES ('$record','$grn_id','$batchcode','$datec','$used_qty','$user')");

    // Also update leftqty in tblgrn1
    $update2 = mysqli_query($con, "UPDATE tblgrn1 SET leftqty = '$remain' WHERE id = '$grn_id'");

    if ($update1 && $update2) {
        echo "<div class='alert alert-success'>Record updated successfully!</div>";
        echo '<script> window.location.href = "admin.php?id=dustraw1";</script>';
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="card p-4">
    <h3>Add Dusting Flour Detail</h3>
    <form method="post" action="">
        <input type="hidden" name="tid" value="<?php echo $tid; ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Select GRN</label>
                <select name="grn" id="grn" class="form-control" required>
                    <option value="">Select GRN</option>

                    <?php

                    $result = mysqli_query($con, "SELECT * FROM tblrawmaterial WHERE pname LIKE '%flour%';");
                    foreach ($result as $row1) {
                        $flour_id = $row1['id'];


                        $sql = mysqli_query($con, "SELECT id, grn, leftqty,batchcode FROM tblgrn1 WHERE product = '$flour_id' and leftqty > 0 order by datetime desc");
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $selected = (isset($_POST['grn']) && $_POST['grn'] == $row['id']) ? 'selected' : ''; ?>
                            <option value="<?php echo $row['id']; ?>"
                                data-qty="<?php echo $row['leftqty']; ?>"
                                <?php echo $selected; ?>>
                                <?php echo $row['grn']; ?> (Batchcode: <?php echo $row['batchcode']; ?>)
                            </option>
                    <?php
                        }
                    }
                    ?>

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Available Qty</label>
                <input type="number" class="form-control" id="availQty" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Used Qty</label>
                <input type="number" name="usedQty" id="usedQty" class="form-control" placeholder="Enter in Kg"
                    min="0" step="0.01" required
                    value="<?php echo isset($_POST['usedQty']) ? $_POST['usedQty'] : ''; ?>">
            </div>


        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateQuantities() {
            let qty = parseFloat($('#grn').find('option:selected').data('qty')) || 0;
            let used = parseFloat($('#usedQty').val()) || 0;

            $('#availQty').val(qty);
            $('#usedQty').attr('max', qty);

            // Calculate left quantity
            let left = qty - used;
            if (left < 0) {
                $('#usedQty').val(qty);
                used = qty;
                left = 0;
            }
            $('#leftQty').val(left.toFixed(2));
        }

        // Initialize on page load
        updateQuantities();

        $('#grn').change(function() {
            $('#usedQty').val(''); // Clear used qty when GRN changes
            updateQuantities();
        });

        $('#usedQty').on('input', function() {
            updateQuantities();
        });
    });
</script>
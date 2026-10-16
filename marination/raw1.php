<?php
include 'connection.php';

// Get tid from URL
$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;

// Get Flour ID
$result = mysqli_query($con, "SELECT * 
FROM tblrawmaterial
WHERE pname LIKE '%flour%';");
$row = mysqli_fetch_assoc($result);
$flour_id = $row['id'];

// Handle form submission
if (isset($_POST['submit'])) {
    $grn_id = intval($_POST['grn']);
    $used_qty = floatval($_POST['usedQty']);

    // Update tblmarination
    $update1 = mysqli_query($con, "UPDATE tblmarination SET used = '$used_qty', grn = '$grn_id' WHERE id = '$tid'");

    // Also update leftqty in tblgrn1
    $update2 = mysqli_query($con, "UPDATE tblgrn1 SET leftqty = leftqty - '$used_qty' WHERE id = '$grn_id'");

    if ($update1 && $update2) {
        echo "<div class='alert alert-success'>Record updated successfully!</div>";
        echo '<script> window.location.href = "admin.php?id=marination&id2=traceniche";</script>';
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
                    $sql = mysqli_query($con, "SELECT id, grn, leftqty,batchcode FROM tblgrn1 WHERE product = '$flour_id' order by datetime desc");
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $selected = (isset($_POST['grn']) && $_POST['grn'] == $row['id']) ? 'selected' : ''; ?>
                        <option value="<?php echo $row['id']; ?>"
                            data-qty="<?php echo $row['leftqty']; ?>"
                            <?php echo $selected; ?>>
                            <?php echo $row['grn']; ?> (Batchcode: <?php echo $row['batchcode']; ?>)
                        </option>
                    <?php
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

            <!-- <div class="col-md-6 mb-3">
                <label class="form-label">Left Qty</label>
                <input type="number" class="form-control" id="leftQty" readonly>
            </div> -->
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
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Yogurt Packaging</li>
            <li><a href="">Add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=yogurtpackaging">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Yogurt Packaging</h4>

                    <form name="form1" method="post">
                        <div class="row">
                            <!-- Product Dropdown -->
                            <div class="col-md-6">
                                <label>Product</label>
                                <select name="product" id="productSelect" class="form-control">
                                    <option value="">Select</option>
                                    <?php
                                    // preload product data for JS
                                    $productData = [];
                                    $sql = mysqli_query($con, "SELECT DISTINCT pid, uid, qty FROM tblyogurt2");
                                    while ($data = mysqli_fetch_assoc($sql)) {
                                        $pid = $data['pid'];
                                        $uid = $data['uid'];
                                        $qty = $data['qty'];

                                        $sq = mysqli_query($con, "SELECT * FROM tblyogurt WHERE id='$pid'");
                                        $sqdata = mysqli_fetch_array($sq);

                                        $name = $sqdata['name'];

                                        // Save for JS
                                        $productData["$pid($uid)"] = [
                                            "batch" => $uid,
                                            "qty"   => $qty,
                                            "kg"    => $sqdata['kg'],
                                            "pks"   => $sqdata['pks']
                                        ];

                                        // Dropdown option
                                        echo '<option value="' . $pid . '(' . $uid  .')'.'">'
                                            . $name . ' (Batchcode: ' . $uid . ')</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Batch Code -->
                            <div class="col-md-6">
                                <label>Batch Code</label>
                                <input type="text" id="batchCode" name="batchCode" class="form-control" readonly>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity" class="form-control" readonly>
                            </div>

                            <!-- Pack -->
                            <div class="col-md-6">
                                <label>Pack</label>
                                <input type="text" id="pack" name="pack" class="form-control" readonly>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preloaded product data from PHP
    var productData = <?php echo json_encode($productData); ?>;

    document.getElementById('productSelect').addEventListener('change', function() {
        var selected = this.value;
        if (productData[selected]) {
            var data = productData[selected];
            document.getElementById('batchCode').value = data.batch;
            document.getElementById('quantity').value = data.qty;

            var total = parseFloat(data.qty);
            var packSize = parseFloat(data.kg) * parseFloat(data.pks);

            // ✅ Round packSize before using
            packSize = Math.round(packSize);
            // alert(packSize);

            if (!isNaN(total) && !isNaN(packSize) && packSize > 0) {
                document.getElementById('pack').value = Math.round(total / packSize);
            } else {
                document.getElementById('pack').value = '';
            }
        } else {
            document.getElementById('batchCode').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('pack').value = '';
        }
    });
</script>


<?php
if (isset($_POST['submit'])) {
    $product   = $_POST['product'];
    $batchCode = $_POST['batchCode'];
    $quantity  = $_POST['quantity'];
    $pack      = $_POST['pack'];

    $insert = mysqli_query($con, "INSERT INTO tblyogurtpackaging (product, batchcode, quantity, pack) 
                                      VALUES ('$product', '$batchCode', '$quantity', '$pack')");
    if ($insert) {
        echo "<script>window.location.href='admin.php?id=yogurtpackaging'</script>";
    } else {
        echo "<p style='color:red'>Error inserting record.</p>";
    }
}

?>
<?php

$dough_rows = [];
$res_dough = mysqli_query($con, "SELECT storagecode, leftsheet, shelflife FROM frozenstorage WHERE leftsheet > 0");
while ($r = mysqli_fetch_assoc($res_dough)) {
    $dough_rows[] = $r;
}


$samosa_rows = [];
$res_samosa = mysqli_query($con, "SELECT cookingcode, leftqty, shelflife FROM frozencooking WHERE pid = 2 AND leftqty > 0");
while ($r = mysqli_fetch_assoc($res_samosa)) {
    $samosa_rows[] = $r;
}


$spring_rows = [];
$res_spring = mysqli_query($con, "SELECT cookingcode, leftqty, shelflife FROM frozencooking WHERE pid = 3 AND leftqty > 0");
while ($r = mysqli_fetch_assoc($res_spring)) {
    $spring_rows[] = $r;
}


if (isset($_POST['submit'])) {
    $quantities = isset($_POST['quantity_used']) ? $_POST['quantity_used'] : [];
    $sources    = isset($_POST['source']) ? $_POST['source'] : [];
    $totalUpdated = 0;
    $doughUsed    = 0;
    $masalaUsed   = 0;
    $date    =$_POST['date'];
    $product = $_POST['product'];
    $pcs     =$_POST['pcs'] ;
    $useby=$_POST['useby'];
    $dt      = date('dmY');
    $pbatch  = "BAC" . $dt . str_pad((mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS c FROM frozenproduction"))['c'] + 1), 3, '0', STR_PAD_LEFT);

    // Insert master row into frozenproduction (now includes pcs)
    mysqli_query($con, "INSERT INTO `frozenproduction` (`date`, `batchcode`, `product`, `qty`,useby) 
                        VALUES ('$date', '$pbatch', '$product', '$pcs','$useby')");
    $mainId = mysqli_insert_id($con);

    foreach ($quantities as $batchcode => $qty) {
        $qty = floatval($qty);
        if ($qty > 0) {
            $batchcode_esc = mysqli_real_escape_string($con, $batchcode);
            $source = isset($sources[$batchcode]) ? $sources[$batchcode] : '';

            $inserted = false;
            $usebyy   = '';

            // ---- Dough batch (frozenstorage) ----
            if ($source === 'dough') {
                $check_dough = mysqli_query($con, "SELECT leftsheet, shelflife FROM frozenstorage WHERE storagecode = '$batchcode_esc' LIMIT 1");
                if ($check_dough && mysqli_num_rows($check_dough) > 0) {
                    $row_d   = mysqli_fetch_assoc($check_dough);
                    $leftQty = floatval($row_d['leftsheet']);
                    $usebyy  = $row_d['shelflife'];

                    if ($qty <= $leftQty) {
                        mysqli_query($con, "UPDATE frozenstorage 
                            SET leftsheet = leftsheet - $qty,
                                usesheet  = usesheet  + $qty
                            WHERE storagecode = '$batchcode_esc'");
                        $totalUpdated++;
                        $doughUsed++;
                        $inserted = true;
                    }
                }
            }

            // ---- Masala batch (frozencooking) ----
            if ($source === 'masala') {
                $check_prod = mysqli_query($con, "SELECT leftqty, shelflife FROM frozencooking WHERE cookingcode = '$batchcode_esc' LIMIT 1");
                if ($check_prod && mysqli_num_rows($check_prod) > 0) {
                    $row_p      = mysqli_fetch_assoc($check_prod);
                    $currentQty = floatval($row_p['leftqty']);
                    $usebyy     = $row_p['shelflife'];

                    if ($qty <= $currentQty) {
                        mysqli_query($con, "UPDATE frozencooking 
                            SET leftqty = leftqty - $qty,
                                useqty  = useqty  + $qty
                            WHERE cookingcode = '$batchcode_esc'");
                        $totalUpdated++;
                        $masalaUsed++;
                        $inserted = true;
                    }
                }
            }

            // Insert sub row into frozenproduction1
            if ($inserted) {
                $usebyy_esc = mysqli_real_escape_string($con, $usebyy);
                $usebVal = ($usebyy_esc === '') ? "NULL" : "'$usebyy_esc'";

                mysqli_query($con, "INSERT INTO `frozenproduction1` 
                    (`mainid`, `date`, `batchcode`, `product`, `qty`, `useby`) 
                    VALUES ('$mainId', '$date', '$batchcode_esc', '$product', '$qty', $usebVal)");
            }
        }
    }

    if ($doughUsed > 0 && $masalaUsed > 0) {
        echo "<script>window.location.href='admin.php?id=fproduction';</script>";
        exit;
    } else {
        mysqli_query($con, "DELETE FROM `frozenproduction1` WHERE mainid = '$mainId'");
        mysqli_query($con, "DELETE FROM `frozenproduction` WHERE id = '$mainId'");
        echo "<script>alert('Error: You must enter quantity for BOTH Dough and Masala batches.');</script>";
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Production</li>
            <li><a href="">add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=fproduction" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>

                    <h4 class="card-title mb-3">Production Record</h4>

                    <form name="form1" method="post" action="" onsubmit="return validateForm()">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="date">Production Date/Time</label>
                                <input type="datetime-local" name="date" id="date" class="form-control" required value="<?php echo date('Y-m-d'); ?>" />
                            </div>

                            <div class="col-md-4">
                                <label for="product">Select Final Product</label>
                                <select class="form-control" name="product" id="product" required>
                                    <option value="">Please Select</option>
                                    <option value="2">Samosa</option>
                                    <option value="3">Spring Roll</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="pcs">Qty (pcs)</label>
                                <input type="number" name="pcs" id="pcs" class="form-control" min="0" step="1" placeholder="0" required />
                            </div>

                            <div class="col-md-4"><br>
                                <label for="date">Use By Date</label>
                                <input type="date" name="useby" id="date" class="form-control" required  />
                            </div>

                        </div>

                        <br>

                        <div id="batch_list_area" style="display:none;">
                            <div id="batch_rows_container">
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var doughData = [
        <?php foreach ($dough_rows as $r): ?> {
                batchcode: "<?php echo $r['storagecode']; ?>",
                qty: "<?php echo rtrim(rtrim(number_format((float)$r['leftsheet'], 3, '.', ''), '0'), '.'); ?>",
                use_by: "<?php echo $r['shelflife']; ?>"
            },
        <?php endforeach; ?>
    ];

    var samosaData = [
        <?php foreach ($samosa_rows as $r): ?> {
                batchcode: "<?php echo $r['cookingcode']; ?>",
                qty: "<?php echo rtrim(rtrim(number_format((float)$r['leftqty'], 3, '.', ''), '0'), '.'); ?>",
                use_by: "<?php echo $r['shelflife']; ?>"
            },
        <?php endforeach; ?>
    ];

    var springRollData = [
        <?php foreach ($spring_rows as $r): ?> {
                batchcode: "<?php echo $r['cookingcode']; ?>",
                qty: "<?php echo rtrim(rtrim(number_format((float)$r['leftqty'], 3, '.', ''), '0'), '.'); ?>",
                use_by: "<?php echo $r['shelflife']; ?>"
            },
        <?php endforeach; ?>
    ];

    document.addEventListener("DOMContentLoaded", function() {
        var productSelect = document.getElementById("product");
        var batchListArea = document.getElementById("batch_list_area");
        var rowsContainer = document.getElementById("batch_rows_container");

        productSelect.addEventListener("change", function() {
            var productId = this.value;
            rowsContainer.innerHTML = "";

            if (productId === "") {
                batchListArea.style.display = "none";
                return;
            }

            batchListArea.style.display = "block";

            var productData = [];
            if (productId === "2") {
                productData = samosaData;
            } else if (productId === "3") {
                productData = springRollData;
            }

            if (doughData.length > 0) {
                var doughHeader = document.createElement("h6");
                doughHeader.className = "text-primary mt-3 mb-2";
                doughHeader.innerHTML = "<strong>Dough</strong>";
                rowsContainer.appendChild(doughHeader);

                for (var i = 0; i < doughData.length; i++) {
                    createBatchRow(doughData[i], rowsContainer, "dough");
                }
            }

            if (productData.length > 0) {
                var productHeader = document.createElement("h6");
                productHeader.className = "text-success mt-3 mb-2";
                productHeader.innerHTML = "<strong>" + (productId === "2" ? "Samosa" : "Spring Roll") + " Masalo</strong>";
                rowsContainer.appendChild(productHeader);

                for (var i = 0; i < productData.length; i++) {
                    createBatchRow(productData[i], rowsContainer, "masala");
                }
            } else {
                var emptyMsg = document.createElement("p");
                emptyMsg.className = "text-center text-muted";
                emptyMsg.textContent = "No product-specific batches available.";
                rowsContainer.appendChild(emptyMsg);
            }
        });

        function createBatchRow(item, container, source) {
            var rowDiv = document.createElement("div");
            rowDiv.className = "row mb-3 align-items-end";

            var col1 = document.createElement("div");
            col1.className = "col-md-4";

            var label1 = document.createElement("label");
            label1.textContent = " Quantity KG ";
            col1.appendChild(label1);

            var inputQty = document.createElement("input");
            inputQty.type = "text";
            inputQty.className = "form-control";
            inputQty.value = item.qty;
            inputQty.readOnly = true;
            inputQty.style.backgroundColor = "#e9ecef";
            col1.appendChild(inputQty);

            rowDiv.appendChild(col1);

            var col2 = document.createElement("div");
            col2.className = "col-md-4";

            var label2 = document.createElement("label");
            label2.innerHTML = 'Use By : (Batch Code: <span style="font-weight:bold;">' + item.batchcode + '</span>)';
            col2.appendChild(label2);

            var inputUseBy = document.createElement("input");
            inputUseBy.type = "text";
            inputUseBy.className = "form-control";
            inputUseBy.value = item.use_by;
            inputUseBy.readOnly = true;
            inputUseBy.style.backgroundColor = "#e9ecef";
            col2.appendChild(inputUseBy);

            rowDiv.appendChild(col2);

            var col3 = document.createElement("div");
            col3.className = "col-md-4";

            var label3 = document.createElement("label");
            label3.textContent = "Quantity Used";
            col3.appendChild(label3);

            var inputUsed = document.createElement("input");
            inputUsed.type = "number";
            inputUsed.className = "form-control quantity-used-input";
            inputUsed.name = "quantity_used[" + item.batchcode + "]";
            inputUsed.min = "0";
            inputUsed.step = "any";
            inputUsed.placeholder = "0";
            inputUsed.setAttribute("data-left-qty", item.qty);
            inputUsed.setAttribute("data-batchcode", item.batchcode);
            inputUsed.setAttribute("data-source", source);

            inputUsed.addEventListener("input", function() {
                var leftQty = parseFloat(this.getAttribute("data-left-qty")) || 0;
                var usedQty = parseFloat(this.value) || 0;
                if (usedQty > leftQty) {
                    this.classList.add("is-invalid");
                } else {
                    this.classList.remove("is-invalid");
                }
            });

            col3.appendChild(inputUsed);

            var hiddenSource = document.createElement("input");
            hiddenSource.type = "hidden";
            hiddenSource.name = "source[" + item.batchcode + "]";
            hiddenSource.value = source;
            col3.appendChild(hiddenSource);

            rowDiv.appendChild(col3);

            container.appendChild(rowDiv);
        }
    });

    function validateForm() {
        var product = document.getElementById("product").value;

        if (product === "") {
            alert("Please select a product.");
            return false;
        }

        var pcs = document.getElementById("pcs").value;
        if (pcs === "" || parseFloat(pcs) <= 0) {
            alert("Please enter Qty (pcs).");
            document.getElementById("pcs").focus();
            return false;
        }

        var inputs = document.querySelectorAll(".quantity-used-input");
        var doughTotal  = 0;
        var masalaTotal = 0;

        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            var leftQty = parseFloat(input.getAttribute("data-left-qty")) || 0;
            var usedQty = parseFloat(input.value) || 0;
            var source  = input.getAttribute("data-source");

            if (usedQty > leftQty) {
                alert("Error: Quantity Used for batch " + input.getAttribute("data-batchcode") + " (" + usedQty + ") exceeds Left Quantity (" + leftQty + ").");
                input.focus();
                return false;
            }

            if (source === "dough") {
                doughTotal += usedQty;
            } else if (source === "masala") {
                masalaTotal += usedQty;
            }
        }

        if (doughTotal <= 0) {
            alert("Please enter Quantity Used for Dough batch.");
            return false;
        }

        if (masalaTotal <= 0) {
            alert("Please enter Quantity Used for Masala batch.");
            return false;
        }

        return true;
    }
</script>
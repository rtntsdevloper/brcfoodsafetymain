<?php
$uid = $_GET['uid'];
$pid = $_GET['pid'];

// Fetch product details and formula from tblyogurt
$productSql = mysqli_query($con, "SELECT * FROM tblyogurt WHERE id='$pid'");
$productData = mysqli_fetch_array($productSql);
$productType = $productData['type'];
$creamFactor = $productData['cream']; // e.g., 0.10
$smpFactor = $productData['smp'];     // e.g., 0.05
$fruitFactor = 0.16; // Default fruit factor

// Get fruit name if product type is fruit
$fruitName = '';
if ($productType == 'fruit') {
    $fruitName = $productData['fname'];
}

// Fetch production plan
$sql = mysqli_query($con, "SELECT * FROM `tblyogurtproduction` where uid='$uid' ");
$row = mysqli_fetch_array($sql);
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Yogurt production</li>
            <li><a href="">add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=yogurtproductionadd" class="btn btn-success float-right">Go Back</a>
                    <h4 class="card-title">Yogurt production</h4>

                    <form name="form1" method="post" id="productionForm" onsubmit="return validateForm()">
                        <div class="row">
                            <!-- Production Planning Section -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-info ">
                                        <h5 class='text-white'><?php echo $productData['name']; ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label style="font-size:18px; font-weight:bold;">Batch Quantity</label>
                                                <input type="number" id="batchQty" name="batch_qty" class="form-control" readonly
                                                    step="0.1" min="0" value="<?php echo $row['qty']; ?>">
                                                <small class="text-muted">Planned production quantity</small>
                                            </div>

                                            <!-- Hidden fields for factors -->
                                            <input type="hidden" id="creamFactor" value="<?php echo $creamFactor; ?>">
                                            <input type="hidden" id="smpFactor" value="<?php echo $smpFactor; ?>">
                                            <input type="hidden" id="productType" value="<?php echo $productType; ?>">
                                            <input type="hidden" id="fruitFactor" value="<?php echo $fruitFactor; ?>">
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <label>Cream Required (Calculated)</label>
                                                <input type="text" id="calculatedCream" class="form-control" readonly style="background-color:#e8f5e9;">
                                            </div>
                                            <div class="col-md-3">
                                                <label>SMP Required (Calculated)</label>
                                                <input type="text" id="calculatedSmp" class="form-control" readonly style="background-color:#e8f5e9;">
                                            </div>
                                            <?php if ($productType == 'fruit'): ?>
                                                <div class="col-md-3">
                                                    <label><?php echo $fruitName; ?> Required (Calculated)</label>
                                                    <input type="text" id="calculatedFruit" class="form-control" readonly style="background-color:#e8f5e9;">
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-3">
                                                <label>Milk Required (Calculated)</label>
                                                <input type="text" id="calculatedMilk" class="form-control" readonly style="background-color:#e8f5e9;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden fields to store calculated values for submission -->
                            <input type="hidden" id="finalCream" name="cream" value="">
                            <input type="hidden" id="finalSmp" name="smp" value="">
                            <input type="hidden" id="finalMilk" name="milk" value="">
                            <input type="hidden" id="finalFruit" name="fruit" value="">
                            <input type="hidden" id="finalFruitName" name="fruit_name" value="<?php echo $fruitName; ?>">
                            <input type="hidden" name="qty" id="totalQty" value="">

                            <!-- Milk Section -->
                            <div class="col-md-12" id="milkSection">
                                <br>
                                <label style="font-size:20px;">Milk (Required: <span id="milkRequired">0</span>)</label>
                                <div id="milk-batches-container"></div>
                                <div id="milkTotal" class="mt-2 fw-bold text-primary"></div>
                            </div>

                            <!-- Cream Section -->
                            <div class="col-md-12" id="creamSection">
                                <br>
                                <label style="font-size:20px;">Cream (Required: <span id="creamRequired">0</span>)</label>
                                <div id="cream-batches-container"></div>
                                <div id="creamTotal" class="mt-2 fw-bold text-success"></div>
                            </div>

                            <!-- SMP Section -->
                            <div class="col-md-12" id="smpSection">
                                <br>
                                <label style="font-size:20px;">Skimmed Milk Powder (Required: <span id="smpRequired">0</span>)</label>
                                <div id="smp-batches-container"></div>
                                <div id="smpTotal" class="mt-2 fw-bold text-warning"></div>
                            </div>

                            <?php if ($productType == 'fruit') { ?>
                                <!-- Fruit Section -->
                                <div class="col-md-12" id="fruitSection">
                                    <br>
                                    <label style="font-size:20px;"><?php echo $fruitName; ?> (Required: <span id="fruitRequired">0</span>)</label>
                                    <div id="fruit-batches-container"></div>
                                    <div id="fruitTotal" class="mt-2 fw-bold text-danger"></div>
                                </div>
                            <?php } ?>
                        </div>

                        <br>
                        <div id="validationMessage" class="mb-3"></div>
                        <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">Save Production</button>
                    </form>

                    <div id="overallTotalMsg" class="mt-3"></div>

                    <script>
                        let batchCounter = {
                            milk: 0,
                            cream: 0,
                            smp: 0,
                            fruit: 0
                        };

                        let fruitName = "<?php echo $fruitName; ?>";
                        let productType = "<?php echo $productType; ?>";

                        // Function to get available batches for a type with leftqty > 0
                        function getAvailableBatches(type) {
                            const batches = [];
                            
                            if (type === 'milk') {
                                <?php
                                $pqnMilk = mysqli_query($con, "SELECT * FROM tblrawmaterial WHERE pname like '%Pasteurised Skimmed Milk%'");
                                while ($pqdata = mysqli_fetch_assoc($pqnMilk)) {
                                    $prodid = $pqdata['id'];
                                    $sqMilk = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE product='$prodid' AND leftqty > 0 ORDER BY useby ASC");
                                    while ($data = mysqli_fetch_assoc($sqMilk)) {
                                        if ($data['leftqty'] > 0) {
                                        ?>
                                        batches.push({
                                            id: '<?php echo $data['id']; ?>',
                                            batchCode: '<?php echo $data['batchcode']; ?>',
                                            leftQty: <?php echo $data['leftqty']; ?>,
                                            useBy: '<?php echo $data['useby']; ?>'
                                        });
                                        <?php
                                        }
                                    }
                                }
                                ?>
                            } else if (type === 'cream') {
                                <?php
                                $pqnCream = mysqli_query($con, "SELECT * FROM tblrawmaterial WHERE pname like '%Cream%'");
                                while ($pqdata = mysqli_fetch_assoc($pqnCream)) {
                                    $prodid = $pqdata['id'];
                                    $sqCream = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE product='$prodid' AND leftqty > 0 ORDER BY useby ASC");
                                    while ($data = mysqli_fetch_assoc($sqCream)) {
                                        if ($data['leftqty'] > 0) {
                                        ?>
                                         batches.push({
                                            id: '<?php echo $data['id']; ?>',
                                            batchCode: '<?php echo $data['batchcode']; ?>',
                                            leftQty: <?php echo $data['leftqty']; ?>,
                                            useBy: '<?php echo $data['useby']; ?>'
                                        });
                                        <?php
                                        }
                                    }
                                }
                                ?>
                            } else if (type === 'smp') {
                                <?php
                                $pqnSmp = mysqli_query($con, "SELECT * FROM tblrawmaterial WHERE pname like '%Skimmed Milk Powder%'");
                                while ($pqdata = mysqli_fetch_assoc($pqnSmp)) {
                                    $prodid = $pqdata['id'];
                                    $sqSmp = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE product='$prodid' AND leftqty > 0 ORDER BY useby ASC");
                                    while ($data = mysqli_fetch_assoc($sqSmp)) {
                                        if ($data['leftqty'] > 0) {
                                        ?>
                                        batches.push({
                                            id: '<?php echo $data['id']; ?>',
                                            batchCode: '<?php echo $data['batchcode']; ?>',
                                            leftQty: <?php echo $data['leftqty']; ?>,
                                            useBy: '<?php echo $data['useby']; ?>'
                                        });
                                        <?php
                                        }
                                    }
                                }
                                ?>
                            } else if (type === 'fruit') {
                                <?php
                                $fruitQuery = "SELECT g.* FROM tblgrn1 g 
                                JOIN tblrawmaterial r ON g.product = r.id 
                                WHERE (r.pname LIKE '%fruit%'";
                                if (!empty($fruitName)) {
                                    $fruitQuery .= " OR r.pname LIKE '%" . mysqli_real_escape_string($con, $fruitName) . "%'";
                                }
                                $fruitQuery .= ") AND g.leftqty > 0 ORDER BY g.useby ASC";
                                $sqFruit = mysqli_query($con, $fruitQuery);
                                while ($data = mysqli_fetch_assoc($sqFruit)) {
                                    if ($data['leftqty'] > 0) {
                                    ?>
                                    batches.push({
                                        id: '<?php echo $data['id']; ?>',
                                        batchCode: '<?php echo $data['batchcode']; ?>',
                                        leftQty: <?php echo $data['leftqty']; ?>,
                                        useBy: '<?php echo $data['useby']; ?>'
                                    });
                                    <?php
                                    }
                                }
                                ?>
                            }
                            
                            return batches;
                        }

                        // Function to auto-select batches with proper multi-batch handling
                        function autoSelectBatches(type, requiredQty) {
                            if (!requiredQty || requiredQty <= 0) {
                                return;
                            }

                            const availableBatches = getAvailableBatches(type);
                            
                            // Check if there are any batches available
                            if (availableBatches.length === 0) {
                                const totalMsg = document.getElementById(`${type}Total`);
                                if (totalMsg) {
                                    totalMsg.innerHTML = `<span style='color:red; font-size:16px; font-weight:bold;'>❌ No batches available for ${type}!</span>`;
                                }
                                updateSubmitButton();
                                return [];
                            }

                            let remainingRequired = requiredQty;
                            let selectedBatches = [];

                            // Sort batches by useby (oldest first)
                            availableBatches.sort((a, b) => new Date(a.useBy) - new Date(b.useBy));

                            // Loop through available batches until requirement is met or no more batches
                            for (let batch of availableBatches) {
                                if (remainingRequired <= 0) break;
                                
                                // Calculate how much to take from this batch
                                let useQty = Math.min(batch.leftQty, remainingRequired);
                                if (useQty > 0) {
                                    selectedBatches.push({
                                        ...batch,
                                        useQty: useQty
                                    });
                                    remainingRequired -= useQty;
                                }
                            }

                            // Clear existing batches
                            const container = document.getElementById(`${type}-batches-container`);
                            container.innerHTML = '';
                            batchCounter[type] = 0;

                            // Add selected batches to container
                            selectedBatches.forEach(batch => {
                                addBatchToContainer(type, batch.id, batch.batchCode, batch.leftQty, batch.useBy, batch.useQty);
                            });

                            // Show shortage message if requirement not fully met
                            if (remainingRequired > 0) {
                                const totalUsed = selectedBatches.reduce((sum, b) => sum + b.useQty, 0);
                                const totalMsg = document.getElementById(`${type}Total`);
                                if (totalMsg) {
                                    totalMsg.innerHTML = `<span style='color:red; font-size:16px; font-weight:bold;'>⚠️ Shortage! Only ${totalUsed.toFixed(2)} available out of ${requiredQty.toFixed(2)} required</span>`;
                                }
                            }

                            // Recalculate totals
                            recalculateTotal(type);
                            
                            return selectedBatches;
                        }

                        // Function to add batch to container
                        function addBatchToContainer(type, batchId, batchCode, leftQty, useBy, useQty) {
                            const container = document.getElementById(`${type}-batches-container`);
                            const batchIndex = batchCounter[type]++;

                            let displayName = type.charAt(0).toUpperCase() + type.slice(1);
                            if (type === 'fruit' && fruitName) {
                                displayName = fruitName;
                            }

                            const batchHtml = `
                                <div class="row mt-2 batch-row" data-batch-id="${batchId}" data-type="${type}">
                                    <div class="col-md-3">
                                        <label>Batch Code</label>
                                        <input type="text" value="${batchCode}" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Left Quantity</label>
                                        <input type="text" value="${leftQty}" class="form-control left-qty" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Use By Date</label>
                                        <input type="date" value="${useBy}" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>${displayName} Quantity Used</label>
                                        <input type="number"
                                            name="${type}used[${batchId}]"
                                            class="form-control qty-input ${type}-input"
                                            step="0.01"
                                            max="${leftQty}"
                                            value="${useQty.toFixed(2)}"
                                            data-type="${type}"
                                            data-leftqty="${leftQty}"
                                            oninput="validateQty(this, ${leftQty}, '${type}Total', '${type}Required')">
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm remove-batch" onclick="removeBatch(this, '${type}')">Remove</button>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="text-danger d-none" id="msg-${batchId}"></h4>
                                    </div>
                                </div>
                            `;

                            container.insertAdjacentHTML('beforeend', batchHtml);
                        }

                        // Remove batch function
                        function removeBatch(button, type) {
                            const row = button.closest('.batch-row');
                            const removedBatchId = row.getAttribute('data-batch-id');
                            
                            // Remove row
                            row.remove();

                            // Recalculate totals
                            recalculateTotal(type);
                            
                            // Auto-select replacement batch if needed
                            const requiredQty = parseFloat(document.getElementById(`${type}Required`).innerText);
                            const currentTotal = getTotalUsed(type);
                            
                            if (currentTotal < requiredQty) {
                                // Recalculate and auto-select new batches
                                autoSelectBatches(type, requiredQty);
                            }
                        }

                        // Calculate production requirements
                        function calculateProduction() {
                            const batchQty = parseFloat(document.getElementById('batchQty').value) || 0;
                            const creamFactor = parseFloat(document.getElementById('creamFactor').value) || 0;
                            const smpFactor = parseFloat(document.getElementById('smpFactor').value) || 0;
                            const productType = document.getElementById('productType').value;

                            let cream = batchQty * creamFactor;
                            let smp = batchQty * smpFactor;
                            let milk = 0;
                            let fruit = 0;

                            if (productType === 'fruit') {
                                const fruitFactor = parseFloat(document.getElementById('fruitFactor').value) || 0.16;
                                fruit = batchQty * fruitFactor;
                                milk = batchQty - cream - smp - fruit;

                                if (document.getElementById('calculatedFruit')) {
                                    document.getElementById('calculatedFruit').value = fruit.toFixed(2);
                                    document.getElementById('fruitRequired').innerText = fruit.toFixed(2);
                                }
                                document.getElementById('finalFruit').value = fruit.toFixed(2);
                            } else {
                                milk = batchQty - cream - smp;
                            }

                            document.getElementById('calculatedCream').value = cream.toFixed(2);
                            document.getElementById('calculatedSmp').value = smp.toFixed(2);
                            document.getElementById('calculatedMilk').value = milk.toFixed(2);

                            document.getElementById('creamRequired').innerText = cream.toFixed(2);
                            document.getElementById('smpRequired').innerText = smp.toFixed(2);
                            document.getElementById('milkRequired').innerText = milk.toFixed(2);

                            document.getElementById('finalCream').value = cream.toFixed(2);
                            document.getElementById('finalSmp').value = smp.toFixed(2);
                            document.getElementById('finalMilk').value = milk.toFixed(2);
                            document.getElementById('totalQty').value = batchQty;

                            // Hide/show sections based on required quantity
                            toggleSection('milkSection', milk);
                            toggleSection('creamSection', cream);
                            toggleSection('smpSection', smp);
                            if (productType === 'fruit') {
                                toggleSection('fruitSection', fruit);
                            }

                            // Show warning if milk is negative
                            const milkField = document.getElementById('calculatedMilk');
                            if (milk < 0) {
                                milkField.style.color = "red";
                                milkField.style.backgroundColor = "#ffe6e6";
                                milkField.style.fontWeight = "bold";
                            } else {
                                milkField.style.color = "";
                                milkField.style.backgroundColor = "#e8f5e9";
                                milkField.style.fontWeight = "";
                            }

                            // Clear existing batches and auto-select
                            ['milk', 'cream', 'smp', 'fruit'].forEach(type => {
                                if (document.getElementById(`${type}Required`)) {
                                    const required = parseFloat(document.getElementById(`${type}Required`).innerText);
                                    if (required > 0) {
                                        // Clear container
                                        document.getElementById(`${type}-batches-container`).innerHTML = '';
                                        batchCounter[type] = 0;
                                        // Auto-select batches
                                        autoSelectBatches(type, required);
                                    }
                                }
                            });
                        }

                        // Toggle section visibility
                        function toggleSection(sectionId, requiredQty) {
                            const section = document.getElementById(sectionId);
                            if (section) {
                                if (requiredQty <= 0) {
                                    section.style.display = 'none';
                                } else {
                                    section.style.display = 'block';
                                }
                            }
                        }

                        function recalculateTotal(type) {
                            let total = 0;
                            document.querySelectorAll(`.${type}-input`).forEach(el => {
                                let val = parseFloat(el.value);
                                if (!isNaN(val)) total += val;
                            });

                            const requiredQty = parseFloat(document.getElementById(`${type}Required`).innerText);
                            const target = document.getElementById(`${type}Total`);

                            if (target && requiredQty > 0) {
                                if (total > requiredQty) {
                                    target.innerHTML = "<span style='color:red; font-size:16px; font-weight:bold;'>❌ EXCEEDED! Used: " + total.toFixed(2) + " / Required: " + requiredQty.toFixed(2) + "</span>";
                                } else if (total < requiredQty) {
                                    // Check if there are more batches available
                                    const availableBatches = getAvailableBatches(type);
                                    const totalAvailable = availableBatches.reduce((sum, b) => sum + b.leftQty, 0);
                                    
                                    if (totalAvailable < requiredQty) {
                                        target.innerHTML = `<span style='color:red; font-size:16px; font-weight:bold;'>❌ Not enough batches! Only ${totalAvailable.toFixed(2)} available, need ${requiredQty.toFixed(2)}</span>`;
                                    } else if (availableBatches.length === 0) {
                                        target.innerHTML = `<span style='color:red; font-size:16px; font-weight:bold;'>❌ No batches available for ${type}!</span>`;
                                    } else {
                                        target.innerHTML = "<span style='color:#ff9800; font-size:16px; font-weight:bold;'>⚠️ Shortage! Used: " + total.toFixed(2) + " / Required: " + requiredQty.toFixed(2) + "</span>";
                                    }
                                } else if (total == requiredQty && total > 0) {
                                    target.innerHTML = "<span style='color:green; font-size:16px; font-weight:bold;'>✓ Complete! Used: " + total.toFixed(2) + " = Required: " + requiredQty.toFixed(2) + "</span>";
                                } else {
                                    target.innerHTML = "";
                                }
                            }

                            checkOverallTotal();
                            updateSubmitButton();
                        }

                        function checkOverallTotal() {
                            let totalUsed = 0;
                            let totalRequired = 0;

                            ['milk', 'cream', 'smp', 'fruit'].forEach(type => {
                                if (document.getElementById(`${type}Required`)) {
                                    totalUsed += getTotalUsed(type);
                                    totalRequired += parseFloat(document.getElementById(`${type}Required`).innerText) || 0;
                                }
                            });

                            const overallMsg = document.getElementById('overallTotalMsg');
                            if (overallMsg && totalRequired > 0) {
                                if (totalUsed > totalRequired) {
                                    overallMsg.innerHTML = "<div style='background:#f8d7da; color:red; padding:10px; border-radius:5px;'><strong>❌ OVERALL EXCEEDED!</strong> Total Used: " + totalUsed.toFixed(2) + " / Required: " + totalRequired.toFixed(2) + "</div>";
                                } else if (totalUsed < totalRequired && totalUsed > 0) {
                                    overallMsg.innerHTML = "<div style='background:#e7f3ff; color:#004085; padding:10px; border-radius:5px;'><strong>⚠️ Partial Production:</strong> " + totalUsed.toFixed(2) + " / " + totalRequired.toFixed(2) + "</div>";
                                } else if (totalUsed == totalRequired && totalUsed > 0) {
                                    overallMsg.innerHTML = "<div style='background:#d4edda; color:green; padding:10px; border-radius:5px;'><strong>✓ COMPLETE!</strong> Total Used: " + totalUsed.toFixed(2) + " = Required: " + totalRequired.toFixed(2) + "</div>";
                                } else if (totalUsed == 0 && totalRequired > 0) {
                                    overallMsg.innerHTML = "<div style='background:#e7f3ff; color:#004085; padding:10px; border-radius:5px;'>Required: " + totalRequired.toFixed(2) + " - Selecting batches...</div>";
                                }
                            }
                        }

                        function getTotalUsed(type) {
                            let total = 0;
                            document.querySelectorAll(`.${type}-input`).forEach(el => {
                                let val = parseFloat(el.value);
                                if (!isNaN(val)) total += val;
                            });
                            return total;
                        }

                        function validateQty(input, max, totalId, requiredId) {
                            const idMatch = input.name.match(/\d+/);
                            if (!idMatch) return;
                            const msg = document.getElementById("msg-" + idMatch[0]);

                            let currentValue = parseFloat(input.value);
                            if (isNaN(currentValue)) currentValue = 0;

                            const leftQty = parseFloat(input.getAttribute('data-leftqty') || max);

                            if (currentValue > leftQty) {
                                input.value = leftQty;
                                currentValue = leftQty;
                                if (msg) {
                                    msg.classList.remove("d-none");
                                    msg.innerHTML = "Quantity cannot exceed " + leftQty;
                                }
                            } else if (msg) {
                                msg.classList.add("d-none");
                            }

                            const type = input.getAttribute('data-type');
                            recalculateTotal(type);
                        }

                        function updateSubmitButton() {
                            const submitBtn = document.getElementById('submitBtn');
                            const validationMsg = document.getElementById('validationMessage');
                            let allComplete = true;
                            let hasShortage = false;
                            let hasExceeded = false;
                            let totalRequired = 0;
                            let totalUsed = 0;
                            let hasNotEnoughBatches = false;
                            let hasNoBatches = false;

                            ['milk', 'cream', 'smp', 'fruit'].forEach(type => {
                                if (document.getElementById(`${type}Required`)) {
                                    const required = parseFloat(document.getElementById(`${type}Required`).innerText) || 0;
                                    const used = getTotalUsed(type);
                                    totalRequired += required;
                                    totalUsed += used;

                                    if (required > 0) {
                                        if (used < required) {
                                            allComplete = false;
                                            hasShortage = true;
                                            
                                            // Check if there are enough batches available
                                            const availableBatches = getAvailableBatches(type);
                                            const totalAvailable = availableBatches.reduce((sum, b) => sum + b.leftQty, 0);
                                            if (totalAvailable < required) {
                                                hasNotEnoughBatches = true;
                                            }
                                            if (availableBatches.length === 0) {
                                                hasNoBatches = true;
                                            }
                                        } else if (used > required) {
                                            allComplete = false;
                                            hasExceeded = true;
                                        }
                                    }
                                }
                            });

                            let hasEmptyRequired = false;
                            ['milk', 'cream', 'smp', 'fruit'].forEach(type => {
                                if (document.getElementById(`${type}Required`)) {
                                    const required = parseFloat(document.getElementById(`${type}Required`).innerText) || 0;
                                    const used = getTotalUsed(type);
                                    if (required > 0 && used === 0) {
                                        hasEmptyRequired = true;
                                    }
                                }
                            });

                            if (hasExceeded) {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-danger"><strong>❌ Error:</strong> Some quantities exceed the required amount. Please adjust the quantities.</div>';
                            } else if (hasNoBatches) {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-danger"><strong>❌ Error:</strong> No batches available for some required materials. Please add raw materials first.</div>';
                            } else if (hasNotEnoughBatches) {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-danger"><strong>❌ Error:</strong> Not enough batches available to meet the production requirement. Please add more raw materials.</div>';
                            } else if (hasShortage || hasEmptyRequired) {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-warning"><strong>⚠️ Warning:</strong> Required quantities are not fully met. Please check batch availability.</div>';
                            } else if (totalRequired > 0 && totalUsed === totalRequired) {
                                submitBtn.disabled = false;
                                validationMsg.innerHTML = '<div class="alert alert-success"><strong>✓ Complete!</strong> All required quantities are met. You can now submit.</div>';
                            } else if (totalRequired === 0) {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-info">No production required for this product.</div>';
                            } else {
                                submitBtn.disabled = true;
                                validationMsg.innerHTML = '<div class="alert alert-info">Please wait while batches are being selected...</div>';
                            }
                        }

                        function validateForm() {
                            let totalUsed = 0;
                            let totalRequired = 0;
                            let hasError = false;
                            let errorMessage = '';

                            ['milk', 'cream', 'smp', 'fruit'].forEach(type => {
                                if (document.getElementById(`${type}Required`)) {
                                    const required = parseFloat(document.getElementById(`${type}Required`).innerText) || 0;
                                    const used = getTotalUsed(type);
                                    totalRequired += required;
                                    totalUsed += used;

                                    if (required > 0 && used < required) {
                                        let typeName = type.charAt(0).toUpperCase() + type.slice(1);
                                        if (type === 'fruit' && fruitName) {
                                            typeName = fruitName;
                                        }
                                        hasError = true;
                                        errorMessage += `${typeName}: Required ${required.toFixed(2)}, Available ${used.toFixed(2)}\n`;
                                    } else if (required > 0 && used > required) {
                                        let typeName = type.charAt(0).toUpperCase() + type.slice(1);
                                        if (type === 'fruit' && fruitName) {
                                            typeName = fruitName;
                                        }
                                        hasError = true;
                                        errorMessage += `${typeName}: EXCEEDED! Required ${required.toFixed(2)}, Used ${used.toFixed(2)}\n`;
                                    }
                                }
                            });

                            if (hasError) {
                                document.getElementById('validationMessage').innerHTML = 
                                    '<div class="alert alert-danger"><strong>❌ Error:</strong><br><pre>' + errorMessage + '</pre>Please fix the quantities before submitting.</div>';
                                return false;
                            }

                            if (totalUsed === 0) {
                                document.getElementById('validationMessage').innerHTML = 
                                    '<div class="alert alert-warning">No batches selected!</div>';
                                return false;
                            }

                            if (totalUsed < totalRequired) {
                                document.getElementById('validationMessage').innerHTML = 
                                    '<div class="alert alert-warning">Required quantities are not fully met. Please check batch availability.</div>';
                                return false;
                            }

                            if (totalUsed > totalRequired) {
                                document.getElementById('validationMessage').innerHTML = 
                                    '<div class="alert alert-danger">Total used exceeds required quantity!</div>';
                                return false;
                            }

                            return true;
                        }

                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            const existingQty = <?php echo $row['qty']; ?>;
                            if (existingQty > 0) {
                                document.getElementById('batchQty').value = existingQty;
                                calculateProduction();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Simple PHP processing code with error checking
if (isset($_POST['submit'])) {
    
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Get values from form
    $uid = mysqli_real_escape_string($con, $_GET['uid']);
    $pid = mysqli_real_escape_string($con, $_GET['pid']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $cream = mysqli_real_escape_string($con, $_POST['cream']);
    $smp = mysqli_real_escape_string($con, $_POST['smp']);
    $milk = mysqli_real_escape_string($con, $_POST['milk']);
    $fruit = isset($_POST['fruit']) ? mysqli_real_escape_string($con, $_POST['fruit']) : '0';
    $fruit_name = isset($_POST['fruit_name']) ? mysqli_real_escape_string($con, $_POST['fruit_name']) : '';
    
    // Validate that quantities match requirements before processing
    $validationPassed = true;
    $validationErrors = [];
    
    // Check if all required quantities are met
    $checkQuery = "SELECT * FROM tblyogurt WHERE id='$pid'";
    $checkResult = mysqli_query($con, $checkQuery);
    $productCheck = mysqli_fetch_assoc($checkResult);
    
    $requiredCream = $qty * $productCheck['cream'];
    $requiredSmp = $qty * $productCheck['smp'];
    $requiredFruit = ($productCheck['type'] == 'fruit') ? $qty * 0.16 : 0;
    $requiredMilk = $qty - $requiredCream - $requiredSmp - $requiredFruit;
    
    // Check each material's total used
    $totalMilkUsed = isset($_POST['milkused']) ? array_sum($_POST['milkused']) : 0;
    $totalCreamUsed = isset($_POST['creamused']) ? array_sum($_POST['creamused']) : 0;
    $totalSmpUsed = isset($_POST['smpused']) ? array_sum($_POST['smpused']) : 0;
    $totalFruitUsed = isset($_POST['fruitused']) ? array_sum($_POST['fruitused']) : 0;
    
    if (abs($totalMilkUsed - $requiredMilk) > 0.01) {
        $validationPassed = false;
        $validationErrors[] = "Milk quantity mismatch: Required $requiredMilk, Used $totalMilkUsed";
    }
    
    if (abs($totalCreamUsed - $requiredCream) > 0.01) {
        $validationPassed = false;
        $validationErrors[] = "Cream quantity mismatch: Required $requiredCream, Used $totalCreamUsed";
    }
    
    if (abs($totalSmpUsed - $requiredSmp) > 0.01) {
        $validationPassed = false;
        $validationErrors[] = "SMP quantity mismatch: Required $requiredSmp, Used $totalSmpUsed";
    }
    
    if ($productCheck['type'] == 'fruit' && abs($totalFruitUsed - $requiredFruit) > 0.01) {
        $validationPassed = false;
        $validationErrors[] = "Fruit quantity mismatch: Required $requiredFruit, Used $totalFruitUsed";
    }
    
    if (!$validationPassed) {
        echo "<div class='alert alert-danger'>";
        echo "<strong>Validation Error:</strong><br>";
        echo implode("<br>", $validationErrors);
        echo "</div>";
        exit;
    }
    
    $success_count = 0;
    $error_count = 0;
    
    // Update Milk batches left quantity
    if (!empty($_POST['milkused'])) {
        foreach ($_POST['milkused'] as $id => $used) {
            if ($used > 0) {
                // First check if the batch still has enough left quantity
                $checkBatchQty = mysqli_query($con, "SELECT leftqty FROM tblgrn1 WHERE id='$id'");
                $batchQtyData = mysqli_fetch_assoc($checkBatchQty);
                
                if ($batchQtyData['leftqty'] >= $used) {
                    $updateQuery = "UPDATE tblgrn1 SET leftqty = leftqty - $used WHERE id = '$id'";
                    if (mysqli_query($con, $updateQuery)) {
                        
                        $batchQuery = mysqli_query($con, "SELECT grncode as grn, useby, batchcode FROM tblgrn1 WHERE id = '$id'");
                        $batchData = mysqli_fetch_assoc($batchQuery);
                        
                        $insertSql = "INSERT INTO tblyogurt2 (uid, pid, qty, cream, smp, milk, fruit, grn, useby, useqty, type, fruit_name, batchcode) 
                                      VALUES ('$uid', '$pid', '$qty', '$cream', '$smp', '$milk', '$fruit', '$batchData[grn]', '$batchData[useby]', '$used', 'milk', '$fruit_name', '$batchData[batchcode]')";
                        
                        if (mysqli_query($con, $insertSql)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                    $validationErrors[] = "Batch $id doesn't have enough milk quantity";
                }
            }
        }
    }
    
    // Update Cream batches left quantity
    if (!empty($_POST['creamused'])) {
        foreach ($_POST['creamused'] as $id => $used) {
            if ($used > 0) {
                $checkBatchQty = mysqli_query($con, "SELECT leftqty FROM tblgrn1 WHERE id='$id'");
                $batchQtyData = mysqli_fetch_assoc($checkBatchQty);
                
                if ($batchQtyData['leftqty'] >= $used) {
                    $updateQuery = "UPDATE tblgrn1 SET leftqty = leftqty - $used WHERE id = '$id'";
                    if (mysqli_query($con, $updateQuery)) {
                        $batchQuery = mysqli_query($con, "SELECT grncode as grn, useby, batchcode FROM tblgrn1 WHERE id = '$id'");
                        $batchData = mysqli_fetch_assoc($batchQuery);
                        
                        $insertSql = "INSERT INTO tblyogurt2 (uid, pid, qty, cream, smp, milk, fruit, grn, useby, useqty, type, fruit_name, batchcode) 
                                      VALUES ('$uid', '$pid', '$qty', '$cream', '$smp', '$milk', '$fruit', '$batchData[grn]', '$batchData[useby]', '$used', 'cream', '$fruit_name', '$batchData[batchcode]')";
                        
                        if (mysqli_query($con, $insertSql)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                    $validationErrors[] = "Batch $id doesn't have enough cream quantity";
                }
            }
        }
    }
    
    // Update SMP batches left quantity
    if (!empty($_POST['smpused'])) {
        foreach ($_POST['smpused'] as $id => $used) {
            if ($used > 0) {
                $checkBatchQty = mysqli_query($con, "SELECT leftqty FROM tblgrn1 WHERE id='$id'");
                $batchQtyData = mysqli_fetch_assoc($checkBatchQty);
                
                if ($batchQtyData['leftqty'] >= $used) {
                    $updateQuery = "UPDATE tblgrn1 SET leftqty = leftqty - $used WHERE id = '$id'";
                    if (mysqli_query($con, $updateQuery)) {
                        $batchQuery = mysqli_query($con, "SELECT grncode as grn, useby, batchcode FROM tblgrn1 WHERE id = '$id'");
                        $batchData = mysqli_fetch_assoc($batchQuery);
                        
                        $insertSql = "INSERT INTO tblyogurt2 (uid, pid, qty, cream, smp, milk, fruit, grn, useby, useqty, type, fruit_name, batchcode) 
                                      VALUES ('$uid', '$pid', '$qty', '$cream', '$smp', '$milk', '$fruit', '$batchData[grn]', '$batchData[useby]', '$used', 'smp', '$fruit_name', '$batchData[batchcode]')";
                        
                        if (mysqli_query($con, $insertSql)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                    $validationErrors[] = "Batch $id doesn't have enough SMP quantity";
                }
            }
        }
    }
    
    // Update Fruit batches left quantity (if fruit yogurt)
    if (!empty($_POST['fruitused'])) {
        foreach ($_POST['fruitused'] as $id => $used) {
            if ($used > 0) {
                $checkBatchQty = mysqli_query($con, "SELECT leftqty FROM tblgrn1 WHERE id='$id'");
                $batchQtyData = mysqli_fetch_assoc($checkBatchQty);
                
                if ($batchQtyData['leftqty'] >= $used) {
                    $updateQuery = "UPDATE tblgrn1 SET leftqty = leftqty - $used WHERE id = '$id'";
                    if (mysqli_query($con, $updateQuery)) {
                        $batchQuery = mysqli_query($con, "SELECT grncode as grn, useby, batchcode FROM tblgrn1 WHERE id = '$id'");
                        $batchData = mysqli_fetch_assoc($batchQuery);
                        
                        $insertSql = "INSERT INTO tblyogurt2 (uid, pid, qty, cream, smp, milk, fruit, grn, useby, useqty, type, fruit_name, batchcode) 
                                      VALUES ('$uid', '$pid', '$qty', '$cream', '$smp', '$milk', '$fruit', '$batchData[grn]', '$batchData[useby]', '$used', 'fruit', '$fruit_name', '$batchData[batchcode]')";
                        
                        if (mysqli_query($con, $insertSql)) {
                            $success_count++;
                        } else {
                            $error_count++;
                        }
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                    $validationErrors[] = "Batch $id doesn't have enough fruit quantity";
                }
            }
        }
    }
    
    // Show success message and redirect
    if ($success_count > 0 && $error_count == 0) {
        echo "<div class='alert alert-success'>Production saved successfully! $success_count batch(es) recorded.</div>";
        ?>
        <script>
            setTimeout(function() {
                window.location.href = 'admin.php?id=yogurtproduction';
            }, 2000);
        </script>
        <?php
    } else {
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error:</strong> $error_count error(s) occurred while saving.<br>";
        if (!empty($validationErrors)) {
            echo implode("<br>", $validationErrors);
        }
        echo "</div>";
    }
}
?> 
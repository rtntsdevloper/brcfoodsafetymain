<?php

// ── Remember customer / date / invoice / product across reloads ──
$savedCustomer = isset($_POST['customer']) ? $_POST['customer'] : '';
$savedDisdate  = isset($_POST['disdate'])  ? $_POST['disdate']  : '';
$savedInvoice  = isset($_POST['invoice'])  ? $_POST['invoice']  : '';
$savedProduct  = isset($_POST['product'])  ? (int)$_POST['product'] : 0;

// ── Product names ──
$productNames = [2 => 'Samosa', 3 => 'Spring roll'];

// ── Init session cart for added rows ──
if (!isset($_SESSION['goodsout_rows'])) {
    $_SESSION['goodsout_rows'] = [];
}

// ── Clear all rows ──
if (isset($_POST['clear_rows'])) {
    $_SESSION['goodsout_rows'] = [];
}

// ── Delete selected rows ──
if (isset($_POST['delete_rows']) && !empty($_POST['del_index'])) {
    foreach ($_POST['del_index'] as $idx) {
        $idx = (int)$idx;
        if (isset($_SESSION['goodsout_rows'][$idx])) {
            unset($_SESSION['goodsout_rows'][$idx]);
        }
    }
    $_SESSION['goodsout_rows'] = array_values($_SESSION['goodsout_rows']);
}

// ── Add a row to session ──
if (isset($_POST['add_row'])) {
    $productId   = $_POST['add_prid'];
    $productName = $_POST['add_product'];
    $batchId     = $_POST['add_batchid'];
    $batchCode   = $_POST['add_batchcode'];
    $bestBefore  = $_POST['add_useby'];
    $boxes       = $_POST['add_boxes'];

    if ($productId > 0 && $batchId > 0 && $boxes > 0) {
        $_SESSION['goodsout_rows'][] = [
            'prid'      => $productId,
            'product'   => $productName,
            'batchid'   => $batchId,
            'batchcode' => $batchCode,
            'useby'     => $bestBefore,
            'boxes'     => $boxes,
        ];
    }
}

// ── Build "boxes already added in session" map: batchcode => total boxes added ──
$addedByBatch = [];
foreach ($_SESSION['goodsout_rows'] as $row) {
    $bc = $row['batchcode'];
    if (!isset($addedByBatch[$bc])) {
        $addedByBatch[$bc] = 0;
    }
    $addedByBatch[$bc] += (int)$row['boxes'];
}

// ── Products ──
$products = [];
$sqlProd = mysqli_query(
    $con,
    "SELECT DISTINCT product
     FROM `frozenproduction`
     WHERE boxing = 'done'
     ORDER BY product ASC"
);
while ($row = mysqli_fetch_assoc($sqlProd)) {
    $pid = (int)$row['product'];
    if (!isset($productNames[$pid])) {
        continue;
    }
    $products[] = [
        'id'   => $pid,
        'name' => $productNames[$pid],
    ];
}

// ── ALL batches grouped by product (only where leftbox - added > 0) ──
$batchesByProduct = [];

$sqlAll = mysqli_query(
    $con,
    "SELECT product, batchcode
     FROM `frozenproduction`
     WHERE boxing = 'done'
     ORDER BY product ASC, id DESC"
);
while ($p = mysqli_fetch_assoc($sqlAll)) {
    $pid = (int)$p['product'];
    if (!isset($productNames[$pid])) {
        continue;
    }
    $bc = mysqli_real_escape_string($con, $p['batchcode']);

    $fb = mysqli_query(
        $con,
        "SELECT * FROM `frozenboxing`
         WHERE `productbatch` = '$bc'
         LIMIT 1"
    );
    if ($f = mysqli_fetch_assoc($fb)) {
        $leftBox = (int)$f['leftbox'];

        // Subtract boxes already added in session for this batch
        $alreadyAdded = isset($addedByBatch[$p['batchcode']]) ? $addedByBatch[$p['batchcode']] : 0;
        $available    = $leftBox - $alreadyAdded;

        // Skip if nothing left
        if ($available <= 0) {
            continue;
        }

        $packPerBox = (int)$f['pack'];
        $totalBox   = (int)$f['totalbox'];

        if (!isset($batchesByProduct[$pid])) {
            $batchesByProduct[$pid] = [];
        }
        $batchesByProduct[$pid][] = [
            'fb_id'        => $f['id'],
            'productbatch' => $f['productbatch'],
            'bestbefore'   => $f['bestbefore'],
            'packperbox'   => $packPerBox,
            'totalbox'     => $totalBox,
            'leftbox'      => $available,   // remaining after session adds
            'boxbatchcode' => $f['boxbatchcode'],
        ];
    }
}

// ── Customers ──
$customers = [];
$sqlCust = mysqli_query($con, "SELECT id, name FROM tblcustomer ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($sqlCust)) {
    $customers[] = $row;
}

// ── Final submit ──
if (isset($_POST['sbtn']) && !empty($_SESSION['goodsout_rows'])) {
    $disdate  = mysqli_real_escape_string($con, $_POST['disdate']);
    $customer = mysqli_real_escape_string($con, $_POST['customer']);
    $invoice  = isset($_POST['invoice']) ? mysqli_real_escape_string($con, $_POST['invoice']) : '';
    $gdncode  = "GDN" . date('dmyhis') . rand(10, 99);
    $cdate    = date('Y-m-d');

    mysqli_query(
        $con,
        "INSERT INTO `tblgdn`(`customer`,`cdate`,`gdn`,`po`)
         VALUES ('$customer','$disdate','$gdncode','$invoice')"
    );

    $ix = 1;
    foreach ($_SESSION['goodsout_rows'] as $r) {
        $product   = mysqli_real_escape_string($con, $r['product']);
        $batchCode = mysqli_real_escape_string($con, $r['batchcode']);
        $useby     = mysqli_real_escape_string($con, $r['useby']);
        $boxreq    = (int)$r['boxes'];
        $gdncode1  = $gdncode . "/" . $ix;

        mysqli_query(
            $con,
            "INSERT INTO `tblgdn1`
                (`customer`,`cdate`,`date`,`gdn`,`batch`,`product`,`qty`,`box`,`useby`,`batchcode`)
             VALUES
                ('$customer','$disdate','$cdate','$gdncode','$gdncode1','$product','$boxreq','$boxreq','$useby','$batchCode')"
        );

        // ── Get current leftbox, subtract, update ──
        $selQ = mysqli_query(
            $con,
            "SELECT * FROM `frozenboxing`
             WHERE `productbatch` = '$batchCode'
             LIMIT 1"
        );
        if ($fr = mysqli_fetch_assoc($selQ)) {
            $curLeft = (int)$fr['leftbox'];
            $newLeft = $curLeft - $boxreq;
            if ($newLeft < 0) {
                $newLeft = 0;
            }

            mysqli_query(
                $con,
                "UPDATE `frozenboxing`
                 SET `leftbox` = $newLeft
                 WHERE `productbatch` = '$batchCode'"
            );
        }

        $ix++;
    }

    $_SESSION['goodsout_rows'] = [];

    echo '<script>window.location.href = "admin.php?id=goodsout";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Out Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #FAF7F2;
            --fg: #2C2417;
            --muted: #8A7E6B;
            --accent: #C85A2A;
            --card: #fff;
            --border: #E8E0D4;
            --input-bg: #FDFCFA;
            --cream: #F5EDE0;
            --green: #4A7C59;
            --red: #C0392B;
            --red-light: #FDECEB;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #C85A2A, #E07B4A);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 26px;
            flex-shrink: 0;
        }

        .brand-text h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 28px;
            margin: 0;
        }

        .brand-text p {
            font-size: 13px;
            color: var(--muted);
            margin: 4px 0 0;
        }

        .form-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(44, 36, 23, 0.06);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
            padding-bottom: 14px;
            border-bottom: 2px solid var(--cream);
        }

        .section-title h2 {
            font-size: 17px;
            margin: 0;
            font-weight: 700;
        }

        .section-title .icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #C85A2A, #E07B4A);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .badge-tag {
            margin-left: auto;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: var(--cream);
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .form-control,
        .form-select {
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: var(--fg);
        }

        .form-control:focus,
        .form-select:focus {
            background: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200, 90, 42, 0.12);
        }

        .form-control[readonly] {
            background: #F5EDE0;
        }

        .btn-add-frame {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 18px;
            border: 2px dashed var(--border);
            background: transparent;
            color: var(--muted);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-add-frame:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-submit {
            background: linear-gradient(135deg, #C85A2A, #D4693A);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 36px;
            font-size: 15px;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(200, 90, 42, 0.3);
        }

        .btn-submit:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--red-light);
            color: var(--red);
            border: 1.5px solid var(--red);
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
        }

        .table thead th {
            background: var(--cream);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            border-color: var(--border);
        }

        .table td,
        .table th {
            border-color: var(--border);
        }

        .stock-info {
            font-size: 12.5px;
            color: var(--fg);
            margin-top: 6px;
            background: #FDFAF5;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 12px;
        }

        .stock-info .label {
            color: var(--muted);
        }

        .stock-info strong {
            color: var(--green);
        }
    </style>
</head>

<body>

    <div class="container py-5" style="max-width:1100px;">
        <div class="container py-5" style="max-width:1100px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="brand-icon"><i class="bi bi-box-seam-fill"></i></div>
                <div class="brand-text">
                    <h1>Goods Out Detail</h1>
                    <p>Frozen Products Dispatch Form</p>
                </div>
                <a href="admin.php?id=frozen" style="margin-left:auto;" class="text-success"> <i class="fa fa-arrow-left"></i> Back</a>
            </div>

            <form method="post" id="mainForm">

                <!-- Customer Details -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="icon-circle"><i class="bi bi-person-fill"></i></div>
                        <h2>Customer Details</h2>
                        <span class="badge-tag">Required</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Dispatch Date</label>
                            <input type="date" class="form-control" id="dispatchDate" name="disdate"
                                value="<?= htmlspecialchars($savedDisdate) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Customer Name</label>
                            <select class="form-select" name="customer" id="customerSel" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c): ?>
                                    <option value="<?= $c['id'] ?>"
                                        <?= ($savedCustomer == $c['id'] ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($c['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Invoice no.</label>
                            <input type="text" class="form-control" name="invoice"
                                value="<?= htmlspecialchars($savedInvoice) ?>">
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="form-section">
                    <div class="section-title">
                        <h2>Product Details</h2>
                        <span class="badge-tag">Boxing Done Only</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product</label>
                            <select class="form-select" name="product" id="productSel" onchange="loadBatches()">
                                <option value="">Select Product</option>
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p['id'] ?>"
                                        <?= ($savedProduct == $p['id'] ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($p['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Select Batch</label>
                            <select class="form-select" id="batchSel" name="batchsel" onchange="onBatchChange()">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Boxes Left</label>
                            <input type="text" class="form-control" id="totalBoxes" readonly>
                            <div class="stock-info" id="stockInfo"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Best Before</label>
                            <input type="date" class="form-control" id="usebyDate" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. of Boxes Required</label>
                            <input type="number" class="form-control" id="boxesInput" min="0" value="0">
                        </div>

                        <div class="col-12">
                            <p id="errorMsg" class="text-danger mb-0" style="font-size:13px"></p>
                        </div>

                        <input type="hidden" name="add_prid" id="add_prid">
                        <input type="hidden" name="add_product" id="add_product">
                        <input type="hidden" name="add_batchid" id="add_batchid">
                        <input type="hidden" name="add_batchcode" id="add_batchcode">
                        <input type="hidden" name="add_useby" id="add_useby">
                        <input type="hidden" name="add_boxes" id="add_boxes">

                        <div class="col-12 mt-3">
                            <button type="button" class="btn-add-frame" onclick="addRow()">
                                <i class="bi bi-plus-circle"></i> Add Product to List
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Added Rows -->
                <div class="form-section">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th style="width:40px"></th>
                                    <th>Product</th>
                                    <th>Batch Code</th>
                                    <th>Best Before</th>
                                    <th>Boxes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($_SESSION['goodsout_rows'])): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No products added yet.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($_SESSION['goodsout_rows'] as $i => $r): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="del_index[]" value="<?= $i ?>">
                                            </td>
                                            <td><?= htmlspecialchars($r['product']) ?></td>
                                            <td><?= htmlspecialchars($r['batchcode']) ?></td>
                                            <td><?= htmlspecialchars($r['useby']) ?></td>
                                            <td><?= (int)$r['boxes'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" name="delete_rows" class="btn btn-danger">Delete Row</button>

                    <div class="text-center mt-4">
                        <button type="submit" name="sbtn" class="btn btn-submit">
                            <i class="bi bi-check2-circle"></i> Submit Goods Out Details
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // ── All batches preloaded from PHP, grouped by product id ──
            var batchesByProduct = <?= json_encode($batchesByProduct) ?>;

            var currentPackPerBox = 0;

            function loadBatches() {
                var pid = document.getElementById('productSel').value;
                var batchSel = document.getElementById('batchSel');

                batchSel.innerHTML = '<option value="">Please Select</option>';
                document.getElementById('totalBoxes').value = '';
                document.getElementById('usebyDate').value = '';
                document.getElementById('stockInfo').innerHTML = '';
                currentPackPerBox = 0;

                if (!pid) return;

                var list = batchesByProduct[pid] || [];
                if (!list.length) {
                    batchSel.innerHTML = '<option value="">No batches with left boxes</option>';
                    return;
                }

                for (var i = 0; i < list.length; i++) {
                    var b = list[i];
                    var opt = document.createElement('option');
                    opt.value = b.fb_id;
                    opt.setAttribute('data-batchcode', b.productbatch);
                    opt.setAttribute('data-packperbox', b.packperbox);
                    opt.setAttribute('data-leftbox', b.leftbox);
                    opt.setAttribute('data-useby', b.bestbefore);
                    opt.textContent = b.productbatch + ' | Box: ' + b.boxbatchcode +
                        ' — ' + b.packperbox + ' pk/box × ' + b.leftbox + ' boxes left';
                    batchSel.appendChild(opt);
                }
            }

            function onBatchChange() {
                var sel = document.getElementById('batchSel');
                var opt = sel.options[sel.selectedIndex];

                if (!opt || !opt.value) {
                    document.getElementById('totalBoxes').value = '';
                    document.getElementById('usebyDate').value = '';
                    document.getElementById('stockInfo').innerHTML = '';
                    currentPackPerBox = 0;
                    return;
                }

                currentPackPerBox = parseInt(opt.getAttribute('data-packperbox')) || 0;
                var leftBox = parseInt(opt.getAttribute('data-leftbox')) || 0;

                document.getElementById('totalBoxes').value = leftBox;
                document.getElementById('usebyDate').value = opt.getAttribute('data-useby');

                document.getElementById('stockInfo').innerHTML =
                    '<span class="label">Pack per box:</span> <strong>' + currentPackPerBox + '</strong>' +
                    ' &nbsp;•&nbsp; <span class="label">Boxes left:</span> <strong>' + leftBox + '</strong>';
            }

            function addRow() {
                var productSel = document.getElementById('productSel');
                var batchSel = document.getElementById('batchSel');
                var batchOpt = batchSel.options[batchSel.selectedIndex];
                var err = document.getElementById('errorMsg');

                var productId = productSel.value;
                var productName = '';
                if (productSel.options[productSel.selectedIndex]) {
                    productName = productSel.options[productSel.selectedIndex].text.trim();
                }

                var batchId = batchSel.value;
                var batchCode = (batchOpt && batchOpt.getAttribute('data-batchcode')) ? batchOpt.getAttribute('data-batchcode') : '';
                var bestBefore = (batchOpt && batchOpt.getAttribute('data-useby')) ? batchOpt.getAttribute('data-useby') : '';
                var leftBoxes = (batchOpt && batchOpt.getAttribute('data-leftbox')) ? parseInt(batchOpt.getAttribute('data-leftbox')) : 0;

                var boxes = parseInt(document.getElementById('boxesInput').value) || 0;

                if (!productId) {
                    err.textContent = '* Please select the product';
                    return;
                }
                if (!batchId) {
                    err.textContent = '* Please select the batch';
                    return;
                }
                if (boxes <= 0) {
                    err.textContent = '* Please enter number of boxes';
                    return;
                }
                if (boxes > leftBoxes) {
                    err.textContent = '* Boxes exceed available (' + leftBoxes + ')';
                    return;
                }
                err.textContent = '';

                document.getElementById('add_prid').value = productId;
                document.getElementById('add_product').value = productName;
                document.getElementById('add_batchid').value = batchId;
                document.getElementById('add_batchcode').value = batchCode;
                document.getElementById('add_useby').value = bestBefore;
                document.getElementById('add_boxes').value = boxes;

                var marker = document.createElement('input');
                marker.type = 'hidden';
                marker.name = 'add_row';
                marker.value = '1';
                document.getElementById('mainForm').appendChild(marker);

                // Disable customer required for this non-final submit
                document.getElementById('customerSel').required = false;

                document.getElementById('mainForm').submit();
            }

            // Set default date only if not already saved from POST
            <?php if (empty($savedDisdate)): ?>
                document.getElementById('dispatchDate').valueAsDate = new Date();
            <?php endif; ?>

            // Auto-load batches if a product was pre-selected
            window.onload = function() {
                if (document.getElementById('productSel').value) {
                    loadBatches();
                }
            };
        </script>
</body>

</html>
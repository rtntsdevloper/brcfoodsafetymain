<?php

if (isset($_POST['filter'])) {
    $startDate = $_POST['sdate'];
    $endDate = $_POST['edate'];
} else {
    $startDate = date('Y-m-d', strtotime('-5 days'));
    $endDate = date('Y-m-d');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Transfer Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            margin: 0
        }

        .fsp {
            --a: #26a69a;
            --ad: #00796b;
            --soft: #e0f2f1;
            --line: #b2dfdb;
            --rgb: 0, 121, 107;
            background: linear-gradient(180deg, #fff8f0, #fef3e6);
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
            padding: 16px;
            color: #3d2b1f;
            min-height: 100dvh;
            line-height: 1.45
        }

        .fsp * {
            box-sizing: border-box
        }

        .fsp a {
            text-decoration: none
        }

        .fs-head {
            background: linear-gradient(135deg, var(--a), var(--ad));
            color: #fff;
            padding: 22px 26px;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(var(--rgb), .25);
            margin-bottom: 24px;
            position: relative;
            overflow: hidden
        }

        .fs-head::before {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%
        }

        .fs-head::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: -30px;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%
        }

        .fs-head>* {
            position: relative;
            z-index: 1
        }

        .fs-head h1 {
            font-weight: 700;
            font-size: 1.7rem;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff
        }

        .fs-head p {
            opacity: .92;
            margin: 0;
            font-size: .95rem
        }

        /* ---------- Header Buttons ---------- */
        .fs-head-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 14px
        }

        .fs-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            background: rgba(255, 255, 255, .2);
            border: 0;
            border-radius: 50px;
            padding: 8px 18px;
            font: inherit;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s
        }

        .fs-back:hover {
            color: #fff;
            background: rgba(255, 255, 255, .32);
            transform: translateY(-1px)
        }

        .fs-back.btn-excel {
            background: rgba(255, 255, 255, .9);
            color: #1b5e20
        }

        .fs-back.btn-excel:hover {
            background: #fff;
            color: #1b5e20
        }

        .fs-back.btn-excel-2 {
            background: rgba(255, 255, 255, .9);
            color: #e65100
        }

        .fs-back.btn-excel-2:hover {
            background: #fff;
            color: #e65100
        }

        /* ---------- Filter Card ---------- */
        .fs-filter {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 24px rgba(var(--rgb), .1);
            border-top: 5px solid var(--a);
            padding: 20px 22px;
            margin-bottom: 22px
        }

        .fs-filter-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--ad);
            margin-bottom: 16px
        }

        .fs-filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: flex-end
        }

        .fs-fg {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1 1 180px;
            min-width: 0
        }

        .fs-fg label {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 700;
            color: #8d6e63
        }

        .fs-input {
            display: block;
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 11px 14px;
            font: inherit;
            font-size: .95rem;
            color: #3d2b1f;
            background: #fff;
            transition: all .15s
        }

        .fs-input:focus {
            outline: 0;
            border-color: var(--a);
            box-shadow: 0 0 0 3px rgba(var(--rgb), .15)
        }

        .fs-apply {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 10px;
            padding: 11px 26px;
            font: inherit;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(135deg, var(--a), var(--ad));
            box-shadow: 0 4px 12px rgba(var(--rgb), .3);
            transition: all .2s;
            flex: 0 0 auto;
            min-height: 44px
        }

        .fs-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(var(--rgb), .4)
        }

        /* ---------- Table ---------- */
        .fs-tw {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 24px rgba(var(--rgb), .1);
            border-top: 5px solid var(--a);
            overflow-x: auto
        }

        .fs-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .92rem
        }

        .fs-table th {
            background: var(--soft);
            color: var(--ad);
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 700;
            text-align: left;
            padding: 14px 16px;
            white-space: nowrap;
            border-bottom: 2px solid var(--line)
        }

        .fs-table th.num,
        .fs-table td.num {
            text-align: right
        }

        .fs-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1ebe6;
            vertical-align: top;
            overflow-wrap: anywhere
        }

        .fs-table tbody tr:last-child td {
            border-bottom: 0
        }

        .fs-table tbody tr:hover {
            background: #f7fbfa
        }

        .fs-table tbody tr.row-ok td:first-child {
            border-left: 4px solid #2e7d32
        }

        .fs-table tbody tr.row-short td:first-child {
            border-left: 4px solid #c62828
        }

        .fs-table tbody tr.row-ok:hover {
            background: #f1f8e9
        }

        .fs-table tbody tr.row-short:hover {
            background: #ffebee
        }

        .fs-pn {
            font-weight: 700
        }

        .fs-id {
            font-size: .78rem;
            color: #8d6e63;
            font-weight: 600;
            white-space: nowrap
        }

        .fs-table td.num {
            white-space: nowrap
        }

        .fs-qty {
            font-weight: 700;
            font-size: 1rem
        }

        .fs-qty.in {
            color: #00796b
        }

        .fs-qty.transfer {
            color: #e65100
        }

        .fs-qty.stored {
            color: #2e7d32
        }

        .fs-qty.stored.short {
            color: #c62828
        }

        .fs-diff {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .75rem;
            font-weight: 700;
            margin-top: 4px;
            padding: 2px 8px;
            border-radius: 50px;
        }

        .fs-diff.ok {
            background: #e8f5e9;
            color: #2e7d32
        }

        .fs-diff.short {
            background: #ffebee;
            color: #c62828
        }

        .fs-sub {
            display: block;
            font-size: .7rem;
            color: #8d6e63;
            font-weight: 600;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: .3px
        }

        @media(max-width:1040px) {
            .fs-tw {
                background: transparent;
                box-shadow: none;
                border-top: 0;
                overflow: visible
            }

            .fs-table,
            .fs-table tbody,
            .fs-table tr,
            .fs-table td {
                display: block;
                width: 100%
            }

            .fs-table thead {
                display: none
            }

            .fs-table tr {
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 4px 14px rgba(var(--rgb), .1);
                margin-bottom: 12px;
                padding: 6px 16px
            }

            .fs-table tbody tr.row-ok {
                border-left: 5px solid #2e7d32
            }

            .fs-table tbody tr.row-short {
                border-left: 5px solid #c62828
            }

            .fs-table td,
            .fs-table tbody td:first-child {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 14px;
                border: 0;
                border-bottom: 1px dashed var(--line);
                padding: 10px 0;
                text-align: right
            }

            .fs-table td:last-child {
                border-bottom: 0
            }

            .fs-table td::before {
                content: attr(data-label);
                font-size: .68rem;
                text-transform: uppercase;
                letter-spacing: .5px;
                color: #a1887f;
                font-weight: 700;
                text-align: left;
                flex-shrink: 0
            }

            .fs-diff {
                margin-top: 0
            }
        }
/* ── Tablet ── */
    @media(max-width:768px) {
        .fs-filter {
            padding: 16px 16px;
            border-radius: 14px
        }

        .fs-filter-row {
            flex-direction: column;
            align-items: stretch;
            gap: 12px
        }

        .fs-fg {
            flex: 1 1 auto
        }

        .fs-apply {
            width: 100%;
            justify-content: center
        }
    }

    /* ── Mobile ── */
    @media(max-width:576px) {
        .fs-filter {
            padding: 14px 12px;
            border-radius: 12px;
            margin-bottom: 16px;
            border-top-width: 4px
        }

        .fs-filter-title {
            font-size: .78rem;
            margin-bottom: 12px
        }

        .fs-filter-row {
            gap: 10px
        }

        .fs-fg label {
            font-size: .68rem
        }

        .fs-input {
            padding: 12px 12px;
            font-size: .9rem;
            border-radius: 8px;
            min-height: 46px
        }

        .fs-apply {
            padding: 12px 20px;
            font-size: .88rem;
            border-radius: 8px;
            min-height: 46px
        }
    }

    /* ── Small phones ── */
    @media(max-width:400px) {
        .fs-filter {
            padding: 12px 10px;
            margin-left: -4px;
            margin-right: -4px;
            border-radius: 10px
        }

        .fs-filter-title {
            font-size: .74rem;
            gap: 6px
        }
    }
    </style>
</head>

<body>
    <div class="fsp fs-teal">
        <div class="fs-wrap full">
            <div class="fs-head">
                <div class="fs-head-actions">
                    <button type="button" class="fs-back" onclick="window.location.href='admin.php?id=stockdetail'">
                        <i class="bi bi-arrow-left"></i> Back to stock
                    </button>
                    <button type="button" class="fs-back btn-excel" onclick="exportExcel()">
                        <i class="bi bi-file-earmark-excel"></i> Save Transfer Detail File
                    </button>
                    <button type="button" class="fs-back btn-excel-2" onclick="exportExcel2()">
                        <i class="bi bi-file-earmark-excel"></i> Save Quantity Detail File
                    </button>
                </div>
                <h1><i class="bi bi-clipboard-check"></i> Stock Transfer Summary</h1>
                <p><i class="bi bi-box-seam"></i> Goods received vs. transferred vs. stored reconciliation</p>
            </div>

            <div class="fs-filter">
                <div class="fs-filter-title"><i class="bi bi-funnel-fill"></i> Filter by Date</div>
                <form action="" method="post">
                    <div class="fs-filter-row">
                        <div class="fs-fg">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" class="fs-input" name="sdate" value="<?php echo $startDate; ?>">
                        </div>
                        <div class="fs-fg">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" class="fs-input" name="edate" value="<?php echo $endDate; ?>">
                        </div>
                        <button type="submit" class="fs-apply" name="filter"><i class="bi bi-search"></i> Apply</button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="fs-tw p-3" id="tw">
                <table class="fs-table" id="zero_configuration_table">
                    <thead>
                        <tr>
                            <th>S No.</th>
                            <th>Product</th>
                            <th class="num">Goods In Qty</th>
                            <th class="num">Transfer Qty</th>
                            <th class="num">Stored Qty</th>
                            <th class="num">Available Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $pxn = mysqli_query($con, "SELECT pname,actualqty,goodqty,storedqty,unitm,storedleftqty,batchcode FROM `stock_in`  where confirm ='Yes'  order by date desc");
                        foreach ($pxn as $pxdata) {
                            $i++;

                            $actualqty = $pxdata['actualqty'];
                            $storedqty = $pxdata['storedqty'];

                            $change = floatval($actualqty) - floatval($storedqty);
                            if ($change > 0) {
                                $rowcolor = "row-short";
                                $diffClass = "short";
                                $diffIcon = "exclamation-triangle-fill";
                                $mtext = $change . " Less";
                            } else {
                                $rowcolor = "row-ok";
                                $diffClass = "ok";
                                $diffIcon = "check-circle-fill";
                                $mtext = "Match";
                            }
                        ?>

                            <tr class="<?= $rowcolor ?>">
                                <td data-label="S No"><span class="fs-id"><?= $i ?></span></td>
                                <td data-label="Product"><span class="fs-pn"><?= $pxdata['pname'] ?></span><span class="fs-sub">batchcode: <?= $pxdata['batchcode'] ?></span></td>
                                <td data-label="Goods In Qty" class="num"><span class="fs-qty in"><?= $pxdata['actualqty'] . " " . $pxdata['unitm'] ?></span></td>
                                <td data-label="Transfer Qty" class="num"><span class="fs-qty transfer"><?= $pxdata['goodqty'] . " " . $pxdata['unitm'] ?></span></td>
                                <td data-label="Stored Qty" class="num">
                                    <span class="fs-qty stored <?= ($diffClass == 'short') ? 'short' : '' ?>"><?= $pxdata['storedqty'] . " " . $pxdata['unitm'] ?> </span>
                                    <span class="fs-diff <?= $diffClass ?>"><i class="bi bi-<?= $diffIcon ?>"></i> <?= $mtext ?></span>
                                </td>
                                <td data-label="Available Qty" class="num"><span class="text-primary fs-qty"><?= $pxdata['storedleftqty'] . " " . $pxdata['unitm'] ?></span></td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    // Query 1: Full data (with batchcode + change)
    $trans = mysqli_query($con, "SELECT date,pname,actualqty,goodqty,storedqty,unitm,storedleftqty,batchcode FROM `stock_in` where confirm ='Yes' and date between '$startDate' and '$endDate' order by date desc");

    $data = [];
    $i = 0;
    while ($rows = mysqli_fetch_assoc($trans)) {
        $changeqty = $rows['actualqty'] - $rows['storedqty'];
        $i++;
        $data[] = [
            'S No'          => $i,
            'date'          => date('d-m-Y', strtotime($rows['date'])),
            'goodsqty'      => $rows['goodqty'] . " " . $rows['unitm'],
            'batchcode'     => $rows['batchcode'],
            'change'        => $changeqty . " " . $rows['unitm'],
            'product'       => $rows['pname'],
            'tranferqty'    => $rows['actualqty'] . " " . $rows['unitm'],
            'storedqty'     => $rows['storedqty'] . " " . $rows['unitm'],
            'storedleftqty' => $rows['storedleftqty'] . " " . $rows['unitm'],
        ];
    }

    // Query 2: Simpler data
    $transn = mysqli_query($con, "SELECT prodid,pname,unitm,supname, SUM(storedqty) as stored_qty ,sum(actualqty) as tranfer_qty,sum(goodqty) as goods_qty,sum(storedleftqty) as stored_leftqty FROM stock_in WHERE confirm = 'Yes' and date between '$startDate' and '$endDate'
                        GROUP BY prodid  order by date desc");

    $datan = [];
    $i = 0;
    while ($rown = mysqli_fetch_assoc($transn)) {
        $changeqtyn = $rown['tranfer_qty'] - $rown['stored_qty'];
        $i++;
        $datan[] = [
            'S No'          => $i,
            'goodsqty'      => $rown['goods_qty'] . " " . $rown['unitm'],
            'product'       => $rown['pname'],
            'tranferqty'    => $rown['tranfer_qty'] . " " . $rown['unitm'],
            'storedqty'     => $rown['stored_qty'] . " " . $rown['unitm'],
            'change'        => $changeqtyn . " " . $rown['unitm'],   // ← ADDED
            'storedleftqty' => $rown['stored_leftqty'] . " " . $rown['unitm'],
        ];
    }
    ?>

    <!-- Use xlsx-js-style so cell colors render in Excel -->
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
<script>

    // === PHP → JS data (declared ONCE) ===
    const rows  = <?= json_encode($data) ?>;
    const rows2 = <?= json_encode($datan) ?>;
    const startDate = "<?= $startDate ?>";
    const endDate   = "<?= $endDate ?>";

    // Hex → ARGB helper
    const toARGB = (hex) => 'FF' + hex.replace('#', '').toUpperCase();

    // =========================================================
    // SHARED: Apply stylish heading (title + subtitle) to a worksheet
    // =========================================================
    function styleHeading(worksheet, titleText, subtitleText, lastCol) {
        // ---- Row 0: Big Bold Title Banner ----
        const titleAddr = XLSX.utils.encode_cell({ r: 0, c: 0 });
        if (!worksheet[titleAddr]) worksheet[titleAddr] = { t: 's', v: titleText };
        worksheet[titleAddr].v = titleText;
        worksheet[titleAddr].s = {
            font: {
                bold: true,
                sz: 18,
                name: 'Segoe UI',
                color: { rgb: 'FFFFFFFF' }
            },
            fill: {
                patternType: 'solid',
                fgColor: { rgb: toARGB('#00796b') }
            },
            alignment: {
                horizontal: 'center',
                vertical: 'center'
            },
            border: {
                top:    { style: 'medium', color: { rgb: toARGB('#004d40') } },
                bottom: { style: 'medium', color: { rgb: toARGB('#004d40') } },
                left:   { style: 'medium', color: { rgb: toARGB('#004d40') } },
                right:  { style: 'medium', color: { rgb: toARGB('#004d40') } }
            }
        };

        for (let c = 1; c <= lastCol; c++) {
            const addr = XLSX.utils.encode_cell({ r: 0, c });
            if (!worksheet[addr]) worksheet[addr] = { t: 's', v: '' };
            worksheet[addr].s = {
                fill: { patternType: 'solid', fgColor: { rgb: toARGB('#00796b') } },
                border: {
                    top:    { style: 'medium', color: { rgb: toARGB('#004d40') } },
                    bottom: { style: 'medium', color: { rgb: toARGB('#004d40') } },
                    left:   { style: 'medium', color: { rgb: toARGB('#004d40') } },
                    right:  { style: 'medium', color: { rgb: toARGB('#004d40') } }
                }
            };
        }

        // ---- Row 1: Subtitle / Date Range ----
        const subAddr = XLSX.utils.encode_cell({ r: 1, c: 0 });
        if (!worksheet[subAddr]) worksheet[subAddr] = { t: 's', v: subtitleText };
        worksheet[subAddr].v = subtitleText;
        worksheet[subAddr].s = {
            font: {
                bold: true,
                italic: true,
                sz: 12,
                name: 'Segoe UI',
                color: { rgb: toARGB('#004d40') }
            },
            fill: {
                patternType: 'solid',
                fgColor: { rgb: toARGB('#b2dfdb') }
            },
            alignment: {
                horizontal: 'center',
                vertical: 'center'
            },
            border: {
                top:    { style: 'thin',   color: { rgb: toARGB('#80cbc4') } },
                bottom: { style: 'medium', color: { rgb: toARGB('#00796b') } },
                left:   { style: 'thin',   color: { rgb: toARGB('#80cbc4') } },
                right:  { style: 'thin',   color: { rgb: toARGB('#80cbc4') } }
            }
        };

        for (let c = 1; c <= lastCol; c++) {
            const addr = XLSX.utils.encode_cell({ r: 1, c });
            if (!worksheet[addr]) worksheet[addr] = { t: 's', v: '' };
            worksheet[addr].s = {
                fill: { patternType: 'solid', fgColor: { rgb: toARGB('#b2dfdb') } },
                border: {
                    top:    { style: 'thin',   color: { rgb: toARGB('#80cbc4') } },
                    bottom: { style: 'medium', color: { rgb: toARGB('#00796b') } },
                    left:   { style: 'thin',   color: { rgb: toARGB('#80cbc4') } },
                    right:  { style: 'thin',   color: { rgb: toARGB('#80cbc4') } }
                }
            };
        }
    }

    // =========================================================
    // SHARED: Style the header row (row 3) bold + teal
    // =========================================================
    function styleHeaderRow(worksheet, headers, numColStart) {
        const headerRowIdx = 3;
        headers.forEach((label, c) => {
            const addr = XLSX.utils.encode_cell({ r: headerRowIdx, c });
            if (!worksheet[addr]) worksheet[addr] = { t: 's', v: label };
            worksheet[addr].v = label;
            worksheet[addr].s = {
                font: {
                    bold: true,
                    sz: 12,
                    name: 'Segoe UI',
                    color: { rgb: 'FFFFFFFF' }
                },
                fill: {
                    patternType: 'solid',
                    fgColor: { rgb: toARGB('#26a69a') }
                },
                alignment: {
                    horizontal: c >= numColStart ? 'right' : 'left',
                    vertical: 'center'
                },
                border: {
                    top:    { style: 'thin',   color: { rgb: toARGB('#00796b') } },
                    bottom: { style: 'medium', color: { rgb: toARGB('#004d40') } },
                    left:   { style: 'thin',   color: { rgb: toARGB('#00796b') } },
                    right:  { style: 'thin',   color: { rgb: toARGB('#00796b') } }
                }
            };
        });
    }

    
    // =========================================================
    // SHARED: Apply red style to the Change column when value > 0
    // =========================================================
    function styleChangeColumn(worksheet, dataArray, dataStartRow, colIndex, key) {
        dataArray.forEach((r, idx) => {
            const rowIdx = dataStartRow + idx;
            const changeNum = parseFloat(String(r[key]).replace(/[^\d.-]/g, '')) || 0;

            if (changeNum > 0) {
                const addr = XLSX.utils.encode_cell({ r: rowIdx, c: colIndex });

                if (!worksheet[addr]) {
                    worksheet[addr] = { t: 's', v: r[key] };
                }

                worksheet[addr].s = {
                    font:      { sz: 11, name: 'Segoe UI', color: { rgb: toARGB('#c62828') }, bold: true },
                    fill:      { patternType: 'solid', fgColor: { rgb: toARGB('#ffebee') } },
                    alignment: { horizontal: 'right', vertical: 'center' },
                    border: {
                        top:    { style: 'thin', color: { rgb: toARGB('#ef9a9a') } },
                        bottom: { style: 'thin', color: { rgb: toARGB('#ef9a9a') } },
                        left:   { style: 'thin', color: { rgb: toARGB('#ef9a9a') } },
                        right:  { style: 'thin', color: { rgb: toARGB('#ef9a9a') } }
                    }
                };
            }

            worksheet['!rows'][rowIdx] = { hpt: 22 };
        });
    }

    // =========================================================
    // EXPORT 1: Transfer Detail (9 columns)
    // =========================================================
    function exportExcel() {
        const heading = [
            ['Stock Transfer Report'],
            ['From: ' + startDate + '  To: ' + endDate],
            [],
        ];

        const headers = [
            'S No', 'Date', 'Product', 'Batch Code',
            'Goods In Qty', 'Transfer Qty', 'Stored Qty',
            'Change In Qty', 'Available Qty'
        ];

        const bodyRows = rows.map(r => [
            r['S No'],
            r['date'],
            r['product'],
            r['batchcode'],
            r['goodsqty'],
            r['tranferqty'],
            r['storedqty'],
            r['change'],
            r['storedleftqty']
        ]);

        const allData = [...heading, headers, ...bodyRows];
        const worksheet = XLSX.utils.aoa_to_sheet(allData);

        const lastCol = 8;

        // Merges
        worksheet['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: lastCol } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: lastCol } }
        ];

        // Column widths
        worksheet['!cols'] = [
            { wch: 8 },   // S No
            { wch: 14 },  // Date
            { wch: 28 },  // Product
            { wch: 16 },  // Batch Code
            { wch: 16 },  // Goods In
            { wch: 16 },  // Transfer
            { wch: 16 },  // Stored
            { wch: 20 },  // Change
            { wch: 18 }   // Available
        ];

        // Row heights
        worksheet['!rows'] = [];
        worksheet['!rows'][0] = { hpt: 32 };
        worksheet['!rows'][1] = { hpt: 22 };
        worksheet['!rows'][2] = { hpt: 8 };
        worksheet['!rows'][3] = { hpt: 26 };

        // Apply attractive heading styles
        styleHeading(worksheet, 'Stock Transfer Report', 'From: ' + startDate + '   To: ' + endDate, lastCol);

        // Apply bold teal header row (numeric columns start at index 4)
        styleHeaderRow(worksheet, headers, 4);

        // Red on Change column (index 7) when change > 0
        styleChangeColumn(worksheet, rows, 4, 7, 'change');

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Transfer Detail');
        XLSX.writeFile(workbook, 'stock_transfer_detail.xlsx', { cellStyles: true });
    }

    // =========================================================
    // EXPORT 2: Quantity Detail (7 columns — aligned with new $datan)
    // Columns: S No, Product, Goods In, Transfer, Stored, Change, Available
    // =========================================================
    function exportExcel2() {
        const heading = [
            ['Stock Quantity Report'],
            ['From: ' + startDate + '  To: ' + endDate],
            [],
        ];

        const headers = [
            'S No', 'Product',
            'Goods In Qty', 'Transfer Qty', 'Stored Qty',
            'Change In Qty', 'Available Qty'
        ];

        const bodyRows = rows2.map(r => [
            r['S No'],
            r['product'],
            r['goodsqty'],
            r['tranferqty'],
            r['storedqty'],
            r['change'],
            r['storedleftqty']
        ]);

        const allData = [...heading, headers, ...bodyRows];
        const worksheet = XLSX.utils.aoa_to_sheet(allData);

        const lastCol = 6;

        // Merges
        worksheet['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: lastCol } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: lastCol } }
        ];

        // Column widths — aligned with 7 columns
        worksheet['!cols'] = [
            { wch: 8 },   // S No
            { wch: 32 },  // Product
            { wch: 16 },  // Goods In
            { wch: 16 },  // Transfer
            { wch: 16 },  // Stored
            { wch: 20 },  // Change
            { wch: 18 }   // Available
        ];

        // Row heights
        worksheet['!rows'] = [];
        worksheet['!rows'][0] = { hpt: 32 };
        worksheet['!rows'][1] = { hpt: 22 };
        worksheet['!rows'][2] = { hpt: 8 };
        worksheet['!rows'][3] = { hpt: 26 };

        // Apply attractive heading styles
        styleHeading(worksheet, 'Stock Quantity Report', 'From: ' + startDate + '   To: ' + endDate, lastCol);

        // Apply bold teal header row (numeric columns start at index 2)
        styleHeaderRow(worksheet, headers, 2);

        // Red on Change column (index 5) when change > 0
        styleChangeColumn(worksheet, rows2, 4, 5, 'change');

        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Quantity Detail');
        XLSX.writeFile(workbook, 'stock_quantity_detail.xlsx', { cellStyles: true });
    }
</script>

</body>

</html>
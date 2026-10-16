<?php

if (isset($_POST['filter'])) {
    $startDate = $_POST['sdate'];
    $endDate = $_POST['edate'];
} else {
    $startDate = date('Y-m-d', strtotime('-5 days'));
    $endDate = date('Y-m-d');
}
?>

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

    .fs-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        background: rgba(255, 255, 255, .2);
        border-radius: 50px;
        padding: 6px 16px;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: 12px
    }

    .fs-back:hover {
        color: #fff;
        background: rgba(255, 255, 255, .32)
    }

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
        vertical-align: middle;
        overflow-wrap: anywhere
    }

    .fs-table tbody tr:last-child td {
        border-bottom: 0
    }

    .fs-table tbody tr:hover {
        background: #f7fbfa
    }

    /* Stock In row — green accent */
    .fs-table tbody tr.row-in td:first-child {
        border-left: 4px solid #2e7d32
    }

    .fs-table tbody tr.row-in:hover {
        background: #f1f8e9
    }

    /* Stock Out row — red accent */
    .fs-table tbody tr.row-out td:first-child {
        border-left: 4px solid #c62828
    }

    .fs-table tbody tr.row-out:hover {
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

    .fs-dt {
        white-space: nowrap
    }

    .fs-dt small {
        display: block;
        color: #8d6e63;
        font-size: .76rem
    }

    .fs-table td.num {
        white-space: nowrap
    }

    .fs-good {
        color: #2e7d32;
        font-weight: 700
    }

    .fs-outc {
        color: #c62828;
        font-weight: 700
    }

    .fs-pill {
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: .75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap
    }

    /* Stock In pill — green */
    .fs-pill.pill-in {
        background: #e8f5e9;
        color: #2e7d32
    }

    /* Stock Out pill — red */
    .fs-pill.pill-out {
        background: #ffebee;
        color: #c62828
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

        .fs-table tbody tr.row-in {
            border-left: 5px solid #2e7d32
        }

        .fs-table tbody tr.row-out {
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

        .fs-dt {
            white-space: normal
        }
    }

    @media(min-width:700px) and (max-width:1040px) {
        .fs-table tbody {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px
        }

        .fs-table tr {
            margin-bottom: 0
        }
    }


    /* card filter */
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

<div class="fsp fs-teal">
    <div class="fs-wrap full">
        <div class="fs-head">
            <a class="fs-back" href="admin.php?id=stockdetail"><i class="bi bi-arrow-left"></i> Back to stock</a>
            <h1><i class="bi bi-arrow-left-right"></i> Stock History</h1>
            <p><i class="bi bi-clock-history"></i> Every stock in and stock out movement of the store</p>
        </div>
        <!-- Filter Card -->
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
        <div class="fs-tw p-3" id="tw">
            <table class="fs-table" id="zero_configuration_table">
                <thead>
                    <tr>
                        <th>S No.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Product</th>
                        <th class="num">Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="rows">
                    <?php
                    $i = 0;
                    $trans = mysqli_query($con, "SELECT st.*,si.pname FROM `stock_trans` as st join tblrawmaterial as si on st.prodid = si.id where date(transon) between '$startDate' and '$endDate' order by transon desc");
                    foreach ($trans as $rows) {
                        $i++;
                        $transtype = $rows['type'];
                        $rowClass = ($transtype == 'IN') ? 'row-in' : 'row-out';
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td data-label="S No"><span class="fs-id"><?= $i ?></span></td>
                            <td data-label="Date">
                                <div class="fs-dt"> <?= date('d M Y h:i a', strtotime($rows['transon'])) ?></div>
                            </td>
                            <td data-label="Type">
                                <?php if ($transtype == 'IN'): ?>
                                    <span class="fs-pill pill-in"><i class="bi bi-arrow-down-circle-fill"></i> Stock In</span>
                                <?php elseif ($transtype == 'WST'): ?>
                                    <span class="fs-pill pill-out"><i class="bi bi-arrow-up-circle-fill"></i> Wastage</span>
                            
                                <?php else: ?>
                                    <span class="fs-pill pill-out"><i class="bi bi-arrow-up-circle-fill"></i> Stock Out</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Product"><span class="fs-pn"><?= $rows['pname'] ?></span></td>
                            <td data-label="Quantity" class="num">
                                <?php if ($transtype == 'IN'): ?>
                                    <span class="fs-good">+<?= $rows['qty']." ".$rows['unitm'] ?></span>
                                <?php else: ?>
                                    <span class="fs-outc">-<?= $rows['qty']." ".$rows['unitm'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Status">
                                <?php if ($transtype == 'IN'): ?>
                                    <span class="fs-good"><i class="bi bi-check-circle-fill"></i> Confirmed</span>
                                <?php elseif ($transtype == 'WST'): ?>
                                    <span class="fs-outc"><i class="bi bi-trash"></i> WASTED</span>
                                <?php else: ?>
                                    <span class="fs-outc"><i class="bi bi-box-arrow-up"></i> Issued</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

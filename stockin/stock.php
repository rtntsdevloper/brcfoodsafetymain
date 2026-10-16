<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --a: #1e88e5;
        --ad: #0d47a1;
        --soft: #e3f2fd;
        --line: #bbdefb;
        --rgb: 30, 136, 229;
        --page: #f0f6fc;
        --add: #1565c0;
        --add-d: #0d47a1;
    }

    .fs-k-fresh {
        --c: #2e7d32;
        --bg: #e8f5e9;
    }

    .fs-k-soon {
        --c: #d84315;
        --bg: #fff0e6;
    }

    .fs-k-low {
        --c: #8a5a00;
        --bg: #fff4d1;
    }

    .fs-k-expired {
        --c: #c62828;
        --bg: #ffebee;
    }

    .fs-k-out {
        --c: #546e7a;
        --bg: #eceff1;
    }

    body {
        background: var(--page);
        font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
    }

    /* ---------- header ---------- */
    .fs-head {
        background: linear-gradient(135deg, var(--a), var(--ad));
        color: #fff;
        padding: 22px 26px;
        border-radius: 18px;
        box-shadow: 0 10px 24px rgba(var(--rgb), .25);
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .fs-head::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255, 255, 255, .08);
        border-radius: 50%;
    }

    .fs-head::after {
        content: "";
        position: absolute;
        bottom: -60px;
        left: -30px;
        width: 140px;
        height: 140px;
        background: rgba(255, 255, 255, .06);
        border-radius: 50%;
    }

    .fs-head>* {
        position: relative;
        z-index: 1;
    }

    .fs-head h1 {
        font-weight: 700;
        font-size: 1.7rem;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
    }

    .fs-head p {
        opacity: .92;
        margin: 0;
        font-size: .95rem;
    }

    .fs-top {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
    }

    .fs-acts {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* ── Base button ── */
    .fs-hb {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        border-radius: 12px;
        padding: 11px 22px;
        font-weight: 700;
        font-size: .85rem;
        border: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .12);
        transition: all .25s cubic-bezier(.4, 0, .2, 1);
        cursor: pointer;
        text-decoration: none;
        position: relative;
        overflow: hidden;
        letter-spacing: .2px;
    }

    .fs-hb::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, .18), transparent 60%);
        pointer-events: none;
    }

    .fs-hb i {
        font-size: 1.05rem;
        transition: transform .25s;
    }

    .fs-hb:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .2);
        text-decoration: none;
    }

    .fs-hb:hover i {
        transform: scale(1.15);
    }

    .fs-hb:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    /* ── Add Stock — vibrant blue ── */
    .fs-hb.add {
        background: linear-gradient(135deg, #1565c0, #0d47a1);
        color: #fff;
    }

    .fs-hb.add:hover {
        background: linear-gradient(135deg, #1976d2, #1565c0);
        color: #fff;
    }

    /* ── Stock Request — fresh green ── */
    .fs-hb.req {
        background: linear-gradient(135deg, #43a047, #2e7d32);
        color: #fff;
    }

    .fs-hb.req:hover {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        color: #fff;
    }

    /* ── Confirm Stock — warm amber ── */
    .fs-hb.conf {
        background: linear-gradient(135deg, #ffa726, #ef6c00);
        color: #fff;
    }

    .fs-hb.conf:hover {
        background: linear-gradient(135deg, #ffb74d, #f57c00);
        color: #fff;
    }

    /* ── History — rich purple ── */
    .fs-hb.hist {
        background: linear-gradient(135deg, #7c4dff, #6200ea);
        color: #fff;
    }

    .fs-hb.hist:hover {
        background: linear-gradient(135deg, #9c7cff, #7c4dff);
        color: #fff;
    }

    /* ── Wastage — deep red ── */
    .fs-hb.wastage {
        background: linear-gradient(135deg, #e53935, #b71c1c);
        color: #fff;
    }

    .fs-hb.wastage:hover {
        background: linear-gradient(135deg, #ef5350, #c62828);
        color: #fff;
    }

    /* ── Go Back — sleek dark slate ── */
    .fs-hb.back {
        background: linear-gradient(135deg, #22c55e, #15803d);
        color: #fff;
    }

    .fs-hb.back:hover {
        background: linear-gradient(135deg, #22c55e, #15803d);
        color: #fff;
    }

    .fs-hb.back:hover i {
        transform: translateX(-3px) scale(1.15);
    }

    /* ── Notification badge ── */
    .fs-n {
        background: #fff;
        color: #d32f2f;
        border-radius: 50px;
        padding: 1px 9px;
        font-size: .72rem;
        font-weight: 800;
        line-height: 1.7;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
        animation: fs-badge-pulse 2s ease-in-out infinite;
    }

    @keyframes fs-badge-pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.12);
        }
    }

    /* ---------- stats ---------- */
    .fs-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .fs-stat {
        background: #fff;
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 4px 14px rgba(var(--rgb), .08);
        border-left: 4px solid var(--c, var(--a));
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .fs-si {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--bg, var(--soft));
        color: var(--c, var(--ad));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .fs-sv {
        display: block;
        font-size: 1.4rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .fs-sl {
        display: block;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #8d6e63;
        font-weight: 600;
    }

    /* ---------- tabs ---------- */
    .fs-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }

    .fs-tab {
        border-radius: 50px;
        padding: 8px 18px;
        font-weight: 600;
        font-size: .82rem;
        border: 2px solid var(--line);
        background: #fff;
        color: var(--ad);
        transition: all .2s;
        cursor: pointer;
        font-family: inherit;
    }

    .fs-tab.on {
        background: var(--a);
        border-color: var(--a);
        color: #fff;
        box-shadow: 0 4px 12px rgba(var(--rgb), .3);
    }

    .fs-tab:hover:not(.on) {
        background: var(--soft);
    }

    /* ---------- search ---------- */
    .fs-input {
        display: block;
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 50px;
        padding: 11px 22px;
        font: inherit;
        font-size: .95rem;
        color: #3d2b1f;
        background: #fff;
        transition: all .15s;
    }

    .fs-input:focus {
        outline: 0;
        border-color: var(--a);
        box-shadow: 0 0 0 3px rgba(var(--rgb), .15);
    }

    .fs-count {
        font-size: .85rem;
        color: #8d6e63;
        margin: 0 0 12px;
    }

    /* ============================================================
       STOCK TABLE CARD — horizontal scroll when table doesn't fit
       ============================================================ */
    .fs-twrap {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(var(--rgb), .08);
        overflow-x: auto;
        /* horizontal scroll when needed */
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .fs-twrap::-webkit-scrollbar {
        height: 8px;
    }

    .fs-twrap::-webkit-scrollbar-track {
        background: var(--soft);
        border-radius: 0 0 16px 16px;
    }

    .fs-twrap::-webkit-scrollbar-thumb {
        background: var(--a);
        border-radius: 8px;
    }

    .fs-twrap::-webkit-scrollbar-thumb:hover {
        background: var(--ad);
    }

    .fs-table {
        width: 100%;
        min-width: 640px;
        /* forces scroll on very narrow screens */
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .fs-table thead th:first-child {
        border-top-left-radius: 16px;
    }

    .fs-table thead th:last-child {
        border-top-right-radius: 16px;
    }

    .fs-table thead th {
        background: #fff;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #8d6e63;
        text-align: left;
        padding: 14px 18px;
        border-bottom: 2px solid var(--line);
        white-space: nowrap;
    }

    .fs-table th[data-sort] {
        cursor: pointer;
        user-select: none;
        transition: color .15s;
    }

    .fs-table th[data-sort]:hover {
        color: var(--ad);
    }

    .fs-table .fs-ar {
        color: var(--a);
        font-size: .8rem;
    }

    .fs-table tbody td {
        padding: 13px 18px;
        border-bottom: 1px solid #f0f4f8;
        vertical-align: middle;
        font-size: .92rem;
        color: #4e342e;
    }

    .fs-table tbody tr.fs-item {
        transition: background .15s;
        background: linear-gradient(90deg, var(--bg, transparent), rgba(255, 255, 255, 0) 110px);
    }

    .fs-table tbody tr.fs-item:hover {
        background: var(--soft);
    }

    .fs-table tbody td:first-child {
        border-left: 4px solid var(--c, var(--a));
    }

    .fs-cellitem {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .fs-ic {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--bg, var(--soft));
        color: var(--c, var(--ad));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .fs-tname {
        font-weight: 700;
        color: #3e2723;
    }

    .fs-qty {
        font-weight: 700;
        font-size: 1rem;
        color: #3e2723;
        white-space: nowrap;
    }

    .fs-qty small {
        font-weight: 500;
        font-size: .76rem;
        color: #a1887f;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .fs-sup {
        font-size: .9rem;
        white-space: nowrap;
    }

    .fs-sup i {
        color: var(--a);
        margin-right: 6px;
        font-size: .82rem;
        opacity: .75;
    }

    .fs-exp {
        white-space: nowrap;
    }

    .fs-days {
        font-size: .7rem;
        color: #a1887f;
        margin-top: 2px;
    }

    .fs-days.w {
        color: #b26a00;
        font-weight: 700;
    }

    .fs-days.b {
        color: #c62828;
        font-weight: 700;
    }

    .fs-empty {
        text-align: center;
        padding: 50px 20px;
        color: #a1887f;
    }

    .fs-empty i {
        display: block;
        font-size: 3.5rem;
        margin-bottom: 15px;
        color: var(--line);
    }

    .fs-hide {
        display: none !important;
    }

    .fs-full {
        width: 100%;
        max-width: 100%;
        padding: 0 20px;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 992px) {
        .fs-stats {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 860px) {
        .fs-table thead th {
            padding: 11px 12px;
            font-size: .64rem;
        }

        .fs-table tbody td {
            padding: 11px 12px;
            font-size: .86rem;
        }

        .fs-ic {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: .88rem;
        }

        .fs-cellitem {
            gap: 10px;
        }

        .fs-sup {
            font-size: .84rem;
        }

        .fs-exp {
            font-size: .84rem;
        }

        .fs-days {
            font-size: .64rem;
        }

        .fs-qty {
            font-size: .92rem;
        }
    }

    @media (max-width: 768px) {
        .fs-full {
            padding: 0 14px;
            margin-bottom: 40px;
        }

        .fs-head {
            padding: 20px 18px;
            text-align: center;
        }

        .fs-head h1 {
            font-size: 1.35rem;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
        }

        .fs-top {
            justify-content: center;
        }

        .fs-acts {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .fs-hb {
            width: 100%;
            justify-content: center;
            padding: 10px 14px;
            font-size: .8rem;
        }

        .fs-stats {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .fs-table thead th {
            padding: 9px 10px;
            font-size: .58rem;
            letter-spacing: .4px;
        }

        .fs-table tbody td {
            padding: 9px 10px;
            font-size: .8rem;
        }

        .fs-tname {
            font-size: .84rem;
        }

        .fs-qty {
            font-size: .84rem;
        }

        .fs-qty small {
            font-size: .64rem;
        }

        .fs-exp {
            font-size: .78rem;
        }

        .fs-days {
            font-size: .62rem;
        }

        .fs-sup {
            font-size: .82rem;
        }
    }

    /* ── Small phones ── */
    @media (max-width: 480px) {
        .fs-acts {
            grid-template-columns: 1fr;
        }

        .fs-hb {
            padding: 11px 16px;
            font-size: .82rem;
            border-radius: 10px;
        }
    }
</style>

<?php


if (isset($_GET['sucess'])) {

    $sucest = $_GET['sucess'];
    if ($sucest == '1') {
        $toast_message = 'Product added successfully';
    } else if ($sucest == '2') {
        $toast_message = 'Data updated successfully';
    } else if ($sucest == 'x') {
        $toast_message = 'Something went wrong';
    } else {
        $toast_message = 'Data updated successfully';
    }
} else {
    $sucest = '';
}


if (!empty($sucest)) {
?>
    <style>
        .fs-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            width: 360px;
            max-width: calc(100vw - 24px);
            box-sizing: border-box;
            background: #fff;
            color: #3d2b1f;
            border-radius: 14px;
            border-left: 5px solid #43a047;
            box-shadow: 0 12px 32px rgba(0, 0, 0, .18);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 14px 17px 16px;
            overflow: hidden;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
            line-height: 1.35;
            transform: translateX(130%);
            opacity: 0;
            transition: transform .35s ease, opacity .35s ease
        }

        .fs-toast.show {
            transform: none;
            opacity: 1
        }

        .fs-toast .ic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e8f5e9;
            color: #2e7d32;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0
        }

        .fs-toast .tx {
            flex: 1;
            min-width: 0
        }

        .fs-toast .tx b {
            display: block;
            color: #2e7d32;
            font-size: .98rem
        }

        .fs-toast .tx span {
            color: #5d4037;
            font-size: .88rem
        }

        .fs-toast .x {
            background: none;
            border: 0;
            color: #8d6e63;
            font-size: 1rem;
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            line-height: 1
        }

        .fs-toast .x:hover {
            background: #f1ebe6;
            color: #3e2723
        }

        .fs-toast .bar {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            width: 100%;
            background: #43a047;
            transform-origin: left;
            animation: fsToastBar 4s linear forwards
        }

        @keyframes fsToastBar {
            to {
                transform: scaleX(0)
            }
        }

        @media(max-width:576px) {
            .fs-toast {
                top: auto;
                bottom: 12px;
                left: 12px;
                right: 12px;
                width: auto;
                max-width: none;
                transform: translateY(150%)
            }
        }

        @media(prefers-reduced-motion:reduce) {
            .fs-toast {
                transition: opacity .2s
            }

            .fs-toast .bar {
                animation-duration: 4s
            }
        }
    </style>

    <div class="fs-toast" id="fsToast" role="status" aria-live="polite">
        <div class="ic"><i class="bi bi-check-circle-fill"></i></div>
        <div class="tx"><b>Success</b><span><?php echo htmlspecialchars($toast_message, ENT_QUOTES, 'UTF-8'); ?></span></div>
        <button type="button" class="x" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        <div class="bar"></div>
    </div>

    <script>
        (function() {
            var toast = document.getElementById('fsToast');
            if (!toast) {
                return;
            }

            function hide() {
                toast.classList.remove('show');
                setTimeout(function() {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 400);
            }

            // slide in, then hide by itself after 4 seconds
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    toast.classList.add('show');
                });
            });
            setTimeout(hide, 4000);
            toast.querySelector('.x').addEventListener('click', hide);

            // remove success=1 from the address, so refreshing the page does not show the toast again
            if (window.history && history.replaceState && window.URL) {
                var u = new URL(window.location.href);
                u.searchParams.delete('sucess');
                history.replaceState(null, '', u.pathname + u.search + u.hash);
            }
        })();
    </script>
<?php } ?>


<div class="fs-full py-4">
    <div class="fsp">
        <?php

        $nmqx = mysqli_num_rows(mysqli_query($con, "SELECT id FROM `stock_in` WHERE confirm ='Pending'"));
        $nmqr = mysqli_num_rows(mysqli_query($con, "SELECT id FROM `stock_request` WHERE status ='Pending'"));



        ?>
        <!-- ========== HEADER ========== -->
        <div class="fs-head">
            <div class="fs-top">
                <div>
                    <h1><i class="bi bi-egg-fried"></i> Food Stock Dashboard</h1>
                    <p><i class="bi bi-card-checklist"></i> All available food stock at a glance</p>
                </div>
                <div class="fs-acts">
                      
                    <a class="fs-hb add" href="admin.php?id=addstock">
                        <i class="bi bi-plus-circle"></i> Add Stock in Store
                    </a>
                    <a class="fs-hb req" href="admin.php?id=confirm-request">
                        <i class="bi bi-check-square"></i> Stock Request
                        <span class="fs-n"><?= $nmqr ?></span>
                    </a>
                    <a class="fs-hb conf" href="admin.php?id=confirm-stock">
                        <i class="bi bi-check-circle-fill"></i> Confirm Stock
                        <span class="fs-n"><?= $nmqx ?></span>
                    </a>
                    <a class="fs-hb hist" href="admin.php?id=stock-flow">
                        <i class="bi bi-clock-history"></i> Stock History

                    </a>
                    <a class="fs-hb wastage" href="admin.php?id=stock-wastage">
                        <i class="bi bi-trash3"></i> Add Wastage

                    </a>
                    <a class="fs-hb back" href="admin.php?id=1">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </a>
                </div>
            </div>
        </div>

        <!-- ========== STATS ========== -->


        <!-- ========== SEARCH + FILTERS ========== -->
        <input id="q" type="search" class="fs-input" placeholder="Search by product or supplier" autocomplete="off">

        <div class="fs-tabs mt-3" id="tabs">
            <button type="button" class="fs-tab on" data-f="all"><i class="bi bi-list-ul"></i> All <span class="fs-c">(0)</span></button>
            <button type="button" class="fs-tab" data-f="fresh"><i class="bi bi-check-lg"></i> In stock <span class="fs-c">(0)</span></button>
            <button type="button" class="fs-tab" data-f="out"><i class="bi bi-slash-circle"></i> Out of stock <span class="fs-c">(0)</span></button>

        </div>

        <div class="fs-count" id="count"></div>

        <!-- ========== STOCK TABLE (scrolls horizontally when needed) ========== -->
        <div class="fs-twrap pt-3">
            <table class="fs-table" id="stockTable">
                <thead>
                    <tr>
                        <th data-sort="name">Product name <span class="fs-ar"></span></th>
                        <th data-sort="qty" style="width:110px">Quantity <span class="fs-ar"></span></th>
                        <th data-sort="supplier">Supplier name <span class="fs-ar"></span></th>
                        <th data-sort="expiry" style="width:150px">Expiry date <span class="fs-ar"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pnqyu = mysqli_query($con, "SELECT prodid,pname,unitm,supname,SUM(storedleftqty) AS total_qty FROM stock_in WHERE confirm = 'Yes'
                        GROUP BY prodid order by pname asc");
                    foreach ($pnqyu as $pdata) {
                        $prodid = $pdata["prodid"];
                        $pname = $pdata["pname"];
                        $qty = $pdata["total_qty"];
                        $supname = $pdata["supname"];
                        $unitm = $pdata["unitm"];

                        if ($qty > 0) {
                            $dtff = 'fresh';
                            $dtff1 = 'fresh';
                        } else {
                            $dtff = 'out';
                            $dtff1 = 'soon';
                        }

                        $getexpiry = mysqli_query($con, "SELECT useby FROM `stock_in` WHERE prodid ='$prodid' and storedleftqty > 0 and confirm='Yes' order by useby asc limit 1");
                        $getexpiry_data = mysqli_fetch_assoc($getexpiry);
                        $getexpn = mysqli_num_rows($getexpiry);
                        if ($getexpn > 0) {
                            $expiry = $getexpiry_data["useby"];
                            $expiry = date("d M Y", strtotime($expiry));
                        } else {
                            $expiry = "--";
                        }



                    ?>

                        <!-- item 1 : Fresh Carrots -->

                        <tr class="fs-item fs-k-<?= $dtff1 ?>"
                            data-state="<?= $dtff ?>"
                            data-name="<?= $pname ?>"
                            data-qty="<?= $qty ?>"
                            data-supplier="<?= $supname ?>"
                            data-expiry="<?= $expiry ?>"
                            data-search="<?= $pname ?> <?= $qty ?> <?= $supname ?> <?= $expiry ?>" onclick="window.location='admin.php?id=product-flow&pid=<?= $prodid ?>'">
                            <td>
                                <div class="fs-cellitem">
                                    <span class="fs-ic"><i class="bi bi-box-seam-fill"></i></span>
                                    <span class="fs-tname"><?= $pname ?></span>
                                </div>
                            </td>
                            <td><span class="fs-qty"><?= $qty ?> <small><?= $unitm ?></small></span></td>
                            <td><span class="fs-sup"><i class="bi bi-truck"></i><?= $supname ?></span></td>
                            <td class="fs-exp">
                                <?= $expiry ?>

                            </td>
                        </tr>

                    <?php
                    }
                    ?>


                </tbody>
            </table>
        </div><!-- /twrap -->

        <!-- ========== EMPTY SEARCH RESULT ========== -->
        <div class="fs-empty fs-hide" id="none">
            <i class="bi bi-search"></i>
            <h5>No stock matches your search</h5>
            <p>Try a different word or choose another filter.</p>
        </div>

    </div>
</div>

<script>
    (function() {
        var rows = Array.prototype.slice.call(document.querySelectorAll('#stockTable tbody tr.fs-item'));
        var box = document.getElementById('q');
        var tabs = document.querySelectorAll('.fs-tab');
        var none = document.getElementById('none');
        var count = document.getElementById('count');
        var current = 'all';
        var sortKey = null,
            sortDir = 1;

        function apply() {
            var words = box.value.toLowerCase().split(/\s+/).filter(Boolean);
            var n = {
                all: 0,
                fresh: 0,
                soon: 0,
                low: 0,
                out: 0,
                expired: 0
            };
            var shown = 0;

            for (var i = 0; i < rows.length; i++) {
                var el = rows[i];
                var text = el.getAttribute('data-search');
                var state = el.getAttribute('data-state');
                var ok = true;

                for (var w = 0; w < words.length; w++) {
                    if (text.indexOf(words[w]) === -1) {
                        ok = false;
                        break;
                    }
                }

                if (ok) {
                    n.all++;
                    n[state]++;
                }

                var show = ok && (current === 'all' || current === state);
                if (show) {
                    el.classList.remove('fs-hide');
                    shown++;
                } else {
                    el.classList.add('fs-hide');
                }
            }

            for (var t = 0; t < tabs.length; t++) {
                tabs[t].querySelector('.fs-c').textContent = '(' + n[tabs[t].getAttribute('data-f')] + ')';
            }

            count.textContent = rows.length ? 'Showing ' + shown + ' of ' + rows.length + ' stock items' : '';
            if (rows.length && shown === 0) none.classList.remove('fs-hide');
            else none.classList.add('fs-hide');
        }

        for (var t = 0; t < tabs.length; t++) {
            tabs[t].addEventListener('click', function() {
                for (var k = 0; k < tabs.length; k++) tabs[k].classList.remove('on');
                this.classList.add('on');
                current = this.getAttribute('data-f');
                apply();
            });
        }

        box.addEventListener('input', apply);
        box.addEventListener('search', apply);

        var ths = document.querySelectorAll('#stockTable thead th[data-sort]');

        function updateArrows() {
            for (var i = 0; i < ths.length; i++) {
                var span = ths[i].querySelector('.fs-ar');
                span.innerHTML = (ths[i].getAttribute('data-sort') === sortKey) ?
                    (sortDir === 1 ? '<i class="bi bi-caret-up-fill"></i>' : '<i class="bi bi-caret-down-fill"></i>') :
                    '';
            }
        }

        function sortRows() {
            var tb = document.querySelector('#stockTable tbody');
            var rs = rows.slice();
            rs.sort(function(a, b) {
                var av = a.getAttribute('data-' + sortKey);
                var bv = b.getAttribute('data-' + sortKey);
                var c;
                if (sortKey === 'qty') {
                    c = (parseFloat(av) || 0) - (parseFloat(bv) || 0);
                } else {
                    c = String(av).localeCompare(String(bv));
                }
                return c * sortDir;
            });
            for (var i = 0; i < rs.length; i++) tb.appendChild(rs[i]);
        }

        for (var s = 0; s < ths.length; s++) {
            ths[s].addEventListener('click', function() {
                var k = this.getAttribute('data-sort');
                if (sortKey === k) {
                    sortDir *= -1;
                } else {
                    sortKey = k;
                    sortDir = 1;
                }
                updateArrows();
                sortRows();
            });
        }

        apply();
    })();
</script>
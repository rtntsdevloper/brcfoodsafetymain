<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .fsp {
        --a: #ff7043;
        --ad: #e64a19;
        --soft: #fff3e0;
        --line: #ffe0b2;
        --rgb: 230, 74, 25;
        background: linear-gradient(180deg, #fff8f0, #fef3e6);
        font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        padding: 16px;
        color: #3d2b1f;
        min-height: 100vh;
        line-height: 1.45;
        margin-bottom: 50px;
    }

    .fsp * {
        box-sizing: border-box
    }

    .fsp a {
        text-decoration: none
    }

    .fsp.fs-purple {
        --a: #ab47bc;
        --ad: #7b1fa2;
        --soft: #f3e5f5;
        --line: #e1bee7;
        --rgb: 123, 31, 162
    }

    .fs-k-fresh {
        --c: #2e7d32;
        --bg: #e8f5e9
    }

    .fs-k-soon {
        --c: #d84315;
        --bg: #fff0e6
    }

    .fs-k-low {
        --c: #8a5a00;
        --bg: #fff4d1
    }

    .fs-k-expired {
        --c: #c62828;
        --bg: #ffebee
    }

    .fs-k-out {
        --c: #546e7a;
        --bg: #eceff1
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

    .fs-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px
    }

    .fs-stat {
        background: #fff;
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 4px 14px rgba(var(--rgb), .08);
        border-left: 4px solid var(--c, var(--a));
        display: flex;
        align-items: center;
        gap: 14px
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
        flex-shrink: 0
    }

    .fs-sv {
        display: block;
        font-size: 1.4rem;
        font-weight: 700;
        line-height: 1.1
    }

    .fs-sl {
        display: block;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #8d6e63;
        font-weight: 600
    }

    .fs-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px
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
        cursor: default;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .fs-tab.on {
        background: var(--a);
        border-color: var(--a);
        color: #fff;
        box-shadow: 0 4px 12px rgba(var(--rgb), .3)
    }

    .fs-tab:hover:not(.on) {
        background: var(--soft)
    }

    .fs-input {
        display: block;
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 9px 12px;
        font: inherit;
        font-size: .9rem;
        color: #3d2b1f;
        background: #fff;
        transition: all .15s
    }

    .fs-input:focus {
        outline: 0;
        border-color: var(--a);
        box-shadow: 0 0 0 3px rgba(var(--rgb), .15)
    }

    .fs-input:disabled {
        background: var(--soft);
        opacity: .85
    }

    .fs-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23a1887f' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        padding-right: 32px;
        cursor: default;
    }

    .fs-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(var(--rgb), .08);
        padding: 20px 22px;
        margin-bottom: 18px;
        border-left: 5px solid var(--a);
        transition: all .22s
    }

    .fs-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(var(--rgb), .15)
    }

    .fs-card[class*="fs-k-"] {
        border-left-color: var(--c);
        background: linear-gradient(90deg, var(--bg), #fff 20%)
    }

    .fs-ch {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 14px
    }

    .fs-ct {
        display: flex;
        align-items: center;
        gap: 14px
    }

    .fs-ic {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: var(--bg, var(--soft));
        color: var(--c, var(--ad));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0
    }

    .fs-title {
        font-weight: 700;
        font-size: 1.12rem;
        margin: 0
    }

    .fs-sub {
        font-size: .78rem;
        color: #8d6e63;
        margin-top: 2px
    }

    .fs-pill {
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: .75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        background: var(--bg, var(--soft));
        color: var(--c, var(--ad))
    }

    .fs-det {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 16px;
        padding: 14px 0;
        border-top: 1px dashed var(--line);
        border-bottom: 1px dashed var(--line)
    }

    .fs-di {
        display: flex;
        flex-direction: column;
        gap: 3px
    }

    .fs-dl {
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #a1887f;
        font-weight: 700
    }

    .fs-dl i {
        color: var(--a);
        margin-right: 4px
    }

    .fs-dv {
        font-size: .95rem;
        font-weight: 700;
        color: #4e342e
    }

    .fs-dv small {
        font-weight: 500;
        font-size: .78rem;
        color: #a1887f
    }

    .fs-av {
        font-weight: 700;
        font-size: .82rem;
        color: #5d4037
    }

    .fs-av.bad {
        color: #c62828
    }

    .fs-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 0;
        border-radius: 50px;
        padding: 9px 22px;
        font: inherit;
        font-size: .85rem;
        font-weight: 600;
        cursor: default;
        transition: all .2s;
        color: #fff;
        min-height: 40px;
        text-decoration: none;
        pointer-events: none;
        opacity: .9;
    }

    .fs-ok {
        background: #43a047;
    }

    .fs-ghost {
        background: #efebe9;
        color: #5d4037;
        padding: 11px 26px;
        font-size: .95rem;
        font-weight: 500
    }

    .fs-foot {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 10px;
        margin: 22px 0
    }

    .fs-good {
        color: #2e7d32;
        font-weight: 700
    }

    /* ===== Footer action area: batch / useby / qty ===== */
    .fs-foot-actions {
        display: grid;
        grid-template-columns: 1.4fr 1fr .8fr auto;
        gap: 12px;
        align-items: end;
        padding-top: 14px;
        border-top: 1px dashed var(--line);
        margin-top: 4px;
    }

    .fs-field {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .fs-field label {
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #a1887f;
        font-weight: 700;
        white-space: nowrap;
    }

    .fs-field label i {
        color: var(--a);
        margin-right: 4px;
    }

    .fs-field .fs-av {
        display: block;
        margin-top: 2px;
        font-size: .75rem;
    }

    .fs-field-btn {
        display: flex;
        align-items: flex-end;
    }

    .fs-field-btn .fs-btn {
        width: 100%;
        white-space: nowrap;
    }

    /* ===== Responsive ===== */

    /* Tablet */
    @media(max-width: 992px) {
        .fs-det {
            grid-template-columns: repeat(2, 1fr)
        }

        .fs-foot-actions {
            grid-template-columns: 1.4fr 1fr .8fr;
        }

        .fs-field-btn {
            grid-column: 1 / -1;
        }

        .fs-field-btn .fs-btn {
            width: 100%;
        }
    }

    /* Small tablet / large phone */
    @media(max-width: 768px) {
        .fsp {
            padding: 12px
        }

        .fs-head {
            padding: 20px 18px;
            text-align: center
        }

        .fs-head h1 {
            font-size: 1.35rem;
            justify-content: center;
            flex-direction: column;
            gap: 8px
        }

        .fs-foot {
            flex-direction: column-reverse
        }

        .fs-ghost {
            width: 100%;
            justify-content: center
        }

        .fs-foot-actions {
            grid-template-columns: 1fr 1fr;
        }

        .fs-field-btn {
            grid-column: 1 / -1;
        }
    }

    /* Phone */
    @media(max-width: 640px) {
        .fs-stats {
            grid-template-columns: 1fr
        }

        .fs-foot-actions {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .fs-card {
            padding: 16px
        }
    }

    /* Small phone */
    @media(max-width: 576px) {
        .fs-head h1 {
            font-size: 1.25rem
        }

        .fs-tab {
            padding: 7px 14px;
            font-size: .78rem
        }

        .fs-input {
            font-size: 16px
        }

        .fs-det {
            gap: 10px
        }
    }

    /* Very small phone */
    @media(max-width: 340px) {
        .fs-det {
            grid-template-columns: 1fr
        }
    }

    @media(hover:none) {
        .fs-card:hover {
            transform: none
        }
    }
</style>

<div class="fsp fs-purple">
    <div class="fs-wrap">
        <div class="fs-head">
            <a class="fs-back" href="admin.php?id=request-stock"><i class="bi bi-arrow-left"></i> Back to request stock</a>
            <h1><i class="bi bi-clipboard-check"></i> Confirm Recieved Stock </h1>
            <p><i class="bi bi-shop"></i> Team first confirm then recieve stock</p>
        </div>

        <form action="" method="post">
            <?php

            $mystock = mysqli_query($con, "SELECT * FROM `stock_request` WHERE rstatus ='Issued'");
            $mystockn = mysqli_num_rows($mystock);
            foreach ($mystock as $row) {
                $prodid = $row["prodid"];



            ?>
                <!-- Request 1: Fresh Carrots -->
                <div class="fs-card">
                    <div class="fs-ch">
                        <div class="fs-ct">
                            <div class="fs-ic"><i class="bi bi-basket3"></i></div>
                            <div>
                                <h5 class="fs-title"><?= $row['product'] ?></h5>
                                <div class="fs-sub"><i class="bi bi-hash"></i> <?= $row['recordid'] ?></div>
                            </div>
                        </div>
                        <span class="fs-pill fs-k-low"><i class="bi bi-clock"></i> <?= $row['status'] ?></span>
                        <input type="hidden" name="prodid[]" value="<?= $prodid ?>">
                        <input type="hidden" name="product[]" value="<?= $row['product'] ?>">
                    </div>

                    <div class="fs-det">
                        <div class="fs-di"><span class="fs-dl">Quantity Issued</span><span class="fs-dv"><?= $row['sendqty'] ?> <small><?= $row['uom'] ?></small></span></div>



                        <input type="hidden" name="reqid[]" value="<?= $row['id'] ?>">
                        <div class="fs-field">
                            <label><i class="bi bi-123"></i>Recieved Quantity</label>
                            <div class="input-group">

                                <input type="number" step="0.01" value="<?= $row['sendqty'] ?>" id="mqty<?= $row['id'] ?>" class="form-control fs-input" name="qty[]" required>
                                <div class="input-group-append">
                                    <input type="hidden" name="uom[]" value="<?= $row['uom'] ?>">
                                    <span class="input-group-text"><?= $row['uom'] ?></span>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            <?php
            }


            ?>

            <?php
            if ($mystockn  > 0) {
            ?>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" name="save" class="fs-btn fs-ok" style="pointer-events: auto; cursor: pointer; padding: 12px 30px; font-size: 1rem;">
                        <i class="bi bi-check2-all"></i> Submit All Requests
                    </button>
                </div>
            <?php

            } else {
            }  ?>
        </form>
    </div>
</div>
<?php
if (isset($_POST['save'])) {

    $reqid = $_POST['reqid'];

    $date = date('d-m-Y');
    $datenx = date('d-m-Y H:i:s');

    foreach ($reqid as $rkey => $rid) {

        $qty = $_POST['qty'][$rkey];
        $prodid = $_POST['prodid'][$rkey];
        $product = $_POST['product'][$rkey];
        $uom = $_POST['uom'][$rkey];


        $update = mysqli_query($con, "UPDATE `stock_request` SET `rstatus`='Done',`rqty`='$qty',`ruser`='$user' WHERE id='$rid'");
        $insett = mysqli_query($con, "INSERT INTO `stock_shop`( `date`, `product`, `prodid`, `qty`, `add_by`, `add_on`, `reqid`,`leftqty`,`unitm`) VALUES ('$date','$product','$prodid','$qty','$user','$datenx','$rid','$qty','$uom')");

        if ($update && $insett) {

            echo "<script>window.location.href = 'admin.php?id=request-flow&sucess=2'</script>";
        } else {
            echo "<script>window.location.href = 'admin.php?id=request-flow&sucess=x'</script>";
        }
    }
}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.default.min.css">
<style>
    body {
        margin: 0
    }

    .fsp {
        --a: #ef5350;
        --ad: #c62828;
        --soft: #ffebee;
        --line: #ffcdd2;
        --rgb: 198, 40, 40;
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

    .fs-wrap {
        max-width: 980px;
        margin: 0 auto
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

    .fs-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 18px;
        font-size: .92rem
    }

    .fs-alert i {
        font-size: 1.2rem;
        margin-top: 1px
    }

    .fs-alert.ok {
        background: #e8f5e9;
        border-left: 4px solid #43a047;
        color: #1b5e20
    }

    .fs-alert.bad {
        background: #ffebee;
        border-left: 4px solid #e53935;
        color: #b71c1c
    }

    .fs-alert[hidden] {
        display: none
    }

    .fs-alert ul {
        margin: 6px 0 0;
        padding-left: 18px
    }

    .fs-form {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(var(--rgb), .1);
        border-top: 5px solid var(--a);
        padding: 26px
    }

    .fs-sec {
        margin-bottom: 26px
    }

    .fs-sec:last-of-type {
        margin-bottom: 8px
    }

    .fs-sec h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .6px;
        font-weight: 700;
        color: var(--ad);
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--soft)
    }

    .fs-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 16px
    }

    .c4 {
        grid-column: span 4
    }

    .c6 {
        grid-column: span 6
    }

    .c8 {
        grid-column: span 8
    }

    .c12 {
        grid-column: span 12
    }

    .fs-field {
        min-width: 0
    }

    .fs-field>label,
    .fs-lbl {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #5d4037;
        margin-bottom: 6px
    }

    .fs-field>label i {
        color: var(--a);
        margin-right: 5px
    }

    .fs-req {
        color: #e53935
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

    textarea.fs-input {
        min-height: 96px;
        resize: vertical
    }

    .fs-input:focus {
        outline: 0;
        border-color: var(--a);
        box-shadow: 0 0 0 3px rgba(var(--rgb), .15)
    }

    .fs-input.bad {
        border-color: #e53935;
        background: #fffafa
    }

    .fs-err {
        color: #c62828;
        font-size: .78rem;
        font-weight: 600;
        margin-top: 5px
    }

    .fs-hint {
        font-size: .8rem;
        font-weight: 600;
        margin-top: 6px;
        color: #2e7d32;
        min-height: 1.2em
    }

    .fs-hint.warn {
        color: #8a5a00
    }

    .fs-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px
    }

    .fs-chip {
        position: relative
    }

    .fs-chip input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        margin: 0;
        cursor: pointer
    }

    .fs-chip span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 50px;
        border: 2px solid var(--line);
        background: #fff;
        font-weight: 600;
        font-size: .88rem;
        color: var(--ad);
        transition: all .2s
    }

    .fs-chip:hover span {
        background: var(--soft)
    }

    .fs-chip input:checked+span {
        background: var(--a);
        border-color: var(--a);
        color: #fff;
        box-shadow: 0 4px 12px rgba(var(--rgb), .3)
    }

    .fs-chip input:focus-visible+span {
        outline: 3px solid rgba(var(--rgb), .35);
        outline-offset: 2px
    }

    .fs-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid #f1ebe6
    }

    .fs-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 50px;
        padding: 12px 30px;
        font: inherit;
        font-size: .95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        min-height: 46px
    }

    .fs-btn.save {
        background: linear-gradient(135deg, var(--a), var(--ad));
        color: #fff;
        box-shadow: 0 5px 14px rgba(var(--rgb), .3)
    }

    .fs-btn.save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(var(--rgb), .4)
    }

    .fs-btn.save[disabled] {
        opacity: .7;
        cursor: wait;
        transform: none
    }

    .fs-btn.ghost {
        background: #efebe9;
        color: #5d4037;
        font-weight: 600
    }

    .fs-btn.ghost:hover {
        background: #d7ccc8
    }

    .fs-recent {
        margin-top: 28px
    }

    .fs-recent h3 {
        font-weight: 700;
        color: var(--ad);
        font-size: 1.05rem;
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px
    }

    .fs-ri {
        background: #fff;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-left: 4px solid var(--a);
        box-shadow: 0 3px 10px rgba(var(--rgb), .06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px
    }

    .fs-rn {
        font-weight: 700
    }

    .fs-rm {
        font-size: .78rem;
        color: #8d6e63;
        margin-top: 3px
    }

    .fs-pill {
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: .75rem;
        background: var(--soft);
        color: var(--ad);
        white-space: nowrap
    }

    .fs-empty {
        text-align: center;
        padding: 26px 16px;
        color: #a1887f;
        background: #fff;
        border-radius: 12px;
        font-size: .9rem
    }

    @media(min-width:1400px) {
        .fsp {
            padding: 24px 32px
        }

        .fs-wrap {
            max-width: 1100px
        }
    }

    @media(max-width:768px) {
        .fsp {
            padding: 12px
        }

        .fs-head {
            padding: 20px 18px;
            text-align: center
        }

        .fs-head h1 {
            font-size: 1.3rem;
            justify-content: center;
            flex-direction: column;
            gap: 8px
        }

        .fs-form {
            padding: 20px 16px
        }

        .c4 {
            grid-column: span 6
        }

        .c8 {
            grid-column: span 12
        }

        .c6 {
            grid-column: span 12
        }
    }

    @media(max-width:480px) {
        .c4 {
            grid-column: span 12
        }

        .fs-input {
            font-size: 16px
        }

        .fs-actions {
            flex-direction: column-reverse
        }

        .fs-btn {
            width: 100%
        }

        .fs-chip span {
            padding: 9px 14px
        }
    }

    /* ── Tom Select theme ── */
    .ts-wrapper.single .ts-control {
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .95rem;
        background: #fff;
        box-shadow: none;
        transition: border-color .15s, box-shadow .15s
    }

    .ts-wrapper.single .ts-control:hover {
        border-color: var(--a)
    }

    .ts-wrapper.single.focus .ts-control {
        border-color: var(--a);
        box-shadow: 0 0 0 3px rgba(var(--rgb), .15)
    }

    .ts-dropdown {
        border: 1px solid var(--line);
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(var(--rgb), .12);
        margin-top: 4px;
        overflow: hidden
    }

    .ts-dropdown .option {
        padding: 10px 14px;
        font-size: .92rem;
        transition: background .12s
    }

    .ts-dropdown .option:hover,
    .ts-dropdown .active {
        background: var(--soft);
        color: var(--ad)
    }

    .ts-wrapper .ts-control .item {
        color: #3d2b1f;
        font-weight: 600
    }

    .ts-wrapper .ts-control input {
        font-size: .95rem
    }
</style>



<div class="fsp">
    <div class="fs-wrap">
        <div class="fs-head">
            <a class="fs-back" href="admin.php?id=stockdetail"><i class="bi bi-arrow-left"></i> Back</a>
            <a class="fs-back" href="admin.php?id=wastage-flow"><i class="bi bi-clock-history"></i> Wastage History</a>
            <h1><i class="bi bi-trash3"></i> Product Wastage</h1>
            <p><i class="bi bi-clipboard2-pulse"></i> Record stock that was thrown away, spoiled or lost</p>
        </div>

        <div class="fs-alert ok" id="wOk" role="status" hidden><i class="bi bi-check-circle-fill"></i>
            <div><strong>Wastage saved.</strong><br><span id="wOkText"></span></div>
        </div>

        <form class="fs-form" method="post" id="wasteForm" enctype="multipart/form-data">
            <div class="fs-sec">
                <h2><i class="bi bi-box-seam"></i> Product details</h2>
                <div class="fs-grid">
                    <div class="fs-field c4">
                        <label for="wDate"><i class="bi bi-calendar-event"></i>Date <span class="fs-req">*</span></label>
                        <input type="date" id="wDate" name="wdate" class="fs-input" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="fs-field c8">
                        <label class="small"><i class="bi bi-egg-fried"></i> Food Item</label>
                        <select name="product" class="fs-select product-select" required onchange="getproducts(this.value)">
                            <option value="">--select--</option>
                            <?php
                            $supq = mysqli_query($con, "SELECT pname, id FROM `tblrawmaterial` ORDER BY pname ASC");
                            if ($supq) {
                                foreach ($supq as $supdata) {
                                    echo '<option value="' . htmlspecialchars($supdata['id']) . '">' . htmlspecialchars($supdata['pname']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="fs-hint" id="wHint"></div>
                    </div>
                    <script>
                        function getproducts(val) {

                            let rid = val;
                            let batchcode = document.getElementById("batchcode");

                            // Loading option
                            batchcode.innerHTML = "<option value=''>Loading...</option>";

                            const xmlhttp = new XMLHttpRequest();

                            xmlhttp.onload = function() {
                                // AJAX success
                                batchcode.innerHTML = "<option value=''>Select Batchcode...</option>" + this.responseText;
                                batchcode.dispatchEvent(new Event('change'));
                            };

                            xmlhttp.open("GET", "stockin/wastage_batch.php?rid=" + rid, true);
                            xmlhttp.send();


                        }
                    </script>

                    <div class="fs-field c4">
                        <label for="batchcode"><i class="bi bi-geo-alt"></i>Batchcode(Mfg/Exp) <span class="fs-req">*</span></label>
                        <select id="batchcode" name="batchcode" class="fs-input" required>
                            <option value=''> Select Batchcode...</option>

                        </select>
                    </div>
                    <div class="fs-field c4">
                        <label for="wQty"><i class="bi bi-123"></i>Quantity wasted <span class="fs-req">*</span></label>
                        <input type="number" id="wQty" name="qty" class="fs-input" min="0.01" step="0.01" placeholder="0" required>
                    </div>
                    <div class="fs-field c4">
                        <label for="wUnit"><i class="bi bi-rulers"></i>Unit <span class="fs-req">*</span></label>
                        <select id="wUnit" name="unitm" class="fs-input" required>
                            <option value="">Select unit...</option>
                            <option>kg</option>
                            <option>ltr</option>
                            <option>pcs</option>
                            <option>bottles</option>
                        </select>
                    </div>

                </div>

                <div class="fs-sec mt-3">
                    <h2><i class="bi bi-question-circle"></i> What happened?</h2>
                    <div class="fs-field">
                        <span class="fs-lbl">Reason <span class="fs-req">*</span></span>
                        <div class="fs-chips">
                            <label class="fs-chip"><input type="radio" name="reason" value="Expired" required><span><i class="bi bi-calendar-x"></i> Expired</span></label>
                            <label class="fs-chip"><input type="radio" name="reason" value="Damaged" required><span><i class="bi bi-exclamation-octagon"></i> Damaged</span></label>
                            <label class="fs-chip"><input type="radio" name="reason" value="Spoiled" required><span><i class="bi bi-emoji-frown"></i> Spoiled</span></label>
                            <label class="fs-chip"><input type="radio" name="reason" value="Spillage" required><span><i class="bi bi-droplet"></i> Spillage</span></label>
                            <label class="fs-chip"><input type="radio" name="reason" value="Other" required><span><i class="bi bi-three-dots"></i> Other</span></label>
                        </div>
                    </div>

                </div>

                <div class="fs-sec">
                    <h2><i class="bi bi-person-check"></i> Report</h2>
                    <div class="fs-grid">
                        <div class="fs-field c6">
                            <label for="wBy"><i class="bi bi-person"></i>Reported by <span class="fs-req">*</span></label>
                            <input type="text" id="wBy" name="reported_by" class="fs-input" maxlength="100" placeholder="Your name" value="<?= $user ?>" readonly>
                        </div>
                        <div class="fs-field c6">
                            <label for="wBy"><i class="bi bi-person"></i>Upload Image <span class="fs-req">*</span></label>
                            <input type="file" id="wBy" name="image" class="fs-input" accept="image/*" required>
                        </div>
                        <div class="fs-field c12">
                            <label for="wNotes"><i class="bi bi-chat-left-text"></i>Notes <span id="wNotesReq" class="fs-req" style="display:none">* (explain the reason)</span></label>
                            <textarea id="wNotes" name="notes" class="fs-input" maxlength="500" placeholder="Anything that helps, for example what went wrong or which fridge it was in"></textarea>
                        </div>
                    </div>
                </div>

                <div class="fs-actions">
                    <button type="reset" class="fs-btn ghost" id="wReset"><i class="bi bi-arrow-counterclockwise"></i> Clear form</button>
                    <button type="submit" class="fs-btn save" id="wSave" name="submit"><i class="bi bi-check2-circle"></i> Save wastage</button>
                </div>
        </form>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Tom Select on product dropdown
        var productSelect = document.querySelector('.product-select');
        if (productSelect) {
            var ts = new TomSelect(productSelect, {
                create: false,
                maxOptions: null,
                placeholder: '--select--',
                dropdownParent: 'body',
                sortField: {
                    field: 'text',
                    direction: 'asc'
                }
            });
        }

        // Handle form reset — destroy & re-init Tom Select
        var form = document.getElementById('wasteForm');
        if (form) {
            form.addEventListener('reset', function() {
                setTimeout(function() {
                    if (ts) {
                        ts.clear();
                        ts.blur();
                    }
                }, 10);
            });
        }
    });
</script>


<?php

if (isset($_POST['submit'])) {

    $wdate = date('Y-m-d', strtotime($_POST['wdate']));
    $product = $_POST['product'];
    $batchcode = $_POST['batchcode'];
    $qty = $_POST['qty'];
    $unitm = $_POST['unitm'];
    $reason = $_POST['reason'];
    $reported_by = $_POST['reported_by'];
    $notes = $_POST['notes'];
    $image = $_FILES['image'];
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];

        $uniq = date('Ymdhis') . rand(0, 0);
        $image_name = $uniq . $image_name;
        $image_path = 'stockin/image/' . $image_name;
        if (move_uploaded_file($image_tmp, $image_path)) {
            $mimage = $image_name;
        } else {
            $mimage = '';
        }
    }
    $prodd = mysqli_fetch_assoc(mysqli_query($con, "SELECT id,pname, batchcode,storedleftqty FROM `stock_in` WHERE id='$batchcode'"));
    $pname = $prodd['pname'];
    $batch = $prodd['batchcode'];
    $storqty = $prodd['storedleftqty'];

    $leftqty = $storqty - $qty;





    $created_at = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `stock_wastage`( `wastage_date`, `pname`, `unitm`, `qty`, `batch`, `reason`, `image`, `reported_by`, `notes`, `created_at`, `user`,`storid`)
     VALUES ('$wdate','$pname','$unitm','$qty','$batch','$reason','$mimage','$reported_by','$notes','$created_at','$user','$batchcode')";
    $query = mysqli_query($con, $sql);
    $batch = mysqli_insert_id($con);
    if ($query) {
        $stockupdate = mysqli_query($con, "UPDATE `stock_in` SET `storedleftqty`='$leftqty' WHERE id='$batchcode'");
        $recordid = "WST" . date('Ymdhi') . rand(100, 999);
       $newins = mysqli_query($con, "INSERT INTO `stock_trans`(`transid`, `qty`, `transby`, `transon`, `recorid`,`unitm`,type,prodid) VALUES ('$batchcode','$qty','$user',' $created_at','$recordid','$unitm','WST','$product')");

        echo "<script>window.location.href='admin.php?id=wastage-flow&sucess=1';</script>";
    } else {
        echo "<script>window.location.href='admin.php?id=wastage-flow&sucess=0';</script>";
    }
}



?>
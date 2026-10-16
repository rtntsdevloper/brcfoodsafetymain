<?php

 $pid = $_GET['rid'];

 $yogurt = mysqli_query($con,"SELECT description,rdate,tank_no FROM `yogurt_records` WHERE id='$pid'");

 $yogr= mysqli_fetch_array($yogurt);

 $yname =$yogr['description'];
 $rdate =$yogr['rdate'];

 $ybactchno = date('ymd', strtotime($rdate));

 $tankrepeat =$yogr['tank_no'];
?>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* ================================================================
     * CCP ENTRY — GREEN THEME (matches Yogurt Production Records sheet)
     * Tokens lifted from the sheet's :root / Block 6 CSS
     * ================================================================ */
    :root {
        --g: #217346;
        --g-dark: #164a2d;
        --g-soft: #e8f4ec;
        --amber: #f59e0b;
        --bd: #d5ded8;
        --bd2: #b9c8bf;
        --txt: #22312a;
    }

    * { box-sizing: border-box }

    body {
        background: #eef2ee;                 /* same page bg as the sheet */
        font: 12.5px/1.45 "Segoe UI", Calibri, Arial, sans-serif;
        color: var(--txt);
    }

    /* ===== Page Header Banner (green gradient — same as sheet .top) ===== */
    .page-header-green {
        background: linear-gradient(135deg, #0e4d2c 0%, #217346 55%, #2f9e67 100%);
        padding: 18px 24px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        position: relative;
        box-shadow: 0 3px 14px rgba(13, 60, 35, .35);
        color: #fff;
        margin-bottom: 22px;
    }

    .page-header-green .header-icon {
        /* same shape as the sheet's .logo */
        width: 44px;
        height: 44px;
        border-radius: 12px;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .28);
        flex-shrink: 0;
    }

    .page-header-green .header-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .page-header-green .header-sub {
        font-size: 11.5px;
        opacity: .92;
        margin-top: 2px;
    }

        /* pH warning line: amber instead of red (amber = "check" colour on the sheet) */
    .page-header-green .header-sub.text-danger {
        color: #ffdfb0 !important;
    }

    .btn-goback {
        /* pill style — same language as the sheet's .pill */
        position: absolute;
        top: 16px;
        right: 18px;
        background: rgba(255, 255, 255, .14);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .26);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s;
    }

    .btn-goback:hover {
        background: #fff;
        color: var(--g-dark);
        text-decoration: none;
    }

    /* ===== Card — same recipe as the sheet's .card ===== */
    .card-theme {
        border: 1px solid var(--bd);
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 16px rgba(20, 50, 35, .08);
        overflow: hidden;
    }

    .card-theme .card-body { padding: 26px 28px }

    /* ===== Labels ===== */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--txt);
        margin-bottom: 6px;
    }

    .form-label i { color: var(--g); margin-right: 6px }

    /* ===== Inputs — same feel as the sheet's .dinput / .ci ===== */
    .form-control {
        border: 1px solid var(--bd2);
        border-radius: 8px;
        padding: 8px 12px;
        height: 38px;
        font: inherit;
        font-size: 13.5px;
        color: var(--txt);
        background: #fff;
        transition: all .15s;
    }

    .form-control:focus {
        border-color: var(--g);
        box-shadow: 0 0 0 3px rgba(33, 115, 70, .15);   /* sheet's focus ring */
    }

    /* readonly = "locked" cells on the sheet (#f2f4f3 / #55605a) */
    .form-control[readonly] {
        background: #f2f4f3;
        color: #55605a;
    }

    .input-group-text {
        border: 1px solid var(--bd2);
        border-radius: 0 8px 8px 0;
        background: var(--g-soft);
        color: var(--g-dark);
        font-weight: 600;
    }

    .input-group .form-control { border-radius: 8px 0 0 8px }

    /* ===== Fieldsets — green version of the pack sections ===== */
    fieldset {
        border: 1px solid #cfe3d6 !important;
        border-radius: 12px !important;
        padding: 16px 18px 6px !important;
        background: #f9fcfa;
        transition: all .2s;
    }

    fieldset:hover {
        border-color: #9ccdb0 !important;
        box-shadow: 0 4px 14px rgba(33, 115, 70, .10);
    }

    legend {
        float: none !important;              /* BS5 reboot floats legends left */
        width: auto;
        background: linear-gradient(180deg, #268152, #1d6741);   /* sheet's plan-summary gradient */
        color: #fff;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: .3px;
        padding: 5px 16px;
        margin-bottom: 0;
    }

    legend i { margin-right: 7px }

    /* ===== Section label — same green as sheet header row 2 ===== */
    .section-label {
        font-size: 13px;
        font-weight: 700;
        color: #1d4b30;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 14px;
    }

    .section-label i { color: var(--g); margin-right: 7px }

    /* ===== Save button — exact clone of the sheet's .btn-save ===== */
    .btn-theme {
        background: linear-gradient(135deg, #217346, #2f9e67);
        color: #fff;
        border: none;
        padding: 9px 34px;
        border-radius: 8px;
        font: 600 13.5px "Segoe UI", Calibri, Arial;
        cursor: pointer;
        transition: all .15s;
        box-shadow: 0 4px 10px rgba(33, 115, 70, .18);
    }

    .btn-theme:hover {
        background: linear-gradient(135deg, #1a5e39, #278b59);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(33, 115, 70, .25);
    }

    .btn-theme:active { transform: translateY(0) }

    .btn-theme i { margin-right: 8px }

    /* ===== responsive — mirrors sheet's 640px breakpoint ===== */
    @media (max-width: 640px) {
        .page-header-green { padding: 14px 16px }
        .btn-goback { position: static; margin-top: 8px }
        .card-theme .card-body { padding: 16px }
    }
</style>

<div class="container-fluid mt-4 mb-5">

    <!-- Page Header -->
    <div class="page-header-green">
        <div class="header-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <div>
            <div class="header-title">CCP Check Entry</div>
            <div class="header-sub text-danger"> CCP Check: pH &lt; 4.4 in Maximum of 18 hours. Start Checking pH after 4 hrs.</div>
        </div>
        <a href="admin.php?id=yogurt" class="btn-goback"><i class="bi bi-arrow-left"></i> Go Back</a>
    </div>

    <!-- Form Card -->
    <div class="card card-theme">
        <div class="card-body">

            <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                action="">

                <!-- ===== Basic Info ===== -->
                <div class="section-label"><i class="bi bi-info-circle-fill"></i>Basic Information</div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip01"><i
                                class="bi bi-box-seam-fill"></i>Product</label>
                        <input class="form-control" id="validationTooltip01" type="text" value="<?= $yname ?>"
                            name="product" readonly />
                        <div class="invalid-tooltip">
                            Please provide a valid product.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip01"><i
                                class="bi bi-box-seam-fill"></i>Batch No.</label>
                        <input class="form-control" id="validationTooltip01" type="text"
                            name="batchno" value="<?= $ybactchno ?>" readonly />
                        <div class="invalid-tooltip">
                            Please provide a valid Batch No.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip02"><i
                                class="bi bi-calendar"></i>Tank No</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="tankno" value="<?= $tankrepeat ?>"
                            required />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip02"><i
                                class="bi bi-calendar"></i>Date</label>
                        <input class="form-control" id="validationTooltip02" type="date" placeholder="" name="date" value="<?= date('Y-m-d') ?>"
                            required />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip02"><i
                                class="bi bi-clock-fill"></i>Time</label>
                        <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="settime"
                            required />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip02"><i
                                class="bi bi-thermometer-half"></i>Tank Temp</label>
                        <div class="input-group">
                            <input class="form-control" id="validationTooltip02" type="number" step="0.01" placeholder="" name="temptype"
                                required />
                            <span class="input-group-text">°C</span>
                        </div>
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip03"><i class="bi bi-scale"></i>PH Value</label>
                        <input class="form-control" id="validationTooltip02" type="input" placeholder="" name="phvalue"
                            required />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>
                </div>

                <button class="btn btn-theme" type="submit" name="submit">
                    <i class="bi bi-save2-fill"></i>Submit Detail
                </button>

            </form>
        </div>
    </div>

</div>

<?php
if(isset($_POST['submit'])){
   $batchno = $_POST['batchno'];
    $date = $_POST['date'];
    $product = $_POST['product'];
    $settime=$_POST['settime'];
    $tankno = $_POST['tankno'];
    $temptype = $_POST['temptype'];
    $phvalue = $_POST['phvalue'];
    $ndate = date('Y-m-d H:i:s');

    $ccpcheck = mysqli_query($con,"INSERT INTO `yogurt_ccp`(`pname`, `eid`, `tank`, `cdate`,`settime`, `tanktemp`, `ph`, `user`, `adate`) VALUES ('$product','$pid','$tankno','$date','$settime','$temptype','$phvalue','$user','$ndate')");
 $mainupdate = mysqli_query($con,"UPDATE `yogurt_records` SET `tank_no`='$tankno',ccp='waiting' WHERE id='$pid'");

    if($ccpcheck ){
        echo "<script>window.location.href='yogurtn/yogurt?date=$rdate'</script>";
    }
}
?>
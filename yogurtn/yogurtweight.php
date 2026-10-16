<?php

 $pid = $_GET['rid'];

 $yogurt = mysqli_query($con,"SELECT description,rdate,tank_no FROM `yogurt_records` WHERE id='$pid'");

 $yogr= mysqli_fetch_array($yogurt);
 $yname =$yogr['description'];
 $rdate = $yogr['rdate'];

 $ybactchno = date('ymd', strtotime($yogr['rdate']));
?>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* ================================================================
     * WEIGHT CHECK — GREEN THEME (matches Yogurt Production Records)
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
        background: #eef2ee;                 /* sheet page bg */
        font: 12.5px/1.45 "Segoe UI", Calibri, Arial, sans-serif;
        color: var(--txt);
    }

    /* ===== Page Header (green gradient — same as sheet .top) ===== */
    .page-header-blue {
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

    .page-header-blue .header-icon {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #fff;
        flex-shrink: 0;
    }

    .page-header-blue .header-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .page-header-blue .header-sub {
        font-size: 11.5px;
        color: rgba(255, 255, 255, .9);
        margin-top: 2px;
    }

    .btn-goback {
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

    /* ===== Inputs — sheet .dinput / .ci feel ===== */
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
        box-shadow: 0 0 0 3px rgba(33, 115, 70, .15);   /* sheet focus ring */
    }

    /* readonly = sheet's "locked cell" look */
    .form-control[readonly] {
        background: #f2f4f3;
        color: #55605a;
    }

    /* computed fields = sheet's yellow "formula" cells */
    #avg_weight,
    #net_weight {
        background: #fffae6;
        font-weight: 600;
        color: #6b5200;
    }

    /* ===== Fieldset (Pack Sections) ===== */
    fieldset {
        border: 1px solid #cfe3d6 !important;
        border-radius: 12px !important;
        padding: 16px 18px 8px !important;
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
        background: linear-gradient(180deg, #268152, #1d6741);
        color: #fff;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: .3px;
        padding: 5px 16px;
        margin-bottom: 0;
    }

    legend i { margin-right: 7px }

    /* ===== Section Divider Label — sheet header-row-2 green ===== */
    .section-label {
        font-size: 13px;
        font-weight: 700;
        color: #1d4b30;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 14px;
    }

    .section-label i { color: var(--g); margin-right: 7px }

    /* ===== Save Button — exact clone of the sheet's .btn-save ===== */
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

    /* ===== responsive — mirrors sheet 640px breakpoint ===== */
    @media (max-width: 640px) {
        .page-header-blue { padding: 14px 16px }
        .btn-goback { position: static; margin-top: 8px }
        .card-theme .card-body { padding: 16px }
    }
</style>

<div class="container-fluid mt-4 mb-5">

    <!-- Page Header -->
    <div class="page-header-blue">
        <div class="header-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <div>
            <div class="header-title">Weight Check Entry</div>
            <div class="header-sub"></div>
        </div>
        <a href="yogurtn/yogurt?date=<?=$rdate ?>" class="btn-goback"><i class="bi bi-arrow-left"></i> Go Back</a>
    </div>

    <!-- Form Card -->
    <div class="card card-theme">
        <div class="card-body">

            <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                action="">

                <!-- ===== Basic Info ===== -->
                <div class="section-label"><i class="bi bi-info-circle-fill"></i>Basic Information</div>

                <div class="form-row">
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
                        <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time"
                            required />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

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
                            name="batchno" value="<?= $ybactchno ?>" readonly/>
                        <div class="invalid-tooltip">
                            Please provide a valid Batch No.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip03"><i class="bi bi-scale"></i>Pack Tare
                            Weight (g)</label>
                        <input class="form-control" id="packtare" type="number" placeholder=""
                            name="packtare" required oninput="checkpack()" />
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip03"><i class="bi bi-scale"></i>Type of Check</label>
                        <select class="form-control"
                            name="type_check" required >
                            <option value="">Select Type of Check</option>
                            <option value="Begining of Production">Begining of Production</option>
                            <option value="Every 30 Minutes">Every 30 Minutes</option>
                            <option value="End of Production">End of Production</option>
                        </select>
                        <div class="invalid-tooltip">
                            Please fill the field.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-123"></i>Declare Weight (g)</label>
                        <input class="form-control" type="number" name="declared" required />
                        <div class="invalid-tooltip">Please fill the field.</div>
                    </div>
                </div>

                <hr style="border-color:#cfe3d6; margin: 25px 0;">

                <!-- ===== Pack Details ===== -->
                <div class="section-label"><i class="bi bi-boxes"></i>Pack Details</div>

                <div class="form-row">

                    <!-- Pack 1 -->
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pot 1 Weight (g)</label>
                                <input class="form-control" type="number" name="pack1" id="pack1" step="0.1" oninput="checkpack()" required />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"></i>Pot 2 Weight (g)</label>
                                <input class="form-control" type="number" name="pack2" id="pack2" step="0.1" oninput="checkpack()" required />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pot 3 Weight (g)</label>
                                <input class="form-control" type="number" name="pack3" id="pack3" step="0.1" oninput="checkpack()" required />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pot 4 Weight (g)</label>
                                <input class="form-control" type="number" name="pack4" id="pack4" step="0.1" oninput="checkpack()" required />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Average Weight (g)</label>
                                <input class="form-control" type="number" name="avg_weight" id="avg_weight" step="0.1" oninput="checkpack()" readonly />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Net Weight (g)</label>
                                <input class="form-control" type="number" name="net_weight" id="net_weight" step="0.1" oninput="checkpack()" readonly />
                                <div class="invalid-tooltip">Please fill the field.</div>
                            </div>

                        </div>

                        <script>
                            function checkpack(){
                                let v1 = parseFloat(document.getElementById('pack1').value) || 0;
                                let v2 = parseFloat(document.getElementById('pack2').value) || 0;
                                let v3 = parseFloat(document.getElementById('pack3').value) || 0;
                                let v4 = parseFloat(document.getElementById('pack4').value) || 0;
                                let packtare = parseFloat(document.getElementById('packtare').value) || 0;

                                // Count only filled fields

                               var total_count = 0;
                                if(v1 > 0) total_count++;
                                if(v2 > 0) total_count++;
                                if(v3 > 0) total_count++;
                                if(v4 > 0) total_count++;

                                var avg = (v1 + v2 + v3 + v4) / total_count;

                                net_weight = avg - packtare;

                                document.getElementById('avg_weight').value = avg;
                                document.getElementById('net_weight').value = net_weight;
                            }
                        </script>
                    </div>

                </div>

                <button class="btn btn-theme" type="submit" name="submit">
                    <i class="bi bi-save2-fill"></i>Save & Next
                </button>

            </form>
        </div>
    </div>

</div>

<!-- Bootstrap Validation Script -->
<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    })();
</script>

<?php
if(isset($_POST['submit'])){
    $time = $_POST['time'];
    $product = $_POST['product'];
    $batchno = $_POST['batchno'];
    $packtare = $_POST['packtare'];
    $pack1 = $_POST['pack1'];
    $pack2 = $_POST['pack2'];
    $pack3 = $_POST['pack3'];
    $pack4 = $_POST['pack4'];
    $declared = $_POST['declared'];
    $type_check = $_POST['type_check'];

    $avg_weight = $_POST['avg_weight'];
    $net_weight = $_POST['net_weight'];
    $recordid = "Weight".$pid."C".date('dmYhis');

    $weightcheck =mysqli_query($con,"INSERT INTO `yogurtweight`( `eid`, `product`, `time`, `packtare`, `pack1`, `pack2`, `pack3`, `pack4`, `declared`, `addby`, `netw`, `avgw`, `wcheck`,`recordid`) VALUES ('$pid','$product','$time','$packtare','$pack1','$pack2','$pack3','$pack4','$declared','$user','$net_weight','$avg_weight','$type_check','$recordid')");
    if($weightcheck){
        if($type_check == 'End of Production'){
            $mainupdate = mysqli_query($con,"UPDATE `yogurt_records` SET `weight`='done',`ccp`='done' WHERE id='$pid'");
        }else{
             $mainupdate = mysqli_query($con,"UPDATE `yogurt_records` SET `weight`='waiting' WHERE id='$pid'");
        }
            echo "<script>window.location.href='yogurtn/yogurt?date=".$rdate."'</script>";
    }
}
?>
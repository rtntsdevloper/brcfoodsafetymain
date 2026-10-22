<?php

$mid = $_GET['mid'];

$tcheck = mysqli_query($con, "SELECT * FROM `tbl_microtrending` WHERE id='$mid'");
$tcheckq = mysqli_fetch_array($tcheck);

$jid = $tcheckq['id'];
$jmid = $tcheckq['mid'];
$month = $tcheckq['admonth'];
$year = date("Y", strtotime($month));

$mname = mysqli_query($con, "SELECT * FROM `tbl_micortrend` WHERE id='$jmid'");
$mname1 = mysqli_fetch_array($mname);
$mname2 = $mname1['name'];


$sid = $tcheckq['sid'];
$sname = mysqli_query($con, "SELECT * FROM `tbl_micortrend1` WHERE id='$sid'");
$sname1 = mysqli_fetch_array($sname);
$sname2 = $sname1['name'];

// ===== Fetch ALL events (justifications + attempts) in chronological order =====
$allQ = mysqli_query($con,
    "SELECT * FROM `tbl_microtrending1`
     WHERE eid='$jid'
       AND (
            (category IS NOT NULL AND category <> '')
            OR (reason   IS NOT NULL AND reason   <> '')
            OR (caction  IS NOT NULL AND caction  <> '')
            OR (rca      IS NOT NULL AND rca      <> '')
            OR (paction  IS NOT NULL AND paction  <> '')
            OR (status = 'Pass')
            OR (status = 'Fail')
       )
     ORDER BY id ASC");

$timelineRows = [];
while ($r = mysqli_fetch_array($allQ)) {
    $timelineRows[] = $r;
}

$masterStatus  = $tcheckq['status'];
$masterFstatus = $tcheckq['fstatus'];

// Determine what the last event was (for the bottom button)
$lastEventType = null;
$lastStatus    = null;
foreach ($timelineRows as $tr) {
    $isJ = (!empty($tr['category']) || !empty($tr['reason']) || !empty($tr['caction']) || !empty($tr['rca']) || !empty($tr['paction']));
    $isA = ($tr['status'] == 'Pass' || $tr['status'] == 'Fail');
    if ($isJ) {
        $lastEventType = 'justification';
        $lastStatus    = null;
    } elseif ($isA) {
        $lastEventType = 'attempt';
        $lastStatus    = $tr['status'];
    }
}
?>

<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem 0;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    h3 {
        color: #6a11cb;
    }

    /* ===== TIMELINE ===== */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    .timeline::before {
        content: '';
        position: absolute;
        width: 6px;
        background: #e6e6e6;
        top: 0;
        bottom: 0;
        left: 30px;
        border-radius: 10px;
        z-index: 0;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background: linear-gradient(to bottom, #6a11cb, #2575fc, #6a11cb);
        top: 0;
        left: 30px;
        border-radius: 10px;
        z-index: 1;
        height: 0;
        animation: timelineFlow 2.5s ease-out forwards;
    }

    @keyframes timelineFlow {
        0%   { height: 0%;   opacity: 0.9; }
        100% { height: 100%; opacity: 0.9; }
    }

    .timeline-end-dot {
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #28a745;
        border: 4px solid white;
        bottom: 0;
        left: 23px;
        border-radius: 50%;
        z-index: 3;
        box-shadow: 0 0 0 3px #28a745;
    }

    /* ===== TIMELINE ITEMS ===== */
    .timeline-container {
        padding: 10px 40px;
        position: relative;
        width: 100%;
        padding-left: 70px;
        margin-bottom: 30px;
        z-index: 2;
    }

    .timeline-container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        background-color: white;
        border: 4px solid #2575fc;
        top: 15px;
        left: 21px;
        border-radius: 50%;
        z-index: 3;
    }

    .timeline-container.is-justification::after { border-color: #6a11cb; }
    .timeline-container.is-pass::after          { border-color: #28a745; }

    .timeline-content {
        padding: 25px;
        background-color: white;
        position: relative;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid #2575fc;
    }

    .timeline-content.jc   { border-left: 4px solid #6a11cb; }
    .timeline-content.pass { border-left: 4px solid #28a745; }

    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-title-inline {
        color: #2c3e50;
        margin-bottom: 15px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f6;
        font-size: 1.15rem;
    }

    .timeline-date {
        font-weight: bold;
        color: #2575fc;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.1rem
    }

    .timeline-bact {
        font-weight: bold;
        width: 100%;
        text-align: left;
        color: #2575fc;
        margin-bottom: 8px;
        gap: 8px;
        font-size: 1.2rem
    }

    .timeline-date i {
        font-size: 1.2rem;
    }

    .timeline-content h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .timeline-content p {
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    /* Justification key/value grid */
    .jc-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        margin-right: -10px;
    }

    .jc-col {
        padding-left: 10px;
        padding-right: 10px;
        margin-bottom: 14px;
        box-sizing: border-box;
    }

    .jc-6 { flex: 0 0 50%; max-width: 50%; }
    .jc-12 { flex: 0 0 100%; max-width: 100%; }

    @media (max-width: 768px) {
        .jc-6 { flex: 0 0 100%; max-width: 100%; }
    }

    .jc-label {
        display: block;
        font-weight: bold;
        color: #6a11cb;
        margin-bottom: 6px;
        font-size: 1rem;
    }

    .jc-value {
        color: #555;
        font-size: 1rem;
        line-height: 1.6;
        font-weight: 500;
        word-wrap: break-word;
    }

    .jc-value.empty {
        color: #a0aec0;
        font-style: italic;
        font-weight: 400;
    }

    .badge {
        font-size: 0.75rem;
        padding: 6px 12px;
    }

    .timeline-end {
        padding: 10px 40px;
        position: relative;
        width: 100%;
        padding-left: 70px;
        margin-top: 20px;
        text-align: center;
        z-index: 2;
    }

    @media screen and (max-width: 768px) {
        .timeline::before,
        .timeline::after { left: 20px; }
        .timeline-end-dot { left: 13px; }
        .timeline-container { padding-left: 50px; padding-right: 15px; }
        .timeline-container::after { left: 11px; }
        .timeline-content { padding: 20px; }
        .timeline-end { padding-left: 50px; padding-right: 15px; }
    }

    .footer {
        text-align: center;
        margin-top: 4rem;
        padding: 1.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }
</style>

<div class="container">

    <!-- ===== PAGE HEADER ===== -->
    <div class="page-header">
        <h1 class="text-light"><?php echo $mname2; ?> (<?php echo $year; ?>)</h1>
        <p><?php echo $sname2; ?> (<?php echo date("M Y", strtotime($month)); ?>)</p>
    </div>

    <!-- ===== TIMELINE ===== -->
    <div class="timeline">

        <?php foreach ($timelineRows as $rowItem):

            $isJustification = (
                (!empty($rowItem['category'])) ||
                (!empty($rowItem['reason'])) ||
                (!empty($rowItem['caction'])) ||
                (!empty($rowItem['rca'])) ||
                (!empty($rowItem['paction']))
            );

            $isAttempt = ($rowItem['status'] == 'Pass' || $rowItem['status'] == 'Fail');

            if (!$isJustification && !$isAttempt) continue;

            if ($isJustification):
        ?>

            <!-- ===== JUSTIFICATION EVENT ===== -->
            <div class="timeline-container is-justification">
                <div class="timeline-content jc">
                    <div class="card-title-inline">
                        <i class="fa fa-clipboard"></i> Justification Details
                    </div>

                    <div class="jc-row">
                        <div class="jc-col jc-6">
                            <span class="jc-label">Attempt On :</span>
                            <div class="jc-value">
                                <?php echo !empty($rowItem['attempt_on']) ? date("M d, Y H:i", strtotime($rowItem['attempt_on'])) : '—'; ?>
                            </div>
                        </div>

                        <div class="jc-col jc-6">
                            <span class="jc-label">Reason Category :</span>
                            <div class="jc-value">
                                <?php echo !empty($rowItem['category']) ? htmlspecialchars(ucfirst($rowItem['category'])) : '—'; ?>
                            </div>
                        </div>

                        <div class="jc-col jc-12">
                            <span class="jc-label">Reason / Details :</span>
                            <div class="jc-value <?php echo empty($rowItem['reason']) ? 'empty' : ''; ?>">
                                <?php echo !empty($rowItem['reason']) ? nl2br(htmlspecialchars($rowItem['reason'])) : 'No reason provided'; ?>
                            </div>
                        </div>

                        <div class="jc-col jc-6">
                            <span class="jc-label">Corrective Action :</span>
                            <div class="jc-value <?php echo empty($rowItem['caction']) ? 'empty' : ''; ?>">
                                <?php echo !empty($rowItem['caction']) ? nl2br(htmlspecialchars($rowItem['caction'])) : 'Not specified'; ?>
                            </div>
                        </div>

                        <div class="jc-col jc-6">
                            <span class="jc-label">RCA (Root Cause Analysis) :</span>
                            <div class="jc-value <?php echo empty($rowItem['rca']) ? 'empty' : ''; ?>">
                                <?php echo !empty($rowItem['rca']) ? nl2br(htmlspecialchars($rowItem['rca'])) : 'Not specified'; ?>
                            </div>
                        </div>

                        <div class="jc-col jc-12">
                            <span class="jc-label">Preventive Action :</span>
                            <div class="jc-value <?php echo empty($rowItem['paction']) ? 'empty' : ''; ?>">
                                <?php echo !empty($rowItem['paction']) ? nl2br(htmlspecialchars($rowItem['paction'])) : 'Not specified'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
            elseif ($isAttempt):
                $isPass = ($rowItem['status'] == 'Pass');
                $cardClass = $isPass ? 'pass' : '';
                $containerClass = $isPass ? 'is-pass' : '';
        ?>

            <!-- ===== ATTEMPT EVENT ===== -->
            <div class="timeline-container <?php echo $containerClass; ?>">
                <div class="timeline-content <?php echo $cardClass; ?>">

                    <div class="timeline-date">
                        <b style="color:#6a11cb;">Sample date : </b>
                        <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($rowItem['sample'])); ?>
                    </div>
                    <div class="timeline-date">
                        <b style="color:#6a11cb;">Sample testing date :</b>
                        <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($rowItem['testing'])); ?>
                    </div>
                    <div class="timeline-date">
                        <b style="color:#6a11cb;">Issue date :</b>
                        <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($rowItem['issue'])); ?>
                    </div>

                    <div class="timeline-date">
                        <b style="color:#6a11cb;">Report no :</b>
                        <i class="fa fa fa-server"></i> <?php echo $rowItem['reportno']; ?>
                    </div>

                    <div class="timeline-date mb-3">
                        <b style="color:#6a11cb;">Report :</b>
                        <a href="micro/upload/<?php echo $rowItem['report']; ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa fa-file-pdf-o"></i> Uploaded Document
                        </a>
                    </div>

                    <!-- ===== BACTERIA TABLE ===== -->
                    <?php
                    $tcheckid = $rowItem['id'];

                    $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tcheckid' AND mid='$jid'");
                    $bactnamex = mysqli_num_rows($bactname);
                    if ($bactnamex > 0) {
                    ?>
                        <div class="timeline-bact">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2 m-0 p-0">
                                        <b style="color:#6a11cb;text-align:left;">Bacterias :</b>
                                    </div>
                                    <div class="col-md-10">
                                        <table class="table text-center" style="font-size: 0.8 rem;">
                                            <tr>
                                                <th>Name</th>
                                                <th>Acceptable Limit</th>
                                                <th>Rejectable Limit</th>
                                                <th>Actual Value</th>
                                                <th>Status</th>
                                            </tr>

                                            <?php
                                            $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tcheckid' AND mid='$jid'");
                                            foreach ($bactname as $bactvalue) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $bactvalue['name']; ?></td>
                                                    <td><?php echo $bactvalue['accept']; ?></td>
                                                    <td><?php echo $bactvalue['reject']; ?></td>
                                                    <td><?php echo $bactvalue['actual']; ?></td>
                                                    <td><?php echo $bactvalue['status']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="timeline-date">
                        <b style="color:#6a11cb;">Status :</b>
                        <?php if ($isPass): ?>
                            <i class="fa fa-file-text-o text-success"> Pass</i>
                        <?php else: ?>
                            <i class="fa fa-file-text-o text-danger"> Fail</i>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        <?php
            endif;
        endforeach;
        ?>

        <!-- ===== BOTTOM ACTION BUTTON ===== -->
        <?php
        $showAddTest   = false;
        $showReAttempt = false;

        if ($masterStatus != 'Pass') {
            if ($lastEventType === 'justification') {
                $showAddTest = true;
            } elseif ($lastEventType === 'attempt' && $lastStatus == 'Fail' && $masterFstatus == 'Yes') {
                $showReAttempt = true;
            }
        }
        ?>

        <?php if ($showAddTest): ?>
            <div class="timeline-end mt-5">
                <div class="timeline-content" style=" border-left: 4px solid #2575fc;">
                    <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>&month=<?php echo $month; ?>&sid=<?php echo $sid; ?>" class="btn btn-primary">Add Test</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($showReAttempt): ?>
            <div class="timeline-end mt-5">
                <div class="timeline-content" style=" border-left: 4px solid #b7110eff;">
                    <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>&month=<?php echo $month; ?>&sid=<?php echo $sid; ?>" class="btn btn-danger">Re-Attempt</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Green end dot -->
        <div class="timeline-end-dot"></div>

    </div>
</div>
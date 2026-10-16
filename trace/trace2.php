<?php

include '../connection.php';

  $batch= $_GET['batch'];



$batchq = mysqli_query($con, "SELECT * FROM `tblmarination` WHERE batchcode='$batch'");

$batchnq = mysqli_num_rows($batchq);



if ($batchnq == 0) {

    ?>





    <div class="empty-state animate-in delay-2">

        <div class="empty-icon-wrap">

            <i class="bi bi-search"></i>

        </div>

        <div class="empty-title">No batch found</div>

        <div class="empty-desc">

            We couldn't locate a production record matching your search. Double-check the batch code and try

            again.

        </div>

        <div class="empty-example">

            <span>Batchcode:</span> <?= $batch ?>

        </div>

    </div>

    <?php

} else {

    ?>

    
                                            <div class="metric-tile">

                                                <a href="admin.php?id=boxingpo&po=<?= $packing1['botfilm'] ?>">

                                                    <div class="label">Bottom Film Batchcode</div>

                                                    <div class="h4 text-info">

                                                        <?= $packing1['botfilm'] ?>

                                                    </div>

                                                </a>

                                            </div>

                                            <!-- user detail of attempt -->

                                            <?php

                                            if (isset($packusercert1['certdate']) && $packusercert1['certdate'] != '') {

                                                $date = new DateTime($packusercert1['certdate']);

                                                $date->modify('-3 years');

                                                $cerdate = $date->format('d-m-Y');
                                            } else {

                                                $cerdate = 'Not Trained';
                                            }



                                            // User Photo

                                            if (isset($packusercert1['simg']) && $packusercert1['simg'] != '') {

                                                $userPhoto = 'student/' . $packusercert1['simg'];
                                            } else {

                                                $userPhoto = '#';
                                            }



                                            // User Certificate

                                            if (isset($packusercert1['certificate']) && $packusercert1['certificate'] != '') {

                                                $userCertificate = 'student/' . $packusercert1['certificate'];
                                            } else {

                                                $userCertificate = '';
                                            }



                                            ?>

                                            <div class="metric-tile">

                                                <div class="label">Attempt By (Training Date) </div>

                                                <div class="h4 text-primary">

                                                    <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                        data-name="<?= $packdetuser ?>" data-pic="<?= $userPhoto ?>"

                                                        data-cert-date="<?= $cerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                        data-pdf-label="Training Document">

                                                        <?= htmlspecialchars($packdetuser) ?>

                                                        (<?= $cerdate ?>)

                                                    </a>

                                                </div>





                                            </div>





                                        </div>

                                    </div>

                            <?php

                                
                            }

                            ?>



                        </div>

                    </div>



                    <?php



                    $metalprocd = mysqli_query($con, "SELECT * FROM `trace_doc` where id='5'");

                    $metalprocd1 = mysqli_fetch_assoc($metalprocd);

                    $metalprocdcertificate = $metalprocd1['path'];

                    ?>

                    <!-- Metal Detection -->

                    <div class="animate-in delay-4">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon metal-icon"><i class="bi bi-magnet"></i></div>

                                <div>

                                    <div class="stage-title">Metal Detection</div>

                                    <div class="stage-sub text-danger"><b>Procedure :</b> <a

                                            href="<?= $metalprocdcertificate ?>"  class="hover-pop" target="_blank"

                                            rel="noopener noreferrer"><i class="bi bi-file-text"></i> view procedure</a>

                                    </div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=metalreport&batch=<?= $batchcode ?>" class="btn-ghost btn

                                                text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>

                            </div>



                            <?php

                            $metalm = mysqli_query($con, "SELECT * FROM `tblmetal` WHERE productbatch ='$batchcode'");

                            $metalmn = mysqli_num_rows($metalm);

                            if ($metalmn == 0) {

                            ?>

                                <div class="empty-state-compact">

                                    <div class="empty-icon">

                                        <i class="bi bi-magnet"></i>

                                    </div>

                                    <div class="empty-title">No Record Found</div>

                                    <div class="empty-sub">No metal details have been recorded for this batch code.

                                    </div>

                                </div>

                                <?php

                            } else {

                                foreach ($metalm as $metalmr) {

                                    $ansar = explode(';', $metalmr['ans']);



                                    $testmty = $metalmr['testtype'];

                                    $metaluser = $metalmr['user'];

                                    $metaluserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$metaluser' and c1.type ='Procedure' and c1.status='Active'");

                                    $metalusercert1 = mysqli_fetch_assoc($metaluserdet);

                                ?>



                                    <!-- Top: Result + Test Type + Gas Reading -->

                                    <div

                                        style="display:flex; align-items:stretch; gap:16px; flex-wrap:wrap; margin-bottom:20px;">



                                        <!-- Result Block -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Date Time</div>

                                            <div style="margin-top:8px;">

                                                <span

                                                    class="test-type-badge"><?= date('d-m-Y h:i A', strtotime($metalmr['datetime'])); ?></span>

                                            </div>

                                        </div>

                                        <!-- Test Type -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Test Type</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['testtype'] ?></span>

                                            </div>

                                        </div>





                                        <!-- Gas Reading -->

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Gas Reading</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['gas'] ?></span>

                                            </div>

                                        </div>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Is correct packaging film being used?</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['pack1'] ?></span>

                                            </div>

                                        </div>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Any correction needed ?</div>

                                            <div style="margin-top:8px;">

                                                <span class="test-type-badge"><?= $metalmr['pack2'] ?></span>

                                            </div>

                                        </div>





                                        <!-- user detail of attempt -->

                                        <?php

                                        if (isset($metalusercert1['certdate']) && $metalusercert1['certdate'] != '') {

                                            $date = new DateTime($metalusercert1['certdate']);

                                            $date->modify('-3 years');

                                            $mcerdate = $date->format('d-m-Y');
                                        } else {

                                            $cerdate = 'Not Trained';
                                        }



                                        // User Photo

                                        if (isset($metalusercert1['simg']) && $metalusercert1['simg'] != '') {

                                            $userPhoto = 'student/' . $metalusercert1['simg'];
                                        } else {

                                            $userPhoto = '#';
                                        }



                                        // User Certificate

                                        if (isset($metalusercert1['certificate']) && $metalusercert1['certificate'] != '') {

                                            $userCertificate = 'student/' . $metalusercert1['certificate'];
                                        } else {

                                            $userCertificate = '';
                                        }



                                        ?>

                                        <div class="metric-tile"

                                            style="flex:0 0 220px; display:flex; flex-direction:column; justify-content:center;">

                                            <div class="label">Attempt By (Training Date) </div>

                                            <div class="h4 text-primary">

                                                <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                    data-name="<?= $metaluser ?>" data-pic="<?= $userPhoto ?>"

                                                    data-cert-date="<?= $mcerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                    data-pdf-label="Training Document">

                                                    <?= htmlspecialchars($metaluser) ?>

                                                    (<?= $cerdate ?>)

                                                </a>

                                            </div>





                                        </div>



                                    </div>



                                    <!-- Checklist Questions -->

                                    <div class="checklist-wrap">

                                        <div class="checklist-title-row">

                                            <div class="checklist-label">Inspection Checklist</div>

                                        </div>

                                        <table class="checklist-table" width="100%">

                                            <thead>

                                                <tr>

                                                    <th style="width:40px;">#</th>

                                                    <th>Question</th>

                                                    <th style="width:100px;">Status</th>



                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php

                                                $m = 0;

                                                $metalq = mysqli_query($con, "SELECT * FROM `tblques2` WHERE status='$testmty'");

                                                while ($metalqr = mysqli_fetch_array($metalq)) {

                                                    if ($ansar[$m] = 'Yes') {

                                                        $color = 'cl-pass';

                                                        $cicon = 'bi-check-circle-fill';
                                                    } else {

                                                        $color = 'cl-fail';

                                                        $cicon = 'bi-x-circle-fill';
                                                    }



                                                ?>



                                                    <tr>

                                                        <td style="color:var(--muted);"><?= $m + 1; ?></td>

                                                        <td><?= $metalqr['ques']; ?></td>

                                                        <td><span class=<?= $color; ?>><i class=<?= $cicon; ?>></i>

                                                                <?= $ansar[$m]; ?>

                                                            </span></td>



                                                    </tr>

                                                <?php

                                                    $m++;
                                                }



                                                ?>



                                            </tbody>

                                        </table>

                                    </div>

                                    <br>

                                    <hr><br>



                            <?php

                                }
                            }



                            ?>



                        </div>

                    </div>







                    <!-- Boxing  -->

                    <div class="animate-in delay-5">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon box-icon"><i class="bi bi-box-seam"></i></div>

                                <div>

                                    <div class="stage-title">Boxing Record</div>

                                    <div class="stage-sub">Final Pack</div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">

                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=boxingreport&batch=<?= $batchcode ?>" class="btn-ghost

                                                btn text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>



                                </div>

                            </div>

                            <?php



                            $boxchk = mysqli_query($con, "SELECT b.*,r.name as bname FROM `tblboxing` as b join tblrecipe as r  on r.id = b.sno where productbatch ='$batchcode'");

                            $boxchkn = mysqli_num_rows($boxchk);



                            if ($boxchkn > 0) {

                                foreach ($boxchk as $boxc) {

                                    $boxuser = $boxc['user'];

                                    $boxuserdet = mysqli_query($con, "SELECT s1.id,c1.certdate,s1.img as simg,c1.certificate FROM `tblstaff` as s1 join tbladmin as a1 join tblstaffcert as c1 on a1.staffid = s1.id and c1.user = s1.id WHERE a1.name ='$boxuser' and c1.type ='Procedure' and c1.status='Active'");

                                    $boxusercert1 = mysqli_fetch_assoc($boxuserdet);







                            ?>

                                    <div

                                        style="display:flex; align-items:flex-start; gap:24px; flex-wrap:wrap;margin-bottom:10px;">

                                        <div class="metrics-grid cols-4" style="flex:1 1 240px; margin-bottom:0;">

                                            <div class="metric-tile">

                                                <div class="label">Date Time</div>

                                                <div class="h4"><?= date('d-m-Y', strtotime($boxc['cdate'])); ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Box Name</div>

                                                <div class="h4 text-info">

                                                    <?= $boxc['bname'] ?>

                                                </div>

                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Box Batchcode (Best Before)</div>

                                                <div class="h4 text-info">

                                                    <?= $boxc['boxbatchcode'] . " (" . date('d-m-Y', strtotime($boxc['bestbefore'])) . ")" ?>

                                                </div>



                                            </div>

                                            <div class="metric-tile">

                                                <div class="label">Total Packs</div>

                                                <div class="h4" style="color:var(--ok);">

                                                    <?= $boxc['img'] ?>

                                                </div>

                                            </div>



                                            <?php

                                            if (isset($boxusercert1['certdate']) && $boxusercert1['certdate'] != '') {

                                                $date = new DateTime($boxusercert1['certdate']);

                                                $date->modify('-3 years');

                                                $bcerdate = $date->format('d-m-Y');
                                            } else {

                                                $bcerdate = 'Not Trained';
                                            }



                                            // User Photo

                                            if (isset($boxusercert1['simg']) && $boxusercert1['simg'] != '') {

                                                $userPhoto = 'student/' . $boxusercert1['simg'];
                                            } else {

                                                $userPhoto = '#';
                                            }



                                            // User Certificate

                                            if (isset($boxusercert1['certificate']) && $boxusercert1['certificate'] != '') {

                                                $userCertificate = 'student/' . $boxusercert1['certificate'];
                                            } else {

                                                $userCertificate = '';
                                            }



                                            ?>

                                            <div class="metric-tile">

                                                <div class="label">Attempt By (Training Date) </div>

                                                <div class="h4 text-primary">

                                                    <a href="#" class="openModalLink hover-pop" id="openModalLink"

                                                        data-name="<?= $boxuser ?>" data-pic="<?= $userPhoto ?>"

                                                        data-cert-date="<?= $bcerdate ?>" data-pdf="<?= $userCertificate ?>"

                                                        data-pdf-label="Training Document">

                                                        <?= htmlspecialchars($boxuser) ?>

                                                        (<?= $bcerdate ?>)

                                                    </a>

                                                </div>





                                            </div>



                                        </div>

                                    </div>



                                <?php

                                }
                            } else {

                                ?>

                                <div class="empty-state-compact">

                                    <div class="empty-icon">

                                        <i class="bi bi-box-seam"></i>

                                    </div>

                                    <div class="empty-title">No Record Found</div>

                                    <div class="empty-sub">No boxing details have been recorded for this batch

                                        code.</div>

                                </div>

                            <?php

                            }

                            ?>

                        </div>

                    </div>



                    <!-- goods out -->

                    <!-- Recipe Record -->

                    <?php

                    $goodsub = mysqli_query($con, "SELECT c.name as cname , g.po as invoice, g.cdate as godate,b.* FROM `tblboxing` as b join tblgdn1 as g1 join tblgdn as g join tblcustomer as c  on g1.batchcode =  b.boxbatchcode AND g1.gdn = g.gdn AND g.customer = c.id where b.productbatch ='$batchcode'");

                    $goodsubn = mysqli_num_rows($goodsub);

                    ?>

                    <div class="animate-in delay-3">

                        <div class="stage-card">

                            <div class="stage-head">

                                <div class="stage-icon recipe-icon"><i class="bi bi-send"></i>

                                </div>

                                <div>

                                    <div class="stage-title">Goods Out Record</div>

                                </div>

                                <div class="stage-head-right ">

                                    <div class="stage-head-right ">



                                        <div class="kv-value mono text-center " id="bakeOven" style="font-size:13px"><a

                                                href="admin.php?id=goodsreport&batch=<?= $batchcode ?>" class="btn-ghost btn

                                                text-info" target="_blank"><i

                                                    class="bi bi-file-earmark-richtext-fill"></i> View

                                                Report</a></div>



                                    </div>

                                </div>

                            </div>



                            <div class="ing-table-wrap">

                                <table class="ing-table">

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Customer Name</th>

                                            <th>Invoice No.</th>

                                            <th>Date</th>

                                            <th>Box Batchcode</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $goodsub = mysqli_query($con, "SELECT c.name as cname , g.po as invoice, g.cdate as godate,b.* FROM `tblboxing` as b join tblgdn1 as g1 join tblgdn as g join tblcustomer as c  on g1.batchcode =  b.boxbatchcode AND g1.gdn = g.gdn AND g.customer = c.id where b.productbatch ='$batchcode'");

                                        $goodsubn = mysqli_num_rows($goodsub);

                                        if ($goodsubn > 0) {



                                            $i = 1;

                                            foreach ($goodsub as $gooddata) {

                                        ?>

                                                <tr>

                                                    <td style="color:var(--muted);"><?= $i ?></td>



                                                    <td style="color:var(--muted);">

                                                        <?= $gooddata['cname'] ?>

                                                    </td>

                                                    <td><?= $gooddata['invoice'] ?></td>

                                                    <td><?= $gooddata['godate'] ?></td>

                                                    <td><?= $gooddata['boxbatchcode'] ?></td>



                                                </tr>

                                            <?php

                                                $i++;
                                            }
                                        } else {

                                            ?>

                                            <tr>

                                                <td colspan="5" class="text-center">No Record Found</td>

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



        



        ?>

    </div>

    <?php

}



?>
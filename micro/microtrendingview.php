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




?>
<style>
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

    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Vertical line */
    .timeline::before {
        content: '';
        position: absolute;
        width: 6px;
        background: linear-gradient(to bottom, #6a11cb, #2575fc);
        top: 0;
        bottom: 0;
        left: 30px;
        border-radius: 10px;
    }

    /* Timeline end marker */
    .timeline::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #28a745;
        border: 4px solid white;
        bottom: 0;
        left: 23px;
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 0 0 3px #28a745;
    }

    /* Timeline container */
    .timeline-container {
        padding: 10px 40px;
        position: relative;
        width: 100%;
        padding-left: 70px;
        margin-bottom: 30px;
    }

    /* Circle markers */
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
        z-index: 1;
    }

    /* Content styling */
    .timeline-content {
        padding: 25px;
        background-color: white;
        position: relative;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid #2575fc;
    }

    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    /* Date styling */
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

    /* Status badges */
    .badge {
        font-size: 0.75rem;
        padding: 6px 12px;
    }

    /* End message styling */
    .timeline-end {
        padding: 10px 40px;
        position: relative;
        width: 100%;
        padding-left: 70px;
        margin-top: 20px;
        text-align: center;
    }

    .end-message {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .end-message h3 {
        margin-bottom: 10px;
        font-weight: 600;
    }

    .end-message p {
        margin-bottom: 0;
        opacity: 0.9;
    }

    /* Mobile responsiveness */
    @media screen and (max-width: 768px) {
        .timeline::before {
            left: 20px;
        }

        .timeline::after {
            left: 13px;
        }

        .timeline-container {
            padding-left: 50px;
            padding-right: 15px;
        }

        .timeline-container::after {
            left: 11px;
        }

        .timeline-content {
            padding: 20px;
        }

        .timeline-end {
            padding-left: 50px;
            padding-right: 15px;
        }
    }

    .footer {
        text-align: center;
        margin-top: 4rem;
        padding: 1.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Top Action Card & Go Back Button */
    .action-card {
        border: none;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
        transition: box-shadow 0.3s ease;
    }

    .action-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
    }

    .action-card .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .action-card .card-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-card .card-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 18px;
        background: linear-gradient(to bottom, #6a11cb, #2575fc);
        border-radius: 2px;
    }

    .btn-go-back {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.92rem;
        padding: 9px 22px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
        transition: all 0.25s ease-in-out;
        text-decoration: none !important;
    }

    .btn-go-back:hover {
        background: linear-gradient(135deg, #218838 0%, #1aa179 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(40, 167, 69, 0.35);
        color: #ffffff !important;
    }

    .btn-go-back:active {
        transform: translateY(0);
        box-shadow: 0 2px 6px rgba(40, 167, 69, 0.2);
    }

    .btn-go-back i {
        font-size: 0.9rem;
        transition: transform 0.2s ease;
    }

    .btn-go-back:hover i {
        transform: translateX(-3px);
    }
</style>
</head>

<body>
    <div class="container">
        <div class="card action-card">
            <div class="card-body">
                <div class="card-title">Micro Trending Details</div>
                <a href="admin.php?id=microtrending" class="btn btn-success btn-go-back">
                    <i class="fa fa-arrow-left"></i> Go Back
                </a>
            </div>
        </div>

        <div class="page-header">


            <h1 class="text-light"><?php echo $mname2; ?> (<?php echo $year; ?>)</h1>
            <p><?php echo $sname2; ?> (<?php echo date("M Y", strtotime($month)); ?>)</p>
        </div>

        <div class="timeline">
            <?php

            $tcheck = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid'and status='Fail'");
            foreach ($tcheck as $tcheckv) {
                $tdid = $tcheckv['id'];
                $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tdid'AND mid='$jid'");
                $bactnamex = mysqli_num_rows($bactname);
            ?>

                <!-- Timeline Item 1 -->
                <div class="timeline-container">
                    <div class="timeline-content">
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Sample date : </b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckv['sample']));  ?>
                        </div>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Sample testing date :</b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckv['testing']));  ?>
                        </div>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Issue date :</b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckv['issue']));  ?>
                        </div>

                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Report no :</b>
                            <i class="fa fa fa-server"></i> <?php echo $tcheckv['reportno'];  ?>
                        </div>

                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Report :</b>
                            <a href="micro/upload/<?php echo $tcheckv['report']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa fa-file-pdf-o"></i>Uploaded Document</a>
                        </div>
                        <?php
                        if ($bactnamex > 0) {
                        ?>
                            <div class="timeline-bact">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 m-0 p-0">
                                            <b style="color:#6a11cb;text-align:left;">Bacterias :</b>
                                        </div>
                                        <div class="col-md-10">
                                            <table class="table text-center" style="font-size: 0.5 rem;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Acceptable Limit</th>
                                                    <th>Rejectable Limit</th>
                                                    <th>Actual Value</th>
                                                    <th>Status</th>
                                                </tr>
                                                <?php
                                                $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tdid'AND mid='$jid'");

                                                foreach ($bactname as $bactvalue) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $bactvalue['name'];  ?></td>
                                                        <td><?php echo $bactvalue['accept'];  ?></td>
                                                        <td><?php echo $bactvalue['reject'];  ?></td>
                                                        <td><?php echo $bactvalue['actual'];  ?></td>
                                                        <td><?php echo $bactvalue['status'];  ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        <?php
                        }
                        ?>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Status :</b>
                            <i class="fa fa-file-text-o text-danger"> Fail</i>
                        </div>

                    </div>
                </div>


            <?php

            }

            if ($tcheckq['status'] == 'Pass') {
                $tcheckp = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid'and status='Pass'");
                $tcheckp1 = mysqli_fetch_array($tcheckp);
                $tdid = $tcheckp1['id'];
                $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tdid'AND mid='$jid'");
                $bactnamex = mysqli_num_rows($bactname);;
            ?>


                <!-- Timeline End Marker -->
                <div class="timeline-end mt-5">

                    <div class="timeline-content" style=" border-left: 4px solid #28a745;">
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Sample date : </b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckp1['sample']));  ?>
                        </div>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Sample testing date :</b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckp1['testing']));  ?>
                        </div>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Issue date :</b>
                            <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckp1['issue']));  ?>
                        </div>

                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Report no :</b>
                            <i class="fa fa fa-server"></i> <?php echo $tcheckp1['reportno'];  ?>
                        </div>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Report :</b>
                            <a href="micro/upload/<?php echo $tcheckp1['report']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa fa-file-pdf-o"></i>Uploaded Document</a>
                        </div>
                        <?php
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
                                                $bactname = mysqli_query($con, "SELECT * FROM `microtrendb` WHERE mmid='$tdid'AND mid='$jid'");

                                                foreach ($bactname as $bactvalue) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $bactvalue['name'];  ?></td>
                                                        <td><?php echo $bactvalue['accept'];  ?></td>
                                                        <td><?php echo $bactvalue['reject'];  ?></td>
                                                        <td><?php echo $bactvalue['actual'];  ?></td>
                                                        <td><?php echo $bactvalue['status'];  ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        <?php
                        }
                        ?>
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Status :</b>
                            <i class="fa fa-file-text-o text-success"> Pass</i>
                        </div>




                    </div>
                </div>
                <?php
            } elseif ($tcheckq['status'] == 'Justified') {
                $tcheckp = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid'and status='Justified'");
                $tcheckp1 = mysqli_fetch_array($tcheckp);

                if ($tcheckp1['reportno'] == 'Retest') {
                ?>
                    <div class="timeline-end mt-5">


                        <div class="timeline-content" style=" border-left: 4px solid #28a745;">
                            <h3 style="color:red">Micro Testing Justification</h3><br>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Date & Time : </b>
                                <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckp1['attempt_on']));  ?>
                            </div>

                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Reason / Details : </b>
                                <?php echo $tcheckp1['reason'];  ?>
                            </div>


                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Signature :</b>
                                <img src="micro/sign/<?= $tcheckp1['sign']; ?>" alt="" width="120" class="ml-3">
                            </div>









                        </div>
                    </div>
                <?php
                } else {
                ?>



                    <!-- Timeline End Marker -->
                    <div class="timeline-end mt-5">


                        <div class="timeline-content" style=" border-left: 4px solid #28a745;">
                            <h3 style="color:red">Micro Testing Justification</h3><br>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Date & Time : </b>
                                <i class="fa fa-calendar"></i> <?php echo date("M d, Y", strtotime($tcheckp1['attempt_on']));  ?>
                            </div>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Reason of Justification :</b>
                                <?php echo date("M d, Y", strtotime($tcheckp1['category']));  ?>
                            </div>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Any Other Reason / Details</b>
                                <?php echo $tcheckp1['reason'];  ?>
                            </div>


                            <?php

                            if ($tcheckp1['category'] == 'missed testing' || $tcheckp1['category'] == 'others') {
                            ?>
                                <!-- detail other -->
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">Corrective Action</b>
                                    <?php echo $tcheckp1['caction'];  ?>
                                </div>
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">RCA (Root Cause Analysis)</b>
                                    <?php echo $tcheckp1['rca'];  ?>
                                </div>
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">Preventive Action</b>
                                    <?php echo $tcheckp1['paction'];  ?>
                                </div>

                            <?php
                            }
                            ?>
                            <!-- detail other  end -->
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Will micro testing be required in the upcoming months?</b>
                                <?php echo $tcheckp1['remark'];  ?>
                            </div>

                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Next Testing Month :</b>
                                <i class="fa fa-calendar"></i> <?php echo date("F Y", strtotime($tcheckp1['month'] . "-01"));  ?>
                            </div>

                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Signature :</b>
                                <img src="micro/sign/<?= $tcheckp1['sign']; ?>" alt="" width="120" class="ml-3">
                            </div>








                        </div>
                    </div>

                <?php
                }

                ?>

            <?php
            } elseif ($tcheckq['status'] == 'Fail' && $tcheckq['fstatus'] == 'Yes') {
            ?>
                <div class="timeline-end mt-5">

                    <div class="timeline-content" style=" border-left: 4px solid #b7110eff;">
                        <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>&month=<?php echo $month; ?>&sid=<?php echo $sid; ?>" class="btn btn-danger">Re-Attempt</a>
                    </div>
                </div>

            <?php

            }

            ?>
        </div>
    </div>


    </div>
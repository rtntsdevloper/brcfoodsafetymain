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

    .timeline-date i {
        font-size: 1.1rem;
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
</style>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1 class="text-light"><?php echo $mname2; ?> (<?php echo $year; ?>)</h1>
            <p><?php echo $sname2; ?> (<?php echo date("M Y", strtotime($month)); ?>)</p>
        </div>

        <div class="timeline">
            <?php

            $tcheck = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid'and status !='Pass'");
            foreach ($tcheck as $tcheckv) {

                if ($tcheckv['status'] == 'Fail') {
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
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Status :</b>
                                <i class="fa fa-file-text-o text-danger"> Fail</i>
                            </div>
                        </div>
                    </div>
                <?php
                } elseif ($tcheckv['status'] == 'Justified') {
                ?>

                    <div class="timeline-container">
                        <div class="timeline-content">
                            <div class="timeline-date text-center text-info">
                                <b style="color:#6a11cb;">Microtesting Justification</b>
                               
                            </div>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Date : </b>
                                <i class="fa fa-calendar"></i> <?php echo date("M d, Y h:i A", strtotime($tcheckv['attempt_on']));  ?>
                            </div>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Reason Category :</b>
                                <?php echo $tcheckv['category']; ?>
                            </div>
                            <div class="timeline-date">
                                <b style="color:#6a11cb;">Any other reason :</b>
                                <?php echo $tcheckv['reason']; ?>
                            </div>
                            <?php if ($tcheckv['category'] == 'missed testing' || $tcheckv['category'] == 'others') {
                            ?>
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">Corrective Action</b>
                                    <i class="fa fa fa-server"></i> <?php echo $tcheckv['caction'];  ?>
                                </div>
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">RCA:</b>
                                    <a href="micro/upload/<?php echo $tcheckv['rca']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa fa-file-pdf-o"></i>Uploaded Document</a>
                                </div>
                                <div class="timeline-date">
                                    <b style="color:#6a11cb;">Preventive Action :</b>
                                    <i class="fa fa-file-text-o text-danger"> <?php echo $tcheckv['paction']; ?></i>
                                </div>
                            <?php
                            }
                            ?>


                        </div>
                    </div>



                <?php

                }
            }

            if ($tcheckq['status'] == 'Pass') {
                $tcheckp = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid'and status='Pass'");
                $tcheckp1 = mysqli_fetch_array($tcheckp);
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
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Status :</b>
                            <i class="fa fa-file-text-o text-success"> Pass</i>
                        </div>
                    </div>
                </div>
            <?php
            } elseif ($tcheckq['status'] == 'Fail' && $tcheckq['fstatus'] == 'Yes') {
            ?>


                <?php

            } elseif ($tcheckq['status'] == 'Justified') {



                $subsq = mysqli_query($con, "SELECT * FROM `tbl_microtrending1` WHERE eid='$jid' and status='Fail'");
                $sub = mysqli_num_rows($subsq);




                if ($sub > 0) {
                ?>
                    <div class="timeline-end mt-5">

                        <div class="timeline-content" style=" border-left: 4px solid #b7110eff;">
                            <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>&month=<?php echo $month; ?>&sid=<?php echo $sid; ?>" class="btn btn-danger">Re-Attempt</a>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="timeline-end mt-5">

                        <div class="timeline-content" style=" border-left: 4px solid #b7110eff;">
                            <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>&month=<?php echo $month; ?>&sid=<?php echo $sid; ?>" class="btn btn-danger">Attempt Micro</a>
                        </div>
                    </div>
                <?php
                }

                ?>
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
                        <div class="timeline-date">
                            <b style="color:#6a11cb;">Status :</b>
                            <i class="fa fa-file-text-o text-success"> Pass</i>
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>
        </div>
    </div>


    </div>
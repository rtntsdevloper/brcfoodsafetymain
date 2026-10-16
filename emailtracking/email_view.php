<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .detail-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        border-left: 4px solid #0d6efd;
    }

    .detail-section h2 {
        color: #0d6efd;
        font-size: 1.4rem;
        margin-bottom: 15px;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
    }

    .detail-value {
        margin-bottom: 12px;
        padding-left: 15px;
    }

    .priority-high {
        color: #dc3545;
        font-weight: bold;
    }

    .priority-medium {
        color: #fd7e14;
        font-weight: bold;
    }

    .priority-low {
        color: #28a745;
    }

    .attachment-badge {
        background-color: #e9ecef;
        padding: 5px 10px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 17px;
    }

    .detail-label {
        font-size: 20px;
    }








    .follow {

        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;

    }

    .timeline1 {
        position: relative;
        padding-left: 50px;
        /* Space for the line and dots */
        /* No explicit padding-bottom; height determined by content */
    }

    .timeline1::before {
        content: "";
        /* The main vertical line */
      
        position: absolute;
        left: 19px;
        /* Adjusted for better centering with 20px wide dots */
        top: 0;
        width: 2px;
        background: #228B22;
        /* Stops the line at the vertical center of the .timeline-completed-text.
               Approx. height of .timeline-completed-text is 16px (padding) + 25.6px (text) = 41.6px.
               Half of this is ~21px. */
        bottom: 25px;
        z-index: 0;
        /* Line is behind the dots */
    }

    .timeline1-item {
        position: relative;
        margin-bottom: 50px;
        /* Space between timeline items */
    }

    .timeline1-item::before {
        /* Dots for each item */
        content: '';
        position: absolute;
        left: -40px;
        /* (timeline padding-left 50px) - (this value 40px) + (dot radius 10px) = 20px center */
        top: 0px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #228B22;
        border: 3px solid #228B22;
        box-sizing: border-box;
        z-index: 1;
        /* Dots are above the line */
    }

    .timeline1-item:first-child::before {
        background: #228B22;
        /* First dot is filled */
    }

    .timeline1-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #4682B4;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .timeline1-title::before {
        content: "";
        margin-right: 10px;
        color: #228B22;
        font-size: 1.5rem;
    }

    .timeline1-date {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-bottom: 20px;
        margin-left: 25px;
    }

    .timeline1-content {
        background: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin-left: 25px;
    }

    /* Styles for the completed message */
    .timeline1-completed {
        position: relative;
        /* margin-top is handled by the last timeline-item's margin-bottom */
        padding-left: 10px;
        /* Space from the timeline line for the text, aligns with other content */
        /* Add a little space at the very bottom of the timeline if desired */
        margin-bottom: 20px;
    }

    .timeline2-completed {
        position: relative;
        /* margin-top is handled by the last timeline-item's margin-bottom */
        padding-left: 10px;
        /* Space from the timeline line for the text, aligns with other content */
        /* Add a little space at the very bottom of the timeline if desired */
        margin-bottom: 20px;
    }

    .timeline1-completed::before {
        /* Dot for the completed message */
        content: '';
        position: absolute;
        left: -40px;
        /* Aligns with other timeline dots */
        top: 50%;
        /* Vertically centers with the text */
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #228B22;
        /* Solid dot for the end */
        border: 3px solid #228B22;
        /* White border to make it pop, similar to active dots */
        box-sizing: border-box;
        z-index: 1;
        /* Dot is above the line */
    }

    .timeline2-completed::before {
        /* Dot for the completed message */
        content: '';
        position: absolute;
        left: -40px;
        /* Aligns with other timeline dots */
        top: 50%;
        /* Vertically centers with the text */
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ffffff;
        /* Solid dot for the end */
        border: 3px solid #212529;
        /* White border to make it pop, similar to active dots */
        box-sizing: border-box;

        z-index: 1;
        /* Dot is above the line */
    }
</style>

<?php
include("connection.php");
$eid = $_GET['view'];

$sql = "SELECT * FROM `tblemailtrack` WHERE id =$eid";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);


?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h4 mb-0"><i class="bi bi-envelope-check me-2"></i> Client Email Tracking Details</h1>
                        <span class="badge bg-white text-dark align-items-right" style="font-size:14px;float:right;">Ticket
                            #<?php echo $row['tcode']; ?></span>
                            <a href="admin.php?id=email_tracking" class="btn btn-success">Go Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Action buttons at top -->


                    <!-- Basic Information Section -->
                    <div class="detail-section">
                        <h2><i class="bi bi-info-circle me-2"></i> Basic Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-label">Email Date & Time</div>
                                <div class="detail-value"><?php echo date('M d,  Y', strtotime($row['date'])) ?> at
                                    <?php echo date("h:i a", strtotime($row['time'])); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Client Name</div>
                                <div class="detail-value"><?php echo $row['client']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Company</div>
                                <div class="detail-value"><?php echo $row['company']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Email Address</div>
                                <div class="detail-value"><?php echo $row['cemail']; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Details Section -->
                    <div class="detail-section">
                        <h2><i class="bi bi-envelope me-2"></i> Email Details</h2>
                        <div class="row">
                            <div class="col-12">
                                <div class="detail-label">Subject</div>
                                <div class="detail-value"><?php echo $row['subject']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Priority</div>
                                <?php
                                if ($row['priority'] == 'high') {
                                    ?>
                                    <div class="detail-value priority-high">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> High
                                    </div>


                                    <?php

                                } elseif ($row['priority'] == 'medium') {
                                    ?>
                                    <div class="detail-value priority-medium">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Medium
                                    </div>


                                    <?php

                                } elseif ($row['priority'] == 'low') {
                                    ?>
                                    <div class="detail-value priority-low">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Low
                                    </div>


                                    <?php

                                }
                                ?>

                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Main Purpose</div>
                                <div class="detail-value">
                                    <?php
                                    $mp = explode(',', $row['purpose']);

                                    foreach ($mp as $key => $value) {

                                        ?>

                                        <span class="badge bg-light"><?php echo $value; ?></span>

                                        <?php
                                    } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Key Points</div>
                                <div class="detail-value">
                                    <p><?php echo $row['keypont']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Attachment File</div>
                                <div class="detail-value">
                                    <a href="emailtracking/supdoc/<?php echo $row['attachment']; ?>" target="_blank"><i
                                            class="bi bi-file-earmark-text me-1"></i>View Attachment</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Items Section -->
                    <div class="detail-section">
                        <div class="container-fluid">

                            <h2><i class="bi bi-list-check me-2"></i> Action Items</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-label">Response Required</div>
                                    <div class="detail-value"><?php echo $row['response']; ?></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-label">Deadline for Response</div>
                                    <div class="detail-value"><?php 
                                    if(!empty($row['deadline'])){
echo date('M d,  Y', strtotime($row['deadline']));
                                    }
                                    else{
                                        echo 'Not Applicable';
                                    }
                                     ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">Status</div>
                                    <?php
                                    if ($row['status'] == 'Completed') {
                                        ?>
                                        <div class="detail-value">
                                            <span class="badge bg-success text-dark" style="font-size:16px;"><i
                                                    class="bi bi-tags"></i>Task Completed</span>
                                        </div>

                                        <?php
                                    } else {
                                        ?>
                                        <div class="detail-value">
                                            <span class="badge bg-warning text-dark" style="font-size:16px;"><i
                                                    class="bi bi-tags"></i><?php echo $row['status']; ?></span>
                                        </div>

                                        <?php

                                    }

                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Follow-up Details Section -->
                    <div class="detail-section mt-5">





                        <h2 class="mb-5"><i class="bi bi-clock-history me-2"></i> Follow-up History</h2>

                        <div class="timeline1">
                            <?php
                            $fid = $row['id'];
                            $i = 0;
                            $foll = mysqli_query($con, "SELECT * FROM `tblfollowup` WHERE eid = '$fid'");
                            $foln = mysqli_num_rows($foll);
                            if ($foln > 0) {
                                foreach ($foll as $fkey) {
                                    $i++;
                                    ?>



                                    <div class="timeline1-item">
                                        <div class="timeline1-title pl-3">Follow-up <?php echo $i; ?></div>

                                        <div class="timeline1-content">
                                            <div class="row">
                                                <div class="col-md-5 col-sm-6">
                                                    <h3 class=" text-primary">Follow-up <?php echo $fkey['follow']; ?></h3>
                                                </div>
                                                <div class="col-md-2 col-sm-0"></div>
                                                <div class="col-md-5 col-sm-6">
                                                    <h3 class="text-center text-primary">Date :
                                                        <?php echo date('d M, Y', strtotime($fkey['date'])); ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="detail-label">Follow-up Method</div>
                                                    <div class="detail-value">
                                                        <?php echo $fkey['method']; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6">
                                                    <div class="detail-label">Attachment File</div>
                                                    <div class="detail-value">
                                                        <?php
                                                        if (!empty($fkey['attach'])) {

                                                            ?>
                                                            <a href="emailtracking/supdoc/<?php echo $fkey['attach']; ?>"
                                                                target="_blank"><i class="bi bi-file-earmark-text me-1"></i>View
                                                                Attachment</a>

                                                            <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="detail-label">Note</div>
                                                    <div class="detail-value">
                                                        <?php echo $fkey['note']; ?>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($row['status'] == 'Completed') {
                                    ?>

                                    <div class="timeline1-completed">
                                        <h2 class=" ml-3 text-success"><i class="bi bi-check-circle-fill"></i> Email Close-off
                                        </h2>


                                    </div>

                                    <?php
                                } else {
                                    ?>
                                    <div class="timeline2-completed">
                                        <h2 class=" ml-3 text-dark"><i class="bi bi-hourglass-bottom"></i> In Progress</h2>
                                    </div>

                                    <?php

                                }

                                ?>





                            </div>
                            <?php
                            } else {



                                ?>

                            <h3>No Follow-up Yet !</h3>

                            <?php
                            }

                            ?>


                    </div>
               

                <?php
                if ($row['status'] == 'Completed') {

                ?>



                <!-- Completion Section -->
                <div class="detail-section mt-3">
                    <h2><i class="bi bi-check-circle me-2"></i> Completion</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-label">Date Closed</div>
                            <div class="detail-value">
                                <?php
                                if (!empty($row['closedate'])) {
                                    echo date('M d,  Y', strtotime($row['closedate']));

                                }

                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Closed By</div>
                            <div class="detail-value"> <?php
                            echo $row['emailcloseby']

                                ?></div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="detail-label">Additional Notes</div>
                            <div class="detail-value"> <?php
                            echo $row['closenote']

                                ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Attachment File</div>
                            <div class="detail-value">
                                <?php
                                if (!empty($row['closefile'])) {

                                    ?>
                                    <a href="emailtracking/supdoc/<?php echo $row['closefile']; ?>" target="_blank"><i
                                            class="bi bi-file-earmark-text me-1"></i>View
                                        Attachment</a>

                                    <?php
                                } ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                }
                ?>












                <!-- Timeline Section -->
                <div class="detail-section">
                    <h2><i class="bi bi-activity me-2"></i>Activity Log</h2>
                    <div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0 mb-1 ml-2">Email Received</h5>
                                <p class="mb-1 text-muted ml-2">
                                    <?php echo date('M d,  Y', strtotime($row['date'])) ?> at
                                    <?php echo date("h:i a", strtotime($row['time'])); ?>
                                </p>
                                <p class="mb-0 ml-2">Initial complaint received from client</p>
                            </div>
                        </div>
                        <!-- <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mt-0 mb-1  ml-2">First Follow-up</h5>
                                    <p class="mb-1 text-muted ml-2">May 15, 2023 at 11:15 AM</p>
                                    <p class="mb-0 ml-2">Assigned to Jane Smith for immediate action</p>
                                </div>
                            </div> -->
                        <!-- <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mt-0 mb-1">Initial Response</h5>
                                    <p class="mb-1 text-muted">May 15, 2023 at 2:45 PM</p>
                                    <p class="mb-0">Phone call made to client to acknowledge issue and gather
                                        more
                                        details</p>
                                </div>
                            </div> -->

                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-check2"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 pl-2">
                                <h5 class="mt-0 mb-1">Resolution</h5>
                                <p class="mb-1 text-muted">
                                    <?php
                                    if (!empty($row['closedate'])) {
                                        echo date('M d,  Y', strtotime($row['closedate'])) ?>
                                    </p>
                                    <p class="mb-0">Client confirmed resolution and closed the ticket</p>
                                </div><?php
                                    } else {
                                        echo "In Progress";
                                    } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom action buttons -->
            <div class="d-flex justify-content-between mt-4">
                <!-- <button class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </button> -->
                <div>
                    <!-- <button class="btn btn-outline-primary me-2">
                                    <i class="bi bi-share me-1"></i> Share
                                </button> -->
                    <!-- <button class="btn btn-primary">
                                    <i class="bi bi-download me-1"></i> Export as PDF
                                </button> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
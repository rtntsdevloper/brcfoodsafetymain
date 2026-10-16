<?php
$mid = $_GET['mid'];

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    body {
        background: linear-gradient(135deg, #eef2f7 0%, #dfe7f1 100%);
        min-height: 100vh;
    }

    .form-card {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border: none;
        border-radius: 14px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        border-bottom: 1px solid #eaecef !important;
    }

    .conditional-section {
        transition: all 0.25s ease;
    }

    textarea {
        resize: vertical;
    }

    .bi {
        vertical-align: -0.125em;
    }

    /* ===== Attractive Go Back Button (header pill) ===== */
    .btn-go-back {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 0.4rem 1.1rem;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 12px rgba(37, 117, 252, 0.35);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-go-back:hover,
    .btn-go-back:focus {
        background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(106, 17, 203, 0.45);
        text-decoration: none;
    }

    .btn-go-back:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(37, 117, 252, 0.35);
    }

    .btn-go-back i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .btn-go-back:hover i {
        transform: translateX(-4px);
    }

    /* ===== Attractive Submit Button ===== */
    .btn-submit {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 0.6rem 1.8rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        box-shadow: 0 4px 14px rgba(17, 153, 142, 0.4);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-submit:hover,
    .btn-submit:focus {
        background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.55);
        text-decoration: none;
    }

    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(17, 153, 142, 0.4);
    }

    .btn-submit i {
        font-size: 1.15rem;
        transition: transform 0.3s ease;
    }

    .btn-submit:hover i {
        transform: scale(1.15) rotate(-8deg);
    }
</style>


<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card form-card">

                <!-- ===== CARD HEADER WITH GO BACK BUTTON ===== -->
                <div class="card-header pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h3 class="mb-0 text-primary">
                                <i class="bi bi-clipboard-check mr-2"></i>Downtime / Issue Report
                            </h3>
                            <p class="text-muted mt-2 mb-0">Fill in the details below. This is a static form — no data is submitted.</p>
                        </div>
                        <a href="admin.php?id=microtattempt&mid=<?php echo $mid; ?>" class="btn btn-go-back mt-2 mt-sm-0">
                            <i class="bi bi-arrow-left-circle-fill"></i> Go Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- STATIC FORM – no action attribute -->
                    <form id="downtimeForm" method="post">

                        <!-- DATETIME INPUT -->
                        <div class="form-group">
                            <label for="datetimeInput" class="font-weight-bold">
                                <i class="bi bi-calendar-event mr-1"></i>Date & Time <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" name="dtime" id="datetimeInput" required>
                            <small class="form-text text-muted">Select the date and time of the issue.</small>
                        </div>

                        <!-- SELECT OPTION -->
                        <div class="form-group">
                            <label for="reasonSelect" class="font-weight-bold">
                                <i class="bi bi-list-ul mr-1"></i>Reason Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="reasonSelect" name="category" required>
                                <option value="" disabled selected>-- Select a reason --</option>
                                <option value="equipment not in use">Equipment/Machine Not In Use</option>
                                <option value="no production">No Production</option>
                                <option value="missed testing">Missed Testing</option>
                                <option value="others">Others</option>
                            </select>
                            <small class="form-text text-muted">Choose the category that best describes the situation.</small>
                        </div>

                        <!-- TEXTAREA: ANY OTHER REASON -->
                        <div class="form-group">
                            <label for="otherReasonTextarea" class="font-weight-bold">
                                <i class="bi bi-pencil-square mr-1"></i>Any Other Reason / Details
                            </label>
                            <textarea class="form-control" id="otherReasonTextarea" rows="3" name="reason" placeholder="Describe any additional context or reason..."></textarea>
                        </div>

                        <!-- CONDITIONAL SECTION -->
                        <div id="conditionalSection" class="conditional-section" style="display: none;">
                            <hr class="my-4">
                            <h5 class="text-secondary mb-3">
                                <i class="bi bi-tools mr-2"></i>Additional Actions Required
                            </h5>

                            <!-- CORRECTIVE ACTION -->
                            <div class="form-group">
                                <label for="correctiveAction" class="font-weight-bold">
                                    <i class="bi bi-wrench-adjustable mr-1"></i>Corrective Action
                                </label>
                                <textarea class="form-control" id="correctiveAction" rows="2" name="caction" placeholder="Describe the corrective action taken or planned..."></textarea>
                            </div>

                            <!-- RCA -->
                            <div class="form-group">
                                <label for="rcaInput" class="font-weight-bold">
                                    <i class="bi bi-search mr-1"></i>RCA (Root Cause Analysis)
                                </label>
                                <textarea class="form-control" id="rcaInput" rows="2" name="rca" placeholder="Enter root cause analysis findings..."></textarea>
                            </div>

                            <!-- PREVENTIVE ACTION -->
                            <div class="form-group">
                                <label for="preventiveAction" class="font-weight-bold">
                                    <i class="bi bi-shield-check mr-1"></i>Preventive Action
                                </label>
                                <textarea class="form-control" id="preventiveAction" rows="2" name="paction" placeholder="Describe preventive measures to avoid recurrence..."></textarea>
                            </div>
                        </div>

                        <!-- ===== SUBMIT BUTTON ===== -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-submit" name="submit">
                                <i class="bi bi-send-check-fill"></i> Submit Report
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Toggle conditional section
        function toggleConditionalSection() {
            var selectedValue = $('#reasonSelect').val();
            if (selectedValue === 'missed_testing' || selectedValue === 'others') {
                $('#conditionalSection').show();
            } else {
                $('#conditionalSection').hide();
            }
        }

        toggleConditionalSection();

        $('#reasonSelect').on('change', function() {
            toggleConditionalSection();
        });
    });
</script>

<?php
if (isset($_POST['submit'])) {
    $dtime = $_POST['dtime'];

    $category = $_POST['category'];
    $reason = $_POST['reason'];
    $caction = $_POST['caction'];
    $rca = $_POST['rca'];
    $paction = $_POST['paction'];





    $prodx = date('dmYHis') . rand(000, 999);

    $insert = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`, `status`, `category`, `reason`, `caction`, `paction`, `rca`) VALUES ('$mid','$dtime','$user','Justified','$category','$reason','$caction','$paction','$rca')");
    $insertxid = mysqli_insert_id($con);

    if ($insert) {
?>
        <script>
            window.location.href = "admin.php?id=microsign&mid=<?php echo $insertxid; ?>&mid1=<?php echo $mid; ?>";
        </script>

<?php

    }
}



?>
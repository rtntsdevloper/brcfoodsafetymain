<?php
include_once 'connection.php';

$eid = $_GET['eid'];// Assuming connection.php contains $con for DB connection

if (isset($_POST['submit'])) {
    // Retrieve form data safely
    $date = $_POST['firstFollowup'];
    $methods = $_POST['fmethod'];
    $method = implode(',', $methods);
    $note = $_POST['notes'];

    $status = $_POST['status'];
    $st = implode(',', $status);
    // $st = $_POST['$st'];
    $flwup = $_POST['flwup'];

    // Handle file upload
    $signature = "";
    if (isset($_FILES["doc"]) && $_FILES["doc"]["error"] == 0) {
        $customName = uniqid('followup_') . date('dmy') . mt_rand(100, 400);
        $fileExtension = pathinfo($_FILES["doc"]['name'], PATHINFO_EXTENSION);
        $fileName = "{$customName}." . $fileExtension;
        $uploadDir = "emailtracking/supdoc/";
        $imagePath = $uploadDir . $fileName;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["doc"]["tmp_name"], $imagePath)) {
            $signature = $fileName;
        }
    }

    // Prepare and execute insert query
    $q = "INSERT INTO `tblfollowup`(`date`, `eid`, `method`, `attach`, `note`,`follow`) VALUES ('$date','$eid', '$method','$signature', '$note','$flwup')";
    // print_r($q);die;
    $q1 = mysqli_query($con, $q);
    // print_r("UPDATE `tblemailtrack` SET `status`='$st' WHERE id = $eid ");die;
    $upd = mysqli_query($con, "UPDATE `tblemailtrack` SET `status`='$st' WHERE id = $eid ");
    if (isset($q1) && isset($upd)) {

        echo "<script>
      document.location.href ='admin.php?id=email_followup&view=" . $eid . "';
      </script>";

    } else {
        echo "<script>
       alert('Something Went wrong ! try again later')
        </script>";
    }


}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0"><i class="bi bi-envelope-plus me-2"></i>Add Followup</h1>
            </div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <!-- Follow-up Details Section -->
                    <div class="form-section">
                        <h2><i class="bi bi-calendar-check me-2"></i>Follow-up Details</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Follow-up</label>
                                <select class="form-control" id="status" name="flwup" required>
                                    <option value="by Us">Follow-up by Us</option>
                                    <option value="by Client">Follow-up by Client</option>


                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status[]" required multiple>
                                    <option value="AM Informed">AM Informed</option>
                                    <option value="Email Read by">Email Read by</option>
                                    <option value="Email to be followed">Email to be followed</option>
                                    <option value="Info Only">Info Only</option>
                                    <option value="Task Pending">Task Pending</option>
                                </select>

                            </div>

                            <div class="col-md-6 col-sm-12 ">
                                <label for="firstFollowup" class="form-label">Follow-up Date</label>
                                <input type="date" class="form-control" id="firstFollowup" name="firstFollowup"
                                    required>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-3">
                                <label class="form-label">Follow-up Method</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="followupEmail" name="fmethod[]"
                                        value="Email">
                                    <label class="form-check-label" for="followupEmail">Email</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fmethod[]" id="followupPhone"
                                        value="Phone">
                                    <label class="form-check-label" for="followupPhone">Phone</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fmethod[]"
                                        id="followupMeeting" value="Meeting">
                                    <label class="form-check-label" for="followupMeeting">Meeting</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments/References Section -->
                    <div class="form-section mt-3">
                        <h2><i class="fa fa-chain me-2"></i>Attachments/References</h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Attachments Included</label>
                                <input type="file" class="form-control" id="doc" name="doc"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes Section -->
                    <div class="form-section mt-3">
                        <h2><i class="bi bi-pencil me-2"></i>Additional Notes</h2>
                        <div class="mb-3">
                            <textarea class="form-control" id="additionalNotes" rows="4" name="notes"></textarea>
                        </div>
                    </div>

                    <!-- Hidden input for eid if needed -->
                    <input type="hidden" name="eid" value="0">

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
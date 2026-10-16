<?php
if (isset($_POST['submit'])) {

    // Assign form inputs to variables
    $emdate = $_POST['emdate'];
    $emtime = $_POST['emtime'];
    $clientName = $_POST['clientName'];
    $company = $_POST['company'];
    $emailAddress = $_POST['emailAddress'];
    $emailSubject = $_POST['emailSubject'];
    $priority = $_POST['priority'];
    $purposeInqui = $_POST['purposeInquiry'];
    $purposeInquiry = implode(',', $purposeInqui);
    $keyPoints = $_POST['keyPoints'];
    $responseRequired = $_POST['responseRequired'];
    $responseDeadline = $_POST['responseDeadline'] ;
    $status = $_POST['status'];
    $st = implode(',', $status);
    $tc1 = mysqli_query($con,"SELECT * FROM `tblemailtrack`");
    $tc2 = mysqli_num_rows($tc1);
    $trdate = date("dmy");
    

    $trackid = "EMT-".$trdate."00".$tc2;

    // Handle file upload
    if (isset($_FILES["doc"]) && $_FILES["doc"]["error"] == 0) {
        $customName = uniqid('doc_');
        $fileName = "{$customName}." . pathinfo($_FILES["doc"]['name'], PATHINFO_EXTENSION);
        $imagePath = "emailtracking/supdoc/{$fileName}";
        if (!file_exists("emailtracking/supdoc")) {
            mkdir("emailtracking/supdoc", 0777, true);
        }
        if (move_uploaded_file($_FILES["doc"]["tmp_name"], $imagePath)) {
            $signature = $fileName;
        } else {
            $signature = "";
        }
    } else {
        $signature = "";
    }

    // Insert query adjusted to match form fields and database columns
    $q = "INSERT INTO `tblemailtrack`(`date`, `time`, `client`, `company`, `cemail`, `subject`, `priority`, `purpose`, `keypont`, `attachment`, `response`, `deadline`, `status`,tcode) VALUES ('$emdate','$emtime','$clientName','$company','$emailAddress','$emailSubject','$priority','$purposeInquiry','$keyPoints','$signature','$responseRequired','$responseDeadline','$st','$trackid')";

    $q1 = mysqli_query($con, $q);

    if ($q1) {
        echo "<script>
  document.location.href ='admin.php?id=email_tracking';
  </script>";
    }
}

?>

<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow">
           
                <div class="row p-3">
                    <div class="col-md-9"><h1 class="h4 mb-0"><i class="bi bi-envelope-plus me-2"></i>Client Email Tracking Form</h1></div>
                    <div class="col-md-3">   <a href="admin.php?id=email_tracking" class="btn btn-success text-right">Go Back</a></div>
                </div>
                
         
            <div class="card-body">

            
                <form method="post" enctype="multipart/form-data">
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h2><i class="bi bi-info-circle me-2"></i>Basic Information</h2>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="emailDate" class="form-label required-field">Email Date</label>
                                <input type="date" class="form-control" name="emdate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="emailTime" class="form-label required-field">Email Time</label>
                                <input type="time" class="form-control"name="emtime" required>
                            </div>
                            <div class="col-md-6">
                                <label for="clientName" class="form-label required-field">Client Name</label>
                                <input type="text" class="form-control" name="clientName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" name="company">
                            </div>
                            
                            <div class="col-12">
                                <label for="emailAddress" class="form-label required-field">Email Address</label>
                                <input type="email" class="form-control" name ="emailAddress" required>
                            </div>
                        </div>
                    </div>

                    <!-- Email Details Section -->
                    <div class="form-section mt-5">
                        <h2><i class="bi bi-envelope me-2"></i>Email Details</h2>
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <label for="emailSubject" class="form-label required-field">Subject</label>
                                <input type="text" class="form-control" name ="emailSubject" required>
                            </div>
                            <div class="col-md-6 mt-3 mb-3">
                                <label class="form-label required-field">Priority</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" name="priority"
                                        value="high" required>
                                    <label class="form-check-label text-danger fw-bold" for="priorityHigh">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>High 
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" name="priority"
                                        value="medium">
                                    <label class="form-check-label text-warning fw-bold" for="priorityMedium">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Medium 
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="priority" name="priority"
                                        value="low">
                                    <label class="form-check-label text-success" for="priorityLow">
                                        <i class="bi bi-info-circle-fill me-1"></i>Low 
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3 mb-3">
                                <label class="form-label required-field">Main Purpose</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="inquiry" name="purposeInquiry[]">
                                    <label class="form-check-label" for="purposeInquiry">Inquiry</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Complaint" name="purposeInquiry[]">
                                    <label class="form-check-label" for="purposeComplaint">Complaint</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Request" name="purposeInquiry[]">
                                    <label class="form-check-label" for="purposeRequest">Request</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="followup" name="purposeInquiry[]">
                                    <label class="form-check-label" for="purposeFollowup">Follow-up</label>
                                </div>
                                
                            </div>
                            <div class="col-6">
                                <label for="keyPoints" class="form-label">Key Points</label>
                                <textarea class="form-control" name = "keyPoints" rows="3"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="keyPoints" class="form-label">Upload Attachment</label>
                                <input type="file" class="form-control" name="doc" id="" multiple accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>
                    </div>

                    <!-- Action Items Section -->
                    <div class="form-section mt-5">
                        <h2><i class="bi bi-list-check me-2"></i>Action Items</h2>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label required-field">Response Required</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="responseRequired"
                                        id="responseYes" value="yes" required>
                                    <label class="form-check-label" for="responseYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="responseRequired" id="responseNo"
                                        value="no">
                                    <label class="form-check-label" for="responseNo">No</label>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <label for="actionOwner" class="form-label">Action Owner</label>
                                <select class="form-select" id="actionOwner">
                                    <option selected disabled value="">Select owner</option>
                                    <option>John Doe</option>
                                    <option>Jane Smith</option>
                                    <option>Mike Johnson</option>
                                    <option>Sarah Williams</option>
                                </select>
                            </div> -->
                            <div class="col-md-6">
                                <label for="responseDeadline" class="form-label">Deadline for Response</label>
                                <input type="date" class="form-control" name ="responseDeadline">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status[]" multiple>
                                    <option value="AM Informed">AM Informed</option>
                                    <option value="Email Read by">Email Read by</option>
                                    <option value="Email to be followed">Email to be followed</option>
                                    <option value="Info Only">Info Only</option>
                                    <option value="Completed">Task Completed</option>
                                    <option value="Task Pending">Task Pending</option>
                                   
                                </select>
                            </div>
                        </div>
                    </div>

                   

                   

                    <!-- Form Buttons -->
                    
                           
                            <button type="submit" name="submit" class="btn btn-primary mt-5">
                                <i class="bi bi-check-circle me-1"></i> Submit Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

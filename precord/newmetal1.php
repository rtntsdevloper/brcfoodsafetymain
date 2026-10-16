<?php
include 'connection.php';

$headingname = "Metal Detector Check Sheet";
$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Get only the first page data
    $check_date = $_POST['check_date'];
    $line = $_POST['line'];
    $air_pressure_check = $_POST['air_pressure_check'];
    $reject_arm_check = $_POST['reject_arm_check'];
    $belt_stop_check = $_POST['belt_stop_check'];
    $operator_sign = $_POST['operator_sign'];
    $comments = $_POST['comments'];
    $verified_by = $_POST['verified_by'];
    
    // Insert only first page data
    $sql = "INSERT INTO tblmetal_detector_checks (check_date, line, air_pressure_check, reject_arm_check, belt_stop_check, operator_sign, comments, verified_by, status) 
            VALUES ('$check_date', '$line', '$air_pressure_check', '$reject_arm_check', '$belt_stop_check', '$operator_sign', '$comments', '$verified_by', 'pending')";
    
    if (mysqli_query($con, $sql)) {
        $last_id = mysqli_insert_id($con);
        $message = "Record saved successfully! Now add test records.";
        echo "<script>window.location.href='admin.php?id=newmetal'</script>";
        // echo "<meta http-equiv='refresh' content='2;url=add_tests.php?id=$last_id'>";
    } else {
        $error = "Error: " . mysqli_error($con);
    }
}
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Quality Control</a></li>
            <li>Metal Detector Check</li>
        </ul>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=newmetal" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>
                <div class="card-title">Metal Detector Check Sheet</div>
                
                <?php if($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form class="needs-validation" novalidate method="post">
                    <!-- Section 1: Basic Information -->
                    <fieldset style="border: 2px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fafafa;">
                        <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #007bff; background: white; border-radius: 20px; border: 1px solid #007bff;">📅 Basic Information</legend>
                        
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="check_date">Date</label>
                                <input class="form-control" type="date" required name="check_date" value="<?php echo date('Y-m-d'); ?>"/>
                                <div class="invalid-tooltip">Please provide a valid date.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label>Line (circle as appropriate)</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="line" value="A" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> Line A
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="line" value="B" style="width: auto; margin-right: 5px; transform: scale(1.2);"> Line B
                                    </label>
                                </div>
                                <div class="invalid-tooltip">Please select a line.</div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <!-- Section 2: Pre-start up Checks -->
                    <fieldset style="border: 2px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fafafa;">
                        <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #007bff; background: white; border-radius: 20px; border: 1px solid #007bff;">🔧 Pre-start up Checks</legend>
                        
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>1. Does the metal detector stop and alarm when air pressure is reduced?</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="air_pressure_check" value="YES" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> YES
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="air_pressure_check" value="NO" style="width: auto; margin-right: 5px; transform: scale(1.2);"> NO
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>2. Does the reject arm fail-safe work correctly?</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="reject_arm_check" value="YES" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> YES
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="reject_arm_check" value="NO" style="width: auto; margin-right: 5px; transform: scale(1.2);"> NO
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>3. Is the belt stop system working correctly?</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="belt_stop_check" value="YES" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> YES
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="belt_stop_check" value="NO" style="width: auto; margin-right: 5px; transform: scale(1.2);"> NO
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="operator_sign">Operator Sign</label>
                                <input class="form-control" type="text" name="operator_sign" placeholder="Operator name/signature">
                            </div>
                        </div>
                    </fieldset>
                    
                    <!-- Section 3: Comments & Verification -->
                    <fieldset style="border: 2px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fafafa;">
                        <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #007bff; background: white; border-radius: 20px; border: 1px solid #007bff;">📝 Comments & Verification</legend>
                        
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" name="comments" rows="3" placeholder="Enter any comments..."></textarea>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="verified_by">Verified by Technical</label>
                                <input class="form-control" type="text" name="verified_by" placeholder="Technical person name">
                            </div>
                        </div>
                    </fieldset>
                   
                    
                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" type="submit" name="submit" style="background: #007bff; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer;">💾 Save & Continue →</button>
                            <button class="btn btn-secondary btn-lg" type="reset" style="background: #6c757d; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">🔄 Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
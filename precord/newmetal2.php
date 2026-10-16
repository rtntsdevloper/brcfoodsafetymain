<?php 
include 'connection.php';
$headingname = "Metal Detector Check Sheet";
$message = "";
$error = "";
$tid = isset($_GET['tid']) ? $_GET['tid'] : 0;

// Insert new test record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $check_id = $tid;
    $test_time = $_POST['test_time'];
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_size = $_POST['product_size'];
    $reject_action = $_POST['reject_action'];
    $test_stick = $_POST['test_stick'];
    $fe_result = $_POST['fe_result'];
    $non_fe_result = $_POST['non_fe_result'];
    $ss_result = $_POST['ss_result'];
    $initial = $_POST['initial'];
    $comments = $_POST['comments'];
    $verified_by = $_POST['verified_by'];
    
    // Insert new test record
    $sql = "INSERT INTO tblmetal_detector_tests (
                check_id, test_time, product_code, product_name, product_size, 
                reject_action, test_stick, fe_result, non_fe_result, ss_result, 
                initial, comments, verified_by
            ) VALUES (
                '$check_id', '$test_time', '$product_code', '$product_name', '$product_size',
                '$reject_action', '$test_stick', '$fe_result', '$non_fe_result', '$ss_result',
                '$initial', '$comments', '$verified_by'
            )";
    
    if (mysqli_query($con, $sql)) {
        $last_id = mysqli_insert_id($con);
        $message = "Test record saved successfully!";
        // Clear form after successful submission
    echo"
<script>
  window.location.href = 'admin.php?id=newmetal';
</script>";
    } else {
        $error = "Error: " . mysqli_error($con);
    }
}

// Fetch existing test records for this check_id
$existing_records = [];
if($tid > 0) {
    $query = mysqli_query($con, "SELECT * FROM tblmetal_detector_tests WHERE check_id = $tid ORDER BY test_time DESC");
    while($row = mysqli_fetch_assoc($query)) {
        $existing_records[] = $row;
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Quality Control</a></li>
            <li>Metal Detector Test Records</li>
        </ul>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=newmetal" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>
                <div class="card-title">Add Metal Detector Test Record</div>
                
                <?php if($message): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <!-- Test Records Table on TOP -->
                <fieldset style="border: 2px solid #28a745; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #f8fff8;">
                    <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #28a745; background: white; border-radius: 20px; border: 1px solid #28a745;">📋 Existing Test Records</legend>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr style="background: #28a745; color: white;">
                                    <th>#</th>
                                    <th>Test Time</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Size</th>
                                    <th>R/S</th>
                                    <th>Test Stick</th>
                                    <th>Fe</th>
                                    <th>Non-Fe</th>
                                    <th>S/S</th>
                                    <th>Initial</th>
                                    <th>Verified By</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if(count($existing_records) > 0): ?>
                                    <?php $i = 1; foreach($existing_records as $record): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $record['test_time']; ?></td>
                                        <td><?php echo $record['product_code']; ?></td>
                                        <td><?php echo $record['product_name']; ?></td>
                                        <td><?php echo $record['product_size']; ?></td>
                                        <td>
                                            <span style="background: <?php echo $record['reject_action'] == 'R' ? '#dc3545' : '#ffc107'; ?>; color: white; padding: 2px 8px; border-radius: 3px;">
                                                <?php echo $record['reject_action']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $record['test_stick']; ?></td>
                                        <td>
                                            <span style="color: <?php echo $record['fe_result'] == 'Pass' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $record['fe_result']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="color: <?php echo $record['non_fe_result'] == 'Pass' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $record['non_fe_result']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="color: <?php echo $record['ss_result'] == 'Pass' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $record['ss_result']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $record['initial']; ?></td>
                                        <td><?php echo $record['verified_by']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" style="text-align: center;">No test records found for this check</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                
                <form class="needs-validation" novalidate method="post">
                    
                    <!-- Hidden field for check_id -->
                    <input type="hidden" name="check_id" value="<?php echo $tid; ?>">
                    
                    <!-- Section: Test Details -->
                    <fieldset style="border: 2px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fafafa;">
                        <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #007bff; background: white; border-radius: 20px; border: 1px solid #007bff;">➕ Add New Test Record</legend>
                        
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>Test Time</label>
                                <input class="form-control" type="time" name="test_time" step="1" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>Product Code</label>
                                <input class="form-control" type="text" name="product_code" placeholder="Enter product code">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>Product Name</label>
                                <input class="form-control" type="text" name="product_name" placeholder="Enter product name">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>Product Size</label>
                                <input class="form-control" type="text" name="product_size" placeholder="Enter product size">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>Test Stick Set Used</label>
                                <input class="form-control" type="text" name="test_stick" placeholder="Test stick used">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>Initial</label>
                                <input class="form-control" type="text" name="initial" placeholder="Initials">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label>R: (Reject) or S: (Line Stop)</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="reject_action" value="R" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> R (Reject)
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="reject_action" value="S" style="width: auto; margin-right: 5px; transform: scale(1.2);"> S (Line Stop)
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>Fe (Pass/Fail)</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="fe_result" value="Pass" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> Pass
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="fe_result" value="Fail" style="width: auto; margin-right: 5px; transform: scale(1.2);"> Fail
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>Non-Fe (Pass/Fail)</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="non_fe_result" value="Pass" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> Pass
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="non_fe_result" value="Fail" style="width: auto; margin-right: 5px; transform: scale(1.2);"> Fail
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label>S/S (Pass/Fail)</label>
                                <div style="background: #f8f9fa; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <label style="margin-right: 20px; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="ss_result" value="Pass" required style="width: auto; margin-right: 5px; transform: scale(1.2);"> Pass
                                    </label>
                                    <label style="cursor: pointer; display: inline-block;">
                                        <input type="radio" name="ss_result" value="Fail" style="width: auto; margin-right: 5px; transform: scale(1.2);"> Fail
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <!-- Section: Comments & Verification -->
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
                    
                    <!-- Test Piece Size Reference -->
                    <fieldset style="border: 2px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 20px; background: #fafafa;">
                        <legend style="width: auto; padding: 0 15px; font-size: 14px; font-weight: bold; color: #007bff; background: white; border-radius: 20px; border: 1px solid #007bff;">📏 Test Piece Size Reference</legend>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="margin-bottom: 0;">
                                <thead>
                                    <tr style="background: #6c757d; color: white;">
                                        <th>Product Type</th>
                                        <th>Ferrous (mm)</th>
                                        <th>Non-ferrous (mm)</th>
                                        <th>Stainless steel (mm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2L, 2.5L, 4L, 5L, 500ml, 125ml</td>
                                        <td>2.5</td>
                                        <td>3.0</td>
                                        <td>4.77</td>
                                    </tr>
                                    <tr>
                                        <td>5L Bottles</td>
                                        <td>2.5</td>
                                        <td>3.0</td>
                                        <td>4.77</td>
                                    </tr>
                                    <tr>
                                        <td>10L</td>
                                        <td>3.5</td>
                                        <td>4.0</td>
                                        <td>4.77</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    
                    <!-- Procedure and Corrective Action Note -->
                    <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px;">
                        <strong>📋 Procedure:</strong> Refer to Metal Detection Procedure OP47 and CCP signage OP48<br><br>
                        <strong>⚠️ Corrective Action - failure of metal detector:</strong><br>
                        • Stop production & inform the Production Manager & Technical Manager<br>
                        • Quarantine all product produced since last satisfactory check.
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" type="submit" name="submit" style="background: #007bff; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer;">💾 Save Test Record</button>
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
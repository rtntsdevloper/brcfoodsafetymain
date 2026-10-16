<?php
$sno = $_GET['sno'];
$rid = $_GET['rid'];

$sql = mysqli_query($con, "select * from tblequipment1 where id='$sno'");
$row = mysqli_fetch_array($sql);

$sql2 = mysqli_query($con, "select * from tblequipment where id='$row[eid]'");
$row2 = mysqli_fetch_array($sql2);

// Define disabled/readonly states - ALL fields become readonly/disabled when status is 'Done'
$isDisabled = ($row['status1'] == 'Done') ? 'disabled' : '';
$isReadonly = ($row['status1'] == 'Done') ? 'readonly' : '';
$isRequired = ($row['status1'] == 'Done') ? '' : 'required';

// File upload fields - ONLY disabled when status is Done AND file exists
$serviceimgDisabled = (($row['status1'] == 'Done') && !empty($row['serviceimg'])) ? 'disabled' : '';
$supdocDisabled = (($row['status1'] == 'Done') && !empty($row['supdoc'])) ? 'disabled' : '';

// Check if both files exist
$bothFilesExist = (!empty($row['serviceimg']) && !empty($row['supdoc']));
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo ($headingname); ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Equipment Maintenance Request</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=ppm">
                        <button class="btn btn-success mb-2" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <?php if ($row['mverify'] == 'done') { ?>
                        <a href="admin.php?id=raisereport&sno=<?php echo $sno; ?>&rid=<?php echo $rid; ?>">
                            <button class="btn btn-info mb-2" style="float:right; margin-left:15px">View Report</button>
                        </a><?php } else { ?>
                        <a href="admin.php?id=raisereport&sno=<?php echo $sno; ?>&rid=<?php echo $rid; ?>">
                            <button class="btn btn-warning mb-2" style="float:right; margin-left:15px">View Report</button>
                        </a>
                    <?php } ?>
                    <h4 class="card-title mb-3">Equipment Maintenance Request</h4>

                    <?php

                    $sql = mysqli_query($con, "SELECT * FROM `ppmraise` where eqpname='$row[eid]' and id='$rid' ");
                    $row2 = mysqli_fetch_array($sql);

                    $eqpname_escaped = $row2['eqpname'];

                    $sql1 = mysqli_query($con, "SELECT * FROM `tblequipment` WHERE id='$eqpname_escaped'");
                    $row1 = mysqli_fetch_array($sql1);
                    $equipmentname = $row1['name'];
                    ?>

                    <!-- Request Details -->
                    <table class="display table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th>Request Number</th>
                                <td><?php echo ($row2['request']); ?></td>
                            </tr>
                            <tr>
                                <th>Date Raised</th>
                                <td><?php echo date("d-m-Y", strtotime($row2['date'])); ?></td>
                            </tr>
                            <tr>
                                <th>Raised By</th>
                                <td><?php echo ($row2['raisedby']); ?></td>
                            </tr>
                            <tr>
                                <th>Production Area</th>
                                <td><?php echo ($row2['area']); ?></td>
                            </tr>
                            <tr>
                                <th>Equipment Name</th>
                                <td><?php echo ($equipmentname); ?></td>
                            </tr>
                            <tr>
                                <th>Equipment ID</th>
                                <td><?php echo ($row2['equipmentcode']); ?></td>
                            </tr>
                            <tr>
                                <th>Equipment Location</th>
                                <td><?php echo ($row2['location']); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="card-body">
                            <h3 align="center" style="color:#FF0000"> Maintenance Completion </h3>
                            <form enctype="multipart/form-data" method="post" name="form1" id="maintenanceForm">
                                <input type="hidden" name="eid" value="<?php echo $row['eid']; ?>" />
                                <input type="hidden" name="sno" value="<?php echo intval($sno); ?>" />
                                <input type="hidden" name="rid" value="<?php echo intval($rid); ?>" />

                                <?php
                                $string2 = $row['checks'];
                                $tags2 = explode(';', $string2);
                                ?>

                                <!-- Safety Check 1 -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label>1&deg; Safety Check:(Maintenance work carried out and complete)</label><br>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety1" value="Yes"
                                                <?php echo (isset($tags2[0]) && $tags2[0] == 'Yes') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety1" value="No"
                                                <?php echo (isset($tags2[0]) && $tags2[0] == 'No') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Safety Check 2 -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>2&deg; Safety Check: (Any residual debris from maintenance work removed and cleared)</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety2" value="Yes"
                                                <?php echo (isset($tags2[1]) && $tags2[1] == 'Yes') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety2" value="No"
                                                <?php echo (isset($tags2[1]) && $tags2[1] == 'No') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">No</label>
                                        </div>
                                        <?php if ($row['status1'] != 'Done'): ?>
                                            <div class="safety2-comment" style="display: <?php echo (isset($tags2[1]) && $tags2[1] == 'No') ? 'block' : 'none'; ?>; margin-top: 10px;">
                                                <label>Comments </label>
                                                <input type="text" class="form-control" name="safety2_reason" value="<?php echo $row['safety2_reason']; ?>" <?php echo (isset($tags2[1]) && $tags2[1] == 'No') ? 'required' : ''; ?>>
                                            </div>
                                        <?php else: ?>
                                            <?php if (!empty($row['safety2_reason'])): ?>
                                                <div style="margin-top: 10px;">
                                                    <label>Comments</label>
                                                    <div class="form-control" style="background: #f5f5f5;"><?php echo $row['safety2_reason']; ?></div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Safety Check 3 -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label>3&deg; Safety Check: (Are tools and equipment used maintenance wiped cleaned and sanitized)</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety3" value="Yes"
                                                <?php echo (isset($tags2[2]) && $tags2[2] == 'Yes') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety3" value="No"
                                                <?php echo (isset($tags2[2]) && $tags2[2] == 'No') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Safety Check 4 -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label>4&deg; Safety Check: (Equipment in good working order and ready for food safe operation)</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety4" value="Yes"
                                                <?php echo (isset($tags2[3]) && $tags2[3] == 'Yes') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="safety4" value="No"
                                                <?php echo (isset($tags2[3]) && $tags2[3] == 'No') ? 'checked' : ''; ?>
                                                <?php echo $isDisabled; ?>>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- PPM Job Description -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-6">
                                        <label>Corrective Action</label>
                                        <textarea class="form-control" name="description" <?php echo $isReadonly; ?> required="required"><?php echo $row['description']; ?></textarea>
                                    </div>
                                </div>

                                <!-- Date Performed -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label>Date Performed</label>
                                        <input type="date" class="form-control" name="dateperformed" required
                                            value="<?php echo $row['dateperformed']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Parts Replaced -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label>Any Parts Replaced</label>
                                        <input type="text" class="form-control" name="preplace" required
                                            value="<?php echo $row['preplace']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Root Cause -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label>Root Cause</label>
                                        <input type="text" class="form-control" name="root" required
                                            value="<?php echo $row['root']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Downtime Duration -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label>Downtime Duration</label>
                                        <input type="text" class="form-control" name="downtime" required
                                            value="<?php echo $row['duration']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Service Report -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label for="serviceimg">Service Report (PDF, JPG, PNG)</label>
                                        <input type="file" class="form-control" name="serviceimg" id="serviceimg" accept=".pdf,.jpg,.jpeg,.png" <?php echo $serviceimgDisabled; ?>>
                                        <?php if (!empty($row['serviceimg'])): ?>
                                            <div style="margin-top:10px;">
                                                <a href="upl1/<?php echo htmlspecialchars($row['serviceimg']); ?>" target="_blank" class="btn btn-info btn-sm">View Document</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Supporting Documents -->
                                <div class="form-row mt-2">
                                    <div class="col-md-6 mb-6">
                                        <label for="supdoc">Supporting Documents (PDF, JPG, PNG)</label>
                                        <input type="file" class="form-control" name="supdoc" id="supdoc" accept=".pdf,.jpg,.jpeg,.png" <?php echo $supdocDisabled; ?>>
                                        <?php if (!empty($row['supdoc'])): ?>
                                            <div style="margin-top:10px;">
                                                <a href="upl1/<?php echo htmlspecialchars($row['supdoc']); ?>" target="_blank" class="btn btn-info btn-sm">View Document</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Engineer Name -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>Engineer Name</label>
                                        <input class="form-control" type="text" required="required"
                                            name="ename" value="<?php echo $row['ename']; ?>" <?php echo $isReadonly; ?> />
                                    </div>
                                </div>

                                <!-- Production Stop -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>Due Production needs be stopped for this Maintenance ?</label>
                                        <div>
                                            <input type="radio" name="production" value="Yes" <?php echo (($row['production']) == 'Yes') ? 'checked' : ''; ?> onchange="showHoursField(this.value)" <?php echo $isDisabled; ?>>
                                            <label> Yes</label>
                                            <input type="radio" name="production" value="No" <?php echo (($row['production']) == 'No') ? 'checked' : ''; ?> onchange="showHoursField(this.value)" <?php echo $isDisabled; ?>>
                                            <label> No</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hours Field -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3" id="hoursField" style="display: <?php echo (($row['production']) == 'Yes') ? 'block' : 'none'; ?>;">
                                        <label for="hours">How many hours production cannot be carried out ?</label>
                                        <input type="number" class="form-control" id="hours" name="hours" min="1" placeholder="Enter hours" value="<?php echo $row['hours']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Engineer Type -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>Is the engineer internal or external?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="engineer_type" id="engineerInternal" value="Internal" <?php echo (($row['engineer_type']) == 'Internal') ? 'checked' : ''; ?> <?php echo $isDisabled; ?>>
                                            <label class="form-check-label" for="engineerInternal">Internal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="engineer_type" id="engineerExternal" value="External" <?php echo (($row['engineer_type']) == 'External') ? 'checked' : ''; ?> <?php echo $isDisabled; ?>>
                                            <label class="form-check-label" for="engineerExternal">External</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Visit Question -->
                                <div class="form-row" id="visitQuestion" style="display:<?php echo (($row['engineer_type']) == 'External') ? 'block' : 'none'; ?>;">
                                    <div class="col-md-4 mb-3">
                                        <label>The person has completed visit before enter Production ?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="visit_completed" id="visitYes" value="Yes" <?php echo (($row['visit_completed']) == 'Yes') ? 'checked' : ''; ?> <?php echo $isDisabled; ?>>
                                            <label class="form-check-label" for="visitYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="visit_completed" id="visitNo" value="No" <?php echo (($row['visit_completed']) == 'No') ? 'checked' : ''; ?> <?php echo $isDisabled; ?>>
                                            <label class="form-check-label" for="visitNo">No</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Corrective Action -->
                                <div class="form-row" id="correctiveAction" style="display:<?php echo (($row['visit_completed']) == 'No') ? 'block' : 'none'; ?>;">
                                    <div class="col-md-4 mb-3">
                                        <label for="corrective_reason">Corrective Action</label>
                                        <input type="text" class="form-control" name="corrective_reason" id="corrective_reason" value="<?php echo $row['corrective_reason']; ?>" <?php echo $isReadonly; ?>>
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="sdate">Maintenance Start Time</label>
                                        <input class="form-control" id="sdate" type="datetime-local" <?php echo $isRequired; ?> name="sdate" value="<?php echo $row['stime']; ?>" <?php echo $isReadonly; ?> />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edate">Maintenance End Time</label>
                                        <input class="form-control" id="edate" type="datetime-local" <?php echo $isRequired; ?> name="edate" value="<?php echo $row['etime']; ?>" <?php echo $isReadonly; ?> />
                                    </div>
                                </div>

                                <!-- Task completed by -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>Task completed by:</label>
                                        <input class="form-control" type="text" required="required"
                                            name="doneby" value="<?php echo $row['completedby']; ?>" <?php echo $isReadonly; ?> />
                                        <?php if (!empty($row['completesign'])): ?>
                                            <img src="signature/<?php echo $row['completesign']; ?>.png" width="200" />
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Submit buttons -->
                                <div class="col-md-12 text-center">
                                    <?php
                                    if ($row['status1'] != 'Done') {
                                        echo '<button class="btn btn-primary" type="submit" name="submit">Submit</button>';
                                    } elseif ($row['status1'] == 'Done' && !$bothFilesExist) {
                                        echo '<button class="btn btn-warning" type="submit" name="update_files">Update Files</button>';
                                    }
                                    ?>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to show/hide comment field for Safety Check 2
    document.addEventListener('DOMContentLoaded', function() {
        function toggleComment() {
            const radios = document.getElementsByName('safety2');
            const commentDiv = document.querySelector('.safety2-comment');

            if (!commentDiv) return;

            function updateCommentVisibility() {
                let isNoSelected = false;
                radios.forEach(radio => {
                    if (radio.value === 'No' && radio.checked) {
                        isNoSelected = true;
                    }
                });

                const commentTextarea = commentDiv.querySelector('input[type="text"]');
                if (isNoSelected) {
                    commentDiv.style.display = 'block';
                    if (commentTextarea) commentTextarea.required = true;
                } else {
                    commentDiv.style.display = 'none';
                    if (commentTextarea) {
                        commentTextarea.required = false;
                    }
                }
            }

            radios.forEach(radio => {
                radio.addEventListener('change', updateCommentVisibility);
            });

            updateCommentVisibility();
        }

        toggleComment();
    });

    // Functions for dynamic visibility
    function showHoursField(value) {
        var hoursField = document.getElementById('hoursField');
        if (value === 'Yes') {
            hoursField.style.display = 'block';
        } else {
            hoursField.style.display = 'none';
        }
    }

    // Engineer type toggle
    document.addEventListener('DOMContentLoaded', function() {
        var engineerRadios = document.getElementsByName('engineer_type');
        var visitQuestion = document.getElementById('visitQuestion');
        
        function toggleVisitQuestion() {
            var selectedValue = null;
            for (var i = 0; i < engineerRadios.length; i++) {
                if (engineerRadios[i].checked) {
                    selectedValue = engineerRadios[i].value;
                    break;
                }
            }
            if (selectedValue === 'External') {
                visitQuestion.style.display = 'block';
            } else {
                visitQuestion.style.display = 'none';
                // Also hide corrective action if engineer is internal
                document.getElementById('correctiveAction').style.display = 'none';
            }
        }
        
        for (var i = 0; i < engineerRadios.length; i++) {
            engineerRadios[i].addEventListener('change', toggleVisitQuestion);
        }
        
        // Visit completed toggle for corrective action
        var visitRadios = document.getElementsByName('visit_completed');
        var correctiveAction = document.getElementById('correctiveAction');
        
        function toggleCorrectiveAction() {
            var selectedValue = null;
            for (var i = 0; i < visitRadios.length; i++) {
                if (visitRadios[i].checked) {
                    selectedValue = visitRadios[i].value;
                    break;
                }
            }
            if (selectedValue === 'No') {
                correctiveAction.style.display = 'block';
            } else {
                correctiveAction.style.display = 'none';
            }
        }
        
        for (var i = 0; i < visitRadios.length; i++) {
            visitRadios[i].addEventListener('change', toggleCorrectiveAction);
        }
    });
</script>

<?php
if (isset($_POST['submit'])) {
    // Sanitize all POST data
    $doneby = mysqli_real_escape_string($con, $_POST['doneby']);
    $ename = mysqli_real_escape_string($con, $_POST['ename']);
    $safety1 = mysqli_real_escape_string($con, $_POST['safety1']);
    $safety2 = mysqli_real_escape_string($con, $_POST['safety2']);
    $safety3 = mysqli_real_escape_string($con, $_POST['safety3']);
    $safety4 = mysqli_real_escape_string($con, $_POST['safety4']);
    $sno = intval($_POST['sno']);
    $eid = intval($_POST['eid']);
    $preplace = mysqli_real_escape_string($con, $_POST['preplace']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $dateperformed = mysqli_real_escape_string($con, $_POST['dateperformed']);
    $root = mysqli_real_escape_string($con, $_POST['root']);
    $downtime = mysqli_real_escape_string($con, $_POST['downtime']);
    
    // New fields
    $production = isset($_POST['production']) ? mysqli_real_escape_string($con, $_POST['production']) : '';
    $hours = isset($_POST['hours']) ? mysqli_real_escape_string($con, $_POST['hours']) : '';
    $engineer_type = isset($_POST['engineer_type']) ? mysqli_real_escape_string($con, $_POST['engineer_type']) : '';
    $visit_completed = isset($_POST['visit_completed']) ? mysqli_real_escape_string($con, $_POST['visit_completed']) : '';
    $corrective_reason = isset($_POST['corrective_reason']) ? mysqli_real_escape_string($con, $_POST['corrective_reason']) : '';
    $sdate = isset($_POST['sdate']) ? mysqli_real_escape_string($con, $_POST['sdate']) : '';
    $edate = isset($_POST['edate']) ? mysqli_real_escape_string($con, $_POST['edate']) : '';

    // Comment for Safety Check 2
    $safety2_reason = isset($_POST['safety2_reason']) ? mysqli_real_escape_string($con, $_POST['safety2_reason']) : '';

    $upl1 = "upl1/";

    // Handle Service Image Upload - ONLY IF FILE IS UPLOADED
    $serviceimg = $row['serviceimg'];
    if (!empty($_FILES['serviceimg']['name']) && $_FILES['serviceimg']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['serviceimg']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
            $uniqueName = uniqid("service_", true) . "." . $ext;
            if (move_uploaded_file($_FILES['serviceimg']['tmp_name'], $upl1 . $uniqueName)) {
                if (!empty($row['serviceimg']) && file_exists($upl1 . $row['serviceimg'])) {
                    unlink($upl1 . $row['serviceimg']);
                }
                $serviceimg = $uniqueName;
            }
        }
    }

    // Handle Supporting Document Upload - ONLY IF FILE IS UPLOADED
    $supdoc = $row['supdoc'];
    if (!empty($_FILES['supdoc']['name']) && $_FILES['supdoc']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['supdoc']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
            $uniqueName = uniqid("supdoc_", true) . "." . $ext;
            if (move_uploaded_file($_FILES['supdoc']['tmp_name'], $upl1 . $uniqueName)) {
                if (!empty($row['supdoc']) && file_exists($upl1 . $row['supdoc'])) {
                    unlink($upl1 . $row['supdoc']);
                }
                $supdoc = $uniqueName;
            }
        }
    }

    $safety = implode(";", [$safety1, $safety2, $safety3, $safety4]) . ";";

    // Update query with all new fields
    $sql = "UPDATE tblequipment1 SET 
            checks='$safety', 
            ename='$ename', 
            completedby='$doneby', 
            status1='Done', 
            description='$description', 
            preplace='$preplace', 
            serviceimg='$serviceimg', 
            supdoc='$supdoc', 
            dateperformed='$dateperformed',
            root='$root',
            duration='$downtime',
            safety2_reason='$safety2_reason',
            production='$production',
            hours='$hours',
            engineer_type='$engineer_type',
            visit_completed='$visit_completed',
            corrective_reason='$corrective_reason',
            stime='$sdate',
            etime='$edate'
            WHERE id='$sno'";
    $sq = mysqli_query($con, $sql);

    if ($sq) {
        ?>
        <script>
            window.open('admin.php?id=raisesign&sno=<?php echo $sno; ?>&rid=<?php echo $rid; ?>', '_self');
        </script>
        <?php
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Process Update Files
if (isset($_POST['update_files'])) {
    $sno = mysqli_real_escape_string($con, $_POST['sno']);
    $rid = mysqli_real_escape_string($con, $_POST['rid']);
    $upl1 = "upl1/";

    $currentSql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
    $currentRow = mysqli_fetch_array($currentSql);

    $serviceimg = $currentRow['serviceimg'];
    $supdoc = $currentRow['supdoc'];

    // Handle serviceimg upload
    if (!empty($_FILES['serviceimg']['name']) && $_FILES['serviceimg']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['serviceimg']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $uniqueName = uniqid("service_", true) . "." . $ext;
            if (move_uploaded_file($_FILES['serviceimg']['tmp_name'], $upl1 . $uniqueName)) {
                if (!empty($currentRow['serviceimg']) && file_exists($upl1 . $currentRow['serviceimg'])) {
                    unlink($upl1 . $currentRow['serviceimg']);
                }
                $serviceimg = $uniqueName;
            }
        }
    }

    // Handle supdoc upload
    if (!empty($_FILES['supdoc']['name']) && $_FILES['supdoc']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['supdoc']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $uniqueName = uniqid("supdoc_", true) . "." . $ext;
            if (move_uploaded_file($_FILES['supdoc']['tmp_name'], $upl1 . $uniqueName)) {
                if (!empty($currentRow['supdoc']) && file_exists($upl1 . $currentRow['supdoc'])) {
                    unlink($upl1 . $currentRow['supdoc']);
                }
                $supdoc = $uniqueName;
            }
        }
    }

    $update = mysqli_query($con, "UPDATE tblequipment1 SET serviceimg='$serviceimg', supdoc='$supdoc' WHERE id='$sno'");
    
    if ($update) {
        echo '<script>window.open("admin.php?id=ppm", "_self");</script>';
    } else {
        echo "Error updating files: " . mysqli_error($con);
    }
}
?>
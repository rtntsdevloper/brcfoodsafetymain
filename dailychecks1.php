<?php
include 'connection.php';
date_default_timezone_set('Europe/London');

$tid = $_GET['tid'];
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';

$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);

// Get machine status - check if already exists for today
$machineStatus = '';
$machineReason = '';
$ename = '';
$edate = '';
$existingId = '';

$sq3 = mysqli_query($con, "select * from dailycheckss where name='$tid' and date='" . date('Y-m-d') . "' order by id desc limit 1");
$qu3 = mysqli_fetch_array($sq3);
if($qu3) {
    $ename = $qu3['ename'];
    $edate = $qu3['date'];
    $machineStatus = $qu3['machineused'];
    $machineReason =$qu3['reason'];
    $existingId = $qu3['id'];
}

// ===== HANDLE NO SUBMISSION =====
if(isset($_POST['submit_no'])) {
    $tid = $_POST['tid'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $user = $_SESSION['user'];
    $machineused = 'No';
    $reason = $_POST['reason_no'];
    
    // CHECK if already exists
    $check = mysqli_query($con, "select id from dailycheckss where name='$tid' and date='$date'");
    if(mysqli_num_rows($check) == 0) {
        // Insert only if not exists
        $insert = mysqli_query($con, "INSERT INTO dailycheckss (name, date, user, ename, machineused, reason) 
                                      VALUES ('$tid', '$date', '$user', '$name', '$machineused', '$reason')");
    } else {
        // Update existing
        $insert = mysqli_query($con, "UPDATE dailycheckss SET machineused='$machineused', reason='$reason', user='$user' 
                                      WHERE name='$tid' AND date='$date'");
    }
    
    if($insert) {
        header("Location: admin.php?id=dailychecks&tid=$tid");
        exit();
    }
}

// ===== HANDLE YES SUBMISSION =====
if(isset($_POST['submit'])) {
    $tid = $_POST['tid'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $user = $_SESSION['user'];
    $machineused = 'Yes';
    
    // CHECK if already exists
    $check = mysqli_query($con, "select id from dailycheckss where name='$tid' and date='$date'");
    if(mysqli_num_rows($check) == 0) {
        // Insert only if not exists
        $insert = mysqli_query($con, "INSERT INTO dailycheckss (name, date, user, ename, machineused) 
                                      VALUES ('$tid', '$date', '$user', '$name', '$machineused')");
    } else {
        // Update existing
        $insert = mysqli_query($con, "UPDATE dailycheckss SET machineused='$machineused', user='$user' 
                                      WHERE name='$tid' AND date='$date'");
    }
    
    if($insert) {
        header("Location: admin.php?id=dailychecks&tid=$tid");
        exit();
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $qu2['name']; ?>
        </h1>
        <ul>
            <li><a href="">Home</a></li>
            <li><?php echo $headingname; ?></li>
        </ul>
    </div>
    <div class="row">
        <a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success"
                style="float:right; margin-left:15px ">Go Back</button></a>
    </div> <br />
    <div class="col-md-12"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form name="form1" action="" enctype="multipart/form-data" method="post">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Select Date</label>
                            <?php
                            if ($edate) {
                                $date = date('d-m-Y', strtotime($edate));
                            } else {
                                $date = date('d-m-Y');
                            }
                            ?>
                            <input type="text" name="date" class="form-control" value="<?php echo $date; ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Attempted By</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?php echo $ename; ?>" />
                        </div>
                    </div>
                    </br>

                    <!-- ===== YES/NO QUESTION ===== -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h3><strong>Is this section/machine operational today?</strong></h3>
                                <div style="margin-top:10px;">
                                    <input type="radio" name="machineused" id="machine_yes" value="Yes" required 
                                        onclick="showAllFields()" 
                                        <?php echo ($machineStatus == 'Yes') ? 'checked' : ''; ?>>
                                    <label for="machine_yes" style="font-size:18px; margin-right:20px;">Yes</label>
                                    
                                    <input type="radio" name="machineused" id="machine_no" value="No" required 
                                        onclick="showReasonOnly()"
                                        <?php echo ($machineStatus == 'No') ? 'checked' : ''; ?>>
                                    <label for="machine_no" style="font-size:18px;">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== REASON DIV (NO) ===== -->
                    <div id="reason_div" style="display: <?php echo ($machineStatus == 'No') ? 'block' : 'none'; ?>; margin-top:20px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Please provide reason for not operational: <span style="color:red;">*</span></strong></label>
                                    <textarea name="reason_no" id="reason_no" class="form-control" rows="4" 
                                        placeholder="Enter reason why this machine/section is not operational today..."
                                        <?php echo ($machineStatus == 'No') ? 'required' : ''; ?>><?php echo htmlspecialchars($machineReason); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="hidden" name="tid" value="<?php echo $tid; ?>">
                                <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                                <input type="hidden" name="name" value="<?php echo $ename; ?>">
                                <button type="submit" name="submit_no" class="btn btn-danger">Submit Reason</button>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ALL FIELDS DIV (YES) ===== -->
                    <div id="all_fields_div" style="display: <?php echo ($machineStatus == 'Yes') ? 'block' : 'none'; ?>;">
                        <input type="hidden" name="tid" value="<?php echo $tid; ?>">
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="name" value="<?php echo $ename; ?>">
                        <input type="hidden" name="cid" value="<?php echo $cid; ?>">

                        <?php if ($tid == 1) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="validationTooltip01"> Time</label>
                                    <input type="time" name="time" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Truck No.</label>
                                    <input type="text" name="truckno" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Operator Name</label>
                                    <input type="text" name="operator" class="form-control" />
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($qu2['image']) { ?>
                            <div class="row">
                                <div class="col-md-6"><br>
                                    <label for="validationTooltip01"> Reference pictures :</label>
                                    <a href="pdf/<?php echo $qu2['image']; ?>" target="_blank"><?php echo $qu2['image']; ?></a>
                                </div>
                            </div>
                        <?php } ?>

                        </br>
                        <div id="txtHint"></div>

                        <?php
                        $sql2 = mysqli_query($con, "select distinct section from dailychecks1 where tid='$tid' ");
                        $j = 0;
                        $jj = 'A';
                        $i = 0;
                        while ($th = mysqli_fetch_array($sql2)) {
                            $j++;
                            $jj++;
                        ?>
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <?php if ($tid == '67') { ?>
                                        <h2 style="color:#0000FF"> <?php echo $th['section']; ?></h2>
                                    <?php } else { ?>
                                        <h2 style="color:#0000FF"><?php echo $j; ?>. <?php echo $th['section']; ?></h2>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                            $sql1 = mysqli_query($con, "select * from dailychecks1 where tid='$tid' and section='$th[section]' ");
                            while ($row1 = mysqli_fetch_array($sql1)) {
                                $sq4 = mysqli_query($con, "select * from dailychecks2 where cid='$cid' and ques='$row1[ques]' ");
                                $qu4 = mysqli_fetch_array($sq4);

                                $ans = $qu4['ans'];
                                $input = $qu4['input'];
                                $answerr = $qu4['answer'];
                                $cmnt = $qu4['cmnt'];

                                $comment = $row1['comment'];
                                $file = $row1['file'];
                                $yesno = $row1['yesno'];
                                $inputbox = $row1['inputbox'];
                                $dateinput = $row1['dateinput'];
                                $timeinput = $row1['timeinput'];
                                $ans = $row1['ans_status'];
                                $answer = $row1['answer'];
                                $required = $row1['required'];

                                $answer = explode(";", $answer);
                            ?>
                                <input type="hidden" name="tid" value="<?php echo $tid; ?>" />

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <h3 style="text-transform:captalize;"> <?php echo $i + 1; ?>.
                                                <?php echo $row1['ques']; ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <?php if ($row1['image'] != "N/A") { ?>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <img src="dailychecks/toolbox/<?php echo $row1['image']; ?>" alt="" width="300px;" height="150px;">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <input type="hidden" id="hidden_ques_<?php echo $i; ?>"
                                    value="<?php echo htmlspecialchars($row1['ques']); ?>">
                                <input type="hidden" id="hidden_section_<?php echo $i; ?>"
                                    value="<?php echo htmlspecialchars($th['section']); ?>">

                                <div id="field_container_<?php echo $i; ?>" style="display: inline-block; width: 100%;">
                                    <div class="row">
                                        <?php if ($dateinput == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="datetime-local" name="dateinput<?php echo $i; ?>" class="form-control"
                                                        value="<?php echo $qu4['dateinput']; ?>"
                                                        onchange="autoSaveField(this.value,'dateinput<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')">
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($timeinput == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="time" name="timeinput<?php echo $i; ?>" class="form-control"
                                                        value="<?php echo $qu4['timeinput']; ?>"
                                                        onchange="autoSaveField(this.value,'timeinput<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')">
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($inputbox == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="text" name="input<?php echo $i; ?>" class="form-control"
                                                        value="<?php echo htmlspecialchars($input); ?>"
                                                        onchange="autoSaveField(this.value,'input<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')">
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($ans == "yes" && !empty($answer)) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <select class="form-control" name="answer<?php echo $i; ?>"
                                                        onchange="autoSaveField(this.value,'answer<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')">
                                                        <option value="">-- Select --</option>
                                                        <?php foreach ($answer as $ansOpt) {
                                                            if (trim($ansOpt) !== '') {
                                                                $selected = ($ansOpt == $qu4['answer']) ? "selected" : "";
                                                                echo '<option value="' . htmlspecialchars($ansOpt) . '" ' . $selected . '>' . htmlspecialchars($ansOpt) . '</option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($yesno == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <select required name="r1<?php echo $i; ?>" class="form-control"
                                                        onchange="autoSaveField(this.value,'r1<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>'); toggleRequired(this.value, <?php echo $i; ?>);">
                                                        <option value="">-- Select --</option>
                                                        <option value="Yes" <?php echo ($qu4['ans'] == "Yes") ? "selected" : ""; ?>>Yes</option>
                                                        <option value="No" <?php echo ($qu4['ans'] == "No") ? "selected" : ""; ?>>No</option>
                                                        <option value="N/A" <?php echo ($qu4['ans'] == "N/A") ? "selected" : ""; ?>>N/A</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($qu4['ans'] == "No") {
                                                echo '<script>toggleRequired("No", ' . $i . ');</script>';
                                            } ?>
                                        <?php } ?>

                                        <?php if ($file == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <?php
                                                    $pics = !empty($qu4['pic']) ? json_decode($qu4['pic'], true) : [];
                                                    if (!empty($pics)) {
                                                        foreach ($pics as $pic) {
                                                            echo '<a href="upl1/' . $pic . '" target="_blank">View File</a><br>';
                                                        }
                                                    }
                                                    ?>
                                                    <input type="hidden" name="oldfile<?php echo $i; ?>" value="<?php echo htmlspecialchars($qu4['pic']); ?>">
                                                    <input type="file" name="img<?php echo $i; ?>[]" multiple class="form-control" accept="image/png,.jpg,.jpeg"
                                                        onchange="autoSaveFile(this,'img<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')">
                                                    <p>Only Upload jpg, jpeg and png images.</p>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($comment == "yes") { ?>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <textarea name="cmnt<?php echo $i; ?>" class="form-control" placeholder="Comment"
                                                        onchange="autoSaveField(this.value,'cmnt<?php echo $i; ?>','<?php echo $cid; ?>','<?php echo $tid; ?>','<?php echo $i; ?>')"><?php echo htmlspecialchars($cmnt); ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="row" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
                        <?php
                                $i++;
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- END all_fields_div -->

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAllFields() {
    var reasonDiv = document.getElementById('reason_div');
    var allFieldsDiv = document.getElementById('all_fields_div');
    var reasonNo = document.getElementById('reason_no');
    
    if(reasonDiv) reasonDiv.style.display = 'none';
    if(allFieldsDiv) allFieldsDiv.style.display = 'block';
    if(reasonNo) reasonNo.required = false;
}

function showReasonOnly() {
    var reasonDiv = document.getElementById('reason_div');
    var allFieldsDiv = document.getElementById('all_fields_div');
    var reasonNo = document.getElementById('reason_no');
    
    if(reasonDiv) reasonDiv.style.display = 'block';
    if(allFieldsDiv) allFieldsDiv.style.display = 'none';
    if(reasonNo) reasonNo.required = true;
}

function toggleRequired(value, index) {
    var fileInput = document.querySelector('input[name="img' + index + '[]"]');
    var commentArea = document.querySelector('textarea[name="cmnt' + index + '"]');

    if (fileInput) {
        if (value === "No") {
            fileInput.setAttribute('required', 'required');
            fileInput.style.borderColor = 'red';
        } else {
            fileInput.removeAttribute('required');
            fileInput.style.borderColor = '';
        }
    }

    if (commentArea) {
        if (value === "No") {
            commentArea.setAttribute('required', 'required');
            commentArea.style.borderColor = 'red';
        } else {
            commentArea.removeAttribute('required');
            commentArea.style.borderColor = '';
        }
    }
}

function autoSaveField(value, fieldName, cid, tid, index) {
    if (value === "") return;

    var ques = document.getElementById("hidden_ques_" + index).value;
    var section = document.getElementById("hidden_section_" + index).value;

    var formData = new FormData();
    formData.append("action", "autosave");
    formData.append("cid", cid);
    formData.append("tid", tid);
    formData.append("ques", ques);
    formData.append("section", section);
    formData.append(fieldName, value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "dailychecks2_ajax", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var indicator = document.getElementById("saved_" + index);
            if (!indicator) {
                indicator = document.createElement("span");
                indicator.id = "saved_" + index;
                indicator.style.cssText = "color:green; font-size:11px; margin-left:5px;";
                var fieldContainer = document.getElementById("field_container_" + index);
                if (fieldContainer) fieldContainer.appendChild(indicator);
            }
            indicator.innerHTML = "✓ Saved";
            setTimeout(function() {
                indicator.innerHTML = "";
            }, 2000);
        }
    };
    xhr.send(formData);
}

function autoSaveFile(inputElem, fieldName, cid, tid, index) {
    if (inputElem.files.length === 0) return;

    var ques = document.getElementById("hidden_ques_" + index).value;
    var section = document.getElementById("hidden_section_" + index).value;

    var formData = new FormData();
    formData.append("action", "autosave");
    formData.append("cid", cid);
    formData.append("tid", tid);
    formData.append("ques", ques);
    formData.append("section", section);

    for (var j = 0; j < inputElem.files.length; j++) {
        formData.append(fieldName + '[]', inputElem.files[j]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "dailychecks2_ajax", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var indicator = document.getElementById("saved_" + index);
            if (!indicator) {
                indicator = document.createElement("span");
                indicator.id = "saved_" + index;
                indicator.style.cssText = "color:green; font-size:11px; margin-left:5px;";
                var fieldContainer = document.getElementById("field_container_" + index);
                if (fieldContainer) fieldContainer.appendChild(indicator);
            }
            indicator.innerHTML = "✓ " + inputElem.files.length + " file(s) uploaded";
            setTimeout(function() {
                indicator.innerHTML = "";
            }, 3000);
        }
    };
    xhr.send(formData);
}

function comment(id, ans) {
    const commentr = document.getElementById("f1" + id);
    const commentr1 = document.getElementById("f2" + id);
    if (ans == "No") {
        commentr.setAttribute("required", "required");
        commentr1.setAttribute("required", "required");
    } else {
        commentr.removeAttribute("required");
        commentr1.removeAttribute("required");
    }
}

function coment(id, ans) {
    if (ans == "At Risk" || ans == "Poor" || ans == "No") {
        const commentr1 = document.getElementById("f2" + id);
        if (ans == "At Risk" || ans == "Poor" || ans == "No") {
            commentr.setAttribute("required", "required");
            commentr1.setAttribute("required", "required");
        } else {
            commentr.removeAttribute("required");
            commentr1.removeAttribute("required");
        }
    }
}
</script>
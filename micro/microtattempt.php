<?php
$mid = $_GET['mid'];

$mtxrow = mysqli_query($con,"SELECT * FROM `tbl_microtrending` WHERE id='$mid'");
$mtxrowd = mysqli_fetch_assoc($mtxrow);
$mtxrow1 = $mtxrowd['mid'];








?>
<style>
    .hidden {
        display: none;
    }
</style>

<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Attempt Micro Trending</li>
            </ul>
        </div>


        <div class="container-fluid">




            <div class="col-md-12 mt-5 mb-5">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">Attempt Micro Trending</div>
                            </div>
                            <div class="col-md-6">
                                
                                <a href="admin.php?id=microview" class="btn btn-success" style="float: right;">Go Back</a>

                                <a href="admin.php?id=microraise&mid=<?php echo $mid; ?>" class="btn btn-primary mr-2" style="float:right; ">Add Justifiaction</a>

                            </div>
                        </div>
                        
                        <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="validationTooltip01">Sampling Date</label>
                                    <input type="date" class="form-control" name="sampdate" required>
                                    <div class="invalid-tooltip">
                                        Please provide Sampling Date.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 ">
                                    <label for="validationTooltip01">Sample Testing Date</label>
                                    <input class="form-control" id="validationTooltip01" type="date" placeholder="Sub-Section" required="required" name="samptest" />
                                    <div class="invalid-tooltip">
                                        Please provide Sample Testing Date.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Date of issue</label>
                                    <input class="form-control" id="validationTooltip01" type="date" placeholder="Sample No." required="required" name="issuedate" />
                                    <div class="invalid-tooltip">
                                        Please provide Date of issue.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Report No.</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Report no" required="required" name="report" />
                                    <div class="invalid-tooltip">
                                        Please provide Report No.
                                    </div>
                                </div>

                                
                            </div>
                            <div class="row justify-content-center my-3">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <!-- Bootstrap form group for select -->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="bacteriaSelect" class="form-label fw-semibold">Choose Bacteria Strain</label>
                                            <select id="bacteriaSelect" class="form-control">
                                                <option value="" disabled selected>-- Select a bacteria --</option>
                                                <?php
                                                $bactx = mysqli_query($con, "SELECT * FROM `tbl_microbact` where section='$mtxrow1'");
                                                while ($bactn = mysqli_fetch_assoc($bactx)) {
                                                    echo "<option value='" . $bactn['name'] . "' data-reject='" . $bactn['rejectl'] . "' data-accept='" . $bactn['acceptl'] . "'>" . $bactn['name'] . "</option>";
                                                }

                                                ?>


                                            </select>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>

                                    <!-- Dynamic entries container: all added bacteria blocks will appear here -->
                                    <div id="dynamicEntriesContainer" class="mt-3">
                                        <!-- No entries initially, but we'll show a placeholder if empty -->
                                        <div id="emptyPlaceholder" class="text-center text-muted py-5 bg-white rounded-3 border border-dashed">
                                            <i class="fas fa-vial fa-2x mb-2 opacity-50"></i>
                                        </div>
                                    </div>

                                    <!-- Optional: summary or extra actions (clear all) -->
                                    <div class="mt-4 d-flex justify-content-end">
                                        <button id="clearAllBtn" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="fas fa-trash-alt me-1"></i> Clear All Entries
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Overall Status</label>
                                    <select name="status" class="form-control" onchange="statusChanged(this.value)" required>
                                        <option disabled selected>Select Status</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>


                                    <div class="invalid-tooltip">
                                        Please provide status.
                                    </div>
                                </div>
                                <script>
                                    function statusChanged(val) {
                                        console.log(val);
                                        const contain = document.getElementById('contain');
                                        if (val === "Fail") {
                                            contain.classList.remove('hidden');
                                        } else {
                                            contain.classList.add('hidden');
                                        }
                                    }
                                </script>

                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Upload Report</label>
                                    <input class="form-control" id="validationTooltip01" type="file" required="required" name="file" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                            </div>

                            <script>
                               

                                (function() {
                                    // DOM elements
                                    const bacteriaSelect = document.getElementById('bacteriaSelect');
                                    const container = document.getElementById('dynamicEntriesContainer');
                                    const emptyPlaceholder = document.getElementById('emptyPlaceholder');
                                    const clearAllBtn = document.getElementById('clearAllBtn');

                                    let entryCounter = 0;

                                    // Helper: check if any entries exist
                                    function hasEntries() {
                                        const entries = document.querySelectorAll('#dynamicEntriesContainer .bacteria-entry-card');
                                        return entries.length > 0;
                                    }

                                    // Helper: show/hide empty placeholder
                                    function togglePlaceholder() {
                                        if (emptyPlaceholder) {
                                            if (hasEntries()) {
                                                emptyPlaceholder.style.display = 'none';
                                            } else {
                                                emptyPlaceholder.style.display = 'block';
                                            }
                                        }
                                    }

                                    // Remove a single entry
                                    function removeEntry(entryElement) {
                                        if (entryElement && entryElement.remove) {
                                            entryElement.remove();
                                            togglePlaceholder();
                                        }
                                    }

                                    // Escape HTML to prevent XSS
                                    function escapeHtml(str) {
                                        if (!str) return '';
                                        return str.replace(/[&<>]/g, function(m) {
                                            if (m === '&') return '&amp;';
                                            if (m === '<') return '&lt;';
                                            if (m === '>') return '&gt;';
                                            return m;
                                        });
                                    }

                                    // Create a new bacteria entry block
                                    function createBacteriaEntry(bacteriaName, acceptVal, rejectVal) {
                                        const uniqueId = `entry_${Date.now()}_${entryCounter++}`;

                                        const cardDiv = document.createElement('div');
                                        cardDiv.className = 'card mb-3 bacteria-entry-card border-start border-primary border-3 shadow-sm';
                                        cardDiv.setAttribute('data-entry-id', uniqueId);

                                        cardDiv.innerHTML = `
            <div class="card-body p-3 border border-light">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-bacterium me-1"></i> ${escapeHtml(bacteriaName)}</h5>
                    <span class="remove-item-btn text-danger" title="Remove entry">
                       X
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-semibold  text-secondary">Acceptance Limit</label>
                        <div class="input-group">
                        <input type="hidden" name="bact_name[]" value="${escapeHtml(bacteriaName)}">
                            <input type="text" class="form-control form-control-sm " name="acceptl[]" value="${escapeHtml(acceptVal)}" readonly>
                        </div>
                        <div class="form-text ">Reference limit</div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label fw-semibold  text-secondary">Rejection Limit</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm " value="${escapeHtml(rejectVal)}" name="rejectl[]" readonly>
                        </div>
                        
                    </div>
                    <div class="col-md-6 col-sm-12 mt-3">
                        <label class="form-label fw-semibold  text-secondary">Actual Value</label>
                        <input type="text" class="form-control form-control-sm user-value-input" placeholder="Enter actual value" name="test_value[]" required>
                        
                    </div>
                    <div class="col-md-6 col-sm-12 mt-3">
                        <label class="form-label fw-semibold  text-secondary">Status</label>
                        <select class="form-control " name="bactstatus[]" required>
                            <option value="">Select Status</option>
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                       
                    </div>
                </div>
            </div>
        `;

                                        // Add remove event to the remove button
                                        const removeBtn = cardDiv.querySelector('.remove-item-btn');
                                        if (removeBtn) {
                                            removeBtn.addEventListener('click', function(e) {
                                                e.preventDefault();
                                                removeEntry(cardDiv);
                                            });
                                        }

                                        return cardDiv;
                                    }

                                    // Handle bacteria selection change
                                    function onBacteriaChange() {
                                        const selectedOption = bacteriaSelect.options[bacteriaSelect.selectedIndex];
                                        if (!selectedOption || !selectedOption.value) {
                                            return;
                                        }

                                        const bacteriaName = selectedOption.value;
                                        const acceptValue = selectedOption.getAttribute('data-accept');
                                        const rejectValue = selectedOption.getAttribute('data-reject');

                                        const newEntry = createBacteriaEntry(
                                            bacteriaName,
                                            acceptValue || 'N/A',
                                            rejectValue || 'N/A'
                                        );
                                        container.appendChild(newEntry);

                                        togglePlaceholder();

                                        // Reset select to allow adding same bacteria again
                                        bacteriaSelect.value = "";
                                    }

                                    // Clear all entries
                                    function clearAllEntries() {
                                        const allEntries = document.querySelectorAll('#dynamicEntriesContainer .bacteria-entry-card');
                                        allEntries.forEach(function(entry) {
                                            entry.remove();
                                        });
                                        togglePlaceholder();
                                    }

                                    // Event listeners
                                    if (bacteriaSelect) {
                                        bacteriaSelect.addEventListener('change', onBacteriaChange);
                                    }

                                    if (clearAllBtn) {
                                        clearAllBtn.addEventListener('click', function() {
                                            if (confirm('Remove all added bacteria entries?')) {
                                                clearAllEntries();
                                            }
                                        });
                                    }

                                    // Initialize placeholder visibility
                                    togglePlaceholder();


                                })();
                            </script>


                            <div class="row hidden" id="contain">
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Corrective action taken</label>
                                    <textarea class="form-control" name="remark"></textarea>
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Is restesting shall be done as corrective action?</label>
                                    <select name="fstatus" id="" class="form-control">
                                        <option disabled selected>Select Status</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>


                                    <div class="invalid-tooltip">
                                        Please provide status.
                                    </div>
                                </div>

                            </div>


                            <br />

                            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                        </form>
                    </div>
                </div>
            </div>




            <?php

            if (isset($_POST['submit'])) {
                $sampdate = $_POST['sampdate'];
                $samptest = $_POST['samptest'];
                $issuedate = $_POST['issuedate'];
                $report = $_POST['report'];
                $status = $_POST['status'];
                $attempton = date('d-m-y h:i');
                $user = $_SESSION['user'];

                $fsatus = $_POST['fstatus'];

                $remark = $_POST['remark'];

                if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
                    $unique = "micro" . date('dmYhis');
                    $file = $unique . $_FILES['file']['name'];
                    $target = "micro/upload/" . $file;
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                        $upfile = $file;
                    } else {
                        $upfile = "";
                    }
                } else {
                    $upfile = "";
                }
                $testm = mysqli_query($con, "select * from tbl_microtrending1 where eid='$mid'");
                $testmn = mysqli_num_rows($testm);
                if ($testmn > 0) {
                    $retest = 'Yes';
                } else {
                    $retest = '';
                }
                $mstid = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`,`sample`, `issue`, `testing`, `report`, `reportno`, `status`,`remark`,`fstatus`,`retest`) VALUES ('$mid','$attempton','$user','$sampdate','$issuedate','$samptest','$upfile','$report','$status','$remark','$fsatus','$retest')");
                $mstdx = mysqli_insert_id($con);


                $bact_name = $_POST['bact_name'];

                foreach($bact_name as $key => $value){
                    $bactname = $value;
                    $testvalue = $_POST['test_value'][$key];
                    $bactstatus = $_POST['bactstatus'][$key];
                    $acceptl = $_POST['acceptl'][$key];
                    $rejectl = $_POST['rejectl'][$key];

                    $mstiq = mysqli_query($con,"INSERT INTO `microtrendb`(`mmid`, `mid`, `name`, `accept`, `reject`, `actual`, `status`) VALUES ('$mstdx','$mid','$bactname','$acceptl','$rejectl','$testvalue','$bactstatus')");
                    
                }


            

               


                $mstidq = mysqli_query($con, "update tbl_microtrending set status='$status',fstatus='$fsatus' where id='$mid'");
                if ($mstid) {
                    echo "<script>alert('Data Updated Successfully!');
                    window.location.href='admin?id=microtrending';</script>";
                }
            }
            ?>
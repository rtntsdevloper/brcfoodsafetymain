<div class="main-content">
    <div class="breadcrumb">
        <ul>
            <li><a href=""></a></li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=zenpack1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Packaging Record</div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Date</label>
                            <input class="form-control" type="date" required name="idate" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Select Packaging</label>
                            <select name="prodid" id="prodid" class="form-control" onchange="loadGrnOptions()" required>
                                <option value="">Select Product</option>
                                <?php
                                $nrk = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE category !='Raw Material'");
                                while ($nrk1 = mysqli_fetch_array($nrk)) {
                                    echo '<option value="' . $nrk1['id'] . '" data-label="' . $nrk1['pname'] . '">' . $nrk1['pname'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
<!-- 
                        <div class="col-md-6 mb-3">
                            <label>GRN No. (PO No.)</label>
                            <select class="form-control" id="primary_grn" name="grncode" required onchange="updateAllDropdowns()">
                                <option value="">Please select GRN</option>
                            </select>
                        </div> -->

                        
                        <div class="col-md-6 mb-3">
                            <label>GRN No.</label>
                            <select class="form-control" id="primary_grn" name="grncode" required onchange="updateAllDropdowns()">
                                <option value="">Please select GRN</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="prodname" id="prodname">
                            <label>Is Packaging Batch Finished?</label>
                            <select name="packfinished" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Batches Section -->
                    <div class="form-row">
                        <div class="col-md-12">
                            <hr>
                            <h5>Additional Batches</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Is there any additional batch used?</label>
                            <select name="additional_batch_used" id="additional_batch_used" class="form-control" onchange="toggleAdditionalFields(this.value)">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div id="additional_fields" style="display:none;">
                        <div id="grn_rows"></div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info btn-sm" onclick="addGrnRow()">+ Add Another Batch</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 mb-3">
                            <label>Raw-Material Batch Code</label>
                            <input class="form-control" type="text" name="batch" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>BB/UB Date</label>
                            <input class="form-control" type="date" name="bbdate" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Number of packaging coded</label>
                            <input type="number" name="numberpack" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Pack add Picture</label>
                            <input type="file" name="packpic" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Is the labelling correct as per the product?</label>
                            <select name="label" id="label" class="form-control" onchange="toggleAction(this.value)">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div id="action_div" style="display:none;">
                                <label>Action Taken</label>
                                <input name="action" type="text" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div id="damage_div">
                                <label>Is any pouches damaged/wasted?</label>
                                <select name="damage" class="form-control" required onchange="toggleDamageFields(this.value)">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <script>
                        function toggleDamageFields(value) {
                            if (value === 'Yes') {
                                document.getElementById('damage_fields').style.display = 'block';
                            } else {
                                document.getElementById('damage_fields').style.display = 'none';
                            }
                        }
                    </script>
                    <div class="form-row" id="damage_fields" style="display:none;">
                        <div class="col-md-6 mb-3">
                            <div id="action_div">
                                <label>Number of pouches damaged/wasted</label>
                                <input name="wasteno" type="number" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div id="action_div">
                                <label>Upload Picture</label>
                                <input name="wastepic" type="file" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Store all GRN options globally
    let allGrnOptions = [];
    let selectedGrns = [];
    let preservePrimaryGrn = false; // Flag to preserve primary GRN value

    // Load GRN options from server
    function loadGrnOptions() {
        var prodid = $('#prodid').val();
        var productName = $('#prodid option:selected').data('label');
        $('#prodname').val(productName);

        if (prodid) {
            $.ajax({
                url: 'zendboxg/packadd1',
                type: 'POST',
                data: {
                    sid: prodid
                },
                success: function(data) {
                    // Store all options
                    allGrnOptions = [];
                    $(data).find('option').each(function() {
                        if ($(this).val() != '') {
                            allGrnOptions.push({
                                value: $(this).val(),
                                text: $(this).text()
                            });
                        }
                    });

                    // If no options found, try parsing HTML string
                    if (allGrnOptions.length == 0) {
                        var temp = $('<div>').html(data);
                        temp.find('option').each(function() {
                            if ($(this).val() != '') {
                                allGrnOptions.push({
                                    value: $(this).val(),
                                    text: $(this).text()
                                });
                            }
                        });
                    }

                    // Update primary GRN dropdown
                    updatePrimaryDropdown();
                }
            });
        }
    }

    // Update primary GRN dropdown with available options
    function updatePrimaryDropdown() {
        var primarySelect = $('#primary_grn');
        var currentValue = preservePrimaryGrn ? primarySelect.val() : '';

        // Clear current options except first
        primarySelect.find('option:not(:first)').remove();

        // Filter out already selected additional GRNs
        let availableGrns = allGrnOptions.filter(grn => !selectedGrns.includes(grn.value));

        // Add available options
        availableGrns.forEach(grn => {
            primarySelect.append(`<option value="${grn.value}">${grn.text}</option>`);
        });

        // Restore previous value if it exists and is still available
        if (currentValue && availableGrns.some(grn => grn.value == currentValue)) {
            primarySelect.val(currentValue);
        }

        // Reset the preserve flag after use
        preservePrimaryGrn = false;

        // Update selected GRNs list
        updateSelectedGrnsList();
    }

    // Update all additional dropdowns
    function updateAllDropdowns() {
        updateSelectedGrnsList();

        // Update each additional row's dropdown
        $('.grn-select').each(function(index) {
            updateSingleDropdown($(this), index);
        });
    }

    // Update selected GRNs list (primary + all additional)
    function updateSelectedGrnsList() {
        selectedGrns = [];

        // Add primary GRN if selected
        var primaryVal = $('#primary_grn').val();
        if (primaryVal) {
            selectedGrns.push(primaryVal);
        }

        // Add all additional GRNs
        $('.grn-select').each(function() {
            var val = $(this).val();
            if (val) {
                selectedGrns.push(val);
            }
        });
    }

    // Update a single dropdown excluding already selected GRNs
    function updateSingleDropdown($dropdown, rowIndex) {
        var currentValue = $dropdown.val();

        // Get all selected GRNs except this dropdown's own value
        let excludedGrns = selectedGrns.filter((val, idx) => {
            // Don't exclude this dropdown's own value
            if (val == currentValue) return false;
            return true;
        });

        // Filter available GRNs
        let availableGrns = allGrnOptions.filter(grn => !excludedGrns.includes(grn.value));

        // Store current HTML
        var currentHtml = $dropdown.html();

        // Clear and repopulate
        $dropdown.find('option:not(:first)').remove();
        availableGrns.forEach(grn => {
            $dropdown.append(`<option value="${grn.value}">${grn.text}</option>`);
        });

        // Restore value if still available
        if (currentValue && availableGrns.some(grn => grn.value == currentValue)) {
            $dropdown.val(currentValue);
        } else {
            $dropdown.val('');
        }
    }

    // Add new additional GRN row
    function addGrnRow() {
        var rowId = 'row_' + Date.now();
        var rowHtml = `
        <div class="form-row" id="${rowId}" style="margin-bottom:10px; padding:10px; background:#f9f9f9; border-left:3px solid #007bff;">
            <div class="col-md-5">
                <label>GRN No.</label>
                <select name="additional_grn[]" class="form-control grn-select" required onchange="handleGrnChange(this, '${rowId}')">
                    <option value="">Select GRN</option>
                </select>
            </div>
            <div class="col-md-5">
                <label>Batch Finished?</label>
                <select name="additional_finished[]" class="form-control">
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm form-control" onclick="removeGrnRow('${rowId}')">Remove</button>
            </div>
        </div>
    `;
        $('#grn_rows').append(rowHtml);

        // Get the new dropdown
        var $newDropdown = $(`#${rowId} .grn-select`);

        // Update selected GRNs list
        updateSelectedGrnsList();

        // Update this dropdown (exclude already selected)
        updateSingleDropdown($newDropdown, $('.grn-select').length - 1);
    }

    // Handle GRN change event
    function handleGrnChange(selectElement, rowId) {
        // Update selected GRNs list
        updateSelectedGrnsList();

        // Update all dropdowns (this will refresh options for all)
        updateAllDropdowns();
    }

    // Remove a GRN row
    function removeGrnRow(rowId) {
        $('#' + rowId).remove();

        // Update selected GRNs list
        updateSelectedGrnsList();

        // Update all dropdowns
        updateAllDropdowns();
    }

    // Toggle additional fields visibility
    function toggleAdditionalFields(value) {
        var primaryGrnValue = $('#primary_grn').val(); // Store current primary GRN value

        if (value == 'Yes') {
            $('#additional_fields').show();
            if ($('#grn_rows').children().length == 0) {
                addGrnRow();
            }
        } else {
            $('#additional_fields').hide();
            $('#grn_rows').empty();

            // IMPORTANT FIX: Set flag to preserve primary GRN and refresh dropdown
            preservePrimaryGrn = true;
            updateSelectedGrnsList();

            // Refresh primary dropdown without losing its value
            var primarySelect = $('#primary_grn');
            var currentPrimaryValue = primaryGrnValue;

            // Rebuild primary dropdown with all available options (since no additional GRNs are selected)
            primarySelect.find('option:not(:first)').remove();
            allGrnOptions.forEach(grn => {
                primarySelect.append(`<option value="${grn.value}">${grn.text}</option>`);
            });

            // Restore the previous value if it exists in the new options
            if (currentPrimaryValue && allGrnOptions.some(grn => grn.value == currentPrimaryValue)) {
                primarySelect.val(currentPrimaryValue);
            } else if (currentPrimaryValue) {
                // If the value is not in options (shouldn't happen), keep it empty
                primarySelect.val('');
            }

            // Clear selected GRNs list and update with only primary
            selectedGrns = [];
            if (primarySelect.val()) {
                selectedGrns.push(primarySelect.val());
            }
        }
    }

    // Toggle action taken field
    function toggleAction(value) {
        if (value == 'No') {
            $('#action_div').show();
        } else {
            $('#action_div').hide();
        }
    }

    $(document).ready(function() {
        $('#additional_fields').hide();
        $('#action_div').hide();
    });
</script>

<?php
if (isset($_POST['submit'])) {
    // Collect form data
    $idate = $_POST['idate'];
    $prodid = $_POST['prodid'];
    $grncode = $_POST['grncode'];
    $prodname = $_POST['prodname'];
    $batch = $_POST['batch'];
    $bbdate = $_POST['bbdate'];
    $label = $_POST['label'];

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    } else {
        $action = '';
    }

    if (isset($_POST['packfinished'])) {
        $packfinished = $_POST['packfinished'];
    } else {
        $packfinished = null; // or set a default if needed
    }

    
 
    if (isset($_POST['numberpack'])) {
        $numberpack = $_POST['numberpack'];
    } else {
        $numberpack = null; // or set a default if needed
    }

    if (isset($_POST['additional_batch_used'])) {
        $additional_batch_used = $_POST['additional_batch_used'];
    } else {
        $additional_batch_used = 'No';
    }

    if (isset($_POST['additional_grn'])) {
        $additional_grn = $_POST['additional_grn'];
    } else {
        $additional_grn = [];
    }

    if (isset($_POST['additional_finished'])) {
        $additional_finished = $_POST['additional_finished'];
    } else {
        $additional_finished = [];
    }


    // Collect all GRNs and their finish status
    $all_grns = [$grncode];
    $all_status = [$packfinished];

    if ($additional_batch_used == 'Yes') {
        foreach ($additional_grn as $key => $grn_id) {
            if (!empty($grn_id)) {
                $all_grns[] = $grn_id;

                if (isset($additional_finished[$key])) {
                    $all_status[] = $additional_finished[$key];
                } else {
                    $all_status[] = 'No';
                }
            }
        }
    }



    $imgpath = "zendboxg/pdf/";
    if (isset($_FILES['packpic'])) {
        $packpic = $_FILES['packpic']['name'];
        $packpic_tmp = $_FILES['packpic']['tmp_name'];
        $packpic_ext = pathinfo($packpic, PATHINFO_EXTENSION);
        $packpic_new = date("YmdHis") . "_" . rand(1000, 9999) . $packpic;

        if (move_uploaded_file($packpic_tmp, $imgpath . $packpic_new)) {
            $packpicnew = $packpic_new;
        } else {
            $packpicnew = "";
        }
    } else {
        $packpicnew = "";
    }

    if (isset($_FILES['wastepic'])) {
        $wastepic = $_FILES['wastepic']['name'];
        $wastepic_tmp = $_FILES['wastepic']['tmp_name'];
        $wastepic_ext = pathinfo($wastepic, PATHINFO_EXTENSION);
        $wastepic_new = date("YmdHis") . "_" . rand(1000, 9999) . $wastepic;
        if (move_uploaded_file($wastepic_tmp, $imgpath . $wastepic_new)) {
            $wastepicnew = $wastepic_new;
        } else {
            $wastepicnew = "";
        }
    } else {
        $wastepicnew = "";
    }

    $damage = $_POST['damage'];
    $wasteno = $_POST['wasteno'];

    // Check for duplicate GRNs (extra safety)
    if (count($all_grns) != count(array_unique($all_grns))) {
        echo "<script>alert('Error: Duplicate GRN selected! Please check your selections.'); window.history.back();</script>";
        exit;
    }

    // Update GRN status in database for batches marked as finished
    foreach ($all_grns as $index => $grn_id) {
        if ($all_status[$index] == 'Yes') {
            mysqli_query($con, "UPDATE `tblgrn1` SET `zendfinish` = 'done' WHERE `id` = '$grn_id'");
        }
    }

    // Generate unique pack batch number
    $count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `zendpackaging`"));
    $packbatch = "Pack" . date('dmY') . '_' . ($count + 1);

    // Prepare strings for storage
    $grn_string = implode(',', $all_grns);
    $status_string = implode(',', $all_status);

    // Insert into database
    
    $insert = mysqli_query($con, "INSERT INTO `zendpackaging`(`sdate`, `pbatch`, `prodid`, `product`, `grnid`, `batchcode`, `bbdate`, `label`, `action`, `user`, `adddate`, `packfinish`, `numpack`, `batch_status`, `packpic`, `wastepic`, `wasteno`, `waste`) VALUES ('$idate','$packbatch','$prodid','$prodname','$grn_string','$batch','$bbdate','$label','$action','$user','" . date('Y-m-d H:i:s') . "','$packfinished','$numberpack','$status_string','$packpicnew','$wastepicnew','$wasteno','$damage')");

    if ($insert) {
        echo "<script>alert('Packaging Record Added Successfully!'); window.location.href='admin.php?id=zenpack1';</script>";
    } else {
        echo "<script>alert('Failed to Add: " . mysqli_error($con) . "'); window.location.href='admin.php?id=packadd';</script>";
    }
}
?>
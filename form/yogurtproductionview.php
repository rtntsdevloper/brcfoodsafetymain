<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Yogurt production</li>
            <li><a href="">add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=yogurtproduction">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Yogurt Production</h4>

                    <?php
                    $uid = $_GET['uid'];

                    $sqlTarget = mysqli_query($con, "SELECT * FROM `tblyogurtproduction` WHERE uid='$uid'");
                    $rowTarget = mysqli_fetch_assoc($sqlTarget);
                    if ($rowTarget) {
                        $targetQty = $rowTarget['qty'];
                    } else {
                        $targetQty = 0;
                    }

                    if (isset($_POST['submit'])) {
                        $tankno_string = $_POST['tankno'];
                        $addqty_string = $_POST['addqty'];
                        $useno_string = $_POST['useno'];

                        $tankno = explode(';', $tankno_string);
                        $addqty = explode(';', $addqty_string);
                        $useno = explode(';', $useno_string);

                        $tankno = array_filter($tankno);
                        $addqty = array_filter($addqty);
                        $useno = array_filter($useno);
                        $addqty = array_map('intval', $addqty);

                        $totalAddQty = array_sum($addqty);
                        $hasExactMatch = false;

                        foreach ($addqty as $qty) {
                            if ($qty == $targetQty) {
                                $hasExactMatch = true;
                                break;
                            }
                        }

                        if ($totalAddQty == $targetQty || $hasExactMatch) {
                            $success = true;

                            $updateProduction = mysqli_query($con, "UPDATE `tblyogurtproduction` SET `tank`='$tankno_string',   `addqty`='$addqty_string',
                                                                        `useno`='$useno_string' 
                                                                    WHERE uid='$uid'");

                            if (!$updateProduction) {
                                $success = false;
                                echo "<script>alert('Error updating production record!');</script>";
                            }

                            if ($success) {
                                echo "<script>alert('Quantity added successfully!'); window.location.href='admin.php?id=yogurtproduction';</script>";
                            }
                        } else {
                            echo "<script>alert('Error: Total must equal $targetQty or any field = $targetQty');</script>";
                        }
                    }
                    ?>

                    <form method="post" action="" id="tankForm">
                        <div class="container-fluid mt-4">
                            <h3>Tank Details</h3>

                            <div class="alert alert-info mb-3">
                                <strong style="font-size:20px;">📌 Instruction</strong><br>
                                <p>Enter the number based on how many times this tank has been used</p>
                                • <strong>0</strong> = First time using this tank → Generates: <strong>T1, T2, T3, T4, T5</strong><br>
                                • <strong>1</strong> = Second time using this tank → Generates: <strong>R1, R2, R3, R4, R5</strong><br>
                                • <strong>2</strong> = Third time using this tank → Generates: <strong>RR1, RR2, RR3, RR4, RR5</strong><br>
                                • <strong>3</strong> = Fourth time using this tank → Generates: <strong>RRR1, RRR2, RRR3, RRR4, RRR5</strong><br>
                                • <strong>4</strong> = Fifth time using this tank → Generates: <strong>RRRR1, RRRR2, RRRR3, RRRR4, RRRR5</strong><br>
                            </div>

                            <div class="alert alert-warning mb-3">
                                <strong>⚠️ Note:</strong> Maximum quantity per tank is <strong>1000</strong>
                            </div>

                            <input type="hidden" name="tankno" id="hiddenTankno" value="">
                            <input type="hidden" name="addqty" id="hiddenAddqty" value="">
                            <input type="hidden" name="useno" id="hiddenUseno" value="">

                            <div id="tankContainer">
                                <div class="tank-row card mb-3 p-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tank No.</label>
                                            <select name="tankno_select[]" class="form-control tankno" required>
                                                <option value="">select</option>
                                                <?php
                                                $sql = mysqli_query($con, "SELECT * FROM `tbltank` ORDER BY id");
                                                while ($row = mysqli_fetch_assoc($sql)) {
                                                    $tankName = $row['tank'];
                                                    echo "<option value='" . $row['id'] . "' 
                                                              data-tankname='" . $tankName . "'
                                                              data-tanknumber='" . preg_replace('/[^0-9]/', '', $tankName) . "'>"
                                                        . $tankName . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Add Quantity (Max: 1000)</label>
                                            <input type="number" class="form-control qty"
                                                placeholder="Enter quantity (max 1000)" min="0" max="1000" step="1" />
                                            <small class="errorMsg" style="color:red; display:none;"></small>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Use No. (0,1,2,3...)</label>
                                            <input type="number" class="form-control use-number-input"
                                                placeholder="Enter 0,1,2,3..." min="0" step="1" />
                                            <small class="useno-hint" style="color:#888; display:block; font-size:11px;"></small>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Generated Use No.</label>
                                            <input type="text" class="form-control useno-display"
                                                placeholder="Auto-generated" readonly style="background-color:#f0f0f0;" />
                                            <input type="hidden" class="useno-hidden" name="useno_hidden[]" value="" />
                                        </div>

                                        <div class="col-md-12 text-right mt-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary" id="addMoreBtn">+ Add More Tank</button>
                            <button type="submit" name="submit" class="btn btn-success" id="submitBtn" style="display:none;">Submit</button>
                        </div>
                    </form>

                    <div class="mt-3" id="totalSumDisplay" style="font-size:18px; font-weight:bold;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let dynamicTarget = <?php echo $targetQty; ?>;
    const MAX_QTY_PER_TANK = 1000;

    function getUseNumberHint(useNumber) {
        if (useNumber === undefined || useNumber === null || useNumber === '') {
            return 'Enter 0=First time, 1=Second time, 2=Third time, 3=Fourth time...';
        }
        let num = parseInt(useNumber);
        if (isNaN(num)) {
            return 'Enter 0=First time, 1=Second time, 2=Third time, 3=Fourth time...';
        }
        if (num == 0) {
            return '✓ First time use → Generates: T (Example: T1, T2, T5)';
        } else if (num == 1) {
            return '✓ Second time use → Generates: R (Example: R1, R2, R5)';
        } else if (num == 2) {
            return '✓ Third time use → Generates: RR (Example: RR1, RR2, RR5)';
        } else if (num == 3) {
            return '✓ Fourth time use → Generates: RRR (Example: RRR1, RRR2, RRR5)';
        } else if (num == 4) {
            return '✓ Fifth time use → Generates: RRRR (Example: RRRR1, RRRR2, RRRR5)';
        } else {
            let rCount = num;
            let prefix = 'R'.repeat(rCount);
            return '✓ ' + (num + 1) + 'th time use → Generates: ' + prefix;
        }
    }

    function generateUseNumber(useNumber, tankNumber) {
        if (useNumber === undefined || useNumber === null || useNumber === '') {
            return '';
        }
        let num = parseInt(useNumber);
        if (isNaN(num)) {
            return '';
        }
        if (num == 0) {
            return 'T' + tankNumber;
        } else if (num == 1) {
            return 'R' + tankNumber;
        } else {
            let rCount = num;
            return 'R'.repeat(rCount) + tankNumber;
        }
    }

    function autoGenerateUseNumber(row) {
        let $tankSelect = row.find('.tankno');
        let tankId = $tankSelect.val();
        let tankNumber = $tankSelect.find('option:selected').attr('data-tanknumber');
        let useNumberInput = row.find('.use-number-input').val();
        let $usenoDisplay = row.find('.useno-display');
        let $usenoHidden = row.find('.useno-hidden');
        let $usenoHint = row.find('.useno-hint');

        if (useNumberInput !== undefined && useNumberInput !== '') {
            $usenoHint.text(getUseNumberHint(parseInt(useNumberInput)));
            $usenoHint.css('color', '#28a745');
        } else {
            $usenoHint.text(getUseNumberHint(null));
            $usenoHint.css('color', '#888');
        }

        if (tankId && useNumberInput !== '' && tankNumber) {
            let generatedUseNo = generateUseNumber(parseInt(useNumberInput), tankNumber);
            if (generatedUseNo) {
                $usenoDisplay.val(generatedUseNo);
                $usenoHidden.val(generatedUseNo);
            } else {
                $usenoDisplay.val('');
                $usenoHidden.val('');
            }
        } else {
            $usenoDisplay.val('');
            $usenoHidden.val('');
        }
    }

    function checkOverallSum() {
        let totalSum = 0;
        let allQtyFields = $('.qty');
        let submitBtn = $('#submitBtn');
        let sumDisplay = $('#totalSumDisplay');
        let hasExactMatch = false;
        let targetQty = dynamicTarget;
        let hasError = false;
        let exceededTarget = false;
        let exceededMaxQty = false;

        allQtyFields.each(function() {
            let row = $(this).closest('.tank-row');
            let val = parseInt($(this).val()) || 0;
            let tankId = row.find('.tankno').val();
            let usenoValue = row.find('.useno-hidden').val();

            if (tankId && val > 0) {
                totalSum += val;
                if (val === targetQty) {
                    hasExactMatch = true;
                }
                if (!usenoValue) {
                    hasError = true;
                }
                if (val > MAX_QTY_PER_TANK) {
                    exceededMaxQty = true;
                }
            }
        });

        // Check if total exceeds target
        if (totalSum > targetQty && targetQty > 0 && !hasExactMatch) {
            exceededTarget = true;
        }

        sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty);

        if (exceededMaxQty) {
            sumDisplay.css('color', 'red');
            sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty + ' ❌ Quantity cannot exceed ' + MAX_QTY_PER_TANK + ' per tank!');
            submitBtn.hide();
        } else if (targetQty > 0 && ((totalSum === targetQty || hasExactMatch) && !hasError && totalSum > 0)) {
            sumDisplay.css('color', 'green');
            sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty + ' ✓');
            submitBtn.show();
        } else if (exceededTarget) {
            sumDisplay.css('color', 'orange');
            sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty + ' ⚠️ Quantity exceeds target! Add another tank or reduce quantity.');
            submitBtn.hide();
        } else {
            sumDisplay.css('color', 'red');
            if (totalSum > targetQty && targetQty > 0) {
                sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty + ' ⚠️ Exceeds target');
            } else if (hasError) {
                sumDisplay.html('Total: ' + totalSum + ' | Target: ' + targetQty + ' ⚠️ Enter use numbers');
            }
            submitBtn.hide();
        }
    }

    function addMoreTanks() {
        let originalRow = $('.tank-row').first().clone();
        originalRow.find('select').val('');
        originalRow.find('.qty').val('');
        originalRow.find('.qty').prop('readonly', false);
        originalRow.find('.use-number-input').val('');
        originalRow.find('.useno-display').val('');
        originalRow.find('.useno-hidden').val('');
        originalRow.find('.useno-hint').text(getUseNumberHint(null)).css('color', '#888');
        originalRow.find('.errorMsg').hide();
        originalRow.find('.tankno').prop('disabled', false);
        $('#tankContainer').append(originalRow);
        checkOverallSum();
        
        // Flash message if target is exceeded
        let totalSum = 0;
        $('.qty').each(function() {
            let val = parseInt($(this).val()) || 0;
            totalSum += val;
        });
        
        if (totalSum > dynamicTarget && dynamicTarget > 0) {
            $('#totalSumDisplay').fadeOut(200).fadeIn(200);
        }
    }

    $(document).on('change', '.tankno', function() {
        let row = $(this).closest('.tank-row');
        row.find('.qty').val('');
        row.find('.use-number-input').val('');
        row.find('.useno-display').val('');
        row.find('.useno-hidden').val('');
        row.find('.useno-hint').text(getUseNumberHint(null)).css('color', '#888');
        row.find('.errorMsg').hide();
        checkOverallSum();
    });

    $(document).on('input', '.qty', function() {
        let row = $(this).closest('.tank-row');
        let val = parseInt($(this).val()) || 0;
        let errorMsg = row.find('.errorMsg');
        let totalSum = 0;
        
        // Calculate current total
        $('.qty').each(function() {
            let currentVal = parseInt($(this).val()) || 0;
            totalSum += currentVal;
        });

        // Check max limit per tank
        if (val > MAX_QTY_PER_TANK) {
            errorMsg.text('❌ Quantity cannot exceed ' + MAX_QTY_PER_TANK + '! Maximum allowed is ' + MAX_QTY_PER_TANK + '.');
            errorMsg.show();
            $(this).val(MAX_QTY_PER_TANK);
            setTimeout(function() {
                errorMsg.fadeOut(3000);
            }, 3000);
        } 
        else if (val < 0) {
            errorMsg.text('Quantity cannot be negative');
            errorMsg.show();
            $(this).val(0);
        } 
        else if (totalSum > dynamicTarget && dynamicTarget > 0 && val > 0) {
            // Show simple message when exceeding target
            errorMsg.text('⚠️ Quantity exceeds target! Add another tank or reduce quantity.');
            errorMsg.show();
            setTimeout(function() {
                errorMsg.fadeOut(3000);
            }, 3000);
        } 
        else {
            errorMsg.hide();
        }
        checkOverallSum();
    });

    $(document).on('input', '.use-number-input', function() {
        let row = $(this).closest('.tank-row');
        autoGenerateUseNumber(row);
        checkOverallSum();
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.tank-row').length > 1) {
            $(this).closest('.tank-row').remove();
            checkOverallSum();
            
            // Check if total still exceeds after removal
            let totalSum = 0;
            $('.qty').each(function() {
                let val = parseInt($(this).val()) || 0;
                totalSum += val;
            });
            
            if (totalSum > dynamicTarget && dynamicTarget > 0) {
                $('#totalSumDisplay').css('color', 'orange');
                $('#totalSumDisplay').html('Total: ' + totalSum + ' | Target: ' + dynamicTarget + ' ⚠️ Quantity exceeds target! Add another tank or reduce quantity.');
            }
        } else {
            alert('At least one tank row is required');
        }
    });

    $('#addMoreBtn').on('click', function() {
        addMoreTanks();
    });

    $('#tankForm').on('submit', function(e) {
        let targetQty = dynamicTarget;
        let totalSum = 0;
        let hasExactMatch = false;
        let tankArray = [];
        let qtyArray = [];
        let usenoArray = [];
        let hasError = false;
        let exceededTarget = false;
        let exceededMaxQty = false;

        if (targetQty <= 0) {
            e.preventDefault();
            alert('No target quantity configured');
            return false;
        }

        $('.tank-row').each(function(index) {
            let tankSelect = $(this).find('.tankno').val();
            let addQty = parseInt($(this).find('.qty').val()) || 0;
            let usenoValue = $(this).find('.useno-hidden').val() || '';

            if (tankSelect && addQty > 0) {
                // Check max limit per tank
                if (addQty > MAX_QTY_PER_TANK) {
                    alert('❌ Row ' + (index + 1) + ': Quantity (' + addQty + ') exceeds maximum allowed (' + MAX_QTY_PER_TANK + ') per tank!');
                    exceededMaxQty = true;
                    return false;
                }
                
                tankArray.push(tankSelect);
                qtyArray.push(addQty);
                usenoArray.push(usenoValue);
                totalSum += addQty;

                if (addQty === targetQty) {
                    hasExactMatch = true;
                }

                if (usenoValue === '') {
                    alert('Error: Row ' + (index + 1) + ' use number is required! Enter 0,1,2,3...');
                    hasError = true;
                    return false;
                }
            }
        });

        if (exceededMaxQty) {
            e.preventDefault();
            return false;
        }

        if (hasError) {
            e.preventDefault();
            return false;
        }

        if (tankArray.length === 0) {
            e.preventDefault();
            alert('Please add at least one tank with quantity');
            return false;
        }

        // Check if total exceeds target
        if (totalSum > targetQty && !hasExactMatch) {
            e.preventDefault();
            alert('⚠️ Total quantity (' + totalSum + ') exceeds target (' + targetQty + ')!\n\nPlease add another tank or reduce the quantity.');
            return false;
        }

        if (totalSum !== targetQty && !hasExactMatch) {
            e.preventDefault();
            alert('Total (' + totalSum + ') must equal ' + targetQty + ' OR any field = ' + targetQty);
            return false;
        }

        $('#hiddenTankno').val(tankArray.join(';'));
        $('#hiddenAddqty').val(qtyArray.join(';'));
        $('#hiddenUseno').val(usenoArray.join(';'));

        return true;
    });

    // Initial check
    checkOverallSum();
});
</script>
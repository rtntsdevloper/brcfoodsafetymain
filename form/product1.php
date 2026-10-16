<?php
include 'connection.php';
$bid = isset($_GET['bid']) ? $_GET['bid'] : '';

// Load data if in draft mode for display
if (isset($_GET['draft']) && $_GET['draft'] == 'draft' && !empty($bid)) {
    $sq = mysqli_query($con, "SELECT * FROM tblproductpacking where id = '$bid'");
    $row = mysqli_fetch_assoc($sq);
    $is_draft = true;

    // Load existing pallet data if available
    $existing_pallets = array();
    if (!empty($row['palletserial'])) {
        $palletserial = json_decode($row['palletserial'], true);
        $palletnumber = json_decode($row['palletnumber'], true);
        $box = json_decode($row['box'], true);
        $pstart = json_decode($row['pstart'], true);

        // Combine into array of pallets
        $pallet_count = max(count($palletserial), count($palletnumber), count($box), count($pstart));
        for ($i = 0; $i < $pallet_count; $i++) {
            $existing_pallets[] = array(
                'serial' => isset($palletserial[$i]) ? $palletserial[$i] : '',
                'number' => isset($palletnumber[$i]) ? $palletnumber[$i] : '',
                'box' => isset($box[$i]) ? $box[$i] : '',
                'start' => isset($pstart[$i]) ? $pstart[$i] : ''
            );
        }
    }
} else {
    $is_draft = false;
    $existing_pallets = array(array('serial' => '', 'number' => '', 'box' => '', 'start' => ''));
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>PRODUCT PACKING RECORD CHECK SHEET</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Product Packing Record Check Sheet</h4>
                <a href="admin.php?id=product"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- SINGLE FORM FOR BOTH DRAFT AND NEW -->
                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="" id="packingForm">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date <span style="color:red">*</span></label>
                            <input class="form-control" id="validationTooltip01" type="date" value="<?php echo $is_draft ? $row['date'] : ''; ?>" name="date" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Ink Jet Code <span style="color:red">*</span></label>
                            <input type="text" name="inkjet" class="form-control" value="<?php echo $is_draft ? $row['inkjet'] : ''; ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Packaging Start Time <span style="color:red">*</span></label>
                            <input class="form-control" id="validationTooltip01" type="time" name="stime" value="<?php echo $is_draft ? $row['stime'] : ''; ?>" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Packaging End Time <span style="color:red">*</span></label>
                            <input class="form-control" id="validationTooltip01" type="time" name="etime" value="<?php echo $is_draft ? $row['etime'] : ''; ?>" />
                        </div>
                    </div>

                    <fieldset style="border:2px solid #333; padding:15px; border-radius:8px; margin:20px 0;">
                        <legend style="font-weight:bold; padding:0 15px; color:#333; font-size:16px; background-color:#f8f9fa;">
                            Inner/Outer Packaging Label
                        </legend>

                        <div class="row" style="display:flex; flex-wrap:wrap; margin:0 -10px;">
                            <!-- Left column -->
                            <div class="col-md-6" style="flex:0 0 50%; max-width:50%; padding:0 10px;">
                                <fieldset style="border:2px solid #666; padding:15px; border-radius:6px; height:100%; background-color:#f8f9fa;">
                                    <legend style="padding:0 10px; color:#333; font-weight:bold; font-size:13px; background-color:#fff; border:1px solid #ccc;">
                                        Inner Packaging Label
                                    </legend>


                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Inner Packaging Label</label>
                                        <input type="file" class="form-control form-control-sm" name="iimg" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['iimg'])): ?>
                                            <small>Current: <?php echo basename($row['iimg']); ?></small>
                                            <input type="hidden" name="existing_iimg" value="<?php echo $row['iimg']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Number of Label Printed</label>
                                        <input type="text" class="form-control form-control-sm" name="iprinted" value="<?php echo $is_draft ? $row['iprinted'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>
                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload Number of Label Printed</label>
                                        <input type="file" class="form-control form-control-sm" name="uprinted" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uprinted'])): ?>
                                            <small>Current: <?php echo basename($row['uprinted']); ?></small>
                                            <input type="hidden" name="existing_uprinted" value="<?php echo $row['uprinted']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Number of Label Used</label>
                                        <input type="text" class="form-control form-control-sm" name="iused" value="<?php echo $is_draft ? $row['iused'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>


                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload Number of Label Used</label>
                                        <input type="file" class="form-control form-control-sm" name="uused" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uused'])): ?>
                                            <small>Current: <?php echo basename($row['uused']); ?></small>
                                            <input type="hidden" name="existing_uused" value="<?php echo $row['uused']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">No. of Label Discard</label>
                                        <input type="text" class="form-control form-control-sm" name="idiscard" value="<?php echo $is_draft ? $row['idiscard'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>


                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload No. of Label Discard</label>
                                        <input type="file" class="form-control form-control-sm" name="udiscard" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['udiscard'])): ?>
                                            <small>Current: <?php echo basename($row['udiscard']); ?></small>
                                            <input type="hidden" name="existing_udiscard" value="<?php echo $row['udiscard']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload start Label </label>
                                        <input type="file" class="form-control form-control-sm" name="uistart" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uistart'])): ?>
                                            <small>Current: <?php echo basename($row['uistart']); ?></small>
                                            <input type="hidden" name="existing_uistart" value="<?php echo $row['uistart']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload end Label </label>
                                        <input type="file" class="form-control form-control-sm" name="uiend" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uiend'])): ?>
                                            <small>Current: <?php echo basename($row['uiend']); ?></small>
                                            <input type="hidden" name="existing_uiend" value="<?php echo $row['uiend']; ?>">
                                        <?php endif; ?>
                                    </div>


                                </fieldset>
                            </div>

                            <!-- Right column -->
                            <div class="col-md-6" style="flex:0 0 50%; max-width:50%; padding:0 10px;">
                                <fieldset style="border:2px solid #666; padding:15px; border-radius:6px; height:100%; background-color:#f8f9fa;">
                                    <legend style="padding:0 10px; color:#333; font-weight:bold; font-size:13px; background-color:#fff; border:1px solid #ccc;">
                                        Outer Packaging Label
                                    </legend>


                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Outer Packaging Label</label>
                                        <input type="file" class="form-control form-control-sm" name="oimg" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['oimg'])): ?>
                                            <small>Current: <?php echo basename($row['oimg']); ?></small>
                                            <input type="hidden" name="existing_oimg" value="<?php echo $row['oimg']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Number of Label Printed</label>
                                        <input type="text" class="form-control form-control-sm" name="oprint" value="<?php echo $is_draft ? $row['oprint'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload Number of Label Printed</label>
                                        <input type="file" class="form-control form-control-sm" name="uoprint" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uoprint'])): ?>
                                            <small>Current: <?php echo basename($row['uoprint']); ?></small>
                                            <input type="hidden" name="existing_uoprint" value="<?php echo $row['uoprint']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Number of Label Used</label>
                                        <input type="text" class="form-control form-control-sm" name="oused" value="<?php echo $is_draft ? $row['oused'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>


                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload Number of Label Used</label>
                                        <input type="file" class="form-control form-control-sm" name="uoused" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uoused'])): ?>
                                            <small>Current: <?php echo basename($row['uoused']); ?></small>
                                            <input type="hidden" name="existing_uoused" value="<?php echo $row['uoused']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">No. of Label Discard</label>
                                        <input type="text" class="form-control form-control-sm" name="odiscard" value="<?php echo $is_draft ? $row['odiscard'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload No. of Label Discard</label>
                                        <input type="file" class="form-control form-control-sm" name="uodiscard" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uodiscard'])): ?>
                                            <small>Current: <?php echo basename($row['uodiscard']); ?></small>
                                            <input type="hidden" name="existing_uodiscard" value="<?php echo $row['uodiscard']; ?>">
                                        <?php endif; ?>
                                    </div>

                                     <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload start Label </label>
                                        <input type="file" class="form-control form-control-sm" name="uostart" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uostart'])): ?>
                                            <small>Current: <?php echo basename($row['uostart']); ?></small>
                                            <input type="hidden" name="existing_uostart" value="<?php echo $row['uostart']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group" style="margin-bottom:15px;">
                                        <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Upload end Label </label>
                                        <input type="file" class="form-control form-control-sm" name="uoend" accept="image/*,application/pdf" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        <?php if ($is_draft && !empty($row['uoend'])): ?>
                                            <small>Current: <?php echo basename($row['uoend']); ?></small>
                                            <input type="hidden" name="existing_uoend" value="<?php echo $row['uoend']; ?>">
                                        <?php endif; ?>
                                    </div>

                                    
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="border:2px solid #333; padding:15px; border-radius:8px; margin:20px 0;">
                        <legend style="font-weight:bold; padding:0 15px; color:#333; font-size:16px; background-color:#f8f9fa;">
                            Label checks at (initial all that apply)
                        </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Start of Run (Checked By)</label>
                                <input type="text" class="form-control form-control-sm" name="start" value="<?php echo $is_draft ? $row['start'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Mid Run (Checked By)</label>
                                <input type="text" class="form-control form-control-sm" name="mid" value="<?php echo $is_draft ? $row['mid'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">End of Run (Checked By)</label>
                                <input type="text" class="form-control form-control-sm" name="end" value="<?php echo $is_draft ? $row['end'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Packaging Batch Change (Checked By)</label>
                                <input type="text" class="form-control form-control-sm" name="batch" value="<?php echo $is_draft ? $row['batch'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset style="border:2px solid #333; padding:15px; border-radius:8px; margin:20px 0;">
                        <legend style="font-weight:bold; padding:0 15px; color:#333; font-size:16px; background-color:#f8f9fa;">
                            Product Details
                        </legend>

                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Julien code</label>
                                <input type="text" class="form-control form-control-sm" name="julien" value="<?php echo $is_draft ? $row['julien'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Best before or use by date</label>
                                <input type="text" class="form-control form-control-sm" name="buse" value="<?php echo $is_draft ? $row['buse'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Units per box</label>
                                <input type="text" class="form-control form-control-sm" name="unit" value="<?php echo $is_draft ? $row['unit'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Number of units packed in last box</label>
                                <input type="text" class="form-control form-control-sm" name="pack" value="<?php echo $is_draft ? $row['pack'] : ''; ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            </div>

                            <div class="col-md-12">
                                <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Comments</label>
                                <textarea name="comments" id="comments" class="form-control form-control-sm" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;"><?php echo $is_draft ? $row['comments'] : ''; ?></textarea>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Pallet Details Section with Add More functionality -->
                    <fieldset style="border:2px solid #333; padding:15px; border-radius:8px; margin:20px 0;">
                        <legend style="font-weight:bold; padding:0 15px; color:#333; font-size:16px; background-color:#f8f9fa;">
                            Pallet Details
                            <button type="button" id="addPalletBtn" class="btn btn-sm btn-success" style="float:right; margin-left:10px;">
                                <i class="fa fa-plus"></i> Add More Pallet
                            </button>
                        </legend>

                        <div id="palletContainer">
                            <?php
                            // Display existing pallets
                            $pallet_counter = 0;
                            foreach ($existing_pallets as $index => $pallet):
                            ?>
                                <div class="pallet-entry" id="palletEntry_<?php echo $index; ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Pallet serial number</label>
                                            <input type="text" class="form-control form-control-sm pallet-serial" name="palletserial[]" value="<?php echo htmlspecialchars($pallet['serial']); ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Pallet number</label>
                                            <input type="text" class="form-control form-control-sm pallet-number" name="palletnumber[]" value="<?php echo htmlspecialchars($pallet['number']); ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">No. boxes on pallet</label>
                                            <input type="text" class="form-control form-control-sm pallet-box" name="box[]" value="<?php echo htmlspecialchars($pallet['box']); ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Start time, e.g. 07:20</label>
                                            <input type="time" class="form-control form-control-sm pallet-time" name="pstart[]" value="<?php echo htmlspecialchars($pallet['start']); ?>" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                                            <?php if ($index > 0): ?>
                                                <span class="remove-pallet" onclick="removePallet(<?php echo $index; ?>)">×</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <hr style="margin: 15px 0; border-color: #ddd;">
                                </div>
                            <?php
                                $pallet_counter = $index;
                            endforeach;
                            ?>
                        </div>
                    </fieldset>

                    <!-- Hidden field for bid if updating draft -->
                    <?php if ($is_draft): ?>
                        <input type="hidden" name="bid" value="<?php echo $bid; ?>">
                    <?php endif; ?>

                    <!-- Hidden field for pallet counter -->
                    <input type="hidden" id="palletCounter" value="<?php echo $pallet_counter; ?>">

                    <!-- Submit buttons INSIDE the form -->
                    <div style="margin-top: 20px; text-align: center;">
                        <button class="btn btn-secondary" type="submit" name="save_draft">Save as Draft</button>
                        <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .remove-pallet {
        color: #dc3545;
        cursor: pointer;
        font-size: 20px;
        float: right;
        margin-top: -5px;
    }

    .remove-pallet:hover {
        color: #bd2130;
    }
</style>

<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize pallet counter from hidden field
        let palletCounter = document.getElementById('palletCounter') ? parseInt(document.getElementById('palletCounter').value) : 0;

        // Get the add button
        const addPalletBtn = document.getElementById('addPalletBtn');

        if (addPalletBtn) {
            addPalletBtn.addEventListener('click', function() {
                palletCounter++;
                const palletContainer = document.getElementById('palletContainer');

                if (palletContainer) {
                    const newPalletEntry = document.createElement('div');
                    newPalletEntry.className = 'pallet-entry';
                    newPalletEntry.id = 'palletEntry_' + palletCounter;

                    newPalletEntry.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Pallet serial number</label>
                            <input type="text" class="form-control form-control-sm pallet-serial" name="palletserial[]" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Pallet number</label>
                            <input type="text" class="form-control form-control-sm pallet-number" name="palletnumber[]" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">No. boxes on pallet</label>
                            <input type="text" class="form-control form-control-sm pallet-box" name="box[]" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:12px; font-weight:bold; display:block; margin-bottom:5px;">Start time, e.g. 07:20</label>
                            <input type="time" class="form-control form-control-sm pallet-time" name="pstart[]" style="width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:12px;">
                            <span class="remove-pallet" onclick="removePallet(${palletCounter})">×</span>
                        </div>
                    </div>
                    <hr style="margin: 15px 0; border-color: #ddd;">
                `;

                    palletContainer.appendChild(newPalletEntry);
                }
            });
        }

        // Handle form submission for validation
        const form = document.getElementById('packingForm');

        if (form) {
            // Add event listener to the submit button (final submission)
            const submitBtn = form.querySelector('button[name="submit"]');

            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    // Validate required fields for final submission
                    const requiredFields = ['date', 'inkjet', 'stime', 'etime'];
                    let isValid = true;

                    requiredFields.forEach(fieldName => {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field && !field.value.trim()) {
                            isValid = false;
                            field.style.borderColor = 'red';
                        } else if (field) {
                            field.style.borderColor = '';
                        }
                    });

                    if (!isValid) {
                        e.preventDefault(); // Prevent form submission
                        alert('Please fill all required fields marked with *: Date, Ink Jet Code, Start Time, and End Time are required.');
                        return false;
                    }

                    // If valid, allow form submission
                    return true;
                });
            }

            // Add event listener to the draft button
            const draftBtn = form.querySelector('button[name="save_draft"]');

            if (draftBtn) {
                draftBtn.addEventListener('click', function(e) {
                    // No validation for draft - allow empty fields
                    // The form will submit normally
                    return true;
                });
            }
        }
    });

    // Make function global
    function removePallet(id) {
        const palletEntry = document.getElementById('palletEntry_' + id);
        if (palletEntry) {
            palletEntry.remove();
        }
    }
</script>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which button was clicked
    $is_draft_submission = isset($_POST['save_draft']);
    $is_final_submission = isset($_POST['submit']);

    // Check if this is an update (has bid)
    $update_bid = isset($_POST['bid']) ? $_POST['bid'] : '';

    // Load existing record data if updating
    $existing_files = array();
    if (!empty($update_bid)) {
        $check_sql = mysqli_query($con, "SELECT * FROM tblproductpacking WHERE id = '$update_bid'");
        if ($check_row = mysqli_fetch_assoc($check_sql)) {
            $existing_files = $check_row;
        }
    }

    // File upload directory
    $upload_dir = "form/upl1/";

    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique ID for this submission
    $unique_id = uniqid() . '_' . time();

    // Enhanced function to upload file with error handling
    function uploadUniqueFile($file_input, $upload_dir, $unique_id, $prefix, $existing_file = '') {
        $result = array('success' => false, 'filename' => '', 'error' => '');
        
        try {
            if (isset($_FILES[$file_input]) && isset($_FILES[$file_input]['error']) && $_FILES[$file_input]['error'] === UPLOAD_ERR_OK && !empty($_FILES[$file_input]['name'])) {
                
                // Check file size (max 5MB)
                if ($_FILES[$file_input]['size'] > 5 * 1024 * 1024) {
                    $result['error'] = "File size exceeds 5MB limit";
                    return $result;
                }
                
                $ext = strtolower(pathinfo($_FILES[$file_input]['name'], PATHINFO_EXTENSION));
                // Allowed extensions
                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
                
                if (in_array($ext, $allowed)) {
                    // Create unique filename
                    $filename = $unique_id . '_' . $prefix . '.' . $ext;
                    $full_path = $upload_dir . $filename;
                    
                    if (move_uploaded_file($_FILES[$file_input]['tmp_name'], $full_path)) {
                        $result['success'] = true;
                        $result['filename'] = $filename;
                        return $result;
                    } else {
                        $result['error'] = "Failed to move uploaded file";
                        return $result;
                    }
                } else {
                    $result['error'] = "Invalid file type. Allowed: " . implode(', ', $allowed);
                    return $result;
                }
            } else {
                // No file uploaded or error occurred
                if (isset($_FILES[$file_input]['error']) && $_FILES[$file_input]['error'] !== UPLOAD_ERR_NO_FILE) {
                    $result['error'] = "Upload error code: " . $_FILES[$file_input]['error'];
                }
                
                // Return existing filename if provided
                if (!empty($existing_file)) {
                    $result['success'] = true;
                    $result['filename'] = basename($existing_file);
                }
                return $result;
            }
        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            return $result;
        }
    }

    // Process all file uploads with error checking
    $file_fields = array(
        'iimg' => 'inner_label',
        'oimg' => 'outer_label',
        'uprinted' => 'inner_printed',
        'uused' => 'inner_used',
        'udiscard' => 'inner_discard',
        'uoprint' => 'outer_printed',
        'uoused' => 'outer_used',
        'uodiscard' => 'outer_discard',
        'uistart' => 'start_label',
        'uiend' => 'end_label',
        'uostart' => 'outer_start_label',
        'uoend' => 'outer_end_label'
    );
    
    $uploaded_files = array();
    $upload_errors = array();
    
    foreach ($file_fields as $field_name => $prefix) {
        $existing_value = isset($existing_files[$field_name]) ? $existing_files[$field_name] : '';
        $result = uploadUniqueFile($field_name, $upload_dir, $unique_id, $prefix, $existing_value);
        
        if ($result['success']) {
            $uploaded_files[$field_name] = $result['filename'];
        } else {
            $upload_errors[$field_name] = $result['error'];
            // Keep existing file if available
            $uploaded_files[$field_name] = !empty($existing_value) ? basename($existing_value) : '';
        }
    }
    
    // Show upload errors if any (but continue with submission)
    if (!empty($upload_errors)) {
        $error_messages = array();
        foreach ($upload_errors as $field => $error) {
            if (!empty($error)) {
                $error_messages[] = ucfirst(str_replace('_', ' ', $field)) . ": " . $error;
            }
        }
        if (!empty($error_messages)) {
            echo "<script>alert('Some files could not be uploaded:\\n" . implode("\\n", $error_messages) . "');</script>";
        }
    }

    // Collect form data
    $date = isset($_POST['date']) ? mysqli_real_escape_string($con, $_POST['date']) : '';
    $inkjet = isset($_POST['inkjet']) ? mysqli_real_escape_string($con, $_POST['inkjet']) : '';
    $stime = isset($_POST['stime']) ? mysqli_real_escape_string($con, $_POST['stime']) : '';
    $etime = isset($_POST['etime']) ? mysqli_real_escape_string($con, $_POST['etime']) : '';

    // Inner Packaging Label
    $iprinted = isset($_POST['iprinted']) ? mysqli_real_escape_string($con, $_POST['iprinted']) : '';
    $iused = isset($_POST['iused']) ? mysqli_real_escape_string($con, $_POST['iused']) : '';
    $idiscard = isset($_POST['idiscard']) ? mysqli_real_escape_string($con, $_POST['idiscard']) : '';

    // Outer Packaging Label
    $oprint = isset($_POST['oprint']) ? mysqli_real_escape_string($con, $_POST['oprint']) : '';
    $oused = isset($_POST['oused']) ? mysqli_real_escape_string($con, $_POST['oused']) : '';
    $odiscard = isset($_POST['odiscard']) ? mysqli_real_escape_string($con, $_POST['odiscard']) : '';

    // Label checks
    $start = isset($_POST['start']) ? mysqli_real_escape_string($con, $_POST['start']) : '';
    $mid = isset($_POST['mid']) ? mysqli_real_escape_string($con, $_POST['mid']) : '';
    $end_run = isset($_POST['end']) ? mysqli_real_escape_string($con, $_POST['end']) : '';
    $batch_change = isset($_POST['batch']) ? mysqli_real_escape_string($con, $_POST['batch']) : '';

    // Product Details
    $julien = isset($_POST['julien']) ? mysqli_real_escape_string($con, $_POST['julien']) : '';
    $buse = isset($_POST['buse']) ? mysqli_real_escape_string($con, $_POST['buse']) : '';
    $unit = isset($_POST['unit']) ? mysqli_real_escape_string($con, $_POST['unit']) : '';
    $pack = isset($_POST['pack']) ? mysqli_real_escape_string($con, $_POST['pack']) : '';
    $comments = isset($_POST['comments']) ? mysqli_real_escape_string($con, $_POST['comments']) : '';

    // Pallet Details - Convert arrays to JSON strings
    $palletserial_json = isset($_POST['palletserial']) ? json_encode($_POST['palletserial']) : '[]';
    $palletnumber_json = isset($_POST['palletnumber']) ? json_encode($_POST['palletnumber']) : '[]';
    $box_json = isset($_POST['box']) ? json_encode($_POST['box']) : '[]';
    $pstart_json = isset($_POST['pstart']) ? json_encode($_POST['pstart']) : '[]';

    // Determine status and validation
    if ($is_draft_submission) {
        $status = 'draft';
        $isValid = true;
    } else {
        $status = 'completed';
        if (empty($date) || empty($inkjet) || empty($stime) || empty($etime)) {
            echo "<script>alert('Please fill all required fields: Date, Ink Jet Code, Start Time, and End Time are required.');</script>";
            $isValid = false;
        } else {
            $isValid = true;
        }
    }

    // Only insert/update if valid
    if ($isValid) {
        if (!empty($update_bid)) {
            // UPDATE existing record
            $sql = "UPDATE tblproductpacking SET
                date = '$date',
                inkjet = '$inkjet',
                stime = '$stime',
                etime = '$etime',
                iprinted = '$iprinted',
                iused = '$iused',
                idiscard = '$idiscard',
                iimg = '{$uploaded_files['iimg']}',
                uprinted = '{$uploaded_files['uprinted']}',
                uused = '{$uploaded_files['uused']}',
                udiscard = '{$uploaded_files['udiscard']}',
                oprint = '$oprint',
                oused = '$oused',
                odiscard = '$odiscard',
                oimg = '{$uploaded_files['oimg']}',
                uoprint = '{$uploaded_files['uoprint']}',
                uoused = '{$uploaded_files['uoused']}',
                uodiscard = '{$uploaded_files['uodiscard']}',
                uistart = '{$uploaded_files['uistart']}',
                uiend = '{$uploaded_files['uiend']}',
                uostart = '{$uploaded_files['uostart']}',
                uoend = '{$uploaded_files['uoend']}',
                start = '$start',
                mid = '$mid',
                `end` = '$end_run',
                `batch` = '$batch_change',
                julien = '$julien',
                buse = '$buse',
                unit = '$unit',
                pack = '$pack',
                comments = '$comments',
                palletserial = '$palletserial_json',
                palletnumber = '$palletnumber_json',
                box = '$box_json',
                pstart = '$pstart_json',
                draft = '$status'
            WHERE id = '$update_bid'";

            if (mysqli_query($con, $sql)) {
                if ($is_draft_submission) {
                    echo "<script>alert('Draft updated successfully!');</script>";
                    echo "<script>window.location.href='admin.php?id=product&draft=draft&bid=" . $update_bid . "';</script>";
                } else {
                    echo "<script>alert('Record updated and marked as completed!');</script>";
                    echo "<script>window.location.href='admin.php?id=product&rid=" . $update_bid . "';</script>";
                }
            } else {
                echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
            }
        } else {
            // INSERT new record
            $record_id = 'PPR-' . rand(1000, 9999);

            $sql = "INSERT INTO tblproductpacking (
                recordid, date, inkjet, stime, etime, 
                iprinted, iused, idiscard, iimg,
                uprinted, uused, udiscard,
                oprint, oused, odiscard, oimg,
                uoprint, uoused, uodiscard,
                uistart, uiend, uostart, uoend,
                start, mid, `end`, `batch`,
                julien, buse, unit, pack, comments,
                palletserial, palletnumber, box, pstart,
                draft
            ) 
            VALUES (
                '$record_id', '$date', '$inkjet', '$stime', '$etime',
                '$iprinted', '$iused', '$idiscard', '{$uploaded_files['iimg']}',
                '{$uploaded_files['uprinted']}', '{$uploaded_files['uused']}', '{$uploaded_files['udiscard']}',
                '$oprint', '$oused', '$odiscard', '{$uploaded_files['oimg']}',
                '{$uploaded_files['uoprint']}', '{$uploaded_files['uoused']}', '{$uploaded_files['uodiscard']}',
                '{$uploaded_files['uistart']}', '{$uploaded_files['uiend']}', '{$uploaded_files['uostart']}', '{$uploaded_files['uoend']}',
                '$start', '$mid', '$end_run', '$batch_change',
                '$julien', '$buse', '$unit', '$pack', '$comments',
                '$palletserial_json', '$palletnumber_json', '$box_json', '$pstart_json',
                '$status'
            )";

            if (mysqli_query($con, $sql)) {
                $new_id = mysqli_insert_id($con);
                if ($is_draft_submission) {
                    echo "<script>alert('Draft saved successfully!');</script>";
                    echo "<script>window.location.href='admin.php?id=product&draft=draft&bid=" . $new_id . "';</script>";
                } else {
                    echo "<script>alert('Product packing record added successfully!');</script>";
                    echo "<script>window.location.href='admin.php?id=product&rid=" . $record_id . "';</script>";
                }
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}
?>
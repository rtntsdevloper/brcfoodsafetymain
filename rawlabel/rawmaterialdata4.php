<?php


$rid = $_GET['rid'];
$sq = mysqli_query($con, "SELECT * FROM tblrawdata WHERE raw='$rid'");
$rowp = mysqli_fetch_assoc($sq);


$rawd = mysqli_query($con, "SELECT s1.supname as supname,p1.pcode as pcode, p1.pname as pname FROM `tblrawmaterial`as p1 join tblrawsupplier as s1 on p1.supid = s1.supid where p1.id ='" . $rid . "'");
$rawd1 = mysqli_fetch_array($rawd);


$prodbtt = array(
    ['name' => "Front Label", 'column' => "frontlabel", 'icon' => "fa fa-image"],
    ['name' => "Back Label", 'column' => "backlabel", 'icon' => "fa fa-image"],
    ['name' => "Outer Label", 'column' => "outerlabel", 'icon' => "fa fa-image"],
    ['name' => "Specification", 'column' => "specification", 'icon' => "fa fa-image"]
);
?>





<style>
    /* custom spacing and subtle transitions for cards */
    .product-card {
        transition: all 0.2s ease;
        border-radius: 0.75rem;
    }

    .product-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }

    .dropdown-detail-table {
        background-color: #f8f9fc;
        border-radius: 0.5rem;
        margin-top: 0.75rem;
        padding: 0;
        overflow-x: auto;
    }

    .detail-table {
        margin-bottom: 0;
        background-color: white;
        border-radius: 0.5rem;
    }

    .detail-table th {
        background-color: #e9ecef;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-table td {
        vertical-align: middle;
    }

    .dropdown-icon {
        cursor: pointer;
        transition: transform 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #f1f3f5;
    }

    .dropdown-icon:hover {
        background-color: #e2e6ea;
    }

    .dropdown-icon.rotated i {
        transform: rotate(180deg);
    }

    .dropdown-icon i {
        transition: transform 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        font-size: 1.1rem;
        color: #2c3e66;
    }

    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.25rem;
    }

    .list-group-item {
        border-left: none;
        border-right: none;
        padding: 1rem 1.25rem;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .badge-category {
        background-color: #eef2ff;
        color: #1e3a8a;
        font-weight: normal;
        padding: 0.3rem 0.7rem;
        border-radius: 30px;
        font-size: 0.75rem;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div class="container-fluid " style="margin-top:50px;">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=rawmaterialdata"><button class="btn btn-success"
                            style="float:right; margin-left:15px"><i class="bi bi-arrow-left-circle"></i> Go
                            Back</button></a>




                    <h4 class="card-title mb-3">Raw Material Labels History</h4>
                    <br>

                    <div class="container-fluid">
                        <!-- header -->
                        <div class="text-center mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="fa fa-cubes" style="font-size:22px;"></i>

                                        </div>
                                        <div class="detail-content">
                                            <h4 class="text-primary">Raw Material Name </h4>
                                            <h6 id="displayRawMaterial"><?php echo $rawd1['pname']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="bi bi-upc-scan" style="font-size:22px;"></i>
                                        </div>
                                        <div class="detail-content">
                                            <h4 class="text-primary">Product Code </h4>
                                            <h6> <?php echo $rawd1['pcode']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <i class="bi bi-building" style="font-size:22px;"></i>
                                        </div>
                                        <div class="detail-content">
                                            <h4 class="text-primary">Supplier Name </h4>
                                            <h6 id="displaySupplier"><?php echo $rawd1['supname']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PRODUCT LIST (card based) -->
                        <div class="card shadow-sm border-0 rounded-lg">

                            <div class="list-group list-group-flush">
                                <?php
                                $i = 0;
                                foreach ($prodbtt as $value) {

                                    $i++;
                                ?>

                                    <!-- Product 1 -->
                                    <div class="list-group-item product-card">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3 bg-light rounded-circle p-2" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-image text-primary"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0 font-weight-bold"><?php echo $value['name']; ?></h5>

                                                </div>
                                            </div>
                                            <div class="dropdown-icon" data-target="detail-<?php echo $i; ?>">
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <!-- hidden detail table container -->
                                        <div id="detail-<?php echo $i; ?>" class="dropdown-detail-table mt-3" style="display: none;">
                                            <table class="table table-sm detail-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>S No.</th>
                                                        <th>Uploaded File</th>
                                                        <th>Upload On</th>
                                                        <th>Upload By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $pdtype = $value['column'];
                                                    $sql = mysqli_query($con, "SELECT * FROM `tblrawdata1` WHERE type ='$pdtype' and rid='$rid'");
                                                    $ix = 1;
                                                    while ($row = mysqli_fetch_array($sql)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $ix; ?></td>
                                                            <td>
                                                                <?php
                                                                $dbFileName1 = $rowp['frontlabel'];

                                                                // Get extension
                                                                $extension1 = pathinfo($dbFileName1, PATHINFO_EXTENSION);

                                                                if ($extension1 == 'pdf') {
                                                                    echo '<a href="rawlabel/pdf/' . $row['image'] . '">View Report</a>';
                                                                } else {
                                                                    echo '<a href="rawlabel/pdf/' . $row['image'] . '"><img src="rawlabel/pdf/' . $row['image'] . '" alt="" width="100px" height="100px"></a>';
                                                                }
                                                                ?>


                                                            </td>
                                                            <td><?php echo date("d-m-Y", strtotime($row['uploadon'])); ?></td>
                                                            <td><?php echo $row['user']; ?></td>
                                                        </tr>


                                                    <?php

                                                        $ix++;
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="list-group-item product-card">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 bg-light rounded-circle p-2" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-image text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 font-weight-bold">Product Images</h5>

                                            </div>
                                        </div>
                                        <div class="dropdown-icon" data-target="detail-<?php echo $i + 1; ?>">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>
                                    <!-- hidden detail table container -->
                                    <div id="detail-<?php echo $i + 1; ?>" class="dropdown-detail-table mt-3" style="display: none;">
                                        <table class="table table-sm detail-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>S No.</th>
                                                    <th>Uploaded File</th>
                                                    <th>Upload On</th>
                                                    <th>Upload By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $sql = mysqli_query($con, "SELECT * FROM `tblrawdata1` WHERE type ='product' and rid='$rid'");
                                                $ix = 1;
                                                while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $ix; ?></td>
                                                        <td>
                                                            <?php
                                                            $dbFileName1 = $rowp['frontlabel'];

                                                            // Get extension
                                                            $extension1 = pathinfo($dbFileName1, PATHINFO_EXTENSION);

                                                            if ($extension1 == 'pdf') {
                                                                echo '<a href="rawlabel/pdf/' . $row['image'] . '">View Report</a>';
                                                            } else {
                                                                echo '<a href="rawlabel/pdf/' . $row['image'] . '"><img src="rawlabel/pdf/' . $row['image'] . '" alt="" width="100px" height="100px"></a>';
                                                            }
                                                            ?>


                                                        </td>
                                                        <td><?php echo date("d-m-Y", strtotime($row['uploadon'])); ?></td>
                                                        <td><?php echo $row['user']; ?></td>
                                                    </tr>


                                                <?php

                                                    $ix++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>





                            </div>

                        </div>
                        <br>
                        <hr>
                        <br>





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    (function() {
        // Wait until DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Select all dropdown icons (the clickable elements)
            const dropdownTriggers = document.querySelectorAll('.dropdown-icon');

            // Function to toggle a specific detail table container
            function toggleDetailTable(trigger, targetId) {
                const targetElement = document.getElementById(targetId);
                if (!targetElement) return;

                // Check current visibility state
                const isVisible = targetElement.style.display !== 'none';

                if (isVisible) {
                    // Hide the table container 
                    targetElement.style.display = 'none';
                    // Remove rotation class from icon if exists (optional but improves UX)
                    trigger.classList.remove('rotated');
                } else {
                    // Show table with smooth effect
                    targetElement.style.display = 'block';
                    // Add rotated class to animate chevron
                    trigger.classList.add('rotated');
                }
            }

            // Attach click event to each dropdown icon
            dropdownTriggers.forEach(trigger => {
                // Get target id from data-target attribute
                const targetId = trigger.getAttribute('data-target');
                if (!targetId) {
                    console.warn('Dropdown icon missing data-target attribute');
                    return;
                }

                // Initially ensure target containers are hidden (but CSS also sets display:none)
                // just for sanity: force hidden if required.
                const targetContainer = document.getElementById(targetId);
                if (targetContainer && targetContainer.style.display !== 'none') {
                    // In case any leftover inline style, but we keep consistent
                    targetContainer.style.display = 'none';
                }

                // add click event
                trigger.addEventListener('click', function(event) {
                    event.stopPropagation(); // avoid any bubbling issues (makes UX clean)
                    toggleDetailTable(trigger, targetId);
                });
            });

            // Optional: close all detail tables when clicking outside? but not needed, 
            // but we respect user expectation - Each dropdown works independently.
            // Extra: ensure that if user opens many, it's fine, but if you want accordion style (close others when open one)
            // you could add that, but instructions didn't specify. To keep intuitive: each independent.
            // For an even better UX we allow single or multiple open, no restriction as list of product names.

            // Also, small addition: adjust icon rotation based on initial state (all hidden, so no rotation)
            // But for graceful pre-existing rotated class reset if any
            dropdownTriggers.forEach(trigger => {
                const targetId = trigger.getAttribute('data-target');
                const targetElem = document.getElementById(targetId);
                if (targetElem && targetElem.style.display === 'block') {
                    trigger.classList.add('rotated');
                } else {
                    trigger.classList.remove('rotated');
                }
            });

            // Additional enhancement: add keyboard or aria? Not required but nice
            // Set ARIA expanded attributes for accessibility? Lightweight.
            dropdownTriggers.forEach(trigger => {
                const targetId = trigger.getAttribute('data-target');
                const targetElem = document.getElementById(targetId);
                if (targetElem) {
                    trigger.setAttribute('aria-expanded', 'false');
                    trigger.setAttribute('role', 'button');
                    trigger.setAttribute('tabindex', '0');
                    trigger.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            trigger.click();
                        }
                    });
                }
            });

            // Synchronize aria-expanded state manually on toggle
            function updateAria() {
                dropdownTriggers.forEach(trigger => {
                    const targetId = trigger.getAttribute('data-target');
                    const targetElem = document.getElementById(targetId);
                    if (targetElem) {
                        const expanded = targetElem.style.display !== 'none';
                        trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                    }
                });
            }

            // Override toggle function to also update aria
            const originalToggle = toggleDetailTable;
            window.toggleDetailTable = function(trigger, targetId) {
                originalToggle(trigger, targetId);
                updateAria();
            };

            // Rebind events to use updated function reference
            // Replace existing event listeners with upgraded version
            dropdownTriggers.forEach(trigger => {
                const newTrigger = trigger.cloneNode(true);
                trigger.parentNode.replaceChild(newTrigger, trigger);
            });

            // Re-query triggers after replacing
            const freshTriggers = document.querySelectorAll('.dropdown-icon');
            freshTriggers.forEach(trigger => {
                const targetId = trigger.getAttribute('data-target');
                if (!targetId) return;
                const container = document.getElementById(targetId);
                if (container && container.style.display === 'none') {
                    trigger.classList.remove('rotated');
                } else if (container && container.style.display === 'block') {
                    trigger.classList.add('rotated');
                }
                trigger.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const tid = this.getAttribute('data-target');
                    const targ = document.getElementById(tid);
                    if (!targ) return;
                    const isHidden = targ.style.display === 'none';
                    if (isHidden) {
                        targ.style.display = 'block';
                        this.classList.add('rotated');
                    } else {
                        targ.style.display = 'none';
                        this.classList.remove('rotated');
                    }
                    // update aria
                    this.setAttribute('aria-expanded', !isHidden ? 'false' : 'true');
                });
                // initial aria
                const initContainer = document.getElementById(targetId);
                trigger.setAttribute('aria-expanded', initContainer && initContainer.style.display !== 'none' ? 'true' : 'false');
                trigger.setAttribute('role', 'button');
                trigger.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        trigger.click();
                    }
                });
            });

            // final manual aria setter for initial consistency.
            document.querySelectorAll('.dropdown-icon').forEach(ic => {
                const tid = ic.getAttribute('data-target');
                const el = document.getElementById(tid);
                if (el && el.style.display === 'none') ic.setAttribute('aria-expanded', 'false');
                else if (el && el.style.display !== 'none') ic.setAttribute('aria-expanded', 'true');
            });
        });
    })();
</script>
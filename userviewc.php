<?php
$sno = $_GET['sno'];
$sl = mysqli_query($con, "select * from tblstaff where id='$sno'");
$row = mysqli_fetch_array($sl);
//allergen
$allergnx = $row['allergen'];
$alcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Allergen'");
$rowal = mysqli_fetch_assoc($alcert);

//level2
$lvl2 = $row['lvl2'];
$lvl2cert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Level2'  order by id desc limit 1");
$rowlvl2 = mysqli_fetch_assoc($lvl2cert);

//haccp
$haccp = $row['haccp'];
$hcpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'HACCP'  order by id desc limit 1");
$hcpcert1 = mysqli_fetch_assoc($hcpcert);

//procedure
$procedure = $row['procedur'];
$procert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'CCP'  order by id desc limit 1");
$procert1 = mysqli_fetch_assoc($procert);

//ccp
$ccp = $row['ccp'];
$ccpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'CCP'  order by id desc limit 1");
$ccpcert1 = mysqli_fetch_assoc($ccpcert);

?>












<style>
    :root {
        --primary-color: #38b2ac;
        --secondary-color: #2c7a47;
        --accent-color: #e53e3e;
        --light-bg: #f7fafc;
        --dark-text: #2d3748;
        --light-text: #718096;
    }



    .header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Fixed User Profile Section */
    .user-profile-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        height: calc(100vh - 140px);
        position: sticky;
        top: 20px;
        overflow-y: auto;
    }

    .user-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 auto 1rem;
    }

    .user-details p {
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }

    .user-details strong {
        color: var(--primary-color);
    }

    .certificate-badge {
        display: inline-block;
        background-color: var(--secondary-color);
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    /* Navigation Tabs */
    .nav-tabs {
        border-bottom: 3px solid #e2e8f0;
        margin-bottom: 1.5rem;
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }

    .nav-tabs .nav-link {
        color: black;
        font-weight: 500;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 10px 15px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .nav-tabs .nav-link:hover {
        color: var(--secondary-color);
        border-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: var(--secondary-color);
        background-color: transparent;
        border-color: var(--secondary-color);
        font-weight: 600;
    }

    .nav-tabs .nav-link i {
        margin-right: 5px;
    }

    /* PDF Viewer Section */
    .pdf-viewer-container {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        height: calc(100vh - 250px);
        display: flex;
        flex-direction: column;
    }

    .pdf-header {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .pdf-iframe {
        flex: 1;
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        background-color: #f8f9fa;
    }

    .pdf-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--light-text);
    }

    .pdf-placeholder i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: var(--secondary-color);
    }

    .certificate-info {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-valid {
        background-color: #c6f6d5;
        color: #22543d;
    }

    .status-expired {
        background-color: #fed7d7;
        color: #742a2a;
    }

    .status-expired {
        background-color: #feebc8;
        color: #744210;
    }

    .status-na {
        background-color: #C0C0C0;
        color: #000;
    }

    footer {
        text-align: center;
        color: var(--light-text);
        font-size: 0.85rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 992px) {
        .user-profile-section {
            position: relative;
            top: 0;
            height: auto;
        }

        .pdf-viewer-container {
            height: 500px;
        }
    }

    @media (max-width: 768px) {
        .nav-tabs .nav-link {
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        .pdf-viewer-container {
            height: 400px;
        }
    }
</style>

<div class="container-fluid h-100">
    <div class="row h-100">
        <!-- Fixed User Profile Section (Left Column) -->
        <div class="col-lg-3 col-xl-2">
            <div class="user-profile-section">
                <div class="text-center">
                    <img src="auditordoc/1.jpg" alt="" class="img-fluid" style="width: 100px; height: 100px; border-radius: 50%;">
                    <h5><?php echo $row['fname'] . " " . $row['lname']; ?></h5>

                </div>

                <div class="user-details mt-4" style="overflow: hidden;">

                    <p><strong><i class="fa fa-building me-2"></i> Department:</strong> <?php echo $row['department']; ?></p>
                    <p><strong><i class="fa fa-envelope me-2"></i> Email:</strong> <?php echo $row['email']; ?></p>
                    <p><strong><i class="fa fa-id-card me-2"></i> Pay Roll No:</strong> <?php echo $row['payroll']; ?></p>
                    <hr>
                    <h4>Training status: </h4>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="medium">HACCP</span>
                            <?php
                            if ($haccp == 'Yes') {

                                if ($hcpcert1['certdate'] < date('Y-m-d')) {
                            ?>
                                    <span class="status-badge status-valid">Valid</span>
                                <?php
                                } else {
                                ?>
                                    <span class="status-badge status-expired">Expired</span>
                            <?php
                                }
                            }else{
                                ?>
                                <span class="status-badge status-na">N/A</span>
                            <?php
                            }
                            ?>

                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="medium">CCP</span>
                            <?php
                            if ($ccp == 'Yes') {

                                if ($ccpcert1['certdate'] < date('Y-m-d')) {
                            ?>
                                    <span class="status-badge status-valid">Valid</span>
                                <?php
                                } else {
                                ?>
                                    <span class="status-badge status-expired">Expired</span>
                            <?php
                                }
                            }
                          else{
                                ?>
                                <span class="status-badge status-na">N/A</span>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="medium">Level 2</span>
                            <?php
                            if ($lvl2 == 'Yes') {

                                if ($rowlvl2['certdate'] < date('Y-m-d')) {
                            ?>
                                    <span class="status-badge status-valid">Valid</span>
                                <?php
                                } else {
                                ?>
                                    <span class="status-badge status-expired">Expired</span>
                            <?php
                                }
                            }
                           else{
                                ?>
                                <span class="status-badge status-na">N/A</span>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="medium">Allergen</span>
                            <?php
                            if ($allergnx == 'Yes') {

                                if ($rowal['certdate'] < date('Y-m-d')) {
                            ?>
                                    <span class="status-badge status-valid">Valid</span>
                                <?php
                                } else {
                                ?>
                                    <span class="status-badge status-expired">Expired</span>
                            <?php
                                }
                            }
                           else{
                                ?>
                                <span class="status-badge status-na">N/A</span>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="d-flex justify-content-between mb-3 ">
                            <span class="medium">Procedure</span>
                            <?php
                            if ($procedure == 'Yes') {

                                if ($procert1['certdate'] < date('Y-m-d')) {
                            ?>
                                    <span class="status-badge status-valid">Valid</span>
                                <?php
                                } else {
                                ?>
                                    <span class="status-badge status-expired">Expired</span>
                            <?php
                                }
                            }
                           else{
                                ?>
                                <span class="status-badge status-na">N/A</span>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area (Right Column) -->
        <div class="col-lg-9 col-xl-10">
            <div class="d-flex flex-column h-100">


                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="certificateTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="haccp-tab" data-bs-toggle="tab" data-bs-target="#haccp" type="button" role="tab" aria-controls="haccp" aria-selected="true">
                            <i class="fa fa-file-text-o"></i> HACCP Certificate
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ccp-tab" data-bs-toggle="tab" data-bs-target="#ccp" type="button" role="tab" aria-controls="ccp" aria-selected="false">
                            <i class="fa fa-file-text-o"></i> CCP Training Record
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="level2-tab" data-bs-toggle="tab" data-bs-target="#level2" type="button" role="tab" aria-controls="level2" aria-selected="false">
                            <i class="fa fa-file-text-o"></i> Level 2 Certificate
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="allergen-tab" data-bs-toggle="tab" data-bs-target="#allergen" type="button" role="tab" aria-controls="allergen" aria-selected="false">
                            <i class="fa fa-file-text-o"></i> Allergen Certificate
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="procedure-tab" data-bs-toggle="tab" data-bs-target="#procedure" type="button" role="tab" aria-controls="allergen" aria-selected="false">
                            <i class="fa fa-file-text-o"></i> Procedure Training Record
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content flex-grow-1" id="certificateTabsContent">
                    <!-- HACCP Tab -->
                    <div class="tab-pane fade show active h-100" id="haccp" role="tabpanel" aria-labelledby="haccp-tab">
                        <div class="row h-100">
                            <div class="col-md-12 h-100">
                                <div class="pdf-viewer-container">
                                    <div class="pdf-header">
                                        <h5 class="mb-2">HACCP Certification Document</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                if ($haccp == 'Yes') {

                                                    if ($hcpcert1['certdate'] < date('Y-m-d')) {
                                                ?>
                                                        <span class="status-badge status-valid">Valid</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="status-badge status-expired">Expired</span>
                                                    <?php
                                                    }
                                                    ?>
                                                    <span class="text-muted small">Refresher training due before: <?php 
                                                    if(!empty($hcpcert1['certdate']) && $hcpcert1['certdate'] != '0000-00-00'){
                                                        echo $hcpcert1['certdate'];
                                                    }
                                                    ?></span>
                                                <?php
                                                }
                                                ?>

                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($hcpcert1['certificate'] && $haccp == 'Yes')) {
                                    ?>
                                        <iframe src="student/<?php echo $hcpcert1['certificate']; ?>"
                                            class="pdf-iframe"
                                            title="HACCP Certificate PDF">
                                        </iframe>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="pdf-placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                            <h5>Data Not Available !</h5>

                                        </div><?php
                                            }
                                                ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- CCP Tab -->
                    <div class="tab-pane fade h-100" id="ccp" role="tabpanel" aria-labelledby="ccp-tab">
                        <div class="row h-100">
                            <div class="col-md-12 h-100">
                                <div class="pdf-viewer-container">
                                    <div class="pdf-header">
                                        <h5 class="mb-2">CCP (Critical Control Point) Records</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                if ($ccp == 'Yes') {



                                                    if ($ccpcert1['certdate'] < date('Y-m-d')) {
                                                ?>
                                                        <span class="status-badge status-valid">Valid</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="status-badge status-expired">Expired</span>
                                                    <?php
                                                    }
                                                    ?>
                                                    <span class="text-muted small">Refresher training due before: <?php if (!empty($ccpcert1['certdate']) && $ccpcert1['certdate'] != '0000-00-00') {
                                                                                                echo date('M d, Y', strtotime($ccpcert1['certdate']));
                                                                                            }  ?></span>
                                                <?php
                                                }
                                                ?>

                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                    if ($ccp == 'Yes' && !empty($ccpcert1['certificate'])) {
                                    ?>
                                        <iframe src="student/<?php echo $ccpcert1['certificate']; ?>"
                                            class="pdf-iframe"
                                            title="CCP Certificate PDF">
                                        </iframe>
                                    <?php
                                    } else {
                                    ?>

                                        <div class="pdf-placeholder">
                                            <i class="fas fa-file-pdf"></i>
                                            <h5>Data Not Available !</h5>

                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Level 2 Tab -->
                    <div class="tab-pane fade h-100" id="level2" role="tabpanel" aria-labelledby="level2-tab">
                        <div class="row h-100">
                            <div class="col-md-12 h-100">
                                <div class="pdf-viewer-container">
                                    <div class="pdf-header">
                                        <h5 class="mb-2">Level 2 Food Safety Certificate</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                if ($lvl2 == 'Yes') {



                                                    if ( date('Y-m-d',strtotime($rowlvl2['certdate']))< $rowlvl2['certdate'] ) {
                                                ?>
                                                        <span class="status-badge status-valid">Valid</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="status-badge status-expired">Expired</span>
                                                    <?php
                                                    }
                                                    ?>
                                                <span class="text-muted small">Refresher training due before:<?php if (!empty($rowlvl2['certdate']) && $rowlvl2['certdate'] != '0000-00-00') {
                                                                                                echo date('M d, Y', strtotime($rowlvl2['certdate']));
                                                                                            }  ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>

                                    <?php
                                    if ($lvl2 == 'Yes' && !empty($rowlvl2['certificate'])) {
                                    ?>
                                    <iframe src="student/<?php echo $rowlvl2['certificate']; ?>"
                                        class="pdf-iframe"
                                        title="Level 2 Food Safety Certificate PDF">
                                    </iframe>
                                    <?php
                                    } else {
                                    ?>

                                    <div class="pdf-placeholder">
                                        <i class="fas fa-file-pdf"></i>
                                        <h5>Data Not Available !</h5>

                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Allergen Tab -->
                    <div class="tab-pane fade h-100" id="allergen" role="tabpanel" aria-labelledby="allergen-tab">
                        <div class="row h-100">
                            <div class="col-md-12 h-100">
                                <div class="pdf-viewer-container">
                                    <div class="pdf-header">
                                        <h5 class="mb-2">Allergen Awareness Training Certificate</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                if ($allergnx == 'Yes') {


                                                    if ($rowal['certdate'] < date('Y-m-d')) {
                                                ?>
                                                        <span class="status-badge status-valid">Valid</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="status-badge status-expired">Expired</span>
                                                    <?php
                                                    }
                                                    ?>
                                                <span class="text-muted small">Refresher training due before:<?php if (!empty($rowal['certdate']) && $rowal['certdate'] != '0000-00-00') {
                                                                                                 echo date('M d, Y', strtotime($rowal['certdate']));
                                                                                             }  ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>

                                    <?php
                                    if ($allergnx == 'Yes' && !empty($rowal['certificate'])) {
                                    ?>
                                    <iframe src="student/<?php echo $rowal['certificate']; ?>"
                                        class="pdf-iframe"
                                        title="Allergen Training Certificate PDF">
                                    </iframe>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="pdf-placeholder">
                                        <i class="fas fa-file-pdf"></i>
                                        <h5>Data Not Available !</h5>

                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Allergen Tab -->
                    <div class="tab-pane fade h-100" id="procedure" role="tabpanel" aria-labelledby="procedure-tab">
                        <div class="row h-100">
                            <div class="col-md-12 h-100">
                                <div class="pdf-viewer-container">
                                    <div class="pdf-header">
                                        <h5 class="mb-2">Procedure Training Certificate</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                if ($procedure == 'Yes') {


                                                    if ($procert1['certdate'] < date('Y-m-d')) {
                                                ?>
                                                        <span class="status-badge status-valid">Valid</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="status-badge status-expired">Expired</span>
                                                    <?php
                                                    }
                                                    ?>
                                                <span class="text-muted small">Refresher training due before :<?php if (!empty($procert1['certdate']) && $procert1['certdate'] != '0000-00-00') {
                                                                                                 echo date('M d, Y', strtotime($procert1['certdate']));
                                                                                              }  ?></span>
                                                <?php
                                                }
                                                ?>
                                              
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                    if ($procedure == 'Yes' && !empty($procert1['certificate'])) {
                                    ?>
                                    <iframe src="student/<?php echo $procert1['certificate']; ?>"
                                        class="pdf-iframe"
                                        title="Allergen Training Certificate PDF">
                                    </iframe>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="pdf-placeholder">
                                        <i class="fas fa-file-pdf"></i>
                                        <h5>Data Not Available !</h5>

                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('#certificateTabs .nav-link');
        const pdfIframes = document.querySelectorAll('.pdf-iframe');




        // Set initial PDF for active tab
        const activeTab = document.querySelector('#certificateTabs .nav-link.active');
        if (activeTab) {
            const tabId = activeTab.id.replace('-tab', '');
            const iframe = document.querySelector(`#${tabId} .pdf-iframe`);
            if (iframe) {
                iframe.src = pdfSources[tabId];
            }
        }




    });
</script>


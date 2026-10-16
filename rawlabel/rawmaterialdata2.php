<?php

$rid = $_GET['rid'];
$sq = mysqli_query($con, "SELECT * FROM tblrawdata WHERE raw='$rid'");
$rowp = mysqli_fetch_assoc($sq);


$rawd = mysqli_query($con, "SELECT s1.supname as supname,p1.pcode as pcode, p1.pname as pname FROM `tblrawmaterial`as p1 join tblrawsupplier as s1 on p1.supid = s1.supid where p1.id ='" . $rid . "'");
$rawd1 = mysqli_fetch_array($rawd);
?>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .header-title {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .header-subtitle {
        color: #6c757d;
        font-size: 1rem;
    }


    .info-card {
        background: white;
        border-radius: 1.2rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
        height: 100%;
    }

    .info-card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-3px);
    }

    /* Product Details Card */
    .details-card {
        background: white;
        border-radius: 1.2rem;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .details-header {
        background: var(--primary-gradient);
        padding: 1.2rem 1.8rem;
        color: white;
    }

    .details-header h4 {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .details-body {
        padding: 1.8rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .detail-icon i {
        font-size: 1.4rem;
        color: #667eea;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        font-weight: 600;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-top: 0.2rem;
    }

    /* Label Cards */
    .label-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        height: 100%;
    }

    .label-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .label-header {
        padding: 1rem;
        text-align: center;
        font-weight: 700;
        color: white;
    }

    .label-header.front {
        background: linear-gradient(135deg, #1976d2, #42a5f5);
    }

    .label-header.back {
        background: linear-gradient(135deg, #7b1fa2, #ab47bc);
    }

    .label-header.outer {
        background: linear-gradient(135deg, #f57c00, #ff9800);
    }

    .label-header i {
        font-size: 1.8rem;
        margin-bottom: 0.3rem;
        display: block;
    }

    .label-preview {
        padding: 1.5rem;
        text-align: center;
        background: #f8f9fa;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-img {
        max-width: 100%;
        max-height: 160px;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .pdf-icon {
        font-size: 4rem;
        color: #dc3545;
    }

    .file-info {
        padding: 0.8rem;
        background: white;
        border-top: 1px solid #e9ecef;
        font-size: 0.7rem;
        color: #6c757d;
        text-align: center;
        word-break: break-all;
    }

    .no-file {
        color: #adb5bd;
        text-align: center;
        padding: 2rem;
    }

    .no-file i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Badge */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-uploaded {
        background: #d4edda;
        color: #155724;
    }

    .status-missing {
        background: #f8d7da;
        color: #721c24;
    }

    /* Action Buttons */
    .action-buttons {
        margin-top: 2rem;
        text-align: center;
    }

    .btn-custom {
        background: var(--primary-gradient);
        border: none;
        padding: 0.7rem 2rem;
        border-radius: 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        margin: 0 0.5rem;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-custom {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 0.7rem 2rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-outline-custom:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-container {
            padding: 0 1rem;
        }

        .header-title {
            font-size: 1.8rem;
        }

        .detail-value {
            font-size: 0.95rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade {
        animation: fadeIn 0.5s ease-out;
    }
</style>


<div class="main-content">
    
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">
                        <a href="admin.php?id=rawmaterialdata"><button class="btn btn-success"
                                style="float:right; margin-left:15px"><i class="bi bi-arrow-left-circle"></i> Go
                                Back</button></a>
                        <a href="admin.php?id=rawmaterialdata4&rid=<?php echo $rid; ?>"><button class="btn btn-primary"
                                style="float:right; margin-left:15px"><i class="bi bi-clock-history"></i>Previous
                                Records</button></a>




                        <h4 class="card-title mb-3">Raw Material Details</h4>
                        <br>
                        <!-- Header -->









                        <div class="header-section animate-fade">
                            <h1 class="header-title">
                                <i class="bi bi-tags-fill"></i> Product Label Details
                            </h1>

                        </div>

                        <!-- Product Details Section -->
                        <div class="details-card animate-fade">
                            <div class="details-header">
                                <h4>
                                    <i class="bi bi-box-seam-fill"></i>
                                    Product Information
                                </h4>
                            </div>
                            <div class="details-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="fa fa-cubes"></i>

                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Raw Material Name</div>
                                                <div class="detail-value" id="displayRawMaterial"><?php echo $rawd1['pname']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="bi bi-upc-scan"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Product Code </div>
                                                <div class="detail-value" id="displayPcode"><?php echo $rawd1['pcode']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Supplier</div>
                                                <div class="detail-value" id="displaySupplier"><?php echo $rawd1['supname']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="bi bi-box-seam-fill"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">SKU Batch</div>
                                                <div class="detail-value" id="displayRawMaterial"><?php echo $rowp['sku']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="bi bi-currency-pound"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Price</div>
                                                <div class="detail-value" id="displayPcode"><?php echo $rowp['price']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                               
<i class="bi bi-diagram-3"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Weight</div>
                                                <div class="detail-value" id="displayPcode"><?php
                                                                                            $rowweight = str_replace(';', '<br>', $rowp['pweight']);
                                                                                            echo $rowweight;
                                                                                            ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="detail-item">
                                            <div class="detail-icon">
                                                <i class="bi bi-collection"></i>
                                            </div>
                                            <div class="detail-content">
                                                <div class="detail-label">Description</div>
                                               
                                                <div class="detail-value" id="displayPcode"><?php echo $rowp['description']; ?></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row my-3">
                                    <div class="col-md-6 col-sm-12">

                                        <h3 class="fw-bold text-dark">
                                            Nutritional Information :
                                        </h3>
                                        <br>
                                        <br>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Typical Value</th>
                                                    <th>Per 100g</th>

                                                </tr>
                                                <tr>
                                                    <th>Energy</th>
                                                    <td><?php echo $rowp['energy']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Fat</th>
                                                    <td><?php echo $rowp['energy']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>of which saturates</th>
                                                    <td><?php echo $rowp['energy']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Carbohydrate</th>
                                                    <td><?php echo $rowp['energy']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>of which sugars</th>
                                                    <td><?php echo $rowp['sugars']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Fibre</th>
                                                    <td><?php echo $rowp['fibre']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Protein</th>
                                                    <td><?php echo $rowp['protein']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Salt</th>
                                                    <td><?php echo $rowp['salt']; ?></td>
                                                </tr>






                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <h3 class="fw-bold text-dark">
                                            Product Images :
                                        </h3>
                                        <br>
                                        <br>
                                        <?php
                                        if (!empty($rowp['productimg'])) {
                                            $rowpx = explode(';', $rowp['productimg']);
                                        ?>
                                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <?php
                                                    foreach ($rowpx as $key => $rimg) {
                                                    ?>
                                                        <div class="carousel-item <?php if ($key == 0) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                                            <img src="rawlabel/productimg/<?php echo $rimg; ?>" class="d-block w-100" alt="...">
                                                        </div>
                                                    <?php

                                                    }

                                                    ?>

                                                </div>
                                                <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </button>
                                            </div>
                                        <?php
                                        } else {
                                            echo "<h4 class='text-danger'>No Product Images Found</h4>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Labels Section -->
                            <h3 class="mb-3 mt-4 fw-bold text-dark">
                                <i class="bi bi-images me-2" style="color: #667eea;"></i>
                                Product Labels
                            </h3>
                            <div class="row g-4 mb-3" id="labelsContainer">
                                <!-- Front Label Card -->

                                <?php
                                if (isset($rowp['frontlabel']) && !empty($rowp['frontlabel'])) {

                                    $dbFileName1 = $rowp['frontlabel'];

                                    // Get extension
                                    $extension1 = pathinfo($dbFileName1, PATHINFO_EXTENSION);


                                ?>
                                    <div class="col-md-6 animate-fade">
                                        <div class="label-card">
                                            <div class="label-header front">
                                                <i class="bi bi-file-image-fill"></i>
                                                FRONT LABEL
                                                <span class="status-badge status-uploaded ms-2" id="frontStatus">Uploaded</span>
                                            </div>
                                            <div class="label-preview" id="outerPreview">

                                                <?php
                                                if ($extension1 == 'pdf') {
                                                ?>
                                                    <iframe src="rawlabel/pdf/<?= $rowp['frontlabel'] ?>" class="img-fluid" alt="Outer Label" style="width: 100%; height:560px;"></iframe>
                                                <?php
                                                } else {
                                                ?>


                                                    <img src="rawlabel/pdf/<?= $rowp['frontlabel'] ?>" class="img-fluid" alt="Outer Label">

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if (isset($rowp['backlabel']) && !empty($rowp['backlabel'])) {


                                    $dbFileName2 = $rowp['backlabel'];

                                    // Get extension
                                    $extension2 = pathinfo($dbFileName2, PATHINFO_EXTENSION);

                                ?>
                                    <!-- Back Label Card -->
                                    <div class="col-md-6 animate-fade">
                                        <div class="label-card">
                                            <div class="label-header front">
                                                <i class="bi bi-file-image-fill"></i>
                                                BACK LABEL
                                                <span class="status-badge status-uploaded ms-2" id="backStatus">Uploaded</span>
                                            </div>
                                            <div class="label-preview" id="outerPreview">
                                                <?php
                                                if ($extension2 == 'pdf') {
                                                ?>
                                                    <iframe src="rawlabel/pdf/<?= $rowp['backlabel'] ?>" class="img-fluid" alt="Outer Label" style="width: 100%; height:560px;"></iframe>
                                                <?php
                                                } else {
                                                ?>


                                                    <img src="rawlabel/pdf/<?= $rowp['backlabel'] ?>" class="img-fluid" alt="Outer Label">

                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                        <?php
                                }
                        ?>

                        <?php
                        if (isset($rowp['outerlabel']) && !empty($rowp['outerlabel'])) {


                            $dbFileName3 = $rowp['outerlabel'];

                            // Get extension
                            $extension3 = pathinfo($dbFileName3, PATHINFO_EXTENSION);


                        ?>
                            <div class="row g-4 mb-3" id="labelsContainer">
                                <!-- Outer Label Card -->
                                <div class="col-md-6 animate-fade">
                                    <div class="label-card">
                                        <div class="label-header front">
                                            <i class="bi bi-file-image-fill"></i>
                                            OUTER LABEL
                                            <span class="status-badge status-uploaded ms-2" id="outerStatus">Uploaded</span>
                                        </div>
                                        <div class="label-preview" id="outerPreview">

                                            <?php
                                            if ($extension3 == 'pdf') {
                                            ?>
                                                <iframe src="rawlabel/pdf/<?= $rowp['outerlabel'] ?>" class="img-fluid" alt="Outer Label" style="width: 100%; height:560px;"></iframe>
                                            <?php
                                            } else {
                                            ?>


                                                <img src="rawlabel/pdf/<?= $rowp['outerlabel'] ?>" class="img-fluid" alt="Outer Label">

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                            ?>

                            <?php
                            if (isset($rowp['specification']) && !empty($rowp['specification'])) {

                                $dbFileName4 = $rowp['specification'];

                                // Get extension
                                $extension4 = pathinfo($dbFileName4, PATHINFO_EXTENSION);


                            ?>
                                <div class="col-md-6 animate-fade">
                                    <div class="label-card">
                                        <div class="label-header front">
                                            <i class="bi bi-file-image-fill"></i>
                                            SPECIFICATION
                                            <span class="status-badge status-uploaded ms-2" id="outerStatus">Uploaded</span>
                                        </div>
                                        <div class="label-preview" id="outerPreview">
                                            <?php
                                            if ($extension4 == 'pdf') {
                                            ?>
                                                <iframe src="rawlabel/pdf/<?= $rowp['specification'] ?>" class="img-fluid" alt="Outer Label" style="width: 100%; height:560px;"></iframe>
                                            <?php
                                            } else {
                                            ?>


                                                <img src="rawlabel/pdf/<?= $rowp['specification'] ?>" class="img-fluid" alt="Outer Label">

                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
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
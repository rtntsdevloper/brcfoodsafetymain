<?php
include 'connection.php';

// Handle date filter
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d', strtotime('-7 days'));
$to_date   = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

// Fetch filtered records
$sq = mysqli_query($con, "SELECT * FROM tblorgan 
    WHERE date BETWEEN '$from_date' AND '$to_date'
    ORDER BY date DESC
");
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Production Organoleptic Assessment</li>
        </ul>
    </div>

    <!-- Date Filter Card -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="mb-3">Filter Records by Date Range</h4>

                    <form method="GET" class="form-inline">
                        <div class="form-group mr-3">
                            <input type="hidden" name="id" value="organ">
                            <label for="from_date" class="mr-2">From Date:</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="<?php echo $from_date; ?>" max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group mr-3">
                            <label for="to_date" class="mr-2">To Date:</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="<?php echo $to_date; ?>" max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">
                            Apply Filter
                        </button>

                        <a href="admin.php?id=organ&from_date=<?php echo date('Y-m-d', strtotime('-7 days')); ?>&to_date=<?php echo date('Y-m-d'); ?>"
                            class="btn btn-outline-secondary">
                            Last 7 Days
                        </a>
                    </form>

                    <div class="mt-2">
                        <small class="text-muted">
                            Showing records from <strong><?php echo date('d-m-Y', strtotime($from_date)); ?></strong>
                            to <strong><?php echo date('d-m-Y', strtotime($to_date)); ?></strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <h3 class="float-left">Weekly Production Organoleptic Assessment Record</h3>

                    <a href="admin.php?id=precord" class="btn btn-success float-right mr-2 ml-1">Back</a>
                    <a href="admin.php?id=organ1" class="btn btn-primary float-right mb-3">Add New</a>
                    <a href="admin.php?id=organreport&from=<?php echo $from_date; ?>&to=<?php echo $to_date; ?>" class="btn btn-warning float-right mb-3" style="margin-right: 5px">View Report</a>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%; vertical-align: middle;" rowspan="2">#</th>
                                    <th style="width: 12%; vertical-align: middle;" rowspan="2">Date</th>
                                    <th style="width: 20%; vertical-align: middle;" rowspan="2">Product Name/Batch Details</th>
                                    <th style="width: 10%; vertical-align: middle;" rowspan="2">Conducted By</th>
                                    <th colspan="4">Appearance</th>
                                    <th colspan="4">Aroma</th>
                                    <th colspan="4">Texture</th>
                                    <th colspan="4">Flavor</th>
                                </tr>
                                <!-- SECOND ROW OF HEADERS - THIS WAS MISSING -->
                                <!-- <tr>
                                    <th>Score</th>
                                    <th colspan="3">Corrective Action</th>
                                    <th>Score</th>
                                    <th colspan="3">Corrective Action</th>
                                    <th>Score</th>
                                    <th colspan="3">Corrective Action</th>
                                    <th>Score</th>
                                    <th colspan="3">Corrective Action</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_records = 0;
                                while ($row = mysqli_fetch_assoc($sq)) {
                                    $date = $row['date'];
                                    $total_records++;

                                    if ($row['appearance'] == 3) {
                                        $bg = 'green';
                                    } elseif ($row['appearance'] == 2) {
                                        $bg = 'orange';
                                    } else {
                                        $bg = 'red';
                                    }

                                    if ($row['aroma'] == 3) {
                                        $bg1 = 'green';
                                    } elseif ($row['aroma'] == 2) {
                                        $bg1 = 'orange';
                                    } else {
                                        $bg1 = 'red';
                                    }
                                    if ($row['texture'] == 3) {
                                        $bg2 = 'green';
                                    } elseif ($row['texture'] == 2) {
                                        $bg2 = 'orange';
                                    } else {
                                        $bg2 = 'red';
                                    }

                                    if ($row['flavour'] == 3) {
                                        $bg3 = 'green';
                                    } elseif ($row['flavour'] == 2) {
                                        $bg3 = 'orange';
                                    } else {
                                        $bg3 = 'red';
                                    }
                                ?>
                                    <!-- First Row for Scores -->
                                    <tr>
                                        <td rowspan="2" style="vertical-align: middle;"><?php echo $i++; ?></td>
                                        <td rowspan="2" style="vertical-align: middle;"><?php echo date("d-m-Y", strtotime($date)); ?></td>
                                        <td rowspan="2" style="vertical-align: middle;"><b>Product Name:</b> <?php echo $row['product']; ?> <br><b>Batch Code:</b> <?php echo $row['details']; ?></td>
                                        <td rowspan="2" style="vertical-align: middle;"><?php echo $row['conducted']; ?></td>

                                        <!-- Appearance Score -->
                                        <td colspan="4" style="background-color:  <?php echo $bg; ?>; color: white; font-weight: bold;"><?php echo $row['appearance']; ?></td>
                                        <!-- Appearance Corrective Action placeholder -->


                                        <!-- Aroma Score -->
                                        <td colspan="4" style="background-color: <?php echo $bg1; ?>; color: white; font-weight: bold;"><?php echo $row['aroma']; ?></td>


                                        <!-- Texture Score -->
                                        <td colspan="4" style="background-color: <?php echo $bg2; ?>; color: white; font-weight: bold;"><?php echo $row['texture']; ?></td>


                                        <!-- Flavor Score -->
                                        <td colspan="4" style="background-color: <?php echo $bg3; ?>; color: white; font-weight: bold;"><?php echo $row['flavour']; ?></td>

                                    </tr>

                                    <!-- Second Row for Corrective Actions -->
                                    <!-- Second Row for Corrective Actions -->
                                    <tr>
                                        <!-- Appearance Corrective Action -->
                                        <?php if (!empty($row['appearance1'])) { ?>
                                            <td colspan="4" style="text-align: left; background-color: #f9f9f9;">
                                                <b>Corrective:</b> <?php echo $row['appearance1']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td colspan="4"></td>
                                        <?php } ?>

                                        <!-- Aroma Corrective Action -->
                                        <?php if (!empty($row['aroma1'])) { ?>
                                            <td colspan="4" style="text-align: left; background-color: #f9f9f9;">
                                                <b>Corrective:</b> <?php echo $row['aroma1']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td colspan="4"></td>
                                        <?php } ?>

                                        <!-- Texture Corrective Action -->
                                        <?php if (!empty($row['texture1'])) { ?>
                                            <td colspan="4" style="text-align: left; background-color: #f9f9f9;">
                                                <b>Corrective:</b> <?php echo $row['texture1']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td colspan="4"></td>
                                        <?php } ?>

                                        <!-- Flavor Corrective Action -->
                                        <?php if (!empty($row['flavour1'])) { ?>
                                            <td colspan="4" style="text-align: left; background-color: #f9f9f9;">
                                                <b>Corrective:</b> <?php echo $row['flavour1']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td colspan="4"></td>
                                        <?php } ?>
                                    </tr>


                                    </tr>
                                <?php
                                }

                                if ($total_records == 0) {
                                ?>
                                    <tr>
                                        <td colspan="20" class="text-center py-4">
                                            No records found for the selected date range.
                                        </td>
                                    </tr>
                                <?php
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Record Count -->
                    <div class="mt-3">
                        <small class="text-muted">
                            Total Records: <strong><?php echo $total_records; ?></strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$sno = $_GET["sno"];

$q = mysqli_query($con, "SELECT * FROM `tblweight` where id='$sno' ");
$q1 = mysqli_fetch_array($q);

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Daily Weight Check Records</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=weight">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>
                    <?php if (empty($q1['msign'])) { ?>
                        <a href="admin.php?id=weightadd1&sno=<?php echo $sno; ?>">
                            <button class="btn btn-info" style="float:right; margin-left:15px">Add New</button>
                        </a>
                    <?php } else {
                    } ?>
                    <a href="admin.php?id=weightreport&sno=<?php echo $sno; ?>">
                        <button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button>
                    </a>

                    <h4 class="card-title mb-3">Daily Weight Check Records</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product</th>
                                        <!-- <th>Product Size (g)</th>
                                        <th>Filling Machines</th>
                                        <th>Weight Scale Calibration (Pass/Fail/Action)</th> -->
                                        <th>Time</th>
                                        <th>Tare Weight (g)</th>
                                        <th>Weight Pot 1 (g)</th>
                                        <th>Weight Pot 2 (g)</th>
                                        <th>Weight Pot 3 (g)</th>
                                        <th>Weight Pot 4 (g)</th>
                                        <th>Average Weight (g)</th>
                                        <th>Net Wt (g)</th>
                                        <th>Operative Signature</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tblweight1` where sno='$sno'");
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['product']; ?></td>
                                            <!-- <td><?php echo $row['productsize']; ?></td>
                                            <td><?php echo $row['fillingmachines']; ?></td>
                                            <td><?php echo $row['weightscale']; ?></td> -->
                                            <td><?php echo $row['time']; ?></td>
                                            <td><?php echo $row['packtare']; ?></td>
                                            <td><?php echo $row['pack1']; ?></td>
                                            <td><?php echo $row['pack2']; ?></td>
                                            <td><?php echo $row['pack3']; ?></td>
                                            <td><?php echo $row['pack4']; ?></td>
                                            <td><?php echo $row['avgweight']; ?></td>
                                            <td><?php echo $row['netweight']; ?></td>
                                            <td>
                                                <?php
                                                if (!empty($row['sign'])) {
                                                    echo '<img src="form/sign/' . $row['sign'] . '.png" height="80" width="130" alt="Signature">';
                                                } else {
                                                    echo "<i>Pending</i>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
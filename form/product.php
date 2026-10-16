<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>PRODUCT PACKING RECORD CHECK SHEET</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <h3 class="float-left">Product Packing Record Check Sheet</h3>

                    <a href="admin.php?id=form" class="btn btn-success float-right mr-2 ml-1">Back</a>
                    <a href="admin.php?id=product1" class="btn btn-primary float-right mb-3">Add New</a>
                    <!-- <a href="admin.php?id=productreport" class="btn btn-warning float-right mb-3" style="margin-right: 5px">View Report</a> -->

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center align-middle" id="zero_configuration_table" style="width:100%; font-size: 12px;">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="3" style="vertical-align: middle;">Date</th>
                                    <th rowspan="3" style="vertical-align: middle;">Packaging Start Time</th>
                                    <th rowspan="3" style="vertical-align: middle;">Packaging End Time</th>
                                    <th colspan="6" style="vertical-align: middle;">Packaging Label</th>
                                    <th colspan="4" style="vertical-align: middle;">Label Checks</th>
                                    <th rowspan="3" style="vertical-align: middle;">View Report</th>
                                    <!-- <th rowspan="3">Complete</th> -->
                                </tr>

                                <tr>
                                    <th colspan="3" style="vertical-align: middle;">Inner Label</th>
                                    <th colspan="3" style="vertical-align: middle;">Outer Label</th>
                                    <th rowspan="2" style="vertical-align: middle;">Start of run</th>
                                    <th rowspan="2" style="vertical-align: middle;">Mid of run</th>
                                    <th rowspan="2" style="vertical-align: middle;">End of run</th>
                                    <th rowspan="2" style="vertical-align: middle;">Packaging batch change</th>
                                </tr>

                                <tr>
                                    <th>No.of label Printed</th>
                                    <th>No. of label used</th>
                                    <th>No. of label discard</th>
                                    <th>No.of label Printed</th>
                                    <th>No. of label used</th>
                                    <th>No. of label discard</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $sq = mysqli_query($con, "SELECT * FROM `tblproductpacking` ORDER BY id DESC");
                                while ($row = mysqli_fetch_assoc($sq)) {
                                ?>

                                    <tr>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['stime']; ?></td>
                                        <td><?php echo $row['etime']; ?></td>
                                        <td><?php echo $row['iprinted']; ?></td>
                                        <td><?php echo $row['iused']; ?></td>
                                        <td><?php echo $row['idiscard']; ?></td>
                                        <td><?php echo $row['oprint']; ?></td>
                                        <td><?php echo $row['oused']; ?></td>
                                        <td><?php echo $row['odiscard']; ?></td>
                                        <td><?php echo $row['start']; ?></td>
                                        <td><?php echo $row['mid']; ?></td>
                                        <td><?php echo $row['end']; ?></td>
                                        <td><?php echo $row['batch']; ?></td>
                                        <!-- <td><a href="admin.php?id=proview&tid=<?php echo $row['id']; ?>" class="btn btn-success">View Report</a></td> -->
                                        <?php
                                        // Check if ANY of the fields are empty
                                        if (
                                            empty($row['date']) || empty($row['stime']) || empty($row['etime']) ||
                                            empty($row['iprinted']) || empty($row['iused']) || empty($row['idiscard']) ||
                                            empty($row['oprint']) || empty($row['oused']) || empty($row['odiscard']) ||
                                            empty($row['start']) || empty($row['mid']) || empty($row['end']) ||
                                            empty($row['batch'])
                                        ) {

                                            // If ANY field is empty, show "Complete data" button
                                            echo '<td><a href="admin.php?id=product1&draft=' . $row['draft'] . '&bid=' . $row['id'] . '" class="btn btn-primary">Complete data</a></td>';
                                        }  
                                        
                                        else {
                                            if($row['msign'] == ''){
                                            // All fields are filled, show different button or nothing
                                            echo '<td><a href="admin.php?id=proview&tid=' . $row['id'] . '&cid=2" class="btn btn-danger">View Record</a></td>';
                                        }else{
                                        echo '<td><a href="admin.php?id=proview&tid=' . $row['id'] . '&cid=1" class="btn btn-success">View Record</a></td>';
 
                                        }
                                    }

                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
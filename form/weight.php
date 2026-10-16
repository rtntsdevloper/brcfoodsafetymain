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
                    <a href="admin.php?id=1">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <a href="admin.php?id=weightadd">
                        <button class="btn btn-info" style="float:right; margin-left:15px">Add New</button>
                    </a>

                    <h4 class="card-title mb-3">Daily Weight Check Records</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Date</th>
                                        <th>Best Before Date</th>
                                        <th>Batch No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tblweight` ORDER BY id DESC");
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        $record_sno = $row['id'];
                                        
                                        // Check if weights already exist for this record
                                        $sel = mysqli_query($con, "SELECT * FROM `tblweights` WHERE sno='$record_sno'");
                                        $sel1 = mysqli_fetch_assoc($sel);
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['bestdate'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['batch']); ?></td>
                                        <td>
                                            <?php
                                            // Show Add button only if no weights exist
                                            if (empty($sel1['size']) || $sel1['size'] == '') {
                                            ?>
                                                <a href="admin.php?id=weightscale&sno=<?php echo $record_sno; ?>" class="btn btn-info btn-sm">Add</a>
                                            <?php
                                            }
                                            ?>
                                            <a href="admin.php?id=weight1&sno=<?php echo $record_sno; ?>" class="btn btn-primary btn-sm">View</a>
                                        </td>
                                    </tr>
                                    <?php
                                        $i++;
                                    }
                                    
                                    if($i == 1) {
                                        echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
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

<style>
.btn-sm {
    margin: 2px;
}
.table td {
    vertical-align: middle;
}
</style>
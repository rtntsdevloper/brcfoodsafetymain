<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>QMS Metal Detector </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=paperwork"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=pw_scaleingadd"><button class="btn btn-danger" style="float:right">Add Record </button></a>

                    </a>

                    <h4 class="card-title mb-3">QMS Scaling Ingredient Control Form</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Batchcode Blue Bag</th>
                                    <th scope="col">Supervisor Verification</th>
                                    <th scope="col">Manager Verification</th>
                                    <th scope="col">View</th>
                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `pw_scaleing` order by date desc");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['bluebag']; ?></td>
                                        <td>
                                            <?php if(empty($row['supervisor'])) { ?>
                                            <a href="admin.php?id=pw_scaleingverify&eid=<?php echo $row['id']; ?>&signx=1"><button class="btn btn-warning">Verification Pending</button></a>
                                            <?php } else { ?>
                                            <button class="btn btn-success">Verified</button>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if(empty($row['manager'])) { ?>
                                            <a href="admin.php?id=pw_scaleingverify&eid=<?php echo $row['id']; ?>&signx=2"><button class="btn btn-warning">Verification Pending</button></a>
                                            <?php } else { ?>
                                            <button class="btn btn-success">Verified</button>
                                            <?php } ?>
                                        </td>

                                        <td><a href="admin.php?id=pw_scaleingview&eid=<?php echo $row['id']; ?>"><button class="btn btn-primary">View</button></a></td>
                                    </tr>
                                <?php
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
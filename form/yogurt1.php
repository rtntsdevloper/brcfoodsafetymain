<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">add</a></li>
            <li>Yogurt Planning</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=yogurt">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>
                    <a href="admin.php?id=yogurtadd">
                        <button class="btn btn-primary" style="float:right; margin-left:15px">Add New</button>
                    </a>



                    <!-- <a href="admin.php?id=yogurtview">
                        <button class="btn btn-info" style="float:right; margin-left:15px">View</button>
                    </a> -->
                    <h4 class="card-title mb-3">Yogurt Planning</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Date</th>
                                        <th>Batch No.</th>
                                        <th>Batch </th>

                                        <th>Required Cream</th>
                                        <th>Required SMP</th>
                                        <th>Required Milk</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT batch, batch1, uid, date,
                                    SUM(batch) AS total_batch,
                                    SUM(cream) AS total_cream,
                                    SUM(smp)   AS total_smp,
                                    SUM(milk)  AS total_milk
                                    FROM tblyogurt1 GROUP BY uid");

                                    $i = 1;

                                    // Grand totals
                                    $grand_req_cream = 0;
                                    $grand_req_smp   = 0;
                                    $grand_req_milk  = 0;

                                    foreach ($sql as $row) {
                                        $grand_req_batch += $row['total_batch'];

                                        $grand_req_cream += $row['total_cream'];
                                        $grand_req_smp   += $row['total_smp'];
                                        $grand_req_milk  += $row['total_milk'];
                                    ?>
                                        <tr style="font-weight:bold;">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                            <td>
                                                <?php echo date('ymd',strtotime($row['batch1'])); ?></td>
                                            <td><?php echo number_format($row['total_batch'], 2); ?></td>

                                            <td><?php echo number_format($row['total_cream'], 2); ?></td>
                                            <td><?php echo number_format($row['total_smp'], 2); ?></td>
                                            <td><?php echo number_format($row['total_milk'], 2); ?></td>
                                            <td><a href="admin.php?id=yogurtview1&uid=<?php echo $row['uid']; ?>" class='btn btn-info'>View</a></td>
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
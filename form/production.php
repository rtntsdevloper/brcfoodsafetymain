<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Yogurt production</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=yogurt">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>
                    <a href="admin.php?id=yogurtproductionadd">
                        <button class="btn btn-primary" style="float:right; margin-left:15px">Add New</button>
                    </a>


                    <!-- <a href="admin.php?id=yogurtview">
                        <button class="btn btn-info" style="float:right; margin-left:15px">View</button>
                    </a> -->
                    <h4 class="card-title mb-3">Yogurt production</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>batch code</th>

                                        <th>Quantity</th>
                                        <th>Add Details</th>
                                        <td>View</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tblyogurtproduction`");
                                    $i = 1;
                                    foreach ($sql as $row) {

                                        $pname = $row['pname'];
                                        $product = mysqli_query($con, "SELECT * FROM `tblyogurt` where id='$pname' ");
                                        $pdata = mysqli_fetch_array($product);
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['date'])) ?></td>
                                            <td><?php echo $pdata['name']; ?></td>
                                            <td><?php echo date('Ymd', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['qty']; ?></td>

                                            <?php
                                            if ($row['addqty'] == '') { ?>
                                                <td><a href="admin.php?id=yogurtproductionview&pname=<?php echo $row['pname']; ?>&uid=<?php echo $row['uid']; ?>" class="btn btn-primary btn-sm">Add Detail</a></td>
                                            <?php } else { ?>
                                                <td><a href="" class="btn btn-success btn-sm">Complete</a></td>

                                            <?php } ?>
                                            <td><a href="admin.php?id=yogurtreport&uid=<?php echo $row['uid']; ?>&pid=<?php echo $pname; ?> " class='btn btn-info btn btn-sm'>view</a></td>
                                        </tr>
                                    <?php $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
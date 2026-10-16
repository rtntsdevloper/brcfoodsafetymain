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
                    <a href="admin.php?id=yogurtpackagingadd">
                        <button class="btn btn-primary" style="float:right; margin-left:15px">Add New</button>
                    </a>


                    <!-- <a href="admin.php?id=yogurtview">
                        <button class="btn btn-info" style="float:right; margin-left:15px">View</button>
                    </a> -->
                    <h4 class="card-title mb-3">Yogurt Packaging </h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Product</th>
                                        <th>Batch Code</th>
                                        <th>Quantity</th>
                                        <th>Pack</th>


                                    </tr>
                                </thead>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `tblyogurtpackaging`");
                                $i = 1;
                                foreach ($sql as $row) {

                                    $prod = mysqli_query($con, "SELECT * FROM `tblyogurtproduction` where uid='$row[batchcode]' ");
                                    $prod1 = mysqli_fetch_array($prod);

                                    $pname = $prod1['pname'];

                                    $prodn = mysqli_query($con, "SELECT * FROM `tblyogurt` where id='$pname' ");
                                    $prodname = mysqli_fetch_array($prodn);


                                ?>
                                    <tbody>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $prodname['name'] ?></td>
                                        <td><?php echo $row['batchcode'] ?></td>
                                        <td><?php echo $row['quantity'] ?></td>

                                        <td><?php echo $row['pack'] ?></td>


                                    </tbody>

                                <?php $i++;
                                } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
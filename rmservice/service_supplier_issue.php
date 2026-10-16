<div class="main-content">
    <div class="breadcrumb ">
        <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
        <ul>
            <li><a href="">Home</a></li>
            <li>Raw supplier Management</li>
        </ul>
    </div>

    <div class="row mb-12 my-5">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:4%;">
                <div class="card-body">

                    <h3>Supplier Management</h3>
                    <div class="row pr-4 mb-1">
                        <div class="col-md-12" style="display: flex; justify-content: right;">



                            <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info"
                                    style="float:right; margin-left:15px">Add</button></a>

                            <a href="admin.php?id=supplier-detail"><button class="btn btn-info"
                                    style="float:right; margin-left:15px">Supplier Risk Assesment</button></a>
                            <a href="admin.php?id=complaintadd"><button class="btn btn-danger ml-3">Raise Supplier
                                    Nc</button></a>
                            <a href="admin.php?id=delistsupplier"><button class="btn btn-warning ml-3">Delisted
                                    Supplier</button></a>
                            <a href="admin.php?id=1"><button class="btn btn-success" style=" margin-left:15px">Go
                                    Back</button></a>

                        </div>
                    </div>

                    <div class="row" style="display: flex; justify-content: center;">
                        <div class="col-md-12 " style="display: flex; justify-content: center;">

                            <div class="btn-group my-5" role="group" aria-label="Basic example">
                                <a href="admin.php?id=supplier-management" class="btn  <?php echo $_GET['id'] == 'stockd' ? 'btn-primary' : 'btn-secondary'; ?>">All Supplier</a>
                                <a href="admin.php?id=supplier-management1&sid=1" class="btn <?php echo $sid == '1' ? 'btn-primary' : 'btn-secondary'; ?>">Raw Material Supplier</a>
                                <a href="admin.php?id=supplier-management1&sid=2" class="btn <?php echo $sid == '2' ? 'btn-primary' : 'btn-secondary'; ?>">Service Supplier</a>
                                <a href="admin.php?id=supplier-management1&sid=3" class="btn <?php echo $sid == '3' ? 'btn-primary' : 'btn-secondary'; ?>">Primary Packaging Supplier</a>
                                <a href="admin.php?id=supplier-management1&sid=4" class="btn <?php echo $sid == '4' ? 'btn-primary' : 'btn-secondary'; ?>">Secondary Packaging Supplier</a>
                            </div>

                        </div>
                    </div>



                    <h4 class="card-title mb-3"></h4>
                    <div class="table-responsive" id="basket">
                        <table class=" table table-striped table-bordered" id="zero_configuration_table">
                            <thead>



                                <tr>
                                    <th>#</th>
                                    <th>Supplier Name</th>
                                    <th>Category</th>
                                    <th>Address</th>
                                    <th>Basis of Approval </th>
                                    <th>Type of Supplier </th>
                                    <th>Risk Assesment </th>
                                    <th>Edit</th>
                                    <th>View</th>
                                    <th>Status</th>


                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                $sql = mysqli_query($con, "select * from tblrawsupplier where status='Active'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;

                                    $id = $row['supid'];


                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['supname'] ?></td>
                                        <td><?php
                                            if ($row['category'] == 'Manufacturar') {
                                                echo "Manufacturer";
                                            } else {
                                                echo $row['category'];
                                            }

                                            ?></td>
                                        <td><?php echo $row['address'] ?> </td>

                                        <td><?php

                                            if ($row['approval'] == 'BRCGS Certification') {
                                                echo "BRCGS Certification or any GFSI Benchmark Certificationii";
                                                if (isset($row['dexpire']) && $row['dexpire'] != '0000-00-00') {
                                                    if ($row['dexpire'] > date('Y-m-d')) {
                                                        $ccl = 'text-success';
                                                        $at = "Expiring on";
                                                    } else {
                                                        $ccl = 'text-danger';
                                                        $at = "Expired On";
                                                    }
                                            ?>
                                                    <br>
                                                    <span class="<?php echo $ccl ?>"><?php echo $at ?> : <?php echo $row['dexpire'] ?></span>
                                            <?php
                                                }
                                            } else {
                                                echo $row['approval'];
                                            }

                                            ?>
                                        </td>

                                        <td><?php echo $row['suptype'] ?></td>


                                        <td>
                                            <?php

                                            $sum = $row['risk'];

                                            if ($row['suptype'] == 'Raw Material Supplier') {
                                                if ($row['risk'] == 'Pending') {
                                            ?>
                                                    <a href="admin.php?id=supplierassesment&view=<?php echo $row['supid'] ?>" rel="noopener noreferrer" class="btn btn-outline-info">Complete Assessment</a>
                                                <?php
                                                } else {

                                                    if ($sum >= 5 && $sum <= 9) {
                                                        echo "<span class='text-success fs-2'>Low Risk</h4>";
                                                    } elseif ($sum >= 10 && $sum <= 13) {
                                                        echo "<span class='text-warning fs-2'>Medium Risk</h4>";
                                                    } elseif ($sum >= 14) {
                                                        echo "<span class='text-danger fs-2'>High Risk</h4>";
                                                    }
                                                }
                                            } else {

                                                if ($row['risk'] == 'Pending') {
                                                ?>
                                                    <a href="admin.php?id=serviceassesment&view=<?php echo $row['supid'] ?>" rel="noopener noreferrer" class="btn btn-outline-info">Complete Assessment</a>
                                            <?php
                                                } else {

                                                    if ($sum >= 4 && $sum <= 6) {
                                                        echo "<span class='text-success fs-2'>Low Risk</h4>";
                                                    } elseif ($sum >= 7 && $sum <= 9) {
                                                        echo "<span class='text-warning fs-2'>Medium Risk</h4>";
                                                    } elseif ($sum >= 10) {
                                                        echo "<span class='text-danger fs-2'>High Risk</h4>";
                                                    }
                                                }
                                            }

                                            ?>


                                        </td>




                                        <td> <a href="admin?id=supplier_edit&view=<?php echo $row['supid'] ?>"><button
                                                    class="btn btn-warning">Edit</button></a></td>
                                        <td> <a href="admin?id=supplier_view&view=<?php echo $row['supid'] ?>"><button
                                                    class="btn btn-success">view</button></a></td>


                                        <td> <a href="admin?id=supplier_delist&view=<?php echo $row['supid'] ?>&status=<?php echo $row['status']; ?>"><button
                                                    class="btn btn-<?php
                                                                    if ($row['status'] == 'Active') {
                                                                        echo 'success';
                                                                    } else {
                                                                        echo 'danger';
                                                                    }
                                                                    ?>

                                                    ?>"><?php echo $row['status']; ?></button></a></td>



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
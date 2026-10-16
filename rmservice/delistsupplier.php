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
                    <div class="row pr-4 mb-3" style="float:right">
                        <a href="admin.php?id=supplier-management"><button class="btn btn-success" style=" margin-left:15px">Go
                                Back</button></a>


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
                                    <th>Risk Assesment </th>
                                    <th>Type of Supplier </th>
                                    <!-- <th>raise complaint</th>-->
                                    <th>Edit</th>
                                    <th>View</th>


                                    <th>view</th>

                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                $sql = mysqli_query($con, "select * from tblrawsupplier where status='Delisted'");
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
                                                echo "BRCGS Certification or any GFSI Benchmark Certification";
                                            } else {
                                                echo $row['approval'];
                                            }

                                            ?></td>
                                        <td><?php echo $row['risk'] ?></td>
                                        <td><?php echo $row['suptype'] ?></td>



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
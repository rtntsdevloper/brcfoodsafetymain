<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Products Details</span>

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=products_add"><button class="btn btn-success" style="float:right; margin-left:15px">Add Details</button></a>

                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php

                        $q = "SELECT * FROM `tblproduct1`";
                        $q1 = mysqli_query($con, $q);

                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Product code</th>
                                        <th>Prodname</th>
                                        <th>Storage</th>
                                        <th>Description</th>
                                        <th>Edit</th>
                                       

                                        <!-- <th>view</th> -->

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php

                                    $i = 0;
                                    foreach ($q1 as $data) {
                                        $i++;



                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data['prodcode']; ?></td>
                                            <td><?php echo $data['prodname']; ?></td>
                                            <td><?php echo $data['storage']; ?>

                                            </td>
                                            <td><?php echo $data['descc']; ?></td>
                                            <td><a href="admin.php?id=products_edit&pro=<?php echo $data['prodid']; ?>"><i class="fa fa-pencil" style="font-size:22px;color:navy"></i></a></td>
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


    
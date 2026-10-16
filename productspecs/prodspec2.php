<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Product Specification Detail</span>

                    <a href="admin.php?id=prodspec"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->






                    <div class="row mt-5">
                        <?php
                        $pro = $_GET['pro'];
                        $specx = mysqli_query($con, "SELECT * FROM `save_specification3` WHERE `id` = '$pro'");
                        $specx1 = mysqli_fetch_array($specx);

                        $prodid = $specx1['pid'];



                        $prox = mysqli_query($con, "SELECT * FROM `tblproduct1` WHERE `prodid` = '$prodid'");
                        $prox1 = mysqli_fetch_array($prox);


                        $q = "SELECT * FROM `product_specification`";
                        $q1 = mysqli_query($con, $q);

                        ?>
                        <h3 class="card-title mb-3 ml-3">Product : <?php echo $prox1['prodname']; ?></h3>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Section Name</th>
                                        <th>View</th>


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
                                            <td><?php echo $data['name']; ?></td>
                                            <td><a href="admin.php?id=prodspec3&pro=<?php echo $pro; ?>&sid=<?php echo $data['id']; ?>" class="btn btn-primary">View</a></td>
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
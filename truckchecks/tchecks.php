<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Vehicle daily safety checks </span>

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=trcheck_add"><button class="btn btn-success" style="float:right; margin-left:15px">Add Details</button></a>

                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php

                        $q = "SELECT * FROM `tbl_truckc`";
                        $q1 = mysqli_query($con, $q);

                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Driver Name</th>
                                        <th>Vehicle Reg. No.</th>
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
                                            <td><?php echo $data['tdate']; ?></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['vehicle']; ?>

                                            </td>
                                            <td><a href="admin.php?id=trcheck_view&pro=<?php echo $data['id']; ?>" class="btn btn-primary">View</a></td>
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


    
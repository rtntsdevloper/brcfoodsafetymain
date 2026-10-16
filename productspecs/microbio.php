<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Micro Biological Product Specification</span>

                    <a href="admin.php?id=productspec"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=microbio1"><button class="btn btn-success" style="float:right; margin-left:15px">Add</button></a>
                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php

                        $q = "SELECT * FROM `save_specification_m`";
                        $q1 = mysqli_query($con, $q);

                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Minimum Limit</th>
                                        <th>Maximum Limit</th>
                                        <th>Frquency</th>
                                        <th>Action</th>
                                       

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
                                            <td><?php echo $data['min']; ?></td>
                                          
                                            </td>
                                            <td><?php echo $data['max']; ?></td>
                                            <td><?php echo $data['freq']; ?></td>
                                            <td><a href="admin.php?id=microbio2&bid=<?php echo $data['id']; ?>"><i class="fa fa-edit"></i></a></td>

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


    
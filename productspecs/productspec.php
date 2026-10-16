<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Products Details</span>

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                   

                    <a href="admin.php?id=microbio"><button class="btn btn-info" style="float:right; margin-left:15px">Micro biological</button></a>



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php

                        $q = "SELECT * FROM `tblproduct1` order by prodname asc";
                        $q1 = mysqli_query($con, $q);

                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Product code</th>
                                        <th>Product name</th>
                                        <th>Description</th>
                                        <th>Specification</th>
                                       

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
                                          
                                            </td>
                                            <td><?php echo $data['descc']; ?></td>
                                            <td><a href="admin.php?id=productspec1&pro=<?php echo $data['prodid']; ?>" class="btn btn-primary">View</a></td>
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


    
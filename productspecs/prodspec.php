<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Products Specification</span>

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                   

                    <a href="admin.php?id=prodspec1"><button class="btn btn-info" style="float:right; margin-left:15px">Create Specification</button></a>



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php

                        $q = "SELECT * FROM `save_specification3` order by id desc";
                        $q1 = mysqli_query($con, $q);

                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Product name</th>
                                        <th>Product Code</th>
                                        <th>Specification</th>
                                         <th>Report</th>

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
                                            <td><?php echo $data['prodname']; ?></td>
                                            <td><?php echo $data['prodcode']; ?></td>
                                            <td><a href="admin.php?id=prodspec2&pro=<?php echo $data['id']; ?>" class="btn btn-primary">View</a></td>
                                             <td><a href="admin.php?id=prodspecview&pro=<?php echo $data['id']; ?>" class="btn btn-primary">View Report</a></td>
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


    
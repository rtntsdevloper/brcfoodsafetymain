<?php
include('connection.php')
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Sleeve Issue</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=paperwork"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>


                <a href="admin.php?id=sleveissueadd"><button class="btn btn-danger"
                        style="float:right; margin-left:15px">Add
                        New</button></a>

                <div class="card-title"> Sleeve Issue</div>



                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sr No.</th>
                                <th scope="col">Date</th>
                                <th>Product code</th>
                                <th>Product name</th>
                                <th>Name of Issuer</th>
                                <th scope="col">Check every half an hour</th>
                                <th scope="col">End of shift check</th>
                                <th scope="col">View Report</th>
                               



                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $q = mysqli_query($con, "SELECT   * FROM `sleveissue`");

                            foreach ($q as $row) {
                                $i++;

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                    <td><?php echo $row['productcode']; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['issuername']; ?></td>

                                    <?php if ($row['finaltime'] == '') { ?>
                                        <td><a href="admin.php?id=sleveissueadd1&sno=<?php echo $row['id']; ?>"
                                                class="btn btn-info">add</a></td>
                                    <?php } else { ?>
                                        <td><a href="" class="btn btn-success">completed</a></td> <?php } ?>
                                    <?php if ($row['finaltime'] == '') { ?>
                                        <td><a href="admin.php?id=sleveissueadd2&sno=<?php echo $row['id']; ?>"
                                                class="btn btn-info">End shift</a></td>
                                    <?php } else { ?>

                                        <td><a href="" class="btn btn-success">completed</a></td> <?php } ?>

                                    <?php if ($row['verify'] == '') { ?>
                                        <td><a href="admin.php?id=verifysleve&sno=<?php echo $row['id']; ?>" class='btn btn-warning'>Verify</a></td>
                                    <?php } else { ?>
                                        <td><a href="admin.php?id=verifysleve&sno=<?php echo $row['id']; ?>" class='btn btn-success'>View Report</a></td>
                                    <?php } ?>

                                   

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
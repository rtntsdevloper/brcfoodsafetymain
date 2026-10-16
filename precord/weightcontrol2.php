<?php
$date = $_GET['date'];
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>WEIGHT CONTROL CHECKS</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=weightcontrol1&date=<?php echo $date; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <!-- <a href="admin.php?id=weightcontroladd"><button class="btn btn-info" style="float:right">Add New</button></a> -->
                    </a>

                    <h4 class="card-title mb-3">WEIGHT CONTROL CHECKS</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">S No.</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Size(L)</th>
                                    <th scope="col">Target Overrun %</th>
                                    <th scope="col">Actual Product Overrun %</th>
                                    <th scope="col">Reject below min weight</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>






                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include('connection.php');
                                $sno = $_GET['sno'];
                                $sql = mysqli_query($con, "SELECT * from `weightcontrol1`  where sno='$sno' ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo $row['code']; ?></td>
                                        <td><?php echo $row['size']; ?></td>
                                        <td><?php echo $row['target']; ?></td>
                                        <td><?php echo $row['actual']; ?></td>
                                        <td><?php echo $row['reject']; ?></td>
                                        <td><?php echo $row['start']; ?></td>
                                        <td>
                                            <?php if ($row['end'] == '') { ?>
                                                <a href="admin.php?id=weightcontrolend&sno=<?php echo $sno; ?>&sid=<?php echo $row['id']; ?>&date=<?php echo $date; ?>" class="btn btn-primary">Finish Time</a>
                                            <?php } else {
                                                echo $row['end'];
                                            } ?>

                                        </td>

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
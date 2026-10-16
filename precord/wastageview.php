<?php
$wdate = $_GET['wcode'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Monitoring Form > Wastage Record </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=wastage"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=wastagepdf&wdate=<?php echo $wdate; ?>"><button class="btn btn-warning mr-3" style="float:right">View Report</button></a>
                    </a>

                    <h4 class="card-title mb-3">Wastage Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Area</th>
                                    
                                    <th scope="col">Type of Waste</th>
                                    <th scope="col">Batch No./BB/UB No.</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Action Taken</th>
                                    <th scope="col">Action By</th>



                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php 


                                $sql = mysqli_query($con, "select * from `tbl_wastage` where date='$wdate'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['area']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td><?php echo $row['batch']; ?> </td>
                                        <td><?php echo $row['qty']; ?> </td>
                                        <td><?php echo $row['reason']; ?> </td>
                                        <td><?php echo $row['action']; ?> </td>
                                        <td><?php echo $row['actionby']; ?> </td>
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
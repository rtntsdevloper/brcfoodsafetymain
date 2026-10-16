<?php


$vdate = $_GET['vdate'];

?>

<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=zendbox&pxid=5"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <!-- <a href="admin.php?id=zendboxadd&pxid=<?= $pxid ?>"><button class="btn btn-danger" style="float:right">Add Boxing Record </button></a> -->

                    <a href="admin.php?id=zendboxpdf&vdate=<?php echo $vdate;?>"><button class="btn btn-primary" style="float:right">View Report </button></a>

                    </a>



                    <h4 class="card-title mb-3">Boxing Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Boxing No.</th>
                                    <th scope="col">Boxing Batchcode</th>
                                    <th scope="col">Total Boxs</th>
                                    <th>Units in Each Box</th>
                                    <th>Total Units</th>

                                    <th scope="col">Updated By </th>
                                    <th scope="col">Updated On</th>
                                    <!-- <th>View</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `zendboxing` WHERE date='$vdate'  ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>

                                        <td><?php echo $row['boxbatch']; ?></td>
                                        <td><?php echo $row['batch']; ?></td>
                                        <td><?php echo $row['totalb']; ?></td>
                                        <td><?php echo $row['eachbox']; ?></td>
                                        <td><?php echo $row['totalsachet']; ?></td>
                                        <td><?php echo $row['user']; ?></td>
                                        <td><?php echo date('d-m-y h:i:s', strtotime($row['cxdate'])); ?></td>
                                        <!-- <td><a href="admin.php?id=zendboxpdf&bid=<?= $row['id'] ?>" class="btn btn-info">View</a></td> -->




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
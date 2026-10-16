<?php
$date = $_GET['date'];
?>
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Production Record</li>
        </ul>
    </div> 
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=proddate"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=zenprodpdf&pdate=<?php echo $date; ?>"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>

                    <!-- <a href="admin.php?id=zenprodadd"><button class="btn btn-danger" style="float:right">Add Production </button></a> -->
                    <!-- <a href="admin.php?id=zenprodpdf&pdate=<?php echo $date; ?>"><button class="btn btn-primary">View Report</button></a> -->
                    </a>

                    <h4 class="card-title mb-3">Production Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Production Batch</th>
                                    <th scope="col">Batch Code</th>
                                    <th scope="col">Final Products</th>
                                    <th scope="col">Units Produced</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Updated On</th>
                                    <!-- <th scope="col">Report</th> -->

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $sql = mysqli_query($con, " select * from `zendproduction` where pdate = '$date' order by pdate desc ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $fpro = mysqli_query($con, " SELECT * FROM `zendfinalproduct` where id='$row[fproduct]' ");
                                    $fro1 = mysqli_fetch_array($fpro);

                                    $vpro = mysqli_query($con, " SELECT * FROM `zendprod1` where vid='$row[fproduct]' ");

                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['pdate'])); ?></td>
                                        <td><?php echo $row['prodbatch']; ?></td>
                                        <td><?php echo $row['batch']; ?></td>

                                        <td><?php echo $fro1['name']; ?></td>
                                        <td><?php echo $row['sachet']; ?></td>
                                        <td><?php echo $row['user']; ?></td>
                                        <td><?php echo date('d-m-y h:i:s', strtotime($row['cdate'])); ?></td>
                                        <!-- <td><a href="admin.php?id=zenprodpdf&wcode=<?php echo $row['id']; ?>"><button class="btn btn-primary">View</button></a></td> -->
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
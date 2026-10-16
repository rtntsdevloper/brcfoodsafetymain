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

                    <a href="admin.php?id=weightcontrol"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=weightcontrolreport&date=<?php echo $date; ?>"><button class="btn btn-info" style="float:right">View Report</button></a>
                    </a>

                    <h4 class="card-title mb-3">WEIGHT CONTROL CHECKS</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">S No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Net Weight</th>
                                    <th scope="col">Gross Weight</th>
                                    <th scope="col">Action</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                include('connection.php');
                                $date = $_GET['date'];
                                $sql = mysqli_query($con, "SELECT * from `weightcontrol`  where date='$date' ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['netweight']; ?></td>
                                        <td><?php echo $row['grossweight']; ?></td>

                                        <td>
                                            <?php if (empty($row['give'])) { ?>
                                                <a href="admin.php?id=weightcontroladd1&sno=<?php echo $row['id']; ?>&date=<?php echo $date ?>"
                                                    class="btn btn-primary">Add Record</a>
                                                <a href="admin.php?id=weightcontrolcomment&sno=<?php echo $row['id']; ?>&date=<?php echo $date ?>"
                                                    class="btn btn-primary">Comment</a>
                                            <?php } else { ?>
                                                <a href="#" class="btn btn-success disabled">Add Record</a>
                                                <a href="#" class="btn btn-success disabled">Comment</a>
                                            <?php } ?>
                                            <a href="admin.php?id=weightcontrol2&sno=<?php echo $row['id']; ?>&date=<?php echo $date ?>"
                                                class="btn btn-info">View</a>
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
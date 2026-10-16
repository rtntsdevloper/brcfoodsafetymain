<?php
$sid = $_GET['sid'];

if (isset($_GET['cdate'])) {
    $crntdate = $_GET['cdate'];
} else {
    $crntdate  = date('Y-m-d');
}

$sqld = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE sid='$sid' and status='first'");
$sqld1 = mysqli_fetch_array($sqld);
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Product daily checks</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <h3><?= $sqld1['name']; ?> (<?= date('M d,Y', strtotime($crntdate)) ?>)</h3>
                        </div>
                        <div class="col-md-3">
                            <label for="">Select date</label>
                            <input type="date" class="form-control" value="<?= $crntdate ?>" onchange="getdt(this.value)">

                            <script>
                                function getdt(dt) {
                                    window.location.href = "admin.php?id=dailycal1&sid=<?= $sid ?>&cdate=" + dt;
                                }
                            </script>

                        </div>
                    </div>

                    <a href="admin.php?id=dailychecksdetail"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>




                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>Date</th>
                                    <th>Section</th>
                                    <th>Check Name</th>
                                    <th colspan="2">Attempt</th>
                                    <th>Verification</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($sid == 2) {
                                    $i = 0;
                                    $sqlx = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE sid =$sid and status='third'");
                                    foreach ($sqlx as $sqlx1) {
                                        $spid = $sqlx1['dpid'];

                                        $sql = mysqli_query($con, "SELECT * FROM dailychecks WHERE status='second' AND sid='$spid' order by name");

                                        while ($row = mysqli_fetch_array($sql)) {
                                            $i++;
                                            $txid = $row['id'];
                                            $tmc = mysqli_query($con, "SELECT * FROM `dailycheckss` WHERE date ='$crntdate' and name ='$txid'");
                                            $tmcn = mysqli_num_rows($tmc);
                                ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date("d-m-Y"); ?></td>
                                                <td><?php echo $sqlx1['name']; ?></td>
                                                <td><?php echo $row['name']; ?></td>


                                                <?php
                                                if ($tmcn > 0) {
                                                    $tmcnx = mysqli_fetch_array($tmc);
                                                    if ($row['open'] == 'yes' && $row['close'] == 'yes') {
                                                ?>
                                                        <td>
                                                            <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-success">Startup Checks Report</a>

                                                        </td>
                                                        <?php if ($tmcnx['name1']== '2') { ?>
                                                            <td>
                                                                <a href="admin.php?id=dailychecks4&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-success">Attempt Closing Checks</a>

                                                            </td>
                                                        <?php } else { ?>
                                                            <td>
                                                                <a href="admin.php?id=closingchecks1&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-success">Attempt Closing Checks</a>

                                                            </td>
                                                        <?php }
                                                    } else {
                                                    ?>
                                                        <td colspan="2">
                                                            <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-success">View Report</a>

                                                        </td>
                                                    <?php
                                                    }

                                                    ?>

                                                    <td>
                                                        <a href="admin?id=verifysign&sno=384&tid=38" class="btn btn-warning">Verification Pending</a>

                                                    </td>


                                                <?php
                                                } else {
                                                ?>
                                                    <td colspan="3" class="text-center">
                                                        <a href="admin.php?id=dailychecks1&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-warning">Not Attempted</a>
                                                    </td>

                                                <?php
                                                }
                                                ?>




                                            </tr>
                                        <?php
                                        }
                                    }
                                } else {
                                    $sql = mysqli_query($con, "SELECT * FROM dailychecks WHERE status='second' AND sid='$sid' order by name");
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $i++;
                                        $txid = $row['id'];
                                        $tmc = mysqli_query($con, "SELECT * FROM `dailycheckss` WHERE date ='$crntdate' and name ='$txid'");
                                        $tmcn = mysqli_num_rows($tmc);

                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date("d-m-Y"); ?></td>
                                            <td><?= $sqld1['name']; ?></td>
                                            <td><?php echo $row['name']; ?></td>

                                            <?php
                                            if ($tmcn > 0) {
                                            ?>
                                                <td>
                                                    <a href="#" class="btn btn-success">Attempted</a>

                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-primary">View Report</a>

                                                </td>


                                            <?php
                                            } else {
                                            ?>
                                                <td colspan="2" class="text-center">
                                                    <a href="" class="btn btn-warning">Not Attempted</a>
                                                </td>

                                            <?php
                                            }
                                            ?>

                                        </tr>
                                <?php
                                    }
                                }


                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
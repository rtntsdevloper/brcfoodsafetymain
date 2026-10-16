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
                                    window.location.href = "admin.php?id=dailycal&sid=<?= $sid ?>&cdate=" + dt;
                                }
                            </script>
                        </div>
                    </div>

                    <a href="admin.php?id=dailychecksdetail"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=merge_report&cdate=<?= $crntdate; ?>&sid=<?= $sid; ?>" ><button class="btn btn-primary" style="float:right; margin-left:15px">Verify Report</button></a>
                    <br><br>
                    <div class="table-responsive mt-5">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>Date</th>
                                    <th>Section</th>
                                    <th>Check Name</th>
                                    <th>Attempt</th>
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
                                                
                                                <?php if ($tmcn > 0) {
                                                    $tmcnx = mysqli_fetch_array($tmc);
                                                    if ($row['open'] == 'Yes' && $row['close'] == 'Yes') {
                                                ?>
                                                        <td>
                                                            <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">Startup Checks Report</a>
                                                            <hr class="mx-2" style="width:1px; height:100%; background:black; border:none;display:inline; transform: rotate(0deg);">
                                                            <?php if ($tmcnx['name1'] == '2') { ?>
                                                                <a href="admin.php?id=dailychecks4&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">Closing Checks Report</a>
                                                            <?php } else { ?>
                                                                <a href="admin.php?id=dailycal2&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-warning">Attempt Closing Checks</a>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td >
                                                            <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">View Report</a>
                                                        </td>
                                                    <?php } ?>
                                                    
                                                    <td>
                                                        <?php if (empty($tmcnx['verifysign'])) {
                                                            if ($row['close'] == 'Yes' && $row['open'] == '') { ?>
                                                                <a href="admin?id=dailycalreportc&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-warning">Verification Pending</a>
                                                            <?php } else { ?>
                                                                <a href="admin?id=dailycalreport&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-warning">Verification Pending</a>
                                                            <?php }
                                                        } else { ?>
                                                            <button class="btn btn-success">Verified</button>
                                                        <?php } ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td  class="text-center">
                                                        <a href="admin.php?id=dailycal1&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-warning">Not Attempted</a>
                                                    </td>
                                                    <td></td>
                                                <?php } ?>
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
                                            <td><?php echo $sqld1['name']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            
                                            <?php if ($tmcn > 0) {
                                                $tmcnx = mysqli_fetch_array($tmc);
                                                if ($row['open'] == 'Yes' && $row['close'] == 'Yes') {
                                            ?>
                                                    <td>
                                                        <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">Startup Checks Report</a>
                                                        <?php if ($tmcnx['name1'] == '2') { ?>
                                                            <a href="admin.php?id=dailychecks4&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">Closing Checks Report</a>
                                                        <?php } else { ?>
                                                            <a href="admin.php?id=dailycal2&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-info">Attempt Closing Checks</a>
                                                        <?php } ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td>
                                                        <a href="admin.php?id=dailychecks3&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-info">View Report</a>
                                                    </td>
                                                <?php } ?>
                                                
                                                <td>
                                                    <?php if (empty($tmcnx['verifysign'])) {
                                                        if ($row['close'] == 'Yes' && $row['open'] == '') { ?>
                                                            <a href="admin?id=dailycalreportc&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-warning">Verification Pending</a>
                                                        <?php } else { ?>
                                                            <a href="admin?id=dailycalreport&sno=<?= $tmcnx['id'] ?>&tid=<?= $txid ?>&sxid=<?= $sid ?>" class="btn btn-warning">Verification Pending</a>
                                                        <?php }
                                                    } else { ?>
                                                        <button class="btn btn-success">Verified</button>
                                                    <?php } ?>
                                                </td>
                                            <?php } else { ?>
                                                <td colspan="2" class="text-center">
                                                    <a href="admin.php?id=dailycal1&tid=<?= $txid ?>&cdate=<?= $crntdate  ?>&sxid=<?= $sid ?>" class="btn btn-warning">Not Attempted</a>
                                                </td>
                                            <?php } ?>
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
    </div>
</div>

<script>
$(document).ready(function() {
    $('#zero_configuration_table').DataTable({
        "pageLength": 10,
        "responsive": true,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>
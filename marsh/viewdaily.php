<?php
include 'connection.php';


$from_date = $_GET['from_date'] ?? date('Y-m-d');
$to_date = $_GET['to_date'] ?? date('Y-m-d');
?>
<style>
    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<div class="main-content">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="breadcrumb">
                <h1 class="mr-2"><?php echo $headingname ?? 'Daily Checks'; ?></h1>
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li>Home</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=1">
                        <button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button>
                    </a>
                     <?php
                        if (isset($_GET['sid']) && !empty($_GET['sid'])) {
                            $sid = $_GET['sid'];
                            ?>
                    <a href="admin.php?id=viewpdf&sid=<?php echo $sid; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>">
                        <button style="float:right;" class="btn btn-warning mt-3">View Report</button>
                    </a>
                    <?php
                        }
                         if (isset($_GET['spid']) && !empty($_GET['spid'])) {
                            $spid = $_GET['spid'];
                        ?>
                         <a href="admin.php?id=viewpdf&spid=<?php echo $spid; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>">
                        <button style="float:right;" class="btn btn-warning mt-3">View Report</button>
                        <?php
                         }?>

                    <!-- Filter -->
                    <form method="GET" action="admin.php">
                        <input type="hidden" name="id" value="viewdaily">
                        <?php
                        if (isset($_GET['sid']) && !empty($_GET['sid'])) {
                            $sid = $_GET['sid'];
                        ?>
                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                        <?php
                        }
                        if (isset($_GET['spid']) && !empty($_GET['spid'])) {
                            $spid = $_GET['spid'];
                        ?>
                            <input type="hidden" name="spid" value="<?php echo $spid; ?>">
                        <?php
                        }
                        ?>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control" value="<?php echo $from_date; ?>" required>
                            </div>
                            <div class="col-sm-4">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control" value="<?php echo $to_date; ?>" required>
                            </div>
                            <div class="col-sm-2 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <p>Showing results from <strong><?php echo date('d-m-Y', strtotime($from_date)); ?></strong> to <strong><?php echo date('d-m-Y', strtotime($to_date)); ?></strong></p>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Date</th>
                                    <?php
                                    function getDateRange($start, $end)
                                    {
                                        $dates = [];
                                        $current = strtotime($start);
                                        $end = strtotime($end);
                                        while ($current <= $end) {
                                            $dates[] = date('Y-m-d', $current);
                                            $current = strtotime('+1 day', $current);
                                        }
                                        return $dates;
                                    }

                                    $dateRange = getDateRange($from_date, $to_date);
                                    $names = [];
                                    $showClosing = [];
                                    if (isset($_GET['sid']) && !empty($_GET['sid'])) {
                                        $sid = $_GET['sid'];
                                       
                                            $sq1 = mysqli_query($con, "SELECT * FROM dailychecks WHERE id ='$sid'");
                                        
                                    }
                                    elseif (isset($_GET['spid']) && !empty($_GET['spid'])) {
                                        $spid = $_GET['spid'];
                                        $sq1 = mysqli_query($con, "SELECT * FROM dailychecks WHERE sid ='$spid' and status !='first'");
                                    }

                                    while ($roww = mysqli_fetch_array($sq1)) {
                                        $names[] = $roww;
                                        $showClosing[$roww['id']] = strtolower($roww['close']) === 'yes';
                                        echo '<th colspan="' . ($showClosing[$roww['id']] ? '3' : '2') . '">' . $roww['name'] . '</th>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php foreach ($names as $roww) {
                                        echo '<th>Startup Checks</th><th>Verified by</th>';
                                        if ($showClosing[$roww['id']]) {
                                            echo '<th>Closing Checks</th>';
                                        }
                                    } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($dateRange as $date) {
                                    echo '<tr>';
                                    echo '<td style="font-size:10px;">' . date('d-m-Y', strtotime($date)) . '</td>';
                                    foreach ($names as $roww) {
                                        $checkDate = mysqli_query($con, "SELECT * FROM dailycheckss WHERE name = '" . $roww['id'] . "' AND date = '$date'");
                                        if (mysqli_num_rows($checkDate) > 0) {
                                            $checkRow = mysqli_fetch_assoc($checkDate);
                                            $startupName = !empty($checkRow['user']) ? $checkRow['user'] : 'Unknown';
                                            $startup = '<font color="green">' . $startupName . '</font>';
                                            $startupVerifiedBy = !empty($checkRow['verifyby']) ? '<font color="green">Verified</font>' : '<font color="red">Not Verified</font>';
                                            $closing = !empty($checkRow['name1']) ? '<font color="green">Attempted</font>' : '<font color="red">Not Checked</font>';
                                        } else {
                                            $startup = '<font color="red">Not<br>Checked</font>';
                                            $startupVerifiedBy = '<font color="red">Not Verified</font>';
                                            $closing = '<font color="red">Not Checked</font>';
                                        }

                                        echo '<td>' . $startup . '</td><td>' . $startupVerifiedBy . '</td>';
                                        if ($showClosing[$roww['id']]) {
                                            echo '<td>' . $closing . '</td>';
                                        }
                                    }
                                    echo '</tr>';
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
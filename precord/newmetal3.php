<?php
include 'connection.php';

$headingname = "Metal Detector Record Details";
$id = isset($_GET['tid']) ? $_GET['tid'] : 0;

// Get main record
$result = mysqli_query($con, "SELECT * FROM tblmetal_detector_checks WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if(!$row) {
    header('Location: view_metal_checks.php');
    exit();
}

// Get test records
$tests = mysqli_query($con, "SELECT * FROM tblmetal_detector_tests WHERE check_id = $id ORDER BY test_time");
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="view_metal_checks.php">Metal Detector Record</a></li>
            <li>Record Details</li>
        </ul>
    </div>
    
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=newmetal" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>
                    <a href="admin.php?id=newmetalreport&tid=<?php echo $id;?>" class="btn btn-warning float-right mr-2">View Report</a>

                    <h4 class="card-title mb-3">Metal Detector Check Record #<?php echo $id; ?></h4>
                    <p>Complete details of the metal detector check</p>
                    
                    <!-- Basic Information -->
                    <div class="table-responsive" style="margin-bottom: 20px;">
                        <table class="table table-bordered">
                            <tr style="background: #f8f9fa;">
                                <th width="20%">Date</th>
                                <td width="30%"><?php echo date('d-m-Y', strtotime($row['check_date'])); ?></td>
                                <th width="20%">Line</th>
                                <td width="30%"><?php echo $row['line']; ?></td>
                            </tr>
                            <tr>
                                <th>Operator Sign</th>
                                <td><?php echo $row['operator_sign']; ?></td>
                                <th>Verified by Technical</th>
                                <td><?php echo $row['verified_by']; ?></td>
                            </tr>
                            <!-- <tr>
                                <th>Status</th>
                                <td colspan="3">
                                    <?php if($row['status'] == 'pending'): ?>
                                        <span style="background: #ffc107; color: #333; padding: 3px 8px; border-radius: 3px;">Pending</span>
                                    <?php else: ?>
                                        <span style="background: #28a745; color: white; padding: 3px 8px; border-radius: 3px;">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr> -->
                        </table>
                    </div>
                    
                    <!-- Pre-start up Checks -->
                    <h5>Pre-start up Checks</h5>
                    <div class="table-responsive" style="margin-bottom: 20px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check Item</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Does the metal detector stop and alarm when air pressure is reduced?</td>
                                    <td style="color: <?php echo $row['air_pressure_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                        <?php echo $row['air_pressure_check']; ?>
                                     </td>
                                </tr>
                                <tr>
                                    <td>Does the reject arm fail-safe work correctly?</td>
                                    <td style="color: <?php echo $row['reject_arm_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                        <?php echo $row['reject_arm_check']; ?>
                                     </td>
                                </tr>
                                <tr>
                                    <td>Is the belt stop system working correctly?</td>
                                    <td style="color: <?php echo $row['belt_stop_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                        <?php echo $row['belt_stop_check']; ?>
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Test Records -->
                    <h5>Test Records</h5>
                    <div class="table-responsive" style="margin-bottom: 20px;">
                        <table class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Time</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Size</th>
                                    <th>R/S</th>
                                    <th>Test Stick</th>
                                    <th>Fe</th>
                                    <th>Non-Fe</th>
                                    <th>S/S</th>
                                    <th>Initial</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $j = 0;
                                while($test = mysqli_fetch_assoc($tests)) {
                                    $j++;
                                ?>
                                <tr>
                                    <td><?php echo $j; ?></td>
                                    <td><?php echo $test['test_time']; ?></td>
                                    <td><?php echo $test['product_code']; ?></td>
                                    <td><?php echo $test['product_name']; ?></td>
                                    <td><?php echo $test['product_size']; ?></td>
                                    <td><?php echo $test['reject_action']; ?></td>
                                    <td><?php echo $test['test_stick']; ?></td>
                                    <td style="color: <?php echo $test['fe_result'] == 'Pass' ? 'green' : 'red'; ?>;"><?php echo $test['fe_result']; ?></td>
                                    <td style="color: <?php echo $test['non_fe_result'] == 'Pass' ? 'green' : 'red'; ?>;"><?php echo $test['non_fe_result']; ?></td>
                                    <td style="color: <?php echo $test['ss_result'] == 'Pass' ? 'green' : 'red'; ?>;"><?php echo $test['ss_result']; ?></td>
                                    <td><?php echo $test['initial']; ?></td>
                                </tr>
                                <?php } 
                                if($j == 0) {
                                    echo "<tr><td colspan='11' style='text-align: center;'>No test records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Comments -->
                    <?php if($row['comments']): ?>
                    <div class="alert alert-warning" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px;">
                        <strong>Comments:</strong> <?php echo nl2br($row['comments']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Test Piece Size Reference -->
                    
            </div>
        </div>
    </div>
</div>

<style>
    .main-content { padding: 20px; }
    .breadcrumb { background: #f8f9fa; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
    .breadcrumb h1 { display: inline-block; margin: 0; font-size: 24px; }
    .breadcrumb ul { float: right; list-style: none; margin: 0; padding: 0; }
    .breadcrumb ul li { display: inline-block; margin-left: 10px; }
    .card { border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .card-title { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
    .table th { background: #f8f9fa; }
    h5 { font-weight: bold; margin: 20px 0 10px 0; color: #007bff; }
</style>
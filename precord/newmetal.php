<?php
include 'connection.php';

$headingname = "Metal Detector Check Records";
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li>Metal Detector Record</li>
        </ul>
    </div>
    
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=precord" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>
                    <a href="admin.php?id=newmetal1" class="btn btn-danger" style="float:right">New Check Sheet</a>
                    <h4 class="card-title mb-3">Metal Detector Check Records</h4>
                    <p>List of all metal detector check records</p>
                    
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Line</th>
                                    <th scope="col">Air Pressure Check</th>
                                    <th scope="col">Reject Arm Check</th>
                                    <th scope="col">Belt Stop Check</th>
                                    <th scope="col">Operator Sign</th>
                                    <th scope="col">Verified By</th>
                                    <!-- <th scope="col">Status</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM tblmetal_detector_checks ORDER BY check_date DESC, created_at DESC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                    // Get test records count
                                    $test_count_query = mysqli_query($con, "SELECT COUNT(*) as count FROM tblmetal_detector_tests WHERE check_id = {$row['id']}");
                                    $test_count = mysqli_fetch_assoc($test_count_query);
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['check_date'])); ?></td>
                                        <td><?php echo $row['line']; ?></td>
                                        <td>
                                            <span style="color: <?php echo $row['air_pressure_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $row['air_pressure_check']; ?>
                                            </span>
                                         </td>
                                        <td>
                                            <span style="color: <?php echo $row['reject_arm_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $row['reject_arm_check']; ?>
                                            </span>
                                         </td>
                                        <td>
                                            <span style="color: <?php echo $row['belt_stop_check'] == 'YES' ? 'green' : 'red'; ?>; font-weight: bold;">
                                                <?php echo $row['belt_stop_check']; ?>
                                            </span>
                                         </td>
                                        <td><?php echo $row['operator_sign']; ?></td>
                                        <td><?php echo $row['verified_by']; ?></td>
                                        <!-- <td>
                                            <?php if($row['status'] == 'pending'): ?>
                                                <span style="background: #ffc107; color: #333; padding: 3px 8px; border-radius: 3px; font-size: 12px;">Pending</span>
                                            <?php else: ?>
                                                <span style="background: #28a745; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">Completed</span>
                                            <?php endif; ?>
                                         </td> -->
                                         
                                        <td>
                                            <a href="admin.php?id=newmetal3&tid=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" style="padding: 3px 10px;">View</a>
                                            <?php if($row['status'] == 'pending'): ?>
                                                <a href="admin.php?id=newmetal2&tid=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" style="padding: 3px 10px;">Add Tests</a>
                                            <?php endif; ?>
                                         </td>
                                    </tr>

                                    <?php
                                }
                                if($i == 0) {
                                    echo "<tr><td colspan='10' style='text-align: center;'>No records found</td></tr>";
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

<style>
    .main-content { padding: 20px; }
    .breadcrumb { background: #f8f9fa; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
    .breadcrumb h1 { display: inline-block; margin: 0; font-size: 24px; }
    .breadcrumb ul { float: right; list-style: none; margin: 0; padding: 0; }
    .breadcrumb ul li { display: inline-block; margin-left: 10px; }
    .breadcrumb ul li a { text-decoration: none; }
    .card { border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .card-title { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
    .table th { background: #f8f9fa; }
    .btn-sm { padding: 3px 10px; font-size: 12px; }
</style>

<script>
    // For datatable functionality if needed
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#zero_configuration_table').DataTable({
                "pageLength": 25,
                "order": [[0, 'desc']]
            });
        }
    });
</script>
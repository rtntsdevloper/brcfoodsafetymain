<?php
include 'connection.php';

$cdate = date('Y-m-d');
$ctime = date('Y-m-d H:i:s');

$tid = $_GET['tid'];

$sq2 = mysqli_query($con, "SELECT * FROM dailychecks WHERE id = '$tid'");
$qu2 = mysqli_fetch_array($sq2);

if(isset($_POST['submit'])) {
    $machineused = $_POST['machineused'];
    $tid = $_POST['tid'];
    $reason = $_POST['reason'];
    $user = $_SESSION['user'];
    
    if($machineused == 'Yes') {
        $insert_query = "INSERT INTO dailycheckss (name, machineused, date, time, user) 
                        VALUES ('$tid', 'Yes', '$cdate', '$ctime', '$user')";
        if(mysqli_query($con, $insert_query)) {
            echo "<script>
                window.location.href = 'admin.php?id=dailychecks1&tid=" . $tid . "';
            </script>";
            exit();
        } else {
            echo "<script>alert('Error inserting record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        if(empty($reason)) {
            echo "<script>alert('Please provide a reason why the machine is not operational.');</script>";
        } else {
            $insert_query = "INSERT INTO dailycheckss (name, machineused, reason, date, time, user) 
                            VALUES ('$tid', 'No', '$reason', '$cdate', '$ctime', '$user')";
            if(mysqli_query($con, $insert_query)) {
                echo "<script>
                    window.location.href = 'admin.php?id=upsign&sno=4&tid=" . $tid . "';
                </script>";
                exit();
            } else {
                echo "<script>alert('Error inserting record: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}
?>

<!-- Your HTML form here -->


<div class="main-content">
    <div class="breadcrumb">
        <ul>
            <li><a href="">Home</a></li>
            <li><?php echo isset($headingname) ? htmlspecialchars($headingname) : ''; ?></li>
        </ul>
    </div>
    
    <div class="row">
        <a href="admin.php?id=dailychecks&tid=<?php echo urlencode($tid); ?>">
            <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
        </a>
    </div> 
    <br />
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form name="form1" action="" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="tid" value="<?php echo htmlspecialchars($tid); ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="machineused">Is this section/machine operational today?</label>
                            <div>
                                <input type="radio" name="machineused" id="machine_yes" value="Yes" required onclick="toggleReason(false)" <?php echo (isset($_POST['machineused']) && $_POST['machineused'] == 'Yes') ? 'checked' : ''; ?>>
                                <label for="machine_yes">Yes</label>
                                
                                <input type="radio" name="machineused" id="machine_no" value="No" required onclick="toggleReason(true)" <?php echo (isset($_POST['machineused']) && $_POST['machineused'] == 'No') ? 'checked' : ''; ?>>
                                <label for="machine_no">No</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <button type="submit" name="submit" class="btn btn-primary">Save and Next</button>
                        </div>
                    </div>
                    
                    <!-- Reason field - shown only when "No" is selected -->
                    <div class="row" id="reason_div" style="display: <?php echo (isset($_POST['machineused']) && $_POST['machineused'] == 'No') ? 'block' : 'none'; ?>; margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reason">Please provide reason for not operational: <span style="color:red;">*</span></label>
                                <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter reason why this machine/section is not operational today..." <?php echo (isset($_POST['machineused']) && $_POST['machineused'] == 'No') ? 'required' : ''; ?>><?php echo isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleReason(show) {
    var reasonDiv = document.getElementById('reason_div');
    var reasonField = document.getElementById('reason');
    
    if(show) {
        reasonDiv.style.display = 'block';
        reasonField.required = true;
    } else {
        reasonDiv.style.display = 'none';
        reasonField.required = false;
        reasonField.value = ''; // Clear the reason field when "Yes" is selected
    }
}
</script>
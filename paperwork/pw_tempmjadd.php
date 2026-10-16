<?php
include 'connection.php';
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Quality Control</a></li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=pw_tempmj">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">
                    Oven Temperature Monitoring Form
                </div>

                <form class="needs-validation" novalidate="novalidate" method="post">

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="date_of_production">DATE OF PRODUCTION</label>
                            <input type="date" class="form-control" id="date_of_production" name="date_of_production" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tray_no">Tray No as per rack</label>
                            <input type="text" class="form-control" id="tray_no" name="tray_no" placeholder="Enter tray number" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity_liquid_mix">QUANTITY of liquid mix</label>
                            <input type="text" class="form-control" id="quantity_liquid_mix" name="quantity_liquid_mix" placeholder="Enter quantity" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="starting_temp">STARTING TEMP (liquid mix)</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="starting_temp" name="starting_temp" placeholder="Enter temperature" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">&deg;C</div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="oven_programme_temp">Oven Programme set temperature</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="oven_programme_temp" name="oven_programme_temp" placeholder="Enter set temperature" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">&deg;C</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_in_oven">Time in Oven (when trays are placed)</label>
                            <input type="text" class="form-control" id="time_in_oven" name="time_in_oven" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="temp1_time">Time and TEMP 1 AFTER 1 hour (Min 80 deg c)</label>
                            <input type="time" class="form-control" id="temp1_time" name="temp1_time" placeholder="Time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="temp1_value">&nbsp;</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="temp1_value" name="temp1_value" placeholder="Temperature" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">&deg;C</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="temp2_time">Time and TEMP 2 AFTER temp 1 ANOTHER 10 MIN (Min 80 deg c all corners and middle- record the least number)</label>
                            <input type="time" class="form-control" id="temp2_time" name="temp2_time" placeholder="Time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="temp2_value">&nbsp;</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="temp2_value" name="temp2_value" placeholder="Temperature (least number)" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">&deg;C</div>
                                </div>


                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>

                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>



<style>
    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    .btn {
        margin-right: 10px;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
</style>

<?php
if (isset($_POST['submit'])) {
    $date_of_production = mysqli_real_escape_string($con, $_POST['date_of_production']);
    $tray_no = mysqli_real_escape_string($con, $_POST['tray_no']);
    $quantity_liquid_mix = mysqli_real_escape_string($con, $_POST['quantity_liquid_mix']);
    $starting_temp = mysqli_real_escape_string($con, $_POST['starting_temp']);
    $oven_programme_temp = mysqli_real_escape_string($con, $_POST['oven_programme_temp']);
    $time_in_oven = mysqli_real_escape_string($con, $_POST['time_in_oven']);
    $temp1_time = mysqli_real_escape_string($con, $_POST['temp1_time']);
    $temp1_value = mysqli_real_escape_string($con, $_POST['temp1_value']);
    $temp2_time = mysqli_real_escape_string($con, $_POST['temp2_time']);
    $temp2_value = mysqli_real_escape_string($con, $_POST['temp2_value']);


    $unique_code = "OVEN" . rand(1000, 9999) . date("YmdHis");

    $query = mysqli_query($con, "INSERT INTO `oven_temperature_monitoring` 
        (`pdate`, `tray_no`, `quantity_liquid_mix`, `starting_temp`, 
         `oven_programme_temp`, `time_in_oven`, `temp1_time`, `temp1_value`, 
         `temp2_time`, `temp2_value`, `unique_code`) 
        VALUES 
        ('$date_of_production', '$tray_no', '$quantity_liquid_mix', '$starting_temp', 
         '$oven_programme_temp', '$time_in_oven', '$temp1_time', '$temp1_value', 
         '$temp2_time', '$temp2_value', '$unique_code')");

    if ($query) {
        $lstid = mysqli_insert_id($con);
        echo "<script>window.location.href = 'admin.php?id=pw_tempmjsigns&sno=$lstid';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>
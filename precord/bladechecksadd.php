<?php
include 'connection.php';
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Blade checks</a></li>
        </ul>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=bladechecks">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">
                  Blade check list 
                </div>

                <form class="needs-validation" novalidate="novalidate" method="post">
                    
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                            <div class="invalid-feedback">
                                Please select date.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" required>
                            <div class="invalid-feedback">
                                Please select time.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="fryer_name">Fryer name</label>
                            <input type="text" class="form-control" id="fryer_name" name="fryer_name" placeholder="Enter fryer name" required>
                            <div class="invalid-feedback">
                                Please enter fryer name.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="blade_no">Blade No</label>
                            <input type="text" class="form-control" id="blade_no" name="blade_no" placeholder="Enter blade number" required>
                            <div class="invalid-feedback">
                                Please enter blade number.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="blades_returned">No. of blades returned</label>
                            <input type="number" class="form-control" id="blades_returned" name="blades_returned" placeholder="Enter number of blades returned" required>
                            <div class="invalid-feedback">
                                Please enter number of blades returned.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="blades_issued">No. of blades issued</label>
                            <input type="number" class="form-control" id="blades_issued" name="blades_issued" placeholder="Enter number of blades issued" required>
                            <div class="invalid-feedback">
                                Please enter number of blades issued.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="blades_intact">Are all blades intact? (Y/N)</label>
                            <select class="form-control" id="blades_intact" name="blades_intact" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select Y or N.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Auto-fill current date and time
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = today;
    
    const now = new Date();
    const currentTime = now.toTimeString().slice(0, 5);
    document.getElementById('time').value = currentTime;
});
</script>

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
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $fryer_name = mysqli_real_escape_string($con, $_POST['fryer_name']);
    $blade_no = mysqli_real_escape_string($con, $_POST['blade_no']);
    $blades_returned = mysqli_real_escape_string($con, $_POST['blades_returned']);
    $blades_issued = mysqli_real_escape_string($con, $_POST['blades_issued']);
    $blades_intact = mysqli_real_escape_string($con, $_POST['blades_intact']);
    
    $unique_code = "BLADE" . rand(1000, 9999) . date("YmdHis");
    
    $query = mysqli_query($con, "INSERT INTO `fryer_blades_inspection` 
        (`date`, `time`, `fryer_name`, `blade_no`, `blades_returned`, `blades_issued`, `blades_intact`, `unique_code`) 
        VALUES 
        ('$date', '$time', '$fryer_name', '$blade_no', '$blades_returned', '$blades_issued', '$blades_intact', '$unique_code')");
    
    if ($query) {

        $nxt = mysqli_insert_id($con);
        echo "<script>alert('Record added successfully'); window.location.href = 'admin.php?id=bladechecksign&sno=$nxt';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>
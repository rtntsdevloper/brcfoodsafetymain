<?php
include 'connection.php';
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Daily Dough Weight Check</li>
        </ul>
    </div>

    <p style="color: red; font-size:15px;" class="ml-3">
        Refer to the product manual for the dough weight.<br>
        The dough weight should be equivalent to the product weight mentioned in the product manual.<br>
        If any deviation noticed, inform your line manager.<br>
        Check Dough Weight Every 1 Hours.
    </p>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 style="float:left;">Add Record</h3>
                <a href="admin.php?id=dough">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" name="time" required />
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Dough Weight</label>
                            <input class="form-control" id="validationTooltip02" type="number" name="dough" required />
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 2</label>
                        <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="dough2" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 3</label>
                        <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="dough3" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 4</label>
                        <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="dough4" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 5</label>
                        <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="dough5" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Add by</label>
                            <input class="form-control" id="validationTooltip02" type="text" name="addby" required />
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$sid = $_GET['sid'];
if (isset($_POST['submit'])) {
    $time  = $_POST['time'];
    $dough = $_POST['dough'];
    $dough2 = $_POST['dough2'];
    $dough3 = $_POST['dough3'];
    $dough4 = $_POST['dough4'];
    $dough5 = $_POST['dough5'];

    $addby = $_POST['addby'];
    $record = date('dmhis');


    // Insert into your table (replace 'dough_records' with your actual table name)
    $sql = "INSERT INTO dough1 (sid,stime, dough,dough2,dough3,dough4,dough5,addby,recordid) VALUES ('$sid','$time', '$dough','$dough2','$dough3','$dough4','$dough5', '$addby','$record')";
    if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=doughsign1&rid=" . $record . "';</script>";
    } else {
        echo "<p style='color:red; margin-left:20px;'>Error: " . mysqli_error($con) . "</p>";
    }
}
?>
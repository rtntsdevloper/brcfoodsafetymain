<?php
include 'connection.php';


$pid = $_GET['tid'];


?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Add Delivery Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=deliverylog"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Time</label>
                            <input class="form-control" id="validationTooltip01" type="time" required="required" name="time" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        </div>
                         <div class="form-row ">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Supplier</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="supplier" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                         </div>
                     <div class="form-row mt-2">
                        <div class="col-md-6 mb-3">
                            <label for="deliveryAccepted">Delivery Accepted</label>
                            <div class="form-control pt-2" style="border: none; padding-left: 16px;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_accepted" id="deliveryYes" value="Yes" required>
                                    <label class="form-check-label" for="deliveryYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_accepted" id="deliveryNo" value="No" required>
                                    <label class="form-check-label" for="deliveryNo">No</label>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please select an option
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Use By Date/Best Before Date: </label>
                            <input name="useby" type="date" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

</div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Product batch Code</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="batchcode" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04"> Temprature</label>
                            <input name="temp" type="text" class="form-control" id="validationTooltip05" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>
            </div>

            </br>
            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
            </form>
        </div>
    </div>
</div>
<?php
include 'connection.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $supplier = $_POST['supplier'];
    $product = $_POST['product'];
    $delivery = $_POST['delivery_accepted'];
    $useby = $_POST['useby'];
    $batchcode = $_POST['batchcode'];
    $temp = $_POST['temp'];

    $nrk = mysqli_query($con, "select * from deliverylog");
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;
    $record = "Wel001" . $nrkn;

    // Insert into deliverylog
    $sql = "INSERT INTO deliverylog (date, time, supplier, product, delivery_accepted, useby, batchcode, temp, recordid,tid) 
            VALUES ('$date', '$time', '$supplier', '$product','$delivery', '$useby', '$batchcode', '$temp', '$record','$pid')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>alert('Delivery Log added successfully!');</script>";
        echo '<script> window.location.href = "admin.php?id=dispatch_sign&rid=' . $record . '";</script>';
    } else {
        echo "<script>alert('Error adding Delivery Log: " . mysqli_error($con) . "');</script>";
    }
}
?>
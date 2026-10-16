<?php
include 'connection.php';
$pid = $_GET['eid'];

$check = mysqli_query($con, "SELECT * FROM tblweight WHERE id='$pid'");
$data = mysqli_fetch_array($check);
$sproduct = $data['product'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add Blast Chiller Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=saucedate&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>




                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Product</label>
                            <input class="form-control" id="validationTooltip01" type="text" value="<?php echo $sproduct;?>" required="required" name="product" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack tare Weight (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="packtare" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack 1 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack1" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack 2 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack2" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack 3 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack3" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack 4 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack4" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack 5</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack5" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Declare Weight (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="declared" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>



                    </div>






                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
            </div>
        </div>




    </div>



    </br>

    </form>
</div>
</div>
</div>

<?php
if (isset($_POST['submit'])) {
    // Basic input sanitization
    $product = $_POST['product'];
    $time = $_POST['time'];
    $tare = $_POST['packtare'];
    $pack1 = $_POST['pack1'];
    $pack2 = $_POST['pack2'];
    $pack3 = $_POST['pack3'];
    $pack4 = $_POST['pack4'];
    $pack5 = $_POST['pack5'];
    $addby = $_POST['addby'];
    $eid = $pid;
    $declare = mysqli_real_escape_string($con, $_POST['declared']);

    // Fixed table name from tnblweight to tblweight
    $nrk = mysqli_query($con, "SELECT * FROM tblweight1");
    if (!$nrk) {
        die("Error in query: " . mysqli_error($con));
    }
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;
    $record = "Wei00" . $nrkn;

    $result = mysqli_query($con, "INSERT INTO tblweight1(product, time, packtare, pack1, pack2, pack3, pack4, pack5, `declared`, `eid`, `recordid`, `addby` ) 
                VALUES('$product', '$time', '$tare', '$pack1', '$pack2', '$pack3', '$pack4', '$pack5', '$declare', '$eid', '$record', '$addby')");

    if ($result) {

        echo '<script>window.location.href = "admin.php?id=weightsign&rid=' . $record . '&eid=' . $pid . '";</script>';
    } else {
        echo "<script>alert('Error adding weight Log: " . addslashes(mysqli_error($con)) . "');</script>";
    }
}
?>
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

    <p style="color: red; font-size:15px;" class="ml-3">Refer to the product manual for the dough weight.<br> The dough weight should be equivalent to the product weight mentioned in the product manual.<br> If any deviation noticed, inform your line manager.
        <br>Check Dough Weight Every 1 Hours.
    </p>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 style="float:left;">Add Record</h3>
                <a href="admin.php?id=dough"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="validationTooltip02">Select Product Batchcode</label>
                            <select class="form-control" name="product" required>
                                <option>Please Select</option>
                                <?php
                                $sqli = mysqli_query($con, "select * from tblmarination where status='Done' and dough!='Done' order by date DESC");
                                while ($row = mysqli_fetch_array($sqli)) {
                                ?>
                                    <option value="<?php echo $row['batchcode']; ?>"><?php echo $row['batchcode']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
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
                        <label for="validationTooltip02">Dough Weight 1</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="dough" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 2</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="dough2" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 3</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="dough3" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 4</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="dough4" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Dough Weight 5</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="dough5" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>



                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Add by</label>
                        <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="addby" required />
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <!-- <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Iced Water oC -1.0 to +1.0oC</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="iwater1" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Boiling Water oC 99oC (+/-1)</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="iboil1" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div> -->

            </div>

        </div>
        </br>
        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
        </form>
    </div>
</div>
</div>

<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $serial = $_POST['product'];
    $name = '';
    $ref = $_POST['time'];
    $ref1 = '';
    $tident = $_POST['dough'];

    $dough2 = $_POST['dough2'];
    $dough3 = $_POST['dough3'];
    $dough4 = $_POST['dough4'];
    $dough5 = $_POST['dough5'];


    $add = $_POST['addby'];

    $nrk = mysqli_query($con, "select * from tbldough");
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;
    $record = "Dough001" . $nrkn;
// echo "INSERT INTO tbldough (date,product, pcode, time, batch, dough,dough2,dough3,dough4,dough5, recordid, addby) VALUES ('$date','$serial', '$name','$ref', '$ref1', '$tident', '$dough2','$dough3','$dough4','$dough5','$record', '$add')";
// die;
    $sql = "INSERT INTO tbldough (date,product, pcode, time, batch, dough,dough2,dough3,dough4,dough5, recordid, addby) VALUES ('$date','$serial', '$name','$ref', '$ref1', '$tident', '$dough2','$dough3','$dough4','$dough5','$record', '$add')";
    $sql1 = mysqli_query($con, $sql);
    $sqlx = mysqli_query($con, "UPDATE tblmarination SET dough='done' where batchcode='$serial'");

    if ($sql1 && $sqlx) {

        echo "<script>window.location.href='admin.php?id=doughsign&rid=" . $record . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
<?php
include 'connection.php';
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Auditor Management</a></li>
            <li>Add Plaster</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=plaster"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title">Add  Plaster Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date of Issuing</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Plaster Issued to</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name"
                                name="product" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Plaster Issued By</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required"
                                name="trace" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Plaster Check and instact end of shift?</label>
                            <input name="temp" type="text" class="form-control" id="validationTooltip05"
                                required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>






                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Check By</label>
                            <input name="sign" type="text" class="form-control" id="validationTooltip06" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['submit'])) {

        $date = $_POST['date'];
        $product = $_POST['product'];

        $trace = $_POST['trace'];
        $temp = $_POST['temp'];
        $sign = $_POST['sign'];


        $sq = "INSERT INTO tblplaster (date, issueto,  issueby, shift, checkby) VALUES ('$date', '$product', '$trace', '$temp', '$sign')";
        $result = mysqli_query($con, $sq);

        if ($result == 1) {
            echo "Record Added Successfully";

        }
    }

    ?>
<?php
include 'connection.php';
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Suplier Stationary Record Record</a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=mlmeats1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Supplier Stationary Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date of Issuing Stationary
                            </label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Description of Issuing Stationary
                            </label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="disc" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Stationary Issue To
                            </label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="stationary" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Stationary Issued By
                            </label>
                            <input name="stationaryby" type="text" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>




                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Is Used Stationary Returned?</label>
                            <select name="returned" id="" class="form-control">
                                <option value="">Please Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Signature</label>
                            <input name="sign" type="text" class="form-control" id="validationTooltip05" required="required" />
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

if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    $disc = $_POST['disc'];
    $product = $_POST['stationary'];

    $qty = $_POST['stationaryby'];
    $trace = $_POST['returned'];
    $temp = $_POST['sign'];

    $sq = "INSERT INTO mlmeats (date, disc, stationary, stationaryby, returned, sign) VALUES ('$date', '$disc', '$product', '$qty', '$trace', '$temp')";
    $result = mysqli_query($con, $sq);

    if ($result == 1) {
        echo "Record Added Successfully";
    }
}

?>
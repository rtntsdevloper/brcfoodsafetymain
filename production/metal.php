<?php
include 'connection.php';
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Metal Detection Record</a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=metal1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <div class="card-title">Add Metal Detection Record</div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Delivery Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Batch Number</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="batch" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Date of Check</label>
                            <input name="checked" type="date" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Rejected By Metal Detector</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="rejected" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Signed</label>
                            <input name="signed" type="text" class="form-control" id="validationTooltip05" required="required" />
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
    $batch = $_POST['batch'];
    $check = $_POST['checked'];
    $rejected = $_POST['rejected'];
    $sign = $_POST['signed'];

    $sq = "INSERT INTO metal (date, batch, checked, rejected, signed) VALUES ('$date', '$batch', '$check', '$rejected', '$sign')";
    $result = mysqli_query($con, $sq);

    if ($result == 1) {
        echo "Record Added Successfully";

        // header("Location: admin.php?id=metal1");
    }
}

?>
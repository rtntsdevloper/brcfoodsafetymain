<?php
include 'connection.php';
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Plaster Record</a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=plaster1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Plaster Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date of Issuing Plaster</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="dateissue" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Plaster Issued To</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="plasterissue" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Plaster Issued By</label>
                            <input name="issueby" type="text" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Plaster checked and intect end of Shift</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="plaster" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Checked By</label>
                            <input name="checkedby" type="text" class="form-control" id="validationTooltip05" required="required" />
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

    $date = $_POST['dateissue'];
    $product = $_POST['plasterissue'];
    $qty = $_POST['issueby'];
    $trace = $_POST['plaster'];
    $temp = $_POST['checkedby'];

    $sq = "INSERT INTO tblplasterrecord (dateissue, plasterissue, issueby, plaster, checkedby) VALUES ('$date', '$product', '$qty', '$trace', '$temp')";
    $result = mysqli_query($con, $sq);

    if ($result == 1) {
        echo "Record Added Successfully";
    }
}

?>
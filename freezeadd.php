<?php
include 'connection.php';
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Records</a></li>
            <li>Frozen Record</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=freeze"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Defrost Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="product" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Quantity</label>
                            <input name="qty" type="number" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Trace Code (Batch Code/UBD)</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="trace" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Temprature</label>
                            <input name="temp" type="text" class="form-control" id="validationTooltip05" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>




                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Date Moved to Chiller for Freezing</label>
                            <input name="moved" type="date" class="form-control" id="validationTooltip06" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Freezer Temprature</label>
                            <input name="chiller" type="text" class="form-control" id="validationTooltip06" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Signed By</label>
                            <input name="sign" type="text" class="form-control" id="validationTooltip06" />
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
    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $trace = $_POST['trace'];
    $temp = $_POST['temp'];
    $moved = $_POST['moved'];
    $chiller = $_POST['chiller'];
    $sign = $_POST['sign'];


    $sq = "INSERT INTO tblfreeze(date, product, qty, trace, temp, moved, chiller, sign) VALUES ('$date', '$product', '$qty', '$trace', '$temp', '$moved', '$chiller', '$sign')";
    $result = mysqli_query($con, $sq);

    if ($result) {
?>

        <script language="javascript">
            window.open('admin.php?id=freeze', '_self');
        </script>

<?php

    }
}

?>
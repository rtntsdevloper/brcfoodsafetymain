<?php
include 'connection.php';

?>


<div class="main-content">

    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Finished product pallet description record sheet</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h4>Finished product pallet description record sheet</h4>
                <a href="admin.php?id=finished"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date/Time</label>
                            <input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pallet Number</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="pallet" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Initials</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="initials" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Quantity</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="qty" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Batch No.</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="batch" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Use by/Best Before</label>
                            <input class="form-control" id="validationTooltip04" type="date" required="required" name="useby" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="validationTooltip03">Description</label>
                            <textarea class="form-control" id="validationTooltip04" type="text" required="required" name="desc"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>

                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background-color: #f8f9fa;
                            border: 1px solid #dee2e6;
                            border-radius: 4px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                        }

                        .sub-tabs {
                            padding: 10px;
                            border: 1px solid #dee2e6;
                            border-top: none;
                            border-radius: 0 0 4px 4px;
                        }
                    </style>




            </div>
        </div>
            <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
    </div>



    
    </form>
</div>


<?php

if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    $pallet = $_POST['pallet'];
    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $initials = $_POST['initials'];
    $useby = $_POST['useby'];
    $cmnt = $_POST['desc'];
    $batch = $_POST['batch'];
    $unique_id = 'REC-' . rand(1000, 9999);
    

    $sql = "INSERT INTO tblfinished (recordid, date, pallet, product, qty, initials, useby, cmnt, batch) VALUES ('$unique_id', '$date', '$pallet', '$product', '$qty', '$initials', '$useby', '$cmnt', '$batch')";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Record added successfully');</script>";
        echo "<script>window.location.href='admin.php?id=finished&rid=" . $unique_id . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}
?>
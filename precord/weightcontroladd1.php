<?php
include 'connection.php';
$date = $_GET['date'];
$sno = $_GET['sno'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=weightcontrol"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">WEIGHT CONTROL CHECKS</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Product</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="product" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Code</label>
                            <input type="text" name="code" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Size(L)</label>
                            <input type="text" name="size" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Target Overrun %</label>
                            <div class="input-group mb-3">
                                <input type="text" name="target" id="" class="form-control">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual Product Overrun %</label>
                            <div class="input-group mb-3">
                                <input type="text" name="actual" id="" class="form-control">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Reject below min weight</label>
                            <select name="reject" class="form-control" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input type="time" name="starttime" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    </div>
                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
            </div>


        </div>




        </form>
    </div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $product = $_POST['product'];
    $code = $_POST['code'];
    $size = $_POST['size'];
    $target = $_POST['target'];
    $actual = $_POST['actual'];
    $reject = $_POST['reject'];
    $starttime = $_POST['starttime'];




    // echo "INSERT INTO `weightcontrol1`(`sno`, `product`, `code`,`size`,`target`,`actual`,`reject`,`start`) VALUES ('$sno','$product','$code','$size','$target','$actual','$reject','$starttime' )";die;

    $insert = mysqli_query($con, "INSERT INTO `weightcontrol1`(`sno`, `product`, `code`,`size`,`target`,`actual`,`reject`,`start`) VALUES ('$sno','$product','$code','$size','$target','$actual','$reject','$starttime' )");

    if ($insert) {
        echo "<script>window.location.href='admin.php?id=weightcontrol1&date=$date'</script>";
    }
}


?>
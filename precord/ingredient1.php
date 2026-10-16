<?php
include 'connection.php';
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
                <a href="admin.php?id=ingredient"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Ingredient and Product Transfer form – Production area
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="idate" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time of Transfer</label>
                            <input type="time" name="ttime" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Name of Product/Ingredient</label>
                            <input type="text" name="pname" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Quantity</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="qty" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Is Raw material/Packaging intact prior to transfer? </label>
                            <select name="intact" id="" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comment</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="reason" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        </br>
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>



                    </div>
            </div>

        </div>


        </form>
    </div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $idate = $_POST['idate'];
    $ttime = $_POST['ttime'];
    $pname = $_POST['pname'];
    $qty = $_POST['qty'];
    $intact = $_POST['intact'];
    $reason = $_POST['reason'];
    $cdate = date('Y-m-d H:i:s');


    $nrk = mysqli_query($con, "select * from `tbl_ingredienttrans` ");
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;

    $record = "ING" . date('Ymdhis') . $nrkn;



    $sq = "INSERT INTO `tbl_ingredienttrans`(`tdate`,`ttime`, `name`, `qty`, `ques`, `comment`, `recordid`,`user`, `cdate`) VALUES ('$idate','$ttime','$pname','$qty','$intact','$reason','$record','$user','$cdate')";
    $result = mysqli_query($con, $sq);

    if ($result) {

        echo '<script> window.location.href = "admin.php?id=ingredientsign&rid=' . $record . '";</script>';
    }
}

?>
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

                <div class="card-title">CCP 3* - COOLING (must be to 7°C or less within 90 minutes of homogenisation)</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pre-transfer cooling temperature(C)</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" name="cooltemp" id="cooltemp" class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><sup>o</sup>C</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Finish time for transfer to high care tank</label>
                            <input type="time" name="finish_time" class="form-control" required>


                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Total time from homogenisation to transfer (minutes)</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" name="totaltime" id="acttemp" class="form-control" required="required">
                                <div class="input-group-append">
                                    <span class="input-group-text">Minutes</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Transferred to tank no:</label>
                            <input type="text" name="tank" id="tank" class="form-control" required>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comments:</label>
                            <textarea name="cmnt" id="homocommnts" class="form-control"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>




                        </br>
                        </br>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="btn">Save & Next</button>
                        </div>




                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

if (isset($_POST['btn'])) {
    $tid = $_GET['tid'];
    $cooltemp = $_POST['cooltemp'] . "<sup>o</sup>C";
    $finish_time = $_POST['finish_time'];
    $totaltime = $_POST['totaltime'] . " Minutes";
    $tank = $_POST['tank'];
    $cmnt = $_POST['cmnt'];
    $udate = date('Y-m-d H:i:s');
    $cuser = $_SESSION['user'];


    $insert = mysqli_query($con, "INSERT INTO `dist_cooling`(`ctemp`, `ftime`, `totaltime`, `transfer`, `cuser`, `cdt`, `cmnt`, `tid`) VALUES ('$cooltemp','$finish_time','$totaltime','$tank','$cuser','$udate','$cmnt','$tid')");
    $cid = mysqli_insert_id($con);

    $update = mysqli_query($con, "UPDATE `dist_mixrecord` SET `cool`='done' WHERE id ='$tid'");
    if ($insert) {
        echo "<script> window.location.href = 'admin.php?id=dist_check&rid=$cid'; </script>";
    }
}



?>
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
                <a href="admin.php?id=dist_mixing"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">HOMOGENISATION</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Set pressure in homogeniser (PSI)/Bar.</label>
                            <input type="text" name="homopres" id="homopres" class="form-control" required>


                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Homogeniser start time</label>
                            <input type="time" name="homotime" id="homotime" class="form-control" required>


                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comments:</label>
                            <textarea name="homocommnts" id="homocommnts" class="form-control"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>




                        </br>
                        </br>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="btn">Submit data</button>
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
    $homopres = $_POST['homopres'];
    $homotime = $_POST['homotime'];
    $homocommnts = $_POST['homocommnts'];
    $hmpdate = date('Y-m-d H:i:s');


    $insert = mysqli_query($con, "INSERT INTO `dist_homogeniser`(`tid`, `homopres`, `homotime`, `cmnt`, `udate`) VALUES ('$tid','$homopres','$homotime','$homocommnts','$hmpdate')");

    $update = mysqli_query($con, "UPDATE `dist_mixrecord` SET `homo`='done' WHERE id ='$tid'");
    if ($insert) {
        echo "<script> window.location.href = 'admin.php?id=dist_mixing'; </script>";
    }
}



?>
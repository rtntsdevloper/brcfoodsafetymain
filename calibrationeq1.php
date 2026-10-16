<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Machinery Management</a></li>
            <li>Add Machinery</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=ppmmgmt">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Add Machinery</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                    <div class="form-row" id="ppmd">

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Is equipment being Calibrated Internally or Externally?</label>
                            <select class="form-control" id="eqserv" name="service" required>
                                <option value="">Please Select</option>
                                <option value="IN">IN</option>
                                <option value="EX">EX</option>
                                <option value="IN/EX">IN/EX</option>
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Frequency</label>
                            <select name="frequency" id="frequency" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Yearly">Yearly</option>
                                <option value="Two Yearly">Two Yearly</option>
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Calibration Date</label>
                            <input class="form-control" id="frequency" type="date" placeholder="Calibration Date" name="cdate" required/>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Calibration Due Date</label>
                            <input class="form-control" id="servsup" type="date" placeholder="Calibration Due Date" name="cdue" required />

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Certfication No.</label>
                            <input class="form-control" id="maintain" type="text" placeholder="Frequency" name="certno" required/>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Calibration File</label>
                            <input class="form-control" id="maintain" type="file" placeholder="Frequency" name="cfile" required/>

                        </div>



                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$sno = $_GET['sno'];

if (isset($_POST['submit'])) {
    $cfile = $_FILES['cfile'];
    $cdate = $_POST['cdate'];
    $cdue = $_POST['cdue'];
    $service = $_POST['service'];
    $cndate = date('Y-m-d H:i:s');
    $certno = $_POST['certno'];
    $cfrequency = $_POST['frequency'];

    $sqln = mysqli_query($con, "SELECT * FROM `tblcalbhistory` WHERE `vid` = '$sno'");
    $row = mysqli_num_rows($sqln);
    if ($row > 0) {
        $sqlp = "UPDATE `tblcalbhistory` SET status='Inactive' WHERE `vid` = '$sno' AND `status`='Active'";
        $resultp = mysqli_query($con, $sqlp);
    }

    if (isset($cfile) && !empty($cfile['name'])) {
        $cfile_name = $cfile['name'];
        $cfile_tmp_name = $cfile['tmp_name'];

        $cxname = "CAL" . date('Ymdhis') . $cfile_name;
        move_uploaded_file($cfile_tmp_name, 'upl1/' . $cxname);
    } else {
        $cxname = "";
    }

    $sqln = "INSERT INTO `tblcalbhistory`(`vid`, `clabi`, `caldate`, `caldue`, `calfile`, `user`, `datet`, `status`, `certno`, `frequency`) VALUES ('$sno','$service','$cdate','$cdue','$cxname','$user','$cndate','Active','$certno','$cfrequency')";
  
    $resultn = mysqli_query($con, $sqln);
    if ($resultn) {
        echo "<script>
        window.location.href='admin.php?id=calibrationeq';
        </script>";
    }
}



?>
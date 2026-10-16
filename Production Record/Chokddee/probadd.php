<?php
include 'connection.php';
$pid = $_GET['tid'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Probe Calibration</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=probdate"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="name" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                    </div>
                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Thermometer Identification</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="tident" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Thermometer Serial No.</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="tserial" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Area</label>
                            <input name="area" type="text" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>

                    <div class="form-row mt-5">
                        <div class="col-md-6">
                            <div class="heading-tab" required>
                                <h6>Thermometer Check ◦C (Hot Water) Between 100ºC ± 1.0ºC</h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-1">
                                <label>Referance Thermometer Temperature</label>
                                <div class="input-group mb-2">

                                    <input type="number" class="form-control" id="inlineFormInputGroup" name="th1" placeholder="temperature" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
                                <label>Area Prob Temperature</label>
                                <div class="input-group mb-2">

                                    <input type="number" class="form-control" id="inlineFormInputGroup" name="th2" placeholder="temperature" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-2">
                                <h6>Thermometer Check ◦C (Chill Water) Between -5ºC-0ºC</h6>
                            </div>
                            <div class="sub-tabs">


                                <label>Referance Thermometer Temperature</label>
                                <div class="input-group mb-2">

                                    <input type="number" class="form-control" id="inlineFormInputGroup" name="ch1" placeholder="temperature" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>

                                <label>Area Prob Temperature</label>
                                <div class="input-group mb-2">

                                    <input type="number" class="form-control" id="inlineFormInputGroup" name="ch2" placeholder="temperature" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-6 mb-3 mt-3">
                            <label for="validationTooltip02">Checked by</label>
                            <?php
                            $qs = mysqli_query($con, "Select * from tblprecord where id = '$pid'");
                            $qs1 = mysqli_fetch_array($qs);
                            $qsid = $qs1['pid'];

                            $psr = mysqli_query($con, "Select * from `tblrecord_attempt` where pid = '$qsid'");



                            ?>
                            <select name="checked" id="" class="form-control">
                                <option>Select Your Name</option>
                                <?php
                                foreach ($psr as $psdata) {
                                    $prname  = $psdata['name'];
                                    echo '<option value="' . $prname . '">' . $prname . '</option>';
                                }

                                ?>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mt-3">
                            <label for="validationTooltip02">Corrective Action (if any )</label>
                            <textarea name="crk" class="form-control"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
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
    </br>
    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
    </form>
</div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $tident = $_POST['tident'];
    $tserial = $_POST['tserial'];
    $area = $_POST['area'];
    $th1 = $_POST['th1'];
    $th2 = $_POST['th2'];
    $ch1 = $_POST['ch1'];
    $ch2 = $_POST['ch2'];
    $check = $_POST['checked'];
    $correct = $_POST['crk'];

    $sql = "INSERT INTO tblprob (date, name, tident, tserial, area, th1, th2, ch1, ch2, checked,correct,pid) VALUES ('$date', '$name', '$tident', '$tserial', '$area', '$th1', '$th2', '$ch1', '$ch2', '$check','$correct','$pid')";

    if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=probdate&tid=".$pid."';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
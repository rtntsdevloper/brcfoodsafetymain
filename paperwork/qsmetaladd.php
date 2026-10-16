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
                <a href="admin.php?id=pw_qsmetal"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">QMS Metal Detector Fail Safe Test Form (For Retail)
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row mb-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="tdate" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time </label>
                            <input type="time" name="ttime" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the time.
                            </div>
                        </div>
                    </div>

                    <?php
                    $sql = mysqli_query($con, "SELECT * FROM `pw_ques`");
                    $i = 0;
                    while ($row = mysqli_fetch_array($sql)) {
                        $i++;
                    ?>

                        <div class="form-row">
                            <div class="col-md-12 mb-1">
                                <label for="validationTooltip02"><b><?php echo $i; ?>. Name of test :</b></label>
                                <?php echo $row['test']; ?>
                                <input type="hidden" name="ntest[]" value="<?php echo $row['test']; ?>">
                            </div>

                            <div class="col-md-12 mb-1">
                                <label for="validationTooltip02"><b>Purpose of test :</b></label>
                                <?php echo $row['purpose']; ?>
                                 <input type="hidden" name="npurpose[]" value="<?php echo $row['purpose']; ?>">
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Test result(Pass/Fail)</label>
                                <select name="testresult[]" id="testresult<?php echo $i; ?>" class="form-control" onchange="showcorrective(this.value, <?php echo $i; ?>)" required>
                                    <option value="">Select</option>
                                    <option value="Pass">Pass</option>
                                    <option value="Fail">Fail</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                                <script>
                                    function showcorrective(value, i) {
                                        var el = document.getElementById("correct" + i);
                                        if (value == "Fail") {
                                            el.setAttribute("required", "required");
                                        } else {
                                            el.removeAttribute("required");
                                        }
                                    }
                                </script>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Corrective Action</label>
                                <textarea name="corrective[]" id="correct<?php echo $i; ?>" class="form-control"></textarea>

                                <div class="invalid-tooltip">
                                    Please fill the corrective action.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Comment</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="cmnt[]" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            </br>

                        </div>
                        <hr>
                    <?php
                    }
                    ?>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                        </div>
                    </div>
            </div>

        </div>


        </form>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $tdate = $_POST['tdate'];
    $ttime = $_POST['ttime'];
    $ucode = "QS" . rand(1000, 9999) . date("Ymd");
    $qsm = mysqli_query($con, "INSERT INTO `pw_qmsmetal`(`qdate`, `qtime`, `ucode`) VALUES ('$tdate', '$ttime', '$ucode')");
    $qsm1 = mysqli_insert_id($con);





    $testresult = $_POST['testresult'];
    $corrective = $_POST['corrective'];
    $cmnt = $_POST['cmnt'];
    $txdate = date("Y-m-d H:i:s");
    $i = 0;
    foreach ($testresult as $key => $value) {
        $result = $value;
        $correct = $corrective[$i];
        $cmnt = $cmnt[$i];
        $ntest = $_POST['ntest'][$i];
        $npurpose = $_POST['npurpose'][$i];

        $qsm2 = mysqli_query($con, "INSERT INTO `pw_qmsmetal1`(`pid`, `result`, `correct`, `cmnt`, `datem`, `ucode`,`test`,`ques`) VALUES ('$qsm1', '$result', '$correct', '$cmnt', '$txdate', '$ucode','$ntest','$npurpose')");
        $i++;
    }
    if ($qsm && $qsm2) {
        echo "<script>alert('Record added successfully'); window.location.href = 'admin.php?id=pw_qsmetalsign&eid=$qsm1';</script>";
    } else {
        echo "<script>alert('Record not added'); window.location.href = 'admin.php?id=pw_qsmetaladd';</script>";
    }
}
?>
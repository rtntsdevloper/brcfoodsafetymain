<?php

include 'connection.php';
$pid = $_GET['pid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Cooking (>=90 °C for 10 minutes) (CCP 1a) </li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">


                <a href="admin.php?id=savouryproduction&pid=<?php echo $pid; ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go
                        Back</button></a>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                    action="">
                    <div class="form-row mt-5">

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Production Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Product Name </label>
                            <select class="form-control" id="validationTooltip02" required="required" name="pname">
                                <option value="" disabled selected>Select Product Name</option>

                                <?php
                                if ($pid == 1) {
                                    $result = mysqli_query($con, "SELECT * FROM tblproductlist ORDER BY  prname ASC");
                                } elseif ($pid == 2) {
                                    $result = mysqli_query($con, "SELECT * FROM tblsauceproductlist ORDER BY  prname ASC");
                                } elseif ($pid == 3) {
                                    $result = mysqli_query($con, "SELECT * FROM tblmeatproductlist ORDER BY prname ASC");
                                } else {
                                }
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['prname'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Batch Code</label>

                            <input class="form-control" id="batchcodeInput" type="text" required="required"
                                name="batchcode" oninput="checkBatchCode()" />
                            <small id="batchcodeFeedback" class="text-danger"></small>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>

                    <!-- <script>
function checkBatchCode() {
    const batchcode = document.getElementById("batchcodeInput").value;
    const feedback = document.getElementById("batchcodeFeedback");
    const inputField = document.getElementById("batchcodeInput");

    if (batchcode.length === 0) {
        feedback.textContent = "";
        inputField.classList.remove("is-invalid");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "chokdee_precord/check_batchcode?batchcode=" + encodeURIComponent(batchcode), true);
    xhr.onload = function() {
        if (this.responseText.trim() === "exists") {
            feedback.textContent = "Batch code already exists!";
            inputField.classList.add("is-invalid");
        } else {
            feedback.textContent = "";
            inputField.classList.remove("is-invalid");
        }
    };
    xhr.send();
}
</script> -->



                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Cooking start time </label>
                            <input class="form-control" id="validationTooltip02" type="time" required="required"
                                name="ctime" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="startTime">Actual Start time of CCP Monitoring </label>
                            <input class="form-control" id="startTime" type="time" required="required"
                                name="starttime" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip041">Actual Temperature of CCP Monitoring at start time</label>
                            <div class="input-group mb-2">
                                <input class="form-control" id="validationTooltip041" type="number" placeholder=""
                                    name="temp1" min="89.9" step="0.1" required oninput="startccp(this.value)" />
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            <p id="ccpstart"></p>

                        </div>

                    </div>
                    <script>
                        function startccp(value) {
                            const startccp = document.getElementById('ccpstart');
                            if (value >= 90) {
                                ccpstart.textContent = "Temperature is acceptable.";
                                ccpstart.style.color = "green";
                            } else {
                                ccpstart.textContent = "Warning: Temperature is below acceptable limit!";
                                ccpstart.style.color = "red";
                            }
                        }
                    </script>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="endTime">Actual End time of CCP Monitoring</label>
                            <input class="form-control" id="endTime" type="time" placeholder="" name="endtime" required
                                oninput="
                                    const startTime = document.getElementById('startTime').value;
                                    const endTime = this.value;
                                    if (startTime && endTime) {
                                        const [startHour, startMin] = startTime.split(':').map(Number);
                                        const [endHour, endMin] = endTime.split(':').map(Number);
                                        const startTotalMin = startHour * 60 + startMin;
                                        const endTotalMin = endHour * 60 + endMin;
                                        if (endTotalMin - startTotalMin < 10) {
                                            this.setCustomValidity('End time must be at least 10 minutes after start time.');
                                            alert('End time must be at least 10 minutes after start time.');
                                        } else {
                                            this.setCustomValidity('');
                                        }
                                    } else {
                                        this.setCustomValidity('');
                                    }
                                " />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Actual Temperature of CCP Monitoring at End time</label>
                            <div class="input-group mb-2">
                                <input class="form-control" id="validationTooltip04" type="number" placeholder=""
                                    name="temp2" required min="89.9" step="0.1" oninput="endccp(this.value)" />
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            <p id="ccpend"></p>
                        </div>
                        <script>
                            function endccp(value) {
                                const ccpend = document.getElementById('ccpend');
                                if (value >= 90) {
                                    ccpend.textContent = "Temperature is acceptable.";
                                    ccpend.style.color = "green";
                                } else {
                                    ccpend.textContent = "Warning: Temperature is below acceptable limit!";
                                    ccpend.style.color = "red";
                                }
                            }
                        </script>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Comment</label>
                            <textarea class="form-control" name="cmnt"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>

            </div>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $date = $_POST['date'];
            $pname = $_POST['pname'];
            $batchcode = $_POST['batchcode'];
            $starttime = $_POST['starttime'];
            $ctime = $_POST['ctime'];
            $temp1 = $_POST['temp1'];
            $endtime = $_POST['endtime'];
            $temp2 = $_POST['temp2'];
            $checkedby = $_POST['checkedby'];
            $cmnt = $_POST['cmnt'];



            $ghj = mysqli_query($con, "select * from tblsavoury  order by id desc limit 1");

            if ($ghj && mysqli_num_rows($ghj) > 0) {
                $ghj1 = mysqli_fetch_array($ghj);
                $tid = $ghj1['id'] + 1;
            } else {
                $tid = 1;
            }

            $check = mysqli_query($con, "SELECT COUNT(*) FROM tblcooking WHERE batchcode = '$batchcode'");
            $exists = mysqli_fetch_array($check)[0];

            if ($exists > 0) {
                echo "<script>alert('This batch code already exists!'); window.history.back();</script>";
                exit();
            }
            $sql = "INSERT INTO `tblcooking`   (`tid`,`pname`, `pdate`, `batchcode`, `ctime`,`starttime`, `temp1`, `endtime`, `temp2`,`pid`,`cmnt`,`checkedby`) 
            VALUES   ('$tid','$pname', '$date', '$batchcode','$ctime', '$starttime', '$temp1', '$endtime', '$temp2','$pid','$cmnt','$checkedby')";

            $sql1 = mysqli_query($con, "INSERT INTO `tblsavoury`   (`date`, `product`, `cooking`, `blastchiller`,`freezing`,`pid`) 
            VALUES   ('$date', '$pname', 'Pending', 'Pending', 'Pending','$pid')");


            if (mysqli_query($con, $sql)) {
                // echo "<script>alert(' Record Added Successfully');</script>";
                echo "<script>
                window.location.href='admin.php?id=cookingccpsignature&date=$date&product=$pname&pid=$pid';
                </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
        ?>
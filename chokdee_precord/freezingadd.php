<?php

include 'connection.php';
$pid = $_GET['pid'];
$date = $_GET['date'];
$product = $_GET['product'];
$sql = mysqli_query($con, "SELECT * FROM tblsavoury where date='$date' and product='$product' and pid='$pid'  ");
$sql1 = mysqli_query($con, "SELECT * FROM tblcooking where pdate='$date' and pname='$product' and pid='$pid'");
$rr = mysqli_fetch_array($sql);
$rr1 = mysqli_fetch_array($sql1);
$prr = $rr['date'];
$prname = $rr['product'];
$prr1 = $rr1['batchcode'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <?php if ($pid == 2) { ?>
                <li>Add Hot Filling (&gt;=82&deg;C or above CCP2)</li>
            <?php } else { ?>
                <li>Add Freezing Info</li>
            <?php } ?>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">


                <a
                    href="admin.php?id=savouryproduction1&date=<?php echo $date; ?>&product=<?php echo $product; ?>&pid=<?php echo $pid; ?>"><button
                        class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                    action="">
                    <div class="form-row mt-5">

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Production Date</label>


                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" value="<?php echo $prr; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Product Name </label>
                            <select class="form-control" id="validationTooltip02" required="required" name="pname"
                                disabled>


                                <?php


                                if ($pid == 1) {
                                    $result = mysqli_query($con, "SELECT * FROM tblproductlist where id='$product'");
                                } elseif ($pid == 2) {
                                    $result = mysqli_query($con, "SELECT * FROM tblsauceproductlist where id='$product'");
                                } elseif ($pid == 3) {
                                    $result = mysqli_query($con, "SELECT * FROM tblmeatproductlist where id='$product'");
                                } else {

                                }
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id'] . '" selected>' . $row['prname'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Batch Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" required="required"
                                name="batchcode" value="<?php echo $prr1; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="startTime">Start Time
                            </label>
                            <input class="form-control" id="startTime" type="time" required="required"
                                name="starttime" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">
                                <?php
                                if ($pid == 2) { ?>
                                    Product Temperature (>=82°C )
                                </label>
                                <div class="input-group mb-2">
                                    <input class="form-control" id="validationTooltip02" type="number" required="required"
                                        name="temp1" min="82.0" step="0.1" oninput="endccp(this.value)" />

                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
                                <p id="ccpend"></p>
                                <script>
                                    function endccp(value) {
                                        const ccpend = document.getElementById('ccpend');
                                        if (value >= 82) {
                                            ccpend.textContent = "Temperature is acceptable.";
                                            ccpend.style.color = "green";
                                        } else {
                                            ccpend.textContent = "Warning: Temperature is below acceptable limit!";
                                            ccpend.style.color = "red";
                                        }
                                    }

                                </script>
                            <?php } else { ?>
                                Freezer Temperature (-18°C or below)
                                </label>
                                <div class="input-group mb-2">
                                    <input class="form-control" id="validationTooltip02" type="number" required="required"
                                        name="temp1" max="-18.0" step="0.1" oninput="endccp11(this.value)" />

                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
                                <p id="ccpend11"></p>
                                <script>
                                    function endccp11(value) {
                                        const ccpend11 = document.getElementById('ccpend11');
                                        if (value <= -18) {
                                            ccpend11.textContent = "Temperature is acceptable.";
                                            ccpend11.style.color = "green";
                                        } else {
                                            ccpend11.textContent = "Warning: Temperature is below acceptable limit!";
                                            ccpend11.style.color = "red";
                                        }
                                    }

                                </script>

                            <?php } ?>



                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="endTime">Finish time</label>
                            <input class="form-control" id="endTime" type="time" placeholder="" name="endtime"
                                required />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04"> <?php
                            if ($pid == 2) { ?>
                                    Product Temperature (>=82°C )

                                </label>
                                <div class="input-group mb-2">
                                    <input class="form-control" id="validationTooltip04" type="number" placeholder=""
                                        name="ptemp" required min="82.0" step="0.1" oninput="startccp1(this.value)" />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
                                <p id="ccpstart1"></p>
                                <script>
                                    function startccp1(value) {
                                        const startccp1 = document.getElementById('ccpstart1');
                                        if (value >= 82) {
                                            ccpstart1.textContent = "Temperature is acceptable.";
                                            ccpstart1.style.color = "green";
                                        } else {
                                            ccpstart1.textContent = "Warning: Temperature is above acceptable limit!";
                                            ccpstart1.style.color = "red";
                                        }
                                    }

                                </script>

                            <?php } else { ?>
                                Product Temperature (-18°C or below)

                                </label>
                                <div class="input-group mb-2">
                                    <input class="form-control" id="validationTooltip04" type="number" placeholder=""
                                        name="ptemp" required max="-18.0" step="0.1" oninput="endccp12(this.value)" />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><sup>o</sup>C</div>
                                    </div>
                                </div>
                                <p id="ccpend12"></p>
                                <script>
                                    function endccp12(value) {
                                        const ccpend12 = document.getElementById('ccpend12');
                                        if (value <= -18) {
                                            ccpend12.textContent = "Temperature is acceptable.";
                                            ccpend12.style.color = "green";
                                        } else {
                                            ccpend12.textContent = "Warning: Temperature is below acceptable limit!";
                                            ccpend12.style.color = "red";
                                        }
                                    }

                                </script>

                            <?php } ?>





                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Comment</label>
                            <textarea class="form-control" name="cmnt"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Checked By</label>
                            <?php
                            $result1 = mysqli_query($con, "SELECT * FROM tblstaff WHERE status='active' and ccp='Yes'");
                            // $result1 = mysqli_query($con, "SELECT * FROM tblstaff WHERE status='active' ");
                            ?>
                            <select class="form-control" id="validationTooltip04" name="checkedby" required>
                                <option value="">Select Please</option>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    echo '<option value="' . $row1['id'] . '">' . $row1['fname'] . ' ' . $row1['lname'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please select a staff member.
                            </div>
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>

            </div>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $date = $prr;
            $pname = $prname;
            $batchcode = $prr1;
            $starttime = $_POST['starttime'];

            $temp1 = $_POST['temp1'];
            $endtime = $_POST['endtime'];
            $ptemp = $_POST['ptemp'];




            $tid = $_GET['tid'];
            $checkedby = $_POST['checkedby'];
            $cmnt = $_POST['cmnt'];
            $sql = "INSERT INTO `tblfreezing` 
            (`tid`,`pname`, `pdate`, `batchcode`, `starttime`, `temp1`, `endtime`, `ptemp`,`pid` ,`cmnt`,`checkedby`) 
            VALUES 
            ('$tid','$pname', '$date', '$batchcode', '$starttime', '$temp1', '$endtime', '$ptemp','$pid','$cmnt','$checkedby')";
            // print_r($sql);
        
            if (mysqli_query($con, $sql)) {
                // echo "<script>alert(' Record Added Successfully');</script>";
                echo "<script>window.location.href='admin?id=freezingsignature&date=$date&product=$product&pid=$pid';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
        ?>
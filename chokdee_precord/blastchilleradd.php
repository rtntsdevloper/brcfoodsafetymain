<?php

include 'connection.php';
$pid = $_GET['pid'];
$date = $_GET['date'];
$product = $_GET['product'];
$sql = mysqli_query($con, "SELECT * FROM tblsavoury where date='$date' and product='$product' and pid='$pid'");

$sql1 = mysqli_query($con, "SELECT * FROM tblcooking where  pdate='$date' and pname='$product' and pid='$pid'");
$rr = mysqli_fetch_array($sql);
$rr1 = mysqli_fetch_array($sql1);
$prr = $rr['date'];
 $prr1 = $rr1['batchcode'];
// $prr = $rr['date'];
$prname = $rr['product'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Blast chiller (&lt;5 &deg; in 90 minutes) CCP 3</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">


               <a href="admin.php?id=savouryproduction1&date=<?php echo $date ;?>&product=<?php echo $product ;?>&pid=<?php echo $pid ;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                    action="">
                    <div class="form-row mt-5">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Production Date</label>


                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" value="<?php echo $prr; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
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
                                Please provide a valid serial number.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Batch Code</label>
                            <input class="form-control" id="validationTooltip025757" type="text" required="required"
                                name="batchcode" value="<?php echo $prr1 ?>"  disabled/>
                            <div class="invalid-tooltip">
                                Please provide a valid serial number.
                            </div>
                        </div>

                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Blast Chiller Temperature </label>
                            <div class="input-group mb-2">

                                <input class="form-control" id="validationTooltip0232" type="number" required="required"
                                    name="temp1"  max="5.0" step="0.1"  oninput="startccp(this.value)" />
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                             
                            </div>
                               <p id="ccpstart"></p>
                        </div> 
                         <script>
                        function startccp(value) {
                            const startccp = document.getElementById('ccpstart');
                            if (value <= 5) {
                                ccpstart.textContent = "Temperature is acceptable.";
                                ccpstart.style.color = "green";
                            } else {
                                ccpstart.textContent = "Warning: Temperature is above acceptable limit!";
                                ccpstart.style.color = "red";
                            }
                        }

                        </script>
                        <div class="col-md-4 mb-3">
                            <label for="startTime">Start Time</label>
                            <input class="form-control" id="startTime" type="time" required="required"
                                name="starttime" />
                            <div class="invalid-tooltip">
                                Please provide a valid area.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Product Temperature</label>
                            <div class="input-group mb-2">

                                <input class="form-control" id="validationTooltip0476" type="number" placeholder=""
                                    name="ptemp" required  max="5.0" step="0.1" oninput="endccp(this.value)"  />
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                         <p id="ccpend"></p></div>
                              
                        
                    </div>
                          <script>
                        function endccp(value) {
                            const ccpend = document.getElementById('ccpend');
                            if (value <= 5) {
                                ccpend.textContent = "Temperature is acceptable.";
                                ccpend.style.color = "green";
                            } else {
                                ccpend.textContent = "Warning: Temperature is below acceptable limit!";
                                ccpend.style.color = "red";
                            }
                        }

                        </script>
                    <div class="form-row mt-2">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Blast Chiller Temperature</label>
                            <div class="input-group mb-2">

                                <input class="form-control" id="validationTooltip047658" type="number" placeholder=""
                                    name="temp2"  max="5.0" step="0.1"   required oninput="endccp1(this.value)"  />
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                
                            </div>
                           
                            </div> <p id="ccpend1"></p>
                        </div>
                         <script>
                        function endccp1(value) {
                            const ccpend1 = document.getElementById('ccpend1');
                            if (value <= 5) {
                                ccpend1.textContent = "Temperature is acceptable.";
                                ccpend1.style.color = "green";
                            } else {
                                ccpend1.textContent = "Warning: Temperature is below acceptable limit!";
                                ccpend1.style.color = "red";
                            }
                        }

                        </script>
                      <div class="col-md-4 mb-3">
                            <label for="endTime">Actual End time of CCP</label>
                            <input class="form-control" id="endTime" type="time" placeholder=""
                                name="endtime" required 
                                oninput="
                                    const startTime = document.getElementById('startTime').value;
                                    const endTime = this.value;
                                    if (startTime && endTime) {
                                        const [startHour, startMin] = startTime.split(':').map(Number);
                                        const [endHour, endMin] = endTime.split(':').map(Number);
                                        const startTotalMin = startHour * 60 + startMin;
                                        const endTotalMin = endHour * 60 + endMin;
                                        if (endTotalMin - startTotalMin < 90) {
                                            this.setCustomValidity('End time must be at least 90 minutes after start time.');
                                            alert('End time must be at least 90 minutes after start time.');
                                        } else {
                                            this.setCustomValidity('');
                                        }
                                    } else {
                                        this.setCustomValidity('');
                                    }
                                "
                            />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Product Temperature
                            </label>
                            <div class="input-group mb-2">

                                <input class="form-control" id="tempInput" type="number" placeholder=""
                                    name="ptemp2" max="5.0" step="0.1" required  title="Please enter a value less than or equal to 90" oninput="startccp1(this.value)"/>
                                    
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            <p id="ccpstart1"></p>
                       
                          
                         </div>
                           <script>
                        function startccp1(value) {
                            const startccp1 = document.getElementById('ccpstart1');
                            if (value <= 5) {
                                ccpstart1.textContent = "Temperature is acceptable.";
                                ccpstart1.style.color = "green";
                            } else {
                                ccpstart1.textContent = "Warning: Temperature is above acceptable limit!";
                                ccpstart1.style.color = "red";
                            }
                        }

                        </script>
                          <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Comment</label>
                            <textarea class="form-control" 
                                name="cmnt"  ></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div></div>
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
                echo '<option value="' . $row1['id'] . '">' . $row1['fname'] . '' . $row1['lname'] . '</option>';
            }
        ?>
    </select>
    <div class="invalid-tooltip">
        Please select a staff member.
    </div>
</div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit" onclick="checkTemp()">Submit</button>
                  


                </form>

            </div>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $date = $prr;
            $pname = $prname;

            $batchcode =$prr1;
            $starttime = $_POST['starttime'];
            $temp1 = $_POST['temp1'];
            $endtime = $_POST['endtime'];
            $temp2 = $_POST['temp2'];
            $ptemp = $_POST['ptemp'];
            $ptemp2 = $_POST['ptemp2'];
            $tid = $_GET['tid'];
 $checkedby = $_POST['checkedby'];
            $cmnt = $_POST['cmnt'];

            $sql = "INSERT INTO `tblblastchiller` 
            (`tid`,`pname`, `pdate`, `batchcode`, `starttime`, `temp1`, `endtime`, `temp2`,`ptemp`,`ptemp2`,`pid`,`cmnt`,`checkedby`) 
            VALUES 
            ('$tid','$pname', '$date', '$batchcode', '$starttime', '$temp1', '$endtime', '$temp2','$ptemp','$ptemp2','$pid','$cmnt','$checkedby')";
            // print_r($sql)   ;die;
        
            if (mysqli_query($con, $sql)) {
                // echo "<script>alert('Scale Calibration Record Added Successfully');</script>";
                echo "<script>window.location.href='admin.php?id=blastchillersignature&date=$date&product=$product&pid=$pid';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
        ?>
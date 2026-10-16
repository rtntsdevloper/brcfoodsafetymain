<?php

include 'connection.php';

$tid =$_GET['tid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Scale Calibration</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=scale&tid=<?php echo $tid;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

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
                            <label for="validationTooltip02">Scale Serial No.</label>
                            <input class="form-control" id="validationTooltip02" type="text" required="required" name="scale" />
                            <div class="invalid-tooltip">
                                Please provide a valid serial number.
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Area</label>
                            <input class="form-control" id="validationTooltip03" type="text" required="required" name="area" />
                            <div class="invalid-tooltip">
                                Please provide a valid area.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Calibration Tested by</label>
                            <?php
										$qs = mysqli_query($con, "Select * from tblprecord where id = '$tid'");
										$qs1 = mysqli_fetch_array($qs);
										$qsid = $qs1['pid'];

										$psr = mysqli_query($con, "Select * from `tblrecord_attempt` where pid = '$qsid'");



										?>
										<select  name="calibration" id="" class="form-control">
											<option>Select Your Name</option>
											<?php
											foreach ($psr as $psdata) {
												$prname  = $psdata['name'];
												echo '<option value="' . $prname . '">' . $prname . '</option>';
											}

											?>

										</select>
                            
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                    </div>
                   

                    <div class="form-row mt-3">
                        <div class="col-md-12">
                            <div class="heading-tab main-tab" data-target="main-sub-tabs">
                                <h6>Ref. Weight ▼</h6>
                           
                                    <P>  <b>Testing Points number: </b> <span>1. Top Left</span> 
                                    <span class="ml-2">2. Top Right </span>
                                    <span class="ml-2">3. Bottom Left </span>
                                    <span class="ml-2">4. Bottom Right </span>
                                    <span class="ml-2">5. Center</span>
                                  
                                   
                                    
                                   </P>
                                    
                                  
                                </ol>
                            </div>

                            <div class="sub-tabs" id="main-sub-tabs" >
                                <!-- Add row wrapper here -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab" data-target="sub-tabs-1">
                                            <h6>50g ▼</h6>
                                        </div>
                                        <div class="sub-tabs" id="sub-tabs-1" >
                                            <label class="text-center">Testing Point For 50g</label>
                                            <ol style="padding-left: 20px; margin-top: 10px;">
                                                <li><input name="th1" type="number" class="form-control mt-2" required></li>
                                                <li><input name="th2" type="number" class="form-control mt-2" required></li>
                                                <li><input name="th3" type="number" class="form-control mt-2" required></li>
                                                <li><input name="th4" type="number" class="form-control mt-2" required></li>
                                                <li><input name="th5" type="number" class="form-control mt-2" required></li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab" data-target="sub-tabs-2">
                                            <h6>100g ▼</h6>
                                        </div>
                                        <div class="sub-tabs" id="sub-tabs-2" >
                                            <label class="text-center">Testing Points For 100g</label>
                                            <ol style="padding-left: 20px; margin-top: 10px;">
                                                <li><input name="ch1" type="number" class="form-control mt-2" required></li>
                                                <li><input name="ch2" type="number" class="form-control mt-2" required></li>
                                                <li><input name="ch3" type="number" class="form-control mt-2" required></li>
                                                <li><input name="ch4" type="number" class="form-control mt-2" required></li>
                                                <li><input name="ch5" type="number" class="form-control mt-2" required></li>
                                            </ol>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab" data-target="sub-tabs-3">
                                            <h6>200g ▼</h6>
                                        </div>
                                        <div class="sub-tabs" id="sub-tabs-3" >
                                            <label style="text-align: center;">Testing Point For 200g</label>
                                            <ol style="padding-left: 20px;">
                                                <li><input name="rt1" type="number" class="form-control" required></li>
                                                <li><input name="rt2" type="number" class="form-control" required></li>
                                                <li><input name="rt3" type="number" class="form-control" required></li>
                                                <li><input name="rt4" type="number" class="form-control" required></li>
                                                <li><input name="rt5" type="number" class="form-control" required></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

               


                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background: #f8f9fa;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                            font-weight: bold;
                        }

                        .sub-tabs {
                            padding: 15px;
                            border: 1px solid #eee;
                            border-radius: 5px;
                            margin-bottom: 10px;
                        }

                        .form-control {
                            margin-bottom: 10px;
                        }

                        /* Fix for inline-block spacing */
                        .row {
                            margin-left: -15px;
                            margin-right: -15px;
                        }

                        .col-md-4 {
                            padding-left: 15px;
                            padding-right: 15px;
                        }
                    </style>
                    <div class="col-md-8 mb-3 mt-3">
                        <label for="commentInput" class="form-label">Comment</label>
                        <textarea class="form-control" id="commentInput" name="comment" rows="3" placeholder="Enter your comment here..."></textarea>
                        <div class="invalid-feedback">
                            Please provide a valid comment.
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $scale = $_POST['scale'];
    $area = $_POST['area'];
    $calibration = $_POST['calibration'];
    $comment = $_POST['comment'];

    // Process 50g fields
    $fifty = array(
        $_POST['th1'],
        $_POST['th2'],
        $_POST['th3'],
        $_POST['th4'],
        $_POST['th5']
    );
    $fifty = implode(",", $fifty);

    // Process 100g fields
    $one = array(
        $_POST['ch1'],
        $_POST['ch2'],
        $_POST['ch3'],
        $_POST['ch4'],
        $_POST['ch5']
    );
    $one = implode(",", $one);

    // Process 200g fields
    $two = array(
        $_POST['rt1'],
        $_POST['rt2'],
        $_POST['rt3'],
        $_POST['rt4'],
        $_POST['rt5']
    );
    $two = implode(",", $two);

    // Insert the data into the database
    $sql = "INSERT INTO `tblscalee` 
            (`date`, `scale`, `area`, `calibration`, `50g`, `100g`, `200g`, `comment`,pid) 
            VALUES 
            ('$date', '$scale', '$area', '$calibration', '$fifty', '$one', '$two', '$comment','$tid')";

    if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=scale&tid=".$tid."';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>
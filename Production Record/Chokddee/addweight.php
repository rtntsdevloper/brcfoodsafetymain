<?php
include 'connection.php';
$pid = $_GET['eid'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add Blast Chiller Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=saucedate&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

              


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Product</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="product" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack tare Weight (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="packtare" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">pack 1 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack1" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">pack 2 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack2" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">pack 3 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack3" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">pack 4 (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack4" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">pack 5</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="pack5" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Declare Weight (g)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="declared" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                       

                        <div class="col-md-6 ">
                            <label for="vehicle_reg">Add By</label><br>
                            <?php

                            $qs = mysqli_query($con, "Select * from tblprecord where id = '$pid'");
                            $qs1 = mysqli_fetch_array($qs);
                            $qsid = $qs1['pid'];

                            $psr = mysqli_query($con, "Select * from `tblrecord_attempt` where pid = '$qsid'");



                            ?>
                            <select name="addby" id="" class="form-control">
                                <option>Select Your Name</option>
                                <?php
                                foreach ($psr as $psdata) {
                                    $prname  = $psdata['name'];
                                    echo '<option value="' . $prname . '">' . $prname . '</option>';
                                }

                                ?>

                            </select>

                        </div>




                    </div>

                   




                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
            </div>
        </div>




    </div>



    </br>

    </form>
</div>
</div>
</div>

<?php
if(isset($_POST['submit'])) {
    // Basic input sanitization
     $product = $_POST['product'];
    $time = $_POST['time'];
    $tare = $_POST['packtare'];
    $pack1 = $_POST['pack1'];
    $pack2 = $_POST['pack2'];
    $pack3 = $_POST['pack3'];
    $pack4 = $_POST['pack4'];
    $pack5 = $_POST['pack5'];
    $addby = $_POST['addby'];
   $eid=$pid;
    $declare = mysqli_real_escape_string($con, $_POST['declared']);
    
    // Fixed table name from tnblweight to tblweight
    $nrk = mysqli_query($con, "SELECT * FROM tblweight");
    if(!$nrk) {
        die("Error in query: " . mysqli_error($con));
    }
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;
    $record = "Wei00" . $nrkn;

    $result = mysqli_query($con, "INSERT INTO tblweight (product, time, packtare, pack1, pack2, pack3, pack4, pack5, `declared`, `eid`, `recordid`, `addby` ) 
                VALUES('$product', '$time', '$tare', '$pack1', '$pack2', '$pack3', '$pack4', '$pack5', '$declare', '$eid', '$record', '$addby')");

    if ($result) {
        
        echo '<script>window.location.href = "admin.php?id=weightsign&rid=' . $record . '&eid='.$pid.'";</script>';
    } else {
        echo "<script>alert('Error adding weight Log: " . addslashes(mysqli_error($con)) . "');</script>";
    }
}
?>
<?php
include 'connection.php';

$pid = $_GET['tid'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Dispatch Log</a></li>
            <li>Add Dispatch Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=dispatch"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Dispatch Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Customer Store</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="cstore" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Use By Date/Best Before Date: </label>
                            <input name="useby" type="date" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>




                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Total Weight/Quantity</label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" name="qty" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Product Temperature</label>
                            <div class="input-group mb-2">
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ptemp" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>

                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip05">Van Temperature</label>

                            <div class="input-group mb-2">

                                <input type="number" class="form-control" id="inlineFormInputGroup" name="vtemp" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip05">Van Hygiene</label> <!-- Changed from "Van Temprature" -->
                            <input name="vhygiene" type="text" class="form-control" id="validationTooltip06" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>




                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip05">Packaging Integrity</label>
                            <input name="pack" type="text" class="form-control" id="validationTooltip06" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <label for="vehicle_reg">Attempt By</label><br>
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




            </div>



            </br>
            <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $cstore = $_POST['cstore'];
    $product = $_POST['product'];
    $useby = $_POST['useby'];
    $qty = $_POST['qty'];
    $ptemp = $_POST['ptemp'];
    $vtemp = $_POST['vtemp'];
    $vhygiene = $_POST['vhygiene'];
    $pack = $_POST['pack'];
    $addby = $_POST['addby'];



    $pk = mysqli_query($con, "SELECT * FROM `tbldispatch`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1 + 1;

    $record = "dispatch_00" . $pk2;

    $sql = "INSERT INTO tbldispatch (date, cstore, product, useby, qty, ptemp, vtemp, vhygiene, pack,recordid,add_by,tid) 
        VALUES ('$date', '$cstore', '$product', '$useby', '$qty', '$ptemp', '$vtemp', '$vhygiene', '$pack','$record','$addby','$pid')";
        // print_r($sql);die;

    $result = mysqli_query($con, $sql);


    if ($result) {

        echo "<script>window.location.href='admin.php?id=dlog_sign&rid=" . $record . "';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>
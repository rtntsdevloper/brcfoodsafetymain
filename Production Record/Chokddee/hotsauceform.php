<?php
include 'connection.php';
$pid = $_GET['tid'];
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
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="batchcode" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <!-- <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div> -->

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

                    <!-- <script>
                        document.querySelectorAll('.heading-tab').forEach(tab => {
                            tab.addEventListener('click', function() {
                                const targetId = this.getAttribute('data-target');
                                const subTabs = document.getElementById(targetId);

                                // Toggle the display of the sub-tabs
                                if (subTabs.style.display === 'none') {
                                    subTabs.style.display = 'block';
                                    this.querySelector('h6').innerHTML = this.querySelector('h6').innerHTML.replace('▼', '▲');
                                } else {
                                    subTabs.style.display = 'none';
                                    this.querySelector('h6').innerHTML = this.querySelector('h6').innerHTML.replace('▲', '▼');
                                }
                            });
                        });
                    </script> -->




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

if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    $product = $_POST['product'];
    $batch = $_POST['batchcode'];
    // $cook = $_POST['time'];
    $addby = $_POST['addby'];
    $pid = $pid;



    $sql = "INSERT INTO tblhot (date, product, batchcode, addby, pid ) VALUES('$date', '$product', '$batch', '$addby', '$pid')";

    if (mysqli_query($con, $sql)) {

        echo "<script>window.location.href='admin.php?id=hotdate&tid=" . $pid . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
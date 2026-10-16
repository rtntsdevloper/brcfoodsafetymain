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
                <a href="admin.php?id=blastdate&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

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
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Quantity</label>
                            <input class="form-control" id="validationTooltip04" type="number" required="required" name="qty" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    </div>
                    <div class="form-row mt-5">
                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-1" required>
                                <h6>Blast Chiller ▼</h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-1">
                                <label>Start Time</label>
                                <input name="th1" type="time" class="form-control" required>

                                <label>Temperature</label>
                                <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="th2" placeholder="temperature" required >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-2">
                                <h6> Product ▼</h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-2">


                                <label>Start Time</label>
                                <input name="ch1" type="time" class="form-control" required>

                                <label>Temperature</label>
                                 <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ch2" placeholder="temperature" required >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>


                            </div>
                        </div>

                        	<div class="col-md-6 mt-2">
										<label for="vehicle_reg">Add By</label><br>
										<?php
										$qs = mysqli_query($con,"Select * from tblprecord where id = '$pid'");
										$qs1 = mysqli_fetch_array($qs);
										$qsid = $qs1['pid'];

										$psr = mysqli_query($con,"Select * from `tblrecord_attempt` where pid = '$qsid'");
										
										

										?>
										<select name="addby" id="" class="form-control">
											<option >Select Your Name</option>
											<?php
											foreach($psr as $psdata){
												$prname  = $psdata['name'];
												echo '<option value="'.$prname.'">'.$prname.'</option>';

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
    $product = $_POST['product'];
    $time = $_POST['time'];
    $qty = $_POST['qty'];
    $th1 = $_POST['th1'];
    $th2 = $_POST['th2'];
    $ch1 = $_POST['ch1'];
    $ch2 = $_POST['ch2'];
    $add=$_POST['addby'];
    $tid = $pid;


    $sql = "INSERT INTO tblblast (date, product, time, qty, th1, th2, ch1, ch2,tid, addby ) VALUES('$date', '$product', '$time', '$qty', '$th1', '$th2', '$ch1', '$ch2', '$tid', '$add')";

    if (mysqli_query($con, $sql)) {
       
        echo "<script>window.location.href='admin.php?id=blastdate&tid=" . $pid . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
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
                <a href="admin.php?id=fryeroil"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

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
                            <label for="validationTooltip02">Time</label>
                            <input name="dtime" type="time" class="form-control" id="validationTooltip03" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                    </div>
                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Has Oil been changed ?</label>
                            <br>
                            <input type="radio" name="tident" id="validationTooltip01" value="Yes" required="required" onchange="funcoil('Yes')"> Yes
                            <input type="radio" class="ml-3" id="validationTooltip02" name="tident" value="No" required="required" onchange="funcoil('No')"> No

                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comment</label>
                            <textarea name="cmnt" id="cmnt" class="form-control"></textarea>
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
            </br>
            <div class="row">
                <div class="col-md-3 ml-3 my-3">
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </div>
            </div>

            </form>
        </div>
    </div>

</div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {
    echo 45;
    $name = $_POST['dtime'];
    $date = $_POST['date'];
    $tident = $_POST['tident'];
    $cmnt = $_POST['cmnt'];
    $bid = "Fry" . date("Ymdhis");
   
    $sql = "INSERT INTO `tblfryoil`(`name`, `date`, `ques`, `cmnt`, `reason`) VALUES ('$name','$date','$tident', '$cmnt','$bid')";

    if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=fryeroilsign&pid=" . $bid . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
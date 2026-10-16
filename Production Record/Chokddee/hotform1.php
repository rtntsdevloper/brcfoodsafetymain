<?php
include 'connection.php';
$bid = isset($_GET['bid']) ? $_GET['bid'] : 0;
$pid= $_GET['tid'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <!-- <li>Add </li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=sauce&tid=<?php $pid;  ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->

                <?php 
                
                $sq= mysqli_query($con, "SELECT * FROM tblhot where id=$bid");
                $row = mysqli_fetch_assoc($sq);

                ?>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" value="<?php echo $row['date'];  ?>" readonly />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" value="<?php echo $row['product'];  ?>" required readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" value="<?php echo $row['batchcode'];  ?>" name="batchcode" required readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required  />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Temp (>82C)</label>
                            <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ptemp" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        

                        

                        <!-- <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Finish time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div> -->
                    </div>
                    <div class="p-2" style="border: 1px solid gray; border-radius:5px;">
                            <h5 style="color: red;"> <b>Sauce Hot filling core temp must be >82°C or above. </b> </h5>
                        </div>
            </div>
        </div>

    </div>



    </br>
    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
    </form>
</div>


<?php

if(isset($_POST['submit'])){

$sccp = $_POST['time'];
$tccp = $_POST['ptemp'];


    $sql = "UPDATE tblhot SET time='$sccp', ptemp='$tccp' WHERE id='$bid'";
 if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=hotdate&tid=" . $pid . "';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
    }
}


?>
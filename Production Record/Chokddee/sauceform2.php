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
            <li>Add Blast Chiller Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=sauce&tid=<?php $pid;  ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->

                <?php 
                
                $sq= mysqli_query($con, "SELECT * FROM tblsauce where id=$bid");
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
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" value="<?php echo $row['batchcode'];  ?>" name="batchcode"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Cooking Start Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" value="<?php echo $row['cooking'];  ?>" name="cooking"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual Start time of CCP</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" value="<?php echo $row['sccp'];  ?>" name="sccp" readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual Temperature of CCP at start time</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" value="<?php echo $row['tccp'];  ?>" name="tccp"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual End time of CCP</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="eccp" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual Temperature of CCP at End time</label>
                            
                            <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="etccp" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
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

$sccp = $_POST['eccp'];
$tccp = $_POST['etccp'];

 $pk = mysqli_query($con,"SELECT * FROM `tblsauce`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1+1;

    $record = "sac00".$pk2;



    $sql = "UPDATE tblsauce SET eccp='$sccp', etccp='$tccp', recordid='$record' WHERE id='$bid'";
 if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href='admin.php?id=saucesign&rid=" . $record . "&tid=" . $pid . "';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
    }
}


?>
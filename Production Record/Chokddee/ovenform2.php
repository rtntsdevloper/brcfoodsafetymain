<?php
include 'connection.php';
$pid=$_GET['tid'];
$bid = isset($_GET['bid']) ? $_GET['bid'] : 0;
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add </li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                 <a href="admin.php?id=ovendate&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->
                    <?php 
                    
                    $sq=mysqli_query($con,"SELECT * FROM tbloven");
                    $row=mysqli_fetch_array($sq);
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
                            <label for="validationTooltip02">Product</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" value="<?php echo $row['product'];  ?>" required readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="time" value="<?php echo $row['time'];  ?>" required readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                          <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Oven Temperature</label>

                            
                           <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="otemp" placeholder="temperature" value="<?php echo $row['otemp'];  ?>" required readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>


                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Finish time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="ftime" value="<?php echo $row['ftime'];  ?>" required readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                          <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Oven Temperature</label>

                            
                           <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="otemp1" placeholder="temperature" value="<?php echo $row['otemp1'];  ?>" required readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Core Temperature After Baking</label>
                           <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="core" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>

                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Quantity</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="" name="qty" required />
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
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $date = $_POST['core'];
    $product = $_POST['qty'];
    
    $pk = mysqli_query($con,"SELECT * FROM `tbloven`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1+1;

    $record = "oven00".$pk2;


    $sql = "UPDATE tbloven SET core='$date', qty='$product', recordid= '$record' where id='$bid'";

    if (mysqli_query($con, $sql)) {
       
        echo "<script>window.location.href='admin.php?id=ovensign&rid=" . $record . "&tid=" . $pid . "';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
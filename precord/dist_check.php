<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">


            <div class="card-body">
                <a href="admin.php?id=dist_mixing"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">CCP Checks
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Is this Product halal?</label>
                            <select name="halal" id="halal" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Cleandown carried out?</label>
                            <select name="clean" id="clean" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Previous product name </label>
                            <input type="text" name="product" id="product" class="form-control">
                        </div>




                        </br>
                        </br>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="btn">Submit data</button>
                        </div>




                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

if (isset($_POST['btn'])) {
    $tid = $_GET['rid'];
    $halal = $_POST['halal'];
    $clean = $_POST['clean'];
    $product = $_POST['product'];



    $insert = mysqli_query($con, "UPDATE `dist_cooling` SET `halal`='$halal',`clean`='$clean',`product`='$product' WHERE id='$tid'");

   
    if ($insert) {
        echo "<script> window.location.href = 'admin.php?id=dist_coolsign&rid=$tid'; </script>";
    }
}



?>
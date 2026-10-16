<?php
include 'connection.php';
$eid = $_GET['eid'];
$sqx = mysqli_query($con,"SELECT * FROM `pw_scaleing` WHERE id='$eid'");
$sqx1 = mysqli_fetch_array($sqx);


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="#">Quality Control</a></li>
            <li><a href="#">Batch Tracking</a></li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=pw_scaleingview&eid=<?php echo $eid; ?>">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">
                    <i class="fas fa-clipboard-list"></i> QMS Scaling Ingredient Control Form
                </div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">

                    <!-- Basic Information Section -->
                    <div class="form-section">

                        <hr>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" value="<?= $sqx1['date'] ?>" readonly>
                                <div class="invalid-feedback">
                                    Please select a date.
                                </div>
                            </div>





                            <div class="col-md-6 mb-3">
                                <label for="blue_bag_batch_code">Blue Bag Batch Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blue_bag_batch_code"
                                    placeholder="e.g., BB-2024-00123"  value="<?= $sqx1['bluebag'] ?>" readonly>
                                <div class="invalid-feedback">
                                    Please enter blue bag batch code.
                                </div>
                                
                            </div>
                        </div>


                    


                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="ingredient">Ingredient Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ingredient" name="ingredient" required>
                                <div class="invalid-feedback">
                                    Please enter ingredient.
                                </div>
                            </div>





                            <div class="col-md-6 mb-3">
                                <label for="blue_bag_batch_code">Product Batch Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blue_bag_batch_code" name="batchcode"
                                    placeholder="e.g., BB-2024-00123" required>
                                <div class="invalid-feedback">
                                    Please enter blue bag batch code.
                                </div>
                                <small class="form-text text-muted">Enter the Product Batch Number</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="blue_bag_batch_code">Best Before Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="blue_bag_batch_code" name="bestbefore"
                                    placeholder="e.g., 2024-00123" required>
                                <div class="invalid-feedback">
                                    Please enter blue bag batch code.
                                </div>
                                <small class="form-text text-muted">Enter the Best Before Date</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="blue_bag_batch_code">Product Quantity<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blue_bag_batch_code" name="quantity"
                                    placeholder="e.g., 100kg" required>
                                <div class="invalid-feedback">
                                    Please enter blue bag batch code.
                                </div>
                                <small class="form-text text-muted">Enter the Product Quantity</small>
                            </div>
                        </div>


                    </div>






                    <!-- Submit Buttons -->
                    <div class="form-row mt-4">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="submit">
                                <i class="fa fa-save"></i> Submit Record
                            </button>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    /* Custom styling for the form */
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .section-title {
        color: #007bff;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .section-title i {
        margin-right: 8px;
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn {
        margin-right: 10px;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
</style>

<?php
// PHP Processing
if (isset($_POST['submit'])) {
    $ingname = mysqli_real_escape_string($con, $_POST['ingredient']);
    $batchno = mysqli_real_escape_string($con, $_POST['batchcode']);
    $bestbefore = mysqli_real_escape_string($con, $_POST['bestbefore']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $crntdate = date("Y-m-d H:i:s");
   



   
    $query = mysqli_query($con, "INSERT INTO `pw_scaleing1`(`ingname`, `batchno`, `bestbefore`, `quantity`, `dater`, `userr`,`eid`) VALUES ('$ingname','$batchno','$bestbefore','$quantity','$crntdate','$user','$eid')");

    if ($query) {
        echo "<script>
          
            window.location.href = 'admin.php?id=pw_scaleingview&eid=".$eid."';
        </script>";
    } else {
        echo "<script>
            window.location.href = 'admin.php?id=pw_scaleingadd';
        </script>";
    }
}
?>
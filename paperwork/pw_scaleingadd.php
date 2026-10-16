<?php
include 'connection.php';


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
                <a href="admin.php?id=pw_scaleing">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">
                    <i class="fas fa-clipboard-list"></i> QMS Scaling Ingredient Control Form
                </div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fa fa-info-circle"></i> Batch Information
                        </h5>
                        <hr>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" required>
                                <div class="invalid-feedback">
                                    Please select a date.
                                </div>
                            </div>

                           

                    

                            <div class="col-md-6 mb-3">
                                <label for="blue_bag_batch_code">Blue Bag Batch Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="blue_bag_batch_code" name="bluebag"
                                    placeholder="e.g., BB-2024-00123" required>
                                <div class="invalid-feedback">
                                    Please enter blue bag batch code.
                                </div>
                                <small class="form-text text-muted">Enter the batch code printed on blue bags</small>
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
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $bluebag = mysqli_real_escape_string($con, $_POST['bluebag']);
    $crntdate = date("Y-m-d H:i:s");
   

    

    // Generate unique code
    $cmcode = "ING" . rand(1000, 9999) . date("YmdHis");

    // Insert query (adjust table name as needed)
    $query = mysqli_query($con, "INSERT INTO `pw_scaleing`(`date`, `bluebag`, `crntdate`, `cmcode`) VALUES ('$date','$bluebag','$crntdate','$cmcode')");

    if ($query) {
        echo "<script>
          
            window.location.href = 'admin.php?id=pw_scaleing';
        </script>";
    } else {
        echo "<script>
            window.location.href = 'admin.php?id=pw_scaleingadd';
        </script>";
    }
}
?>
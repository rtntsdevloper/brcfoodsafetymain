<?php
include_once 'connection.php';

$eid = $_GET['eid'];// Assuming connection.php contains $con for DB connection
$sql = "SELECT * FROM `tblemailtrack` WHERE id = '$eid'";
$sq1= mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($sq1);

if (isset($_POST['submit'])) {
    // Retrieve form data safely
    
    $note = $_POST['notes'];

    
    

    $upd = mysqli_query($con, "UPDATE `tblemailtrack` SET `comment`='$note' WHERE id = $eid ");
    if (isset($upd)) {

        echo "<script>
      document.location.href ='admin.php?id=email_followup&view=" . $eid . "';
      </script>";

    } else {
        echo "<script>
       alert('Something Went wrong ! try again later')
        </script>";
    }


}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="row p-3">
                    <div class="col-md-10"><h1 class="h4 mb-0"><i class="bi bi-envelope-plus me-2"></i>Email Comment</h1></div>
                    <div class="col-md-2">   <a href="admin.php?id=email_tracking" class="btn btn-success text-right">Go Back</a></div>
                </div>
                
            </div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    
                    <div class="form-section mt-3">
                        <h2><i class="bi bi-pencil me-2"></i>Email Comment</h2>
                        <div class="mb-3">
                            <textarea class="form-control" id="additionalNotes" rows="4" name="notes" required><?php
                            if(!empty($data['comment'])){
                                echo $data['comment'];
                            }
                            ?></textarea>
                        </div>
                    </div>

                    

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
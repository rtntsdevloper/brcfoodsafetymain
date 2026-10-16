
<?php
$eid = $_GET['eid'];
include ('connection.php');

?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0"><i class="bi bi-envelope-plus me-2"></i>Email Closeoff</h1>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">


                    <!-- Completion Section -->
                    <div class="form-section">
                        <h2><i class="bi bi-check-circle me-2"></i>Completion</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="dateClosed" class="form-label">Date Closed</label>
                                <input type="date" class="form-control" id="dateclosed" name="dateclosed">
                            </div>
                            <div class="col-md-6">
                                <label for="closedBy" class="form-label">Closed By</label>
                                <input type="text" name="closeby" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes Section -->
                    <div class="form-section">
                        <h2><i class="bi bi-pencil me-2"></i>Additional Notes</h2>
                        <div class="mb-3">
                            <textarea class="form-control" id="additionalNotes" rows="4" name="adnote"></textarea>
                        </div>
                    </div>
                    <div class="form-section">
                        <h2><i class="bi bi-pencil me-2"></i> Upload Attachment</h2>
                        <div class="mb-3">
                            <input type="file" name="doc" id="">
                        </div>
                    </div>



                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="bi bi-check-circle me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

if (isset($_POST['submit'])) {

    $close = $_POST['dateclosed'];
    $cname = $_POST['closeby'];
    $addnote = $_POST['adnote'];






     $signature = "";
    if (isset($_FILES["doc"]) && $_FILES["doc"]["error"] == 0) {
        $customName = "Close_".$eid. $_FILES["doc"]["name"];
       
        $fileName = $customName;
        $uploadDir = "emailtracking/supdoc/";
        $imagePath = $uploadDir . $fileName;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["doc"]["tmp_name"], $imagePath)) {
            $signature = $fileName;
        }
    }
    else{
        $signature = "";
    }






    // $pic = $_FILES['doc']['name'];



    // echo $pic;

    $q = "UPDATE `tblemailtrack` SET `closedate`='$close',`Status`='Completed',`emailcloseby`='$cname',`closenote`='$addnote',`closefile`='$signature' WHERE id ='$eid'";
    // print_r($q);die;
    $q1 = mysqli_query($con, $q);

    

    if (isset($q1)) {

        echo "<script>
  document.location.href ='admin.php?id=email_tracking';
  </script>";

    } else {
        echo "<script>
   alert('Something Went wrong ! try again later')
    </script>";
    }
}

?>

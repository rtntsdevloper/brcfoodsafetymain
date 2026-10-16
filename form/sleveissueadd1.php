<?php
include("connection.php");

$sno = $_GET['sno'];
// Handle form submission
if (isset($_POST['submit'])) {
    // Collect form data
    $time = $_POST['time'];
    $sleeveissue = $_POST['sleeveissue'];
    $comments = $_POST['comments'];
    $checkedby = $_POST['checkedby'];
    $upl1 = 'paperwork/upl1/';

    // Front image
    $frontimage = $_FILES['frontimage']['name'];
    $frontTmp = $_FILES['frontimage']['tmp_name'];
    move_uploaded_file($frontTmp, $upl1 . $frontimage);

    // Back image
    $backimage = $_FILES['backimage']['name'];
    $backTmp = $_FILES['backimage']['tmp_name'];
    move_uploaded_file($backTmp, $upl1 . $backimage);

    $sql = "INSERT INTO sleveissue1 (sno, time, sleeveissue, comment, checkedby, frontimage, backimage) 
            VALUES ('$sno', '$time', '$sleeveissue', '$comments', '$checkedby', '$frontimage', '$backimage')";
    // echo $sql;die;
    mysqli_query($con, $sql);
    if ($sql) {
        echo "<script>window.location.href='admin.php?id=sleeve&sno=$sno';</script>";
    }
}
?>

<!-- Your HTML Form -->
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Sleeve Issue</h1>
        <ul>
            <li><a href="">Sleeve Issue</a></li>
            <li>add</li>
        </ul>
    </div>
    <div class="col-md-12"> 
        <div class="card">
            <div class="card-body ">
                <a href="admin.php?id=sleeve">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Check every half an hour </div>

                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row mt-5">
<!-- 
                        <div class="col-md-6 mb-3">
                            <label>Is the correct product sleeve and coding used as per the product?</label>
                            <select name="sleeve" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div> -->

                        <div class="col-md-6 mb-3">
                            <label>Time</label>
                            <input class="form-control" type="time" name="time" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Is the correct product sleeve being used?</label>
                            <select name="sleeveissue" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Comments</label>
                            <textarea name="comments" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Checked by</label>
                            <input type="text" name="checkedby" class="form-control" required>
                        </div>

                            <div class="col-md-6 mb-3">
                                <label>Front Image</label>
                                <input type="file" name="frontimage" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Back Image</label>
                                <input type="file" name="backimage" class="form-control" required>
                            </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
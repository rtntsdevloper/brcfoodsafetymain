<?php
include("connection.php");

$sno = $_GET['sno'];

if (isset($_POST['submit'])) {
    $finaltime = $_POST['finaltime'];
    $correct1 = $_POST['correct1'];
    $comment1 = $_POST['comment1'];
    $checked1 = $_POST['checked1'];
    $pouchesreturned = mysqli_real_escape_string($con, $_POST['pouchesreturned']);
    $pouchespacked = mysqli_real_escape_string($con, $_POST['pouchespacked']);
    $wasted = mysqli_real_escape_string($con, $_POST['wasted']);
    $accounted = mysqli_real_escape_string($con, $_POST['accounted']);
    $sql = "UPDATE sleveissue
            SET finaltime='$finaltime', 
                correct1='$correct1', 
                comment1='$comment1', 
                checked1='$checked1', 
                pouchesreturned='$pouchesreturned', 
                pouchespacked='$pouchespacked', 
                sleeveswasted='$wasted', 
                accounted='$accounted' 
            WHERE id='$sno'";
    // echo $sql;die;

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>window.location.href='admin.php?id=issuersign&sno=$sno';</script>";
    } else {
        echo "<p style='color:red'>Error updating record: " . mysqli_error($con) . "</p>";
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

                <div class="card-title"> End of Shift checks </div>

                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row mt-5">


                        <div class="col-md-6 mb-3">
                            <label>Time</label>
                            <input class="form-control" type="time" name="finaltime" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Is the correct product sleeve and coding used as per the product ?</label>
                            <select name="correct1" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="pouchesreturned">Number of pouches/sleeves returned</label>
                            <input class="form-control" type="text" placeholder="enter number of sleeves returned"
                                name="pouchesreturned" required />
                            <div class="invalid-tooltip">Please provide a valid number.</div>
                        </div>

                        <!-- Number of pouches/sleeves packed -->
                        <div class="col-md-6 mb-3">
                            <label for="pouchespacked">Number of pouches/sleeves packed</label>
                            <input class="form-control" type="text" placeholder="enter number of sleeves packed"
                                name="pouchespacked" required />
                            <div class="invalid-tooltip">Please provide a valid number.</div>
                        </div>

                        <!-- Number of sleeves wasted -->
                        <div class="col-md-6 mb-3">
                            <label for="wasted">Number of sleeves wasted/used for records</label>
                            <input class="form-control" type="text" placeholder="enter number of sleeves wasted"
                                name="wasted" required />
                            <div class="invalid-tooltip">Please provide a valid number.</div>
                        </div>

                        <!-- All sleeve accounted for? -->
                        <div class="col-md-6 mb-3">
                            <label for="accounted">All sleeve accounted for?</label>
                            <select name="accounted" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-tooltip">Please select an option.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Comments</label>
                            <textarea name="comment1" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Checked by</label>
                            <input type="text" name="checked1" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
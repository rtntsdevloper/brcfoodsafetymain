<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Sleeve Issue</a></li>
            <li>add</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body ">
                <a href="admin.php?id=sleeve"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <div class="card-title">Sleeve Issue Control</div>

                <ul class="list-unstyled px-4">
                    <li style="font-size:18px;">Instructions:</li>
                </ul>
                <ol>
                    <li>All sleeves need to be issued by the operations supervisor/authorised personnel. All details below must be entered for every production run.</li>
                    <li>The verification of correct product sleeve and coding being used as per product has to be done prior to start the run, hourly and at the end of each run.</li>
                    <li>All sleeves should be accounted for i.e. sleeves issued = sleeves used + sleeves returned + sleeves wasted/discarded.</li>
                    <li>Any material disposed must be recorded in this form. Any discrepancy needs to be immediately reported to the direct Manager, and a Non-conformance raised and investigated.</li>
                </ol>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="date">Date</label>
                            <input class="form-control" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">Please provide a valid date.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time">Time</label>
                            <input class="form-control" type="time" name="time" />
                            <div class="invalid-tooltip">Please provide a valid time.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="productcode">Product code</label>
                            <input class="form-control" type="text" placeholder="enter product code" name="productcode" />
                            <div class="invalid-tooltip">Please provide a valid product code.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="productname">Product Name</label>
                            <input class="form-control" type="text" placeholder="enter product name" name="productname" required />
                            <div class="invalid-tooltip">Please provide a valid product name.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="issuername">Name of Issuer</label>
                            <input class="form-control" type="text" name="issuername" />
                            <div class="invalid-tooltip">Please provide a valid issuer name.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="personname">Name of person receiving/returning sleeves</label>
                            <input class="form-control" type="text" placeholder="enter name of person receiving/returning sleeves" name="personname" required />
                            <div class="invalid-tooltip">Please provide a valid name.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="machine">Is the machine being used free of any damage and fully functioning?</label>
                            <select name="machine" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-tooltip">Please select an option.</div>
                        </div>

                        <!-- Has the packing line been cleared? -->
                        <div class="col-md-6 mb-3">
                            <label>Has the packing line been cleared from packaging materials used in previous run/shifts?</label>
                            <select class="form-control" name="packingline" onchange="toggleSubFields(this, 'packingline')">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div id="packingline_upload" style="display:none; margin-top:10px;">
                                <label>Upload File</label>
                                <input type="file" class="form-control" name="packingline1" />
                            </div>
                            <div id="packingline_comment" style="display:none; margin-top:10px;">
                                <label>Comment</label>
                                <textarea class="form-control" name="packingline1" placeholder="Enter your comment"></textarea>
                            </div>
                        </div>

                        <!-- Number of Batches -->
                        <div class="col-md-6 mb-3">
                            <label for="batches">Number of Batches to be packed</label>
                            <input class="form-control" type="text" placeholder="enter number of batches to be packed" name="batches" required />
                            <div class="invalid-tooltip">Please provide a valid number.</div>
                        </div>

                        <!-- Number of pouches/sleeves issue -->
                        <div class="col-md-6 mb-3">
                            <label for="pouchessleevesissue">Number of pouches/sleeves issue</label>
                            <input class="form-control" type="text" placeholder="enter number of pouches/sleeves issue" name="pouchessleevesissue" required />
                            <div class="invalid-tooltip">Please provide a valid number.</div>
                        </div>

                        <!-- Is the correct product sleeve and coding used? -->
                        <div class="col-md-6 mb-3">
                            <label>Is the correct product sleeve and coding used as per the product?</label>
                            <select class="form-control" name="correctsleeve" onchange="toggleSubFields(this, 'correctsleeve')">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div id="correctsleeve_upload" style="display:none; margin-top:10px;">
                                <label>Upload File</label>
                                <input type="file" class="form-control" name="correctsleeve1" />
                            </div>
                            <div id="correctsleeve_comment" style="display:none; margin-top:10px;">
                                <label>Comment</label>
                                <textarea class="form-control" name="correctsleeve1" placeholder="Enter your comment"></textarea>
                            </div>
                        </div>

                        <!-- Barcode of sleeve issue -->
                        <div class="col-md-6 mb-3">
                            <label>Barcode of sleeve issue</label>
                            <input type="text" class="form-control" name="barcodesleeve" placeholder="Enter barcode" />
                            <div style="margin-top:10px;">
                                <label>Upload barcode of sleeve issue</label>
                                <input type="file" class="form-control" name="barcodesleeveissue1" accept="image/*" />
                            </div>
                        </div>

                        <!-- Last three digits of barcode -->
                        <div class="col-md-6 mb-3">
                            <label>Last three digits of barcode</label>
                            <input class="form-control" type="text" name="lastdigit" placeholder="Enter last three digits" required />
                            <div style="margin-top:10px;">
                                <label>Upload last three digits of barcode</label>
                                <input type="file" class="form-control" name="lastdigit1" accept="image/*" />
                            </div>
                            <div class="invalid-tooltip">Please provide a valid barcode.</div>
                        </div>

                        <!-- 2D barcode of sleeve issued -->
                        <div class="col-md-6 mb-3">
                            <label>2D barcode of sleeve issued</label>
                            <input type="text" class="form-control" name="twodbarcode" placeholder="Enter 2D barcode" />
                            <div style="margin-top:10px;">
                                <label>Upload 2D barcode</label>
                                <input type="file" class="form-control" name="twodbarcode1" accept="image/*" />
                            </div>
                        </div>

                        <!-- Number of pouches/sleeves returned -->
                        
                        <!-- Comment -->
                        <div class="col-md-12 mb-3">
                            <label for="comment">Comment</label>
                            <textarea name="comment" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSubFields(selectElement, fieldName) {
        var uploadDiv = document.getElementById(fieldName + '_upload');
        var commentDiv = document.getElementById(fieldName + '_comment');

        if (selectElement.value === 'Yes') {
            if (uploadDiv) uploadDiv.style.display = 'block';
            if (commentDiv) commentDiv.style.display = 'none';
        } else if (selectElement.value === 'No') {
            if (uploadDiv) uploadDiv.style.display = 'none';
            if (commentDiv) commentDiv.style.display = 'block';
        } else {
            if (uploadDiv) uploadDiv.style.display = 'none';
            if (commentDiv) commentDiv.style.display = 'none';
        }
    }
</script>


<?php
if (isset($_POST['submit'])) {

    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $productcode = mysqli_real_escape_string($con, $_POST['productcode']);
    $productname = mysqli_real_escape_string($con, $_POST['productname']);
    $issuername = mysqli_real_escape_string($con, $_POST['issuername']);
    $personname = mysqli_real_escape_string($con, $_POST['personname']);
    $machine = mysqli_real_escape_string($con, $_POST['machine']);
    $batches = mysqli_real_escape_string($con, $_POST['batches']);
    $pouchessleevesissue = mysqli_real_escape_string($con, $_POST['pouchessleevesissue']);
    $lastdigit = mysqli_real_escape_string($con, $_POST['lastdigit']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    // Packing line
    $packingline = mysqli_real_escape_string($con, $_POST['packingline']);
    $packingline1 = '';
    if ($packingline == 'Yes') {
        $packingline1 = $_FILES['packingline1']['name'];
    } elseif ($packingline == 'No') {
        $packingline1 = mysqli_real_escape_string($con, $_POST['packingline1']);
    }

    // Correct sleeve
    $correctsleeve = mysqli_real_escape_string($con, $_POST['correctsleeve']);
    $correctsleeve1 = '';
    if ($correctsleeve == 'Yes') {
        $correctsleeve1 = $_FILES['correctsleeve1']['name'];
    } elseif ($correctsleeve == 'No') {
        $correctsleeve1 = mysqli_real_escape_string($con, $_POST['correctsleeve1']);
    }

    // Barcode sleeve
    $barcodesleeve = mysqli_real_escape_string($con, $_POST['barcodesleeve']);
    $barcodesleeveissue1 = $_FILES['barcodesleeveissue1']['name'];

    // Last digit file
    $lastdigit1 = $_FILES['lastdigit1']['name'];

    // 2D barcode
    $twodbarcode = mysqli_real_escape_string($con, $_POST['twodbarcode']);
    $twodbarcode1 = $_FILES['twodbarcode1']['name'];


    $upload_dir = "paperwork/upl1/";

    if ($packingline == 'Yes') {
        $packingline1 = $_FILES['packingline1']['name'];
        move_uploaded_file($_FILES['packingline1']['tmp_name'], $upload_dir . $packingline1);
    }

    if ($correctsleeve == 'Yes') {
        $correctsleeve1 = $_FILES['correctsleeve1']['name'];
        move_uploaded_file($_FILES['correctsleeve1']['tmp_name'], $upload_dir . $correctsleeve1);
    }

    $barcodesleeveissue1 = $_FILES['barcodesleeveissue1']['name'];
    move_uploaded_file($_FILES['barcodesleeveissue1']['tmp_name'], $upload_dir . $barcodesleeveissue1);


    $lastdigit1 = $_FILES['lastdigit1']['name'];
    move_uploaded_file($_FILES['lastdigit1']['tmp_name'], $upload_dir . $lastdigit1);

    $twodbarcode1 = $_FILES['twodbarcode1']['name'];
    move_uploaded_file($_FILES['twodbarcode1']['tmp_name'], $upload_dir . $twodbarcode1);


    // Insert query
    $sql = "INSERT INTO `sleveissue`
        (`date`, `time`, `productcode`, `productname`, `issuername`, `personname`,
         `machine`, `packingline`, `packingline1`, `batches`, `pouchessleevesissue`,
         `correctsleeve`, `correctsleeve1`, `barcodesleeveissue`, `barcodesleeveissue1`,
         `lastdigit`, `lastdigit1`, `twodbarcode`, `twodbarcode1`, `comment`)
        VALUES
        ('$date', '$time', '$productcode', '$productname', '$issuername', '$personname',
         '$machine', '$packingline', '$packingline1', '$batches', '$pouchessleevesissue',
         '$correctsleeve', '$correctsleeve1', '$barcodesleeve', '$barcodesleeveissue1',
         '$lastdigit', '$lastdigit1', '$twodbarcode', '$twodbarcode1','$comment')";

    if (mysqli_query($con, $sql)) {
        echo "<script> window.location.href='admin.php?id=sleeve';</script>";
    } else {
        echo "<script> window.location.href='admin.php?id=sleeve';</script>";
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <ul>
            <li><a href=""></a></li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <a href="admin.php?id=flabeling&id2=<?php echo $_GET['id2']; ?>">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Sealing & Labelling check</div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label>Date</label>
                            <input class="form-control" type="date" required name="idate" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Production Batch</label>
                            <select name="prodbatch" class="form-control" required>
                                <option value="">Select Production Batch</option>
                                <?php
                                $nrk = mysqli_query($con, "SELECT * FROM `frozenmarination` WHERE label=''");
                                while ($nrk1 = mysqli_fetch_array($nrk)) {
                                    echo "<option value='" . $nrk1['batchcode'] . "'>" . $nrk1['batchcode'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Is the Pouches Sealed Properly?</label>
                            <select name="sachetsealed" id="sachetsealed" class="form-control" onchange="getcmnt()" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Is labelling correct on packet?</label>
                            <select name="labelling" id="labelcorrect" class="form-control" onchange="getcmnt()" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Is batch code & BBD printed adequately?</label>
                            <select name="print" id="bbprint" class="form-control" onchange="getcmnt()" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <script>
                            function getcmnt() {
                                var sachetsealed = document.getElementById("sachetsealed").value;
                                var labelcorrect = document.getElementById("labelcorrect").value;
                                var bbprint = document.getElementById("bbprint").value;
                                if (sachetsealed == "No" || labelcorrect == "No" || bbprint == "No") {
                                    document.getElementById("cmnt").style.display = "block";
                                } else {
                                    document.getElementById("cmnt").style.display = "none";
                                }
                            }
                        </script>

                        <div class="col-md-6 mb-3" id="cmnt" style="display:none;">
                            <label>Comments</label>
                            <textarea name="comment" class="form-control"></textarea>
                        </div>

                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $idate = $_POST['idate'];
    $prodbatch = $_POST['prodbatch'];
    $sachetsealed = $_POST['sachetsealed'];
    $labelling = $_POST['labelling'];
    $print = $_POST['print'];
    $comment = $_POST['comment'];
    $cdate = date('Y-m-d H:i:s');

    $packq = mysqli_query($con, "INSERT INTO `frozenlabeling`
        (`dates`, `productbatch`, `sealed`, `labelling`, `print`, `user`, `cdate`, `comments`)
        VALUES ('$idate','$prodbatch','$sachetsealed','$labelling','$print','$user','$cdate','$comment')");

    if ($packq) {
    
        mysqli_query($con, "UPDATE `frozenmarination` SET `label`='done' WHERE batchcode='$prodbatch'");
        echo "<script>window.location.href='admin.php?id=flabeling&id2=" . $_GET['id2'] . "';</script>";
    } else {
        echo "<script>alert('Failed to Add');</script>";
    }
}

?>
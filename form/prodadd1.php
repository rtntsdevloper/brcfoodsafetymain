<?php
$vid = $_GET['vid'];
$sqx1 = mysqli_query($con, "SELECT * FROM `zendproduction` WHERE id='$vid'");
$rowx1 = mysqli_fetch_array($sqx1);
$pckid = $rowx1['packid'];

$finm = mysqli_query($con, "SELECT * FROM `zendfinalproduct` WHERE id='$rowx1[fproduct]'");
$rowfinm = mysqli_fetch_array($finm);
$rowfinal = $rowfinm['name'];


?>

<div class="col-md-12 mb-5">
    <div class="card">
        <div class="card-body">
            <a href="admin.php?id=recip1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

            <div class="card-title">Production Detail
            </div>


            <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Finished Product</label>
                        <input type="text" class="form-control" value="<?= $rowfinal ?>" readonly>

                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Packaging Batch</label>
                        <input type="text" class="form-control" value="<?= $rowx1['pbatch'] ?>" readonly>

                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">

                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Production Batch Code</label>
                        <input class="form-control" id="validationTooltip01" type="text" required="required" name="batch" />

                    </div>
                    <!-- <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">SKU Batch Code</label>
                        <input class="form-control" id="validationTooltip01" type="text" required="required" name="skubatch" />

                    </div> -->
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">No. of Units Produced</label>
                        <input class="form-control" id="validationTooltip01" type="number" required="required" name="sachets" />

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Is the filling machine throughtly cleaned before starting production of this product?</label>
                        <select name="machineclean" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6">

                        <label for="validationTooltip01">Is all coded packaging used of selected batch?</label>
                        <select name="packcode" class="form-control" required onchange="otherpacks(this.value)">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>


                    </div>

                    <script>
                        function otherpacks(val) {
                            if (val == 'Yes') {
                                document.getElementById('otherpack').classList.remove('d-none');
                                document.getElementById('othpck').required = true;
                            } else {
                                document.getElementById('otherpack').classList.add('d-none');
                                document.getElementById('othpck').required = false;
                            }
                        }
                    </script>

                    <div class="col-md-6">
                        <div id="otherpack" class="d-none">
                            <label for="validationTooltip01">Is any other batch of packaging used?</label>
                            <select name="otherpack" class="form-control" id="othpck" onchange="otherpack1(this.value)">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                    </div>
                    <script>
                        function otherpack1(val) {
                            if (val == 'Yes') {
                                document.getElementById('otherbatch').classList.remove('d-none');
                                document.getElementById('otherprodk').required = true;
                            } else {
                                document.getElementById('otherbatch').classList.add('d-none');
                                document.getElementById('otherprodk').required = false;
                            }
                        }
                    </script>
                </div>
                <div class="row my-3 d-none" id="otherbatch">

                    <div class="col-md-6">



                        <label for="validationTooltip02">Other Packaging Batch</label>
                        <select name="otherpbatch" id="otherprodk" class="form-control">
                            <option value="">Select</option>
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM `zendpackaging` WHERE prodend ='' and id != '$pckid'");
                            while ($row = mysqli_fetch_array($sql)) {
                            ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['pbatch']; ?>(<?= $row['batchcode'] ?>)</option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>
                    <div class="col-md-6">

                        <label for="validationTooltip01">Is all coded packaging used of selected batch?</label>
                        <select name="otherpackcode" class="form-control" onchange="otherpack(this.value)">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>


                    </div>

                </div>

                <div class="form-row mt-2">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {

    $batch = $_POST['batch'];
    $skubatch = '';
    $sachets = $_POST['sachets'];
    $packcode = $_POST['packcode'];
    $otherpack = $_POST['otherpack'];
    $otherpbatch = $_POST['otherpbatch'];
    $otherpackcode = $_POST['otherpackcode'];

    $machineclean = $_POST['machineclean'];

    $skn = mysqli_query($con, "SELECT * FROM `zendpackaging` WHERE id='$otherpbatch'");
    $rkn = mysqli_fetch_array($skn);
    $rkin = $rkn['pbatch'];

    if ($packcode == 'Yes') {
        $qkn = mysqli_query($con, "Update `zendpackaging` SET `prodend`='done' WHERE id='$pckid'");
    }
    if ($otherpackcode == 'Yes') {
        $qkn = mysqli_query($con, "Update `zendpackaging` SET `prodend`='done' WHERE id='$otherpbatch'");
    }

    $cdate = date('Y-m-d h:i:s');
    

    $sqlm = mysqli_query($con, "UPDATE `zendproduction` SET `batch`='$batch',`skbatch`='$skubatch',`sachet`='$sachets',sachetleft='$sachets',`coded`='$packcode',`othercode`='$otherpack',`otherbid`='$otherpbatch',`othercheck`='$otherpackcode',`otherbatch`='$rkin',`user`='$user',`cdate`='$cdate',`done`='done',`machinec` ='$machineclean' WHERE id='$vid'");

    if ($sqlm) {
        echo "<script>window.location.href='admin.php?id=zenprod';</script>";
    } else {
        echo "<script>window.location.href='admin.php?id=zenprod';</script>";
    }
}

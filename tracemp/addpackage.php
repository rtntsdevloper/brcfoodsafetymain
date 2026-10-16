<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Packaging and Label Check</li>
        </ul>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 style="float:left;">Add Packaging and Label</h3>
                <a href="admin.php?id=package"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" >
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" value name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <select name="pname" id="pdnm" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                $sq1 = mysqli_query($con, "SELECT * FROM `tblflavourmix` where status ='Pending'");

                                while ($row = mysqli_fetch_assoc($sq1)) {
                                ?>
                                    <option value="<?php echo $row['productname']; ?>" data-name='<?php echo $row['batch']; ?>' data-weight='<?php echo $row['totalleft']; ?>' data-date='<?php echo $row['date']; ?>' data-expiry='<?php echo $row['useby1']; ?>'><?php echo $row['productname']; ?> (<?php echo $row['batch'] ?>)</option>
                                <?php
                                }
                                ?>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <script>
                            document.getElementById('pdnm').addEventListener('change', function() {
                                const selectedOption = this.options[this.selectedIndex];
                                const dataName = selectedOption.getAttribute('data-name');
                                const dataDate = selectedOption.getAttribute('data-date');
                                const dataExp = selectedOption.getAttribute('data-expiry');
                                const dataWeight = selectedOption.getAttribute('data-weight');

                                document.getElementById('ubd').value = dataDate;
                                document.getElementById('btcode').value = dataName;
                                document.getElementById('expd').value = dataExp;
                                document.getElementById('weight').value = dataWeight;

                            });
                        </script>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Production Date</label>
                            <input class="form-control" id="ubd" type="date" required="required" name="pdate" readonly />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Best before Date</label>
                            <input class="form-control" id="expd" type="date" required="required" name="bbdate" readonly />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Product Batchcode</label>
                            <input class="form-control" id="btcode" type="text" required="required" name="batchcode" readonly />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Product Start Weight</label>
                            <div class="input-group mb-3">

                                <input type="number" class="form-control" id="weight" name="prdweight" readonly>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kg</span>
                                </div>
                            </div>

                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Size of Packaging</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="size">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">g</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Type of Packaging</label>
                            <select name="packname" onchange="package(this)" class="form-control">
                                <option>Please Select</option>
                                <?php
                                $qsp = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE `category` LIKE 'Primary Packaging' order by pname ASC");
                                foreach ($qsp as $row) {
                                ?>
                                    <option value="<?php echo $row['pname']; ?>" data-id="<?php echo $row['id']; ?>"><?php echo $row['pname']; ?></option>
                                <?php
                                }

                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6" id="packtype">

                        </div>


                        <script>
                            function package(quantity) {
                                const selectedOption = quantity.options[quantity.selectedIndex];
                                const dataId = selectedOption.getAttribute('data-id');
                                document.getElementById('prodnsid').value = dataId;


                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState === 4) {
                                        if (this.status === 200) {
                                            document.getElementById('packtype').innerHTML = this.responseText;
                                        } else {
                                            console.error("Request failed with status:", this.status);
                                            document.getElementById('packtype').innerHTML = "Error loading packaging details.";
                                        }
                                    }
                                };

                                xhr.open("GET", "tracemp/packageqty.php?quantity=" + encodeURIComponent(dataId), true);
                                xhr.send();
                            }
                        </script>


                        <script>
                            function pcknm(pname) {
                                const selectedOption = pname.options[pname.selectedIndex];
                                const dataIdn = selectedOption.getAttribute('data-id');
                                const databatch = selectedOption.getAttribute('data-name');
                                document.getElementById('strkw').value = dataIdn;


                            }
                        </script>


                        <input type="hidden"  id="prodnsid" name="packid">


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Packaging Start Weight</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="stweight" id="strkw" readonly>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kg</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3 pl-3">
                            <label for="validationTooltip01">Is Previous Packaging Removed from the Line?</label>
                            <br>
                            <input type="radio" name="rline" value="Yes"> Yes
                            <input type="radio" name="rline" value="No"> No
                            <input type="radio" name="rline" value="N/A"> N/A


                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch code printed on label</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="batchlabel" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                        </div>



                    </div>

            </div>
            </br>

            </form>
        </div>
    </div>
</div>

<?php

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $pname = $_POST['pname'];
    $pdate = $_POST['pdate'];
    $pbatch = $_POST['batch'];
    $prweight = $_POST['prdweight'];
    $size = $_POST['size'];
    $batchcode = $_POST['batch'];

    $rline = $_POST['rline'];
    $bbdate = $_POST['bbdate'];

    $packw = $_POST['stweight'];
    $packname = $_POST['packname'];
    $packgrn = $_POST['packgrn'];
    $batchlabel = $_POST['batchlabel'];
    $prodsid = $_POST['packid'];

    $pk = mysqli_query($con, "SELECT * FROM `tbllabel`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1 + 1;

    $record = "PACK00" . $pk2;

    $sql = "INSERT INTO tbllabel (date,pname, pdate, size, batchcode, rline, bbdate, recordid,prodbatch,prdweight,packweight, `prdname`, `prdbatch`, `printbatch`,`prodid`) VALUES ('$date','$pname', '$pdate', '$size', '$packgrn', '$rline', '$bbdate', '$record','$pbatch','$prweight','$packw','$packname','$packgrn','$batchlabel','$prodsid')";
    // print_r($sql);die;

    if (mysqli_query($con, $sql)) {

        echo "<script>window.location.href='admin.php?id=opsign&tid=$record';</script>";
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }
}


?>
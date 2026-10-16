<?php
$sno = $_GET['sno'];
$sql = mysqli_query($con, "select * from tbl_micortrend1 where id='$sno'");
$row = mysqli_fetch_array($sql);


$sid = $row['sid'];
$sql1 = mysqli_query($con, "select * from tbl_micortrend where id='$sid'");
$row1 = mysqli_fetch_array($sql1);



?>


<div class="container">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Micro Trending Assign</li>
            </ul>
        </div>
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-12">
                    <a href="admin.php?id=microview" class="btn btn-success" style="float: right;">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">




            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title">Micro Trending</div>

                        <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="validationTooltip01">Section</label>
                                    <input type="text" class="form-control" readonly value="<?= $row1['name']; ?>">
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Sub-Section Name</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Sub-Section" required="required" name="sname" value="<?= $row['name']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Sample No.</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Sample No." required="required" name="sample" value="<?= $row['sampleno']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Location</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Location" required="required" name="loc" value="<?= $row['location']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Area</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Area" name="area" required="required" name="area" value="<?= $row['area']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Frequency</label>
                                    <input class="form-control" id="validationTooltip01" type="number" name="frequency" placeholder="Frequency" required="required"  value="<?= $row['frequency']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Select Month</label>
                                    <select id="month" name="month[]" required multiple class="form-control">
                                        <?php
                                        $montha = $row['months'];
                                      $monthb = explode(";", $montha);

                                        ?>

                                        <option value="01"<?php if (in_array("01", $monthb)) { ?> selected <?php } ?>>January</option>
                                        <option value="02"<?php if (in_array("02", $monthb)) { ?> selected <?php } ?>>February</option>
                                        <option value="03" <?php if (in_array("03", $monthb)) { ?> selected <?php } ?>>March</option>
                                        <option value="04" <?php if (in_array("04", $monthb)) { ?> selected <?php } ?>>April</option>
                                        <option value="05" <?php if (in_array("05", $monthb)) { ?> selected <?php } ?>>May</option>
                                        <option value="06" <?php if (in_array("06", $monthb)) { ?> selected <?php } ?>>June</option>
                                        <option value="07" <?php if (in_array("07", $monthb)) { ?> selected <?php } ?> >July</option>
                                        <option value="08" <?php if (in_array("08", $monthb)) { ?> selected <?php } ?>>August</option>
                                        <option value="09" <?php if (in_array("09", $monthb)) { ?> selected <?php } ?>>September</option>
                                        <option value="10" <?php if (in_array("10", $monthb)) { ?> selected <?php } ?>>October</option>
                                        <option value="11" <?php if (in_array("11", $monthb)) { ?> selected <?php } ?>>November</option>
                                        <option value="12"<?php if (in_array("12", $monthb)) { ?> selected <?php } ?>>December</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>




                            </div>



                            <br />

                            <button class="btn btn-primary" type="submit" name="submit2">Submit </button>
                        </form>
                    </div>
                </div>
            </div>




            <?php

            $addby = $_SESSION['user'];
            if (isset($_POST['submit1'])) {
                $name = mysqli_real_escape_string($con, $_POST['sname']);

                $sql = mysqli_query($con, "INSERT INTO `tbl_micortrend`(`name`, `add_by`) VALUES ('$name','$addby')");
            ?>
                <script language="javascript">
                    window.open('admin.php?id=microadd', '_self');
                </script>
            <?php
            }
            ?>


            <?php
            if (isset($_POST['submit2'])) {
                $sample = $_POST['sample'];
                $loc = $_POST['loc'];
                $area = $_POST['area'];
                $frequency = $_POST['frequency'];
                $mont = $_POST['month'];
                $month = implode(";", $mont);
                $addby = $_SESSION['user'];
                

                $sname = mysqli_real_escape_string($con, $_POST['sname']);
                $sql1 = mysqli_query($con, "UPDATE `tbl_micortrend1` SET `name`='$sname', `add_by`='$addby', `location`='$loc', `area`='$area', `sampleno`='$sample', `frequency`='$frequency', `months`='$month' WHERE `id`='$sno'");
            ?>
                <script language="javascript">
                    alert("Successfully updated!");
                    window.open('admin.php?id=microview1&sno=<?= $sid ?>', '_self');
                </script>
            <?php
            }
            ?>
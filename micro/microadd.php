<div class="container">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Add Micro Trending</li>
            </ul>
        </div>
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-12">
                    <a href="admin.php?id=microview" class="btn btn-success" style="float: right;">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Section</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>

                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Sub-Section</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="sid">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                                            while ($row = mysqli_fetch_array($gh)) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="validationTooltip01">Location</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Location" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="validationTooltip01">Sample No.</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Sample No." required="required" name="sample" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>


                                    <div class="col-12 mt-3">
                                        <label for="validationTooltip01">Area</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Area" name="area" required="required" name="area" />
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
                    $sid = $_POST['sid'];
                    $sample = $_POST['sample'];
                    $area = $_POST['area'];
                    $sname = mysqli_real_escape_string($con, $_POST['sname']);
                    $addby = $_SESSION['user'];
                    $sql1 = mysqli_query($con, "INSERT INTO `tbl_micortrend1`(`name`, `add_by`, `sid`, `area`, `sampleno`) VALUES ('$sname','$addby','$sid','$area','$sample')");
                ?>
                    <script language="javascript">
                        alert("Successfully updated!");
                        window.open('admin.php?id=microadd', '_self');
                    </script>
                <?php
                }
                ?>
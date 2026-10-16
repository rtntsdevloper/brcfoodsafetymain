<div class="container">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Edit Micro Trending</li>
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

                        <div class="card-title">Micro Trending Assign</div>

                        <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-12">
                                    <label for="validationTooltip01">Section</label>
                                    <select name="section" id="" class="form-control" onchange="getsub(this.value)" required>
                                        <option disabled selected>-- Select Section --</option>
                                        <?php
                                        $sectionm = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                                        foreach ($sectionm as $sectionmv) {
                                            echo '<option value="' . $sectionmv['id'] . '">' . $sectionmv['name'] . '</option>';
                                        }


                                        ?>

                                    </select>
                                    <div class="invalid-tooltip">
                                        Please select a section.
                                    </div>
                                </div>
                                <script>
                                    function getsub(quantity) {

                                        const xhr = new XMLHttpRequest();
                                        xhr.onreadystatechange = function() {
                                            if (this.readyState === 4) {
                                                if (this.status === 200) {
                                                    // Update the label with the response


                                                    document.getElementById('subsection').innerHTML = this.responseText;
                                                } else {

                                                }
                                            }
                                        };

                                        xhr.open("GET", "micro/microassignadd1.php?sid=" + quantity, true);
                                        xhr.send();

                                    }
                                </script>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Sub-Section Name</label>
                                    <select name="subsection" id="subsection" class="form-control" required>
                                        <option disabled selected> -- Select Sub-Section -- </option>

                                    </select>
                                    <div class="invalid-tooltip">
                                        Please select a sub-section.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Enter Year</label>
                                    <input class="form-control" id="validationTooltip01" type="number" name="year" min="2020" step="1" placeholder="Frequency" required="required" value="<?php echo date('Y'); ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Frequency</label>
                                    <input class="form-control" id="validationTooltip01" type="number" name="frequency" placeholder="Frequency" required="required" value="<?= $row['frequency']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="validationTooltip01">Select Month</label>
                                    <select id="month" name="month[]" required multiple class="form-control">

                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
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
                $sample = $_POST['section'];
                $subsec = $_POST['subsection'];
                $year = $_POST['year'];
                $frequency = $_POST['frequency'];
                $mont = $_POST['month'];


                $addby = $_SESSION['user'];
                $attempton = date('Y-m-d h:i:s');

                foreach ($mont as $month => $mvalue) {
                    $admonth = $year."-".$mvalue;
                    $sql1 = mysqli_query($con, "INSERT INTO `tbl_microtrending`(`sid`, `mid`, `month`, `assign_on`, `user`, `year`, `frequency`,`admonth`) VALUES ('$subsec','$sample','$mvalue','$attempton','$addby','$year','$frequency','$admonth')");
                }
                if ($sql1) {


            ?>
                    <script language="javascript">
                        alert("Successfully updated!");
                        window.open('admin.php?id=microassign', '_self');
                    </script>
            <?php
                }
            }
            ?>
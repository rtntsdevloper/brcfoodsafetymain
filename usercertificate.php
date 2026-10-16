<?php
$sno = $_GET['sno'];
$sl = mysqli_query($con, "select * from tblstaff where id='$sno'");
$row = mysqli_fetch_array($sl);
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">User Management</a></li>
            <li>Edit User</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=umgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Upload Certificate</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="sno" value="<?php echo $sno; ?>" />
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">First name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name" required="required" name="fname" value="<?php echo $row['fname']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Last name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Last name" required="required" name="lname" value="<?php echo $row['lname']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
                        </div>

                    </div>
                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">Procedure Training</legend>
                        <div class="form-row">

                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Is this certification applicable to the user?</label>
                                <select name="procedure" id="" class="form-control" onchange="showcert(this.value,1)">
                                    <option selected disabled>Please select</option>
                                    <option value="Yes" <?php if ($row['procedure'] == "Yes") echo "selected"; ?>>Yes</option>
                                    <option value="No" <?php if ($row['procedure'] == "No") echo "selected"; ?>>No</option>
                                </select>

                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>

                            <?php
                            $procert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'CCP'  order by id desc limit 1");
                            $procert1 = mysqli_fetch_assoc($procert);

                            ?>
                            <div class="col-md-8">
                                <div class="row <?php if ($row['procedure'] == "No" || $row['procedure'] == "") {
                                                    echo "d-none";
                                                } ?>" id="cert1">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Certificate : 
                                            <?php 
                                            if (!empty($procert1['certificate'])) {
                                                ?>
<a href="student/$procert1['certificate']" target="_blank" style="color:#0000FF">View Procedure Certificate</a>
                                                <?php
                                                
                                            }
                                            ?>
                                            </label>
                                        <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Expiry Date : </label>
                                        <input name="expirydate" class="form-control" id="validationTooltip08" type="date" value="<?= $procert1['certdate'];  ?>">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </fieldset>


                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">CCP Training</legend>
                        <div class="form-row">


                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Is this certification applicable to the user?</label>
                                <select name="ccp" id="" class="form-control" onchange="showcert(this.value,2)">
                                    <option selected disabled>Please select</option>
                                    <option value="Yes" <?php if ($row['ccp'] == "Yes") echo "selected"; ?>>Yes</option>
                                    <option value="No" <?php if ($row['ccp'] == "No") echo "selected"; ?>>No</option>
                                </select>

                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <?php
                            $ccpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'CCP'  order by id desc limit 1");
                            $ccpcert1 = mysqli_fetch_assoc($ccpcert);

                            ?>
                            <div class="col-md-8">
                                <div class="row <?php if ($row['ccp'] == "No" || $row['ccp'] == "") {
                                                    echo "d-none";
                                                } ?>" id="cert2">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Certificate :
                                            <?php
                                            if (!empty($ccpcert1['certificate'])) {
                                            ?>
                                                <a href="student/<?php echo $ccpcert1['certificate']; ?>" target="_blank" style="color:#0000FF">View CCP Certificate</a>
                                            <?php
                                            }

                                            ?>

                                        </label>
                                        <input name="ccert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Expiry Date : </label>
                                        <input name="cexpirydate" class="form-control" id="validationTooltip08" type="date" value="<?= $ccpcert1['certdate'] ?>">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </fieldset>




                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">HACCP Training</legend>
                        <div class="form-row">


                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Is this certification applicable to the user?</label>
                                <select name="haccp" id="" class="form-control" onchange="showcert(this.value,3)" required>
                                    <option selected disabled>Please select</option>
                                    <option value="Yes" <?php if ($row['haccp'] == "Yes") echo "selected"; ?>>Yes</option>
                                    <option value="No" <?php if ($row['haccp'] == "No") echo "selected"; ?>>No</option>
                                </select>

                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <?php
                            $hcpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'HACCP'  order by id desc limit 1");
                            $hcpcert1 = mysqli_fetch_assoc($hcpcert);

                            ?>
                            <div class="col-md-8">
                                <div class="row <?php if ($row['haccp'] == "No" || $row['haccp'] == "") {
                                                    echo "d-none";
                                                } ?>" id="cert3">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Certificate : <?php if (!empty($hcpcert1['certificate'])) { ?>
                                                <a href="student/<?php echo $hcpcert1['certificate']; ?>" target="_blank" style="color:#0000FF">View HACCP Certificate</a>
                                            <?php } ?> </label>
                                        <input name="hcert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Expiry Date : </label>
                                        <input name="hexpirydate" class="form-control" id="validationTooltip08" type="date" value="<?php echo $hcpcert1['certdate']; ?>">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>




                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">Level 2 Food Safety Training</legend>
                        <div class="form-row">

                            <?php
                            $lvl2cert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Level2'  order by id desc limit 1");
                            $rowlvl2 = mysqli_fetch_assoc($lvl2cert);
                            ?>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Is this certification applicable to the user?</label>
                                <select name="lvl2" id="" class="form-control" onchange="showcert(this.value,4)" required>
                                    <option selected disabled>Please select</option>
                                    <option value="Yes" <?php if ($row['lvl2'] == "Yes") echo "selected" ?>>Yes</option>
                                    <option value="No" <?php if ($row['lvl2'] == "No") echo "selected" ?>>No</option>
                                </select>

                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row <?php if ($row['lvl2'] == "No" || $row['lvl2'] == "") {
                                                    echo "d-none";
                                                }  ?>" id="cert4">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Certificate :
                                            <?php if (!empty($rowlvl2['certificate'])) {
                                            ?>
                                                <a href="student/<?php echo  $rowlvl2['certificate']; ?>" target="_blank" style="color:#0000FF">View Level 2 Certificate</a>
                                            <?php
                                            }
                                            ?>



                                        </label>
                                        <input name="lvcert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Expiry Date : </label>
                                        <input name="lvexpirydate" class="form-control" id="validationTooltip08" type="date" value="<?php echo $rowlvl2['certdate']; ?>">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </fieldset>


                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">Allergen Training</legend>

                        <div class="form-row">
                            <?php
                            $alcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Allergen'");
                            $rowal = mysqli_fetch_assoc($alcert);

                            ?>


                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Is this certification applicable to the user?</label>
                                <select name="allergen" id="" class="form-control" onchange="showcert(this.value,5)" required>
                                    <option selected disabled>Please select</option>
                                    <option value="Yes" <?php if ($row['allergen'] == "Yes") echo "selected"; ?>>Yes</option>
                                    <option value="No" <?php if ($row['allergen'] == "No") echo "selected"; ?>>No</option>
                                </select>

                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row <?php if ($row['allergen'] == "No" || $row['allergen'] == "") {
                                                    echo "d-none";
                                                } ?>" id="cert5">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Certificate :
                                            <?php if (!empty($rowal['certificate'])) {
                                            ?>
                                                <a href="student/<?php echo $rowal['certificate']; ?>" target="_blank" style="color:#0000FF">View Allergen Certificate</a>
                                            <?php
                                            }

                                            ?> </label>
                                        <input name="alcert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip05">Expiry Date : </label>
                                        <input name="alexpirydate" class="form-control" id="validationTooltip08" type="date" value="<?php echo $rowal['certdate']; ?>">
                                        <div class="invalid-tooltip">
                                            Please fill the field.

                                        </div>
                                    </div>
                                </div>


                            </div>
                    </fieldset>

                    <button class="btn btn-primary mt-3 ml-3" type="submit" name="submit">Submit </button>
            </div>



            </form>
        </div>
    </div>

    <script>
        function showcert(val, id) {
            if (val == "Yes") {
                document.getElementById("cert" + id).classList.remove("d-none");
            } else {
                document.getElementById("cert" + id).classList.add("d-none");
            }
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {
        $user = $_SESSION['user'];
        $crdate = date("d-m-Y H:i:s");
        $procedure = $_POST['procedure'];
        $haccp = $_POST['haccp'];
        $ccp = $_POST['ccp'];
        $lvl2 = $_POST['lvl2'];
        $allergen = $_POST['allergen'];
        $certup = mysqli_query($con, "UPDATE `tblstaff` SET `ccp`='$ccp',`lvl2`='$lvl2',`procedure`='$procedure',`haccp`='$haccp',`allergen`='$allergen' WHERE id='$sno'");


        //Procedure

        if ($procedure == "Yes") {

            $proexpirydate = $_POST['expirydate'];
            if (isset($_FILES['cert']['name']) && !empty($_FILES['cert']['name'])) {
                $procert = "procedure_" . date("YmdHis") . $_FILES['cert']['name'];
                move_uploaded_file($_FILES['cert']['tmp_name'], "student/" . $procert);
                $procedcert = mysqli_query($con, "INSERT INTO `tblstaffcert`(`user`, `type`, `add_on`, `certificate`, `certdate`, `add_by`) VALUES ('$sno','Procedure','$crdate','$procert','$proexpirydate','$user')");
            }
        }

        //HACCP

        if ($haccp == "Yes") {

            $hexpirydate = $_POST['hexpirydate'];
            if (isset($_FILES['hcert']['name']) && !empty($_FILES['hcert']['name'])) {
                $hcert = "haccp_" . date("YmdHis") . $_FILES['hcert']['name'];
                move_uploaded_file($_FILES['hcert']['tmp_name'], "student/" . $hcert);

                $hacpcert = mysqli_query($con, "INSERT INTO `tblstaffcert`(`user`, `type`, `add_on`, `certificate`, `certdate`, `add_by`) VALUES ('$sno','HACCP','$crdate','$hcert','$hexpirydate','$user')");
            }
        }
        //CCP

        if ($ccp == "Yes") {
            echo $ccertexpirydate = $_POST['cexpirydate'];
            if (isset($_FILES['ccert']['name']) && !empty($_FILES['ccert']['name'])) {
                $ccert = "ccp_" . date("YmdHis") . $_FILES['ccert']['name'];
                move_uploaded_file($_FILES['ccert']['tmp_name'], "student/" . $ccert);
                $ccpcert = mysqli_query($con, "INSERT INTO `tblstaffcert`(`user`, `type`, `add_on`, `certificate`, `certdate`, `add_by`) VALUES ('$sno','CCP','$crdate','$ccert','$ccertexpirydate','$user')");
            } else {
                $ccert = "";
            }
        }

        //Level2

        if ($lvl2 == "Yes") {
            echo $lvexpirydate = $_POST['lvexpirydate'];
            if (isset($_FILES['lvcert']['name']) && !empty($_FILES['lvcert']['name'])) {
                $lvcert = "level2_" . date("YmdHis") . $_FILES['lvcert']['name'];
                move_uploaded_file($_FILES['lvcert']['tmp_name'], "student/" . $lvcert);
                $lvpcert = mysqli_query($con, "INSERT INTO `tblstaffcert`(`user`, `type`, `add_on`, `certificate`, `certdate`, `add_by`) VALUES ('$sno','Level2','$crdate','$lvcert','$lvexpirydate','$user')");
            }
        }

        //Allergen
        if ($allergen == "Yes") {
            echo $alexpirydate = $_POST['alexpirydate'];
            if (isset($_FILES['alcert']['name']) && !empty($_FILES['alcert']['name'])) {
                $alcert = "allergen_" . date("YmdHis") . $_FILES['alcert']['name'];
                move_uploaded_file($_FILES['alcert']['tmp_name'], "student/" . $alcert);
                $alcert = mysqli_query($con, "INSERT INTO `tblstaffcert`(`user`, `type`, `add_on`, `certificate`, `certdate`, `add_by`) VALUES ('$sno','Allergen','$crdate','$alcert','$alexpirydate','$user')");
            }
        }

        if ($certup) {
    ?>
            <script>
                alert("Certificate Updated Successfully");
                 window.location.href = "admin.php?id=umgmt";
            </script>
    <?php
        }
    }
    ?>
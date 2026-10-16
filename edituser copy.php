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

                <div class="card-title">Edit User</div>
                <?php
                if (isset($_GET['msg'])) {
                ?>
                    <div class="card-title" style="color:#FF0000">User already exist</div>
                <?php
                }
                ?>
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
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">User name</label>
                            <input name="uname" type="text" class="form-control" id="validationTooltip03" placeholder="User name" required="required" value="<?php echo $row['uname']; ?>" disabled="disabled" />
                            <div class="invalid-tooltip">
                                Please provide a valid username.

                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Password</label>
                            <input class="form-control" id="validationTooltip04" type="password" placeholder="password" required="required" name="pwd" value="<?php echo $row['pwd']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid password.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Department</label>
                            <input name="department" type="text" class="form-control" id="validationTooltip05" placeholder="Department" required="required" value="<?php echo $row['department']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Job Title</label>
                            <input name="jobtitle" type="text" class="form-control" id="validationTooltip06" placeholder="Job Title" required="required" value="<?php echo $row['jobtitle']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Email</label>
                            <input name="email" type="email" class="form-control" id="validationTooltip06" placeholder="Email" value="<?php echo $row['email']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Pay roll no</label>
                            <input name="payroll" type="number" class="form-control" id="validationTooltip07" placeholder="Pay roll no" required="required" value="<?php echo $row['payroll']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">User Photo : <a href="student/<?php echo $row['img']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['img']; ?></a></label>
                            <input name="img" class="form-control" id="validationTooltip08" type="file" accept="image/jpeg,jpg">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4>Procedure Training</h4>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Is this certification applicable to the user?</label>
                            <select name="applicable" id="" class="form-control" onchange="showcert(this.value,1)">
                                <option selected disabled>Please select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row d-none" id="cert1">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Certificate : <a href="student/<?php echo $row['cert']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['cert']; ?></a></label>
                                    <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Expiry Date : </label>
                                    <input name="expirydate" class="form-control" id="validationTooltip08" type="date">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4>CCP Training</h4>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Is this certification applicable to the user?</label>
                            <select name="applicable" id="" class="form-control" onchange="showcert(this.value,2)">
                                <option selected disabled>Please select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row d-none" id="cert2">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Certificate : <a href="student/<?php echo $row['cert']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['cert']; ?></a></label>
                                    <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Expiry Date : </label>
                                    <input name="expirydate" class="form-control" id="validationTooltip08" type="date">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <h4>HACCP Training</h4>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Is this certification applicable to the user?</label>
                            <select name="applicable" id="" class="form-control" onchange="showcert(this.value,3)">
                                <option selected disabled>Please select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row d-none" id="cert3">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Certificate : <a href="student/<?php echo $row['cert']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['cert']; ?></a></label>
                                    <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Expiry Date : </label>
                                    <input name="expirydate" class="form-control" id="validationTooltip08" type="date">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                     <div class="form-row">
                        <div class="col-md-12">
                            <h4>Level 2 Food Safety Training</h4>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Is this certification applicable to the user?</label>
                            <select name="applicable" id="" class="form-control" onchange="showcert(this.value,4)">
                                <option selected disabled>Please select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row d-none" id="cert4">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Certificate : <a href="student/<?php echo $row['cert']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['cert']; ?></a></label>
                                    <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Expiry Date : </label>
                                    <input name="expirydate" class="form-control" id="validationTooltip08" type="date">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                    <fieldset class="border p-3 mt-3">
                        <legend class="w-auto px-2">Metal Test Inputs</legend></fieldset>

                     <div class="form-row">
                        <div class="col-md-12">
                            <h4>Allergen Training</h4>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Is this certification applicable to the user?</label>
                            <select name="applicable" id="" class="form-control" onchange="showcert(this.value,5)">
                                <option selected disabled>Please select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row d-none" id="cert5">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Certificate : <a href="student/<?php echo $row['cert']; ?>" target="_blank" style="color:#0000FF"><?php echo $row['cert']; ?></a></label>
                                    <input name="cert" class="form-control" id="validationTooltip08" type="file" accept="application/pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip05">Expiry Date : </label>
                                    <input name="expirydate" class="form-control" id="validationTooltip08" type="date">
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
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
    $sno = $_POST['sno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $payroll = $_POST['payroll'];
    $jobtitle = $_POST['jobtitle'];
    $img = $_FILES['img']['name'];
    $user = $_SESSION['user'];
    $cert = $_FILES['cert']['name'];

    if ($cert == "") {
        $cert = $_POST['cert1'];
    } else if ($cert != "") {
        $cert = $_FILES['cert']['name'];
        $h = move_uploaded_file($_FILES['cert']['tmp_name'], "student/" . $cert);
    }

    $y = move_uploaded_file($_FILES['img']['tmp_name'], "student/" . $img);

    $fg = mysqli_query($con, "select * from tblstaff where uname='$uname' and id!='$sno'");
    $match = mysqli_num_rows($fg);
    if ($match >= 1) {
?>
        <script language="javascript">
            window.open('admin.php?id=edituser&sno=<?php echo $sno; ?>&msg=1', '_self');
        </script>

    <?php
    } else {
        if ($img != "") {
            $sql = mysqli_query($con, "update tblstaff set fname='$fname', lname='$lname',  pwd='$pwd', department='$department', payroll='$payroll',email='$email', jobtitle='$jobtitle',img='$img',cert='$cert' where id='$sno'");
        } else {
            $sql = mysqli_query($con, "update tblstaff set fname='$fname', lname='$lname',  pwd='$pwd', department='$department', payroll='$payroll', email='$email', jobtitle='$jobtitle',cert='$cert' where id='$sno'");
        }
    ?>
        <script language="javascript">
            window.open('admin.php?id=umgmt', '_self');
        </script>
<?php
    }
}
?>
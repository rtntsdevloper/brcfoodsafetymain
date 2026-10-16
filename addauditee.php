<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Auditee Management</a></li>
            <li>Add Auditee</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=auditeemgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Auditee</div>
                <h3>General Information</h3>
                <?php
                if (isset($_GET['msg'])) {
                ?>
                    <div class="card-title" style="color:#FF0000">Already exist</div>
                <?php
                }
                ?>
                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name" required="required" name="name" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Contact</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="Contact" required="required" name="contact" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Email</label>
                            <input name="email" type="email" class="form-control" id="validationTooltip03" placeholder="Email" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Username</label>
                            <input class="form-control" id="validationTooltip04" type="text" placeholder="Username" required="required" name="uname" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Password</label>
                            <input name="pwd" type="password" class="form-control" id="validationTooltip05" placeholder="Password" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Department</label>
                            <select name="dept[]" class="form-control" required multiple="multiple">
                                <option value="">Please Select</option>
                                <?php
                                $sql = mysqli_query($con, "select * from tbldept");
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditee Photo</label>
                            <input name="img" type="file" class="form-control" id="validationTooltip06" placeholder="City" required="required" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditee Signature</label>
                            <input name="sign" type="file" class="form-control" id="validationTooltip06" placeholder="City" required="required" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h3>Tab Access</h3>
                        <div class="row">
                            </br>
                            <?php
                            $query = mysqli_query($con, "select * from tbltabs");
                            $i = 1;
                            while ($roc = mysqli_fetch_array($query)) {
                            ?>
                                <div class="col-4">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno'] ?>" id="flexCheckDefault-<?php echo $roc['sno'] ?>" name="tab_acess[]"

                                        <label class="form-check-label" for="flexCheckDefault-<?php echo $roc['sno'] ?>">
                                    <?php echo $roc['name'] ?> <?php echo $roc['name1'] ?>
                                    </label>
                                </div>
                            <?php
                                $i++;
                            }
                            ?>
                        </div>
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>

                    </div>

                    </br>

                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $rt = "";
    $rt1 = "";
    $user = $_SESSION['user'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    $deptt = "";
    foreach ($_POST['dept'] as $selected) {
        $deptt .= $selected . ";";
    }


    if (!empty($_POST['tab_acess'])) {
        $tabs = $_POST['tab_acess'];
        $tabs = implode(';', $tabs) . ";";
    } else {
        $tabs = $_POST['tab_ids'];
    }



    $img = $_FILES['img']['name'];
    $gh = move_uploaded_file($_FILES['img']['tmp_name'], "auditordoc/" . $img);

      $sign = "Sign_".$_FILES['sign']['name'];
    $gh1 = move_uploaded_file($_FILES['sign']['tmp_name'], "auditordoc/" . $sign);

    $fg = mysqli_query($con, "select * from tblauditee where uname='$uname'");
    $match = mysqli_num_rows($fg);
    if ($match >= 1) {
?>
        <script language="javascript">
            window.open('admin.php?id=addauditee&msg=1', '_self');
        </script>
        <?php
    } else if ($match <= 0) {

        $fg1 = mysqli_query($con, "select * from tblauditor where user='$uname'");
        $match1 = mysqli_num_rows($fg1);

        if ($match1 >= 1) {
        ?>
            <script language="javascript">
                window.open('admin.php?id=addauditee&msg=1', '_self');
            </script>
        <?php
        } else {
            $sql = mysqli_query($con, "INSERT INTO tblauditee (name, contact, email, dept, uname, pwd, img,tabs,sign) VALUES ( '$name', '$contact', '$email', '$deptt', '$uname', '$pwd', '$img','$tabs','$sign');");
        ?>
            <script language="javascript">
                window.open('admin.php?id=auditeemgmt', '_self');
            </script>
<?php
        }
    }
}
?>
<?php
$fg = mysqli_query($con, "select * from tblauditee where id='$_GET[sno]'");
$jk = mysqli_fetch_array($fg);

?>

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
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name" required="required" name="name" value="<?php echo $jk['name']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Contact</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="Contact" required="required" name="contact" value="<?php echo $jk['contact']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Email</label>
                            <input name="email" type="email" class="form-control" id="validationTooltip03" placeholder="Email" required="required" value="<?php echo $jk['email']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Username</label>
                            <input class="form-control" id="validationTooltip04" type="text" placeholder="Username" required="required" name="uname" value="<?php echo $jk['uname']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Password</label>
                            <input name="pwd" type="password" class="form-control" id="validationTooltip05" placeholder="Password" required="required" value="<?php echo $jk['pwd']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Department</label>
                            <select name="dept[]" class="form-control" required multiple="multiple">
                                <?php
                                $string = $jk['dept'];
                                $tags1 = explode(';', $string);
                                foreach ($tags1 as $key1) {
                                    if ($key1 != "") {
                                        $sql2 = mysqli_query($con, "select * from tbldept where id='$key1]'");
                                        $row2 = mysqli_fetch_array($sql2);
                                ?>

                                        <option value="<?php echo $row2['id']; ?>" selected="selected"><?php echo $row2['name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
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
                            <label for="validationTooltip05">Auditee Photo <a href="auditordoc/<?php echo $jk['img']; ?>" target="_blank"> <?php echo $jk['img']; ?> </a></label>
                            <input name="img" type="file" class="form-control" id="validationTooltip06" placeholder="City" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditee Signature<a href="auditordoc/<?php echo $jk['sign']; ?>" target="_blank"> <?php echo $jk['sign']; ?> </a></label>
                            <input name="sign" type="file" class="form-control" id="validationTooltip06" placeholder="City" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-12">
                            <label for="validationTooltip05">Tabs Access</label>
                            <input type="text" hidden name="tab_ids" value="<?php echo $jk['tabs']; ?>">
                            <?php
                            $query = mysqli_query($con, "select * from tbltabs");
                            $i = 1;
                            while ($roc = mysqli_fetch_array($query)) {
                            ?>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno'] ?>" id="flexCheckDefault-<?php echo $roc['sno'] ?>" name="tab_acess[]"
                                        <?php
                                        $tab_ids = explode(';', $jk['tabs']); // assuming tab_id is a comma-separated string
                                        if (in_array($roc['sno'], $tab_ids)) {
                                            echo 'checked';
                                        }
                                        ?>>
                                    <label class="form-check-label" for="flexCheckDefault-<?php echo $roc['sno'] ?>">
                                        <?php echo $roc['name'] ?> <?php echo $roc['name1'] ?>
                                    </label>
                                </div>
                            <?php
                                $i++;
                            }
                            ?>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                    </div>

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

    $img = $_FILES['img']['name'];
    $gh = move_uploaded_file($_FILES['img']['tmp_name'], "auditordoc/" . $img);

    $sign = "Sign_" . $_FILES['sign']['name'];
    $gh1 = move_uploaded_file($_FILES['sign']['tmp_name'], "auditordoc/" . $sign);

    if (!empty($_POST['tab_acess'])) {
        $tabs = $_POST['tab_acess'];
        $tabs = implode(';', $tabs) . ";";
    } else {
        $tabs = $_POST['tab_ids'];
    }


    $fg = mysqli_query($con, "select * from tblauditee where uname='$uname' and id!='$_GET[sno]'");
    $match = mysqli_num_rows($fg);
    if ($match >= 1) {
?>
        <script language="javascript">
            window.open('admin.php?id=addauditee&msg=1&sno=<?php echo $_GET['sno']; ?>', '_self');
        </script>
        <?php
    } else if ($match <= 0) {

        $fg1 = mysqli_query($con, "select * from tblauditor where user='$uname'");
        $match1 = mysqli_num_rows($fg1);

        if ($match1 >= 1) {
        ?>
            <script language="javascript">
                window.open('admin.php?id=addauditee&msg=1&sno=<?php echo $_GET['sno']; ?>', '_self');
            </script>
        <?php
        } else {
            if ($img == "") {
                $sql = mysqli_query($con, "update tblauditee  set name='$name', contact='$contact', email='$email', dept='$deptt', uname='$uname', pwd='$pwd',tabs='$tabs' where id='$_GET[sno]'");
            } elseif ($sign == "") {
                $sql = mysqli_query($con, "update tblauditee  set name='$name', contact='$contact', email='$email', dept='$deptt', uname='$uname', pwd='$pwd',tabs='$tabs' where id='$_GET[sno]'");
            } else {
                $sql = mysqli_query($con, "update tblauditee  set name='$name', contact='$contact', email='$email', dept='$deptt', uname='$uname', pwd='$pwd', img='$img',sign ='$sign',tabs='$tabs'  where id='$_GET[sno]'");
            }
        ?>
            <script language="javascript">
                window.open('admin.php?id=auditeemgmt', '_self');
            </script>
<?php
        }
    }
}
?>
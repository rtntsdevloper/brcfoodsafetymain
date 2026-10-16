<?php
$sno = $_GET['sno'];
$sql = mysqli_query($con, "select * from tblauditor where id='$sno'");
$row = mysqli_fetch_array($sql);
$tid = $row['tid'];
$sid = $row['sid'];
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Auditor Management</a></li>
            <li>Add Auditor</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=auditor"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Auditor</div>
                <h3>General Information</h3>
                <?php
                if (isset($_GET['msg'])) {
                ?>
                    <div class="card-title" style="color:#FF0000">Already exist</div>
                <?php
                }
                ?>
                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                    <input type="hidden" name="sno" value="<?php echo $sno; ?>" />

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name" required="required" name="name" value="<?php echo $row['name']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Contact</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder="Contact" required="required" name="contact" value="<?php echo $row['contact']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Email</label>
                            <input name="email" type="email" class="form-control" id="validationTooltip03" placeholder="Email" required="required" value="<?php echo $row['email']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Username</label>
                            <input class="form-control" id="validationTooltip04" type="text" placeholder="Username" required="required" name="uname" value="<?php echo $row['user']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Password</label>
                            <input name="pwd" type="text" class="form-control" id="validationTooltip05" placeholder="Password" required="required" value="<?php echo $row['pwd']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Department</label>
                            <select name="dept[]" class="form-control" required multiple="multiple">
                                <?php
                                $string = $row['dept'];
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

                                $sql1 = mysqli_query($con, "select * from tbldept");

                                while ($row1 = mysqli_fetch_array($sql1)) {
                                ?>
                                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditor Photo: <a href="auditordoc/<?php echo $row['userimg']; ?>" target="_blank" style="color:#3333FF"><?php echo $row['userimg']; ?></a></label>
                            <input name="img" type="file" class="form-control" id="validationTooltip06" placeholder="City" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditor Signature  <a href="signature/<?php echo $row['sign']; ?>" target="_blank" style="color:#3333FF"><?php echo $row['sign']; ?></a></label>
                            <input name="sign" type="file" class="form-control" id="validationTooltip06" placeholder="City" required="required" accept="image/*,.jpg,.gif,.png,.jpeg" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Auditor Certificate <a href="auditordoc/<?php echo $row['cert']; ?>" target="_blank" style="color:#3333FF"><?php echo $row['cert']; ?></a></label>
                            <input name="img2" type="file" class="form-control" id="validationTooltip06" placeholder="City" accept="application/pdf" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05"> Certificate Expired on</label>
                            <input name="date" type="date" class="form-control" id="validationTooltip06" value="<?php echo $row['expiredon']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Document if any? <a href="auditordoc/<?php echo $row['userimg']; ?>" target="_blank" style="color:#3333FF"><?php echo $row['img']; ?></a> </label>
                            <input name="img1" type="file" class="form-control" id="validationTooltip07" placeholder="Contact" accept="application/pdf" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <script>
                            function myFunction(str) {
                                var x = document.getElementById("myDIV" + str);
                                if (x.style.display === "none") {
                                    x.style.display = "block";
                                } else {
                                    x.style.display = "block";
                                }
                            }
                        </script>


                        <div class="col-12">
                            <label for="validationTooltip05">Tabs Access</label>
                            <input type="text" hidden name="tab_ids" value="<?php echo $row['tabs']; ?>">
                            <?php
                            $query = mysqli_query($con, "select * from tbltabs");
                            $i = 1;
                            while ($roc = mysqli_fetch_array($query)) {
                            ?>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno'] ?>" id="flexCheckDefault-<?php echo $roc['sno'] ?>" name="tab_acess[]"
                                        <?php
                                        $tab_ids = explode(';', $row['tabs']); // assuming tab_id is a comma-separated string
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


                        <div class="form-row">
                            <h3>Other Information</h3>
                            <?php
                            ?>
                            <input type="text" hidden value="<?php echo $row['tid']; ?>" name="other_info">

                            <input type="text" hidden value="<?php echo $row['sid']; ?>" name="sid1[]">


                            <?php

                            // $xyz = [];
                            $ide = explode(';', $row['tid']);
                            $xyz = explode(';', $sid);

                            $xyz_str = implode("','", $xyz);

                            $sql = "SELECT id FROM subtest WHERE sid IN ('$xyz_str')";
                            $result = mysqli_query($con, $sql);


                            while ($tt = mysqli_fetch_array($result)) {
                                //    $master= $tt['id'];
                            ?>
                                <input type="text" hidden value="<?php echo $tt['id']; ?>">
                            <?php
                            }


                            $sq = mysqli_query($con, "select * from addtest1");

                            while ($row = mysqli_fetch_array($sq)) {
                            ?>

                                <div class="col-md-12 mb-12">
                                    <label for="validationTooltip05">
                                        <input type="checkbox" onclick="myFunction(<?php echo $row['testid']; ?>)"
                                            name="tid[]" value="<?php echo $row['testid']; ?>"
                                            <?php if (in_array($row['testid'], $ide)) echo 'checked'; ?> />
                                        <?php echo $row['testid']; ?>. <?php echo $row['subject']; ?>
                                    </label>
                                </div>


                                <div class="col-md-12 mb-12" id="myDIV<?php echo $row['testid']; ?>"
                                    style="display:none; margin-left:20px">
                                    <?php
                                    $sq1 = mysqli_query($con, "select distinct sid from subtest where tid='$row[testid]'");
                                    $checked = false;
                                    while ($row1 = mysqli_fetch_array($sq1)) {

                                        $gh1 = mysqli_query($con, "select * from subtest where sid='$row1[sid]'");
                                        $rows1 = mysqli_fetch_array($gh1);

                                        if (in_array($row1['sid'], $xyz)) {
                                            $checked = true;
                                        }
                                    ?>
                                        <br />

                                        <label for="validationTooltip05" style="color:#0033FF">
                                            <input type="checkbox" name="sid[]"
                                                value="<?php

                                                        echo $rows1['sid']; ?>"
                                                <?php
                                                $xyz = explode(';', $sid);

                                                $xyz_str = implode("','", $xyz);

                                                $sql = "SELECT id FROM subtest WHERE sid IN ('$xyz_str')";
                                                $result = mysqli_query($con, $sql);

                                                $ids = array();
                                                while ($tt = mysqli_fetch_array($result)) {
                                                    $ids[] = $tt['id'];
                                                }

                                                if (in_array($rows1['id'], $ids)) echo 'checked';
                                                else {
                                                    echo 'unchecked';
                                                }
                                                ?>>





                                            <?php
                                            $val = $row1['sid'];
                                            //   echo   count($val);

                                            // output the original value
                                            echo    $val;
                                            ?>.
                                            <?php echo $rows1['subtest']; ?>
                                        </label>

                                    <?php
                                    }

                                    if ($checked) {
                                    ?>
                                        <script>
                                            document.getElementById("myDIV<?php echo $row['testid']; ?>").style.display = "block";
                                        </script>
                                    <?php
                                    }
                                    ?>

                                </div>


                            <?php    } ?>




                            <?php
                            // }
                            ?>

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
    $sno = $_POST['sno'];

    $qu = mysqli_query($con, "select * from tblauditor where id='$sno'");
    $qu1 = mysqli_fetch_array($qu);

    $user = $_SESSION['user'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $expiredon = $_POST['expiredon'];
    $rt = "";
    $rt1 = "";
    $deptt = "";


    if ($_FILES['img']['name'] == "") {
        $img = $qu1['userimg'];
    } else {
        $img = $_FILES['img']['name'];
        $gh = move_uploaded_file($_FILES['img']['tmp_name'], "auditordoc/" . $img);
    }

    if ($_FILES['img1']['name'] == "") {
        $img1 = $qu1['img'];
    } else {
        $img1 = $_FILES['img1']['name'];
        $gh1 = move_uploaded_file($_FILES['img1']['tmp_name'], "auditordoc/" . $img1);
    }

    if ($_FILES['img2']['name'] == "") {
        $img2 = $qu1['cert'];
    } else {
        $img2 = $_FILES['img2']['name'];
        $gh2 = move_uploaded_file($_FILES['img2']['tmp_name'], "auditordoc/" . $img2);
    }

    if ($_FILES['sign']['name'] == "") {
        $img2 = $qu1['sign'];
    } else {

        $sign = "Sign_" . $_FILES['sign']['name'];
        $gh4 = move_uploaded_file($_FILES['sign']['tmp_name'], "signature/" . $sign);
    }



    foreach ($_POST['dept'] as $selected) {
        $deptt .= $selected . ";";
    }


    $img2;

    if (!empty($_POST['tab_acess'])) {
        $tabs = $_POST['tab_acess'];
        $tabs = implode(';', $tabs) . ";";
    } else {
        $tabs = $_POST['tab_ids'];
    }
    $tid = count($_POST['tid']);
    $sid = count($_POST['sid']);
    $dept = count($_POST['dept']);

    for ($h = 0; $h < $tid; $h++) {
        $sourcePath = $_POST['tid'][$h];
        $rt .= $sourcePath . ";";
    }

    if ($_POST['sid']) {

        for ($j = 0; $j < $sid; $j++) {
            $sourcePath1 = $_POST['sid'][$j];
            $rt1 .= $sourcePath1 . ";";
        }
    } else {
        $rt1 = $row['sid1'];
        $rt1 = explode($rt, ';');
    }

    $fg = mysqli_query($con, "select * from tblauditor where user='$uname' and id!='$sno'");
    $match = mysqli_num_rows($fg);
    if ($match >= 1) {
?>
        <script language="javascript">
            window.open('admin.php?id=addauditor&msg=1&sno=<?php echo $sno; ?>', '_self');
        </script>
        <?php
    } else if ($match <= 0) {

        $fg1 = mysqli_query($con, "select * from tblauditee where uname='$uname'");
        $match1 = mysqli_num_rows($fg1);

        if ($match1 >= 1) {
        ?>
            <script language="javascript">
                window.open('admin.php?id=addauditor&msg=1&sno=<?php echo $sno; ?>', '_self');
            </script>
        <?php
        } else {
            $sql = mysqli_query($con, "update  tblauditor set name='$name', contact='$contact', email='$email', img='$img1', userimg='$img', user='$uname', pwd='$pwd',addby='$user',dept='$deptt',cert='$img2' , expiredon='$expiredon',tabs='$tabs',tid='$rt', sid='$rt1',signature ='$sign' where id='$sno'");
        ?>
            <script language="javascript">
                window.open('admin.php?id=auditor', '_self');
            </script>

<?php
        }
    }
}
?>
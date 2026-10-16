<?php
$sno = $_GET['sno'];

$sql23 = mysqli_query($con, "select * from tbldetail where id='$sno' ");
$row23 = mysqli_fetch_array($sql23);

$hj = mysqli_query($con, "select * from subtest where sid='$row23[sid]'");
$hj1 = mysqli_fetch_array($hj);


$hj2 = mysqli_query($con, "select * from addtest1 where testid='$row23[tid]'");
$hj3 = mysqli_fetch_array($hj2);

?>
<script language="javascript">
    function cal() {
        if (document.form1.tab1.checked == false && document.form1.tab2.checked == false && document.form1.tab3.checked == false && document.form1.tab4.checked == false) {
            document.getElementById("error4").style.color = "red";

            document.getElementById('error4').innerHTML = "Please select tab access";
            return false;
        } else if (document.form1.position.value == "") {
            document.getElementById("error3").style.color = "red";

            document.getElementById('error3').innerHTML = "Please enter position";
            document.form1.position.focus();
            return false;
        } else {
            return true;
        }
    }
</script>


<script>
    function showHint(str) {
        if (str.length == 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
            xmlhttp.open("GET", "tblgetclause.php?q=" + str);
            xmlhttp.send();
        }
    }
</script>


<script>
    function showHint1(str, str1) {
        if (str.length == 0) {
            document.getElementById("txtHint1").innerHTML = "";
            return;
        } else {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                document.getElementById("txtHint1").innerHTML = this.responseText;
            }
            xmlhttp.open("GET", "tblgetclause1.php?q=" + str + "&tid=" + str1);
            xmlhttp.send();
        }
    }
</script>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Documents Upload</a></li>
            <li>Add Documents</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=additionalmgmt">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>



                <?php
                if (isset($_GET['msg'])) {
                ?>
                    <div class="card-title" style="color:#FF0000">Already exist</div>
                <?php
                }
                ?>
                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data" id="uuploadForm3<?php echo $i; ?>" name="">



                    <div class="form-row" id="refresh">
                        <div id="uuploadStatus3<?php echo $i; ?>"></div>

                        <div class="col-md-12 mb-12">
                            <label for="validationTooltip01"> Type</label>
                            <select class="form-control" id="validationTooltip01" type="text" required="required" name="typee">
                                <option value="<?php echo $row23['typee']; ?>"><?php echo $row23['typee']; ?></option>

                                <?php
                                $sq = mysqli_query($con, "select * from tblcat");
                                while ($row = mysqli_fetch_array($sq)) {
                                ?>
                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name1']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Section</label>
                            <select name="p1" class="form-control" required onchange="showHint(this.value)">
                                <option value="<?php echo $hj3['testid']; ?>"><?php echo $hj3['subject']; ?></option>
                                <?php
                                $xy = mysqli_query($con, "select * from addtest1");
                                while ($xy1 = mysqli_fetch_array($xy)) {
                                ?>
                                    <option value="<?php echo $xy1['testid']; ?>"><?php echo $xy1['subject']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>




                        <div class="col-md-4 mb-3" id="txtHint">
                            <label for="validationTooltip03"> Select Sub-Section</label>
                            <select class="form-control" required name="p2">
                                <?php

                                $gh = mysqli_query($con, "select * from subtest where tid='$row23[tid]'");
                                while ($rows = mysqli_fetch_array($gh)) {
                                ?>
                                    <option value="<?php echo $rows['sid']; ?>"><?php echo $rows['sid']; ?>.<?php echo $rows['subtest']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid password.
                            </div>

                        </div>



                        <div class="col-md-4 mb-3" id="txtHint1">
                            <label for="validationTooltip03"> Select Clause</label>
                            <select class="form-control" required name="p3[]" multiple="multiple">
                                <?php

                                $gh = mysqli_query($con, "select * from subtest1 where tid='$row23[tid]' and sid='$row23[sid]'");
                                while ($rows = mysqli_fetch_array($gh)) {



                                    if ($rows['ssid'] != "") {

                                        $fid = $rows['ssid'];
                                    } else {

                                        $fid = $rows['fid'];
                                    }



                                ?>
                                    <option value="<?php echo $fid; ?>"><?php echo $rows['fid']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid password.
                            </div>

                        </div>


                        <div class="col-md-4 mb-4">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="name" placeholder="Title" value="<?php echo $row23['section']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Version</label>
                            <input name="version" type="text" class="form-control" value="<?php echo $row23['ver']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Issue Date</label>
                            <input name="date" type="date" class="form-control" value="<?php echo $row23['issuedate']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Recertification Date</label>
                            <input name="date1" type="date" class="form-control" value="<?php echo $row23['recertification']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip04">Authorised By</label>
                            <input name="authorised" type="text" class="form-control" value="<?php echo $row23['authrisedby']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-12 mb-12">
                            <label for="validationTooltip01">Detail</label>
                            <textarea class="form-control" id="validationTooltip01" required="required" name="detail" value="<?php echo $row23['detail']; ?>" placeholder="Enter the correct name of document"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-12 mb-12">
                            <label for="validationTooltip01">Reason for change</label>
                            <textarea class="form-control" id="validationTooltip01" name="reason" placeholder="Reason for document change"><?php echo $row23['reason']; ?></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-12">
                            <label for="validationTooltip01">Link if any</label>
                            <input class="form-control" id="validationTooltip01" type="text" name="linkk" placeholder="Web Link if any?" value="<?php echo $row23['linkk']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-12">
                            <label for="validationTooltip01">Category</label>
                            <select name="category" class="form-control">
                                <?php if (!empty($row23['category'])) {
                                ?>
                                    <option value="<?php echo $row23['category']; ?>"><?php echo $row23['category']; ?></option>

                                <?php

                                } else {
                                ?>
                                    <option value="">Select document uploaded</option>
                                <?php
                                } ?>

                                <option value="Multiple">Multiple</option>
                                <option value="Single">Single</option>

                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <input type="hidden" name="imgg" value="<?php echo $row23['img']; ?>" />
                        <div class="col-md-12 mb-12">
                            <label for="validationTooltip01">Upload Document: <a href="document/<?php echo $row23['img']; ?>" target="_blank">
                                    <?php echo $row23['img']; ?></a></label>
                            <input class="form-control" id="validationTooltip01" type="file" name="document" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" type="submit" id="submitt" name="submitt"> Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submitt'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $linkk = $_POST['linkk'];
    $imgg = $_POST['imgg'];
    if ($document == "") {
        $document = $imgg;
    } else {
        $document = $_FILES['document']['name'];

        move_uploaded_file($_FILES['document']['tmp_name'], "document/" . $document);
    }

    //$snoo=$_POST['snoo'];

    $typee = $_POST['typee'];

    $date = $_POST['date'];
    $authorised = $_POST['authorised'];
    $version = $_POST['version'];
    $date1 = $_POST['date1'];

    $reason = mysqli_real_escape_string($con, $_POST['reason']);


    $user = $_SESSION['user'];
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $p3 = "";

    foreach ($_POST['p3'] as $selected) {
        $p3 .= $selected . ";";


        $sql = mysqli_query($con, "update tbldetail set tid='$p1', sid='$p2', fid='$selected', section='$name', detail='$detail', img='$document', user='$user', date='$date', typee='$typee', linkk='$linkk',issuedate='$date',ver='$version',authrisedby='$authorised',recertification='$date1',reason='$reason' where id='$_GET[sno]'");
    }

?>
    <script language="">
        window.open('admin.php?id=additionalmgmt', '_self');
    </script>
<?php
}
?>
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
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Procedure Upload</a></li>
            <li>Add Procedure</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=procedure">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>


                <?php
                if (isset($_GET['msg'])) {
                ?>
                    <div class="card-title" style="color:#FF0000">Already exist</div>
                <?php
                }
                ?>
                <form class="form-horizontal" method="post" action="" name="form1" onsubmit="return cal();" enctype="multipart/form-data">
                    <?php
                    $sno = $_GET['sno'];
                    $sql = mysqli_query($con, "select * from tblprocedure where id='$sno'");
                    $row = mysqli_fetch_array($sql);


                    $xyy = mysqli_query($con, "select * from tblmodule1 where id='$row[module]'");
                    $xyy1 = mysqli_fetch_array($xyy);


                    $xyr1 = mysqli_query($con, "select * from tbldept1 where id='$row[dept]'");
                    $xyr11 = mysqli_fetch_array($xyr1);
                    ?>


                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Select Module</label>

                            <select name="module" class="form-control" required>
                                <option value="<?php echo $xyy1['id']; ?>"><?php echo $xyy1['name']; ?></option>

                                <?php

                                $xy = mysqli_query($con, "select * from tblmodule1");
                                while ($xy1 = mysqli_fetch_array($xy)) {
                                ?>
                                    <option value="<?php echo $xy1['id']; ?>"><?php echo $xy1['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please select module

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Select Department</label>

                            <select name="dept" class="form-control" required>
                                <option value="<?php echo $xyr11['id']; ?>"><?php echo $xyr11['dept']; ?></option>

                                <?php

                                $xyr = mysqli_query($con, "select * from tbldept1");
                                while ($xyr1 = mysqli_fetch_array($xyr)) {
                                ?>
                                    <option value="<?php echo $xyr1['id']; ?>"><?php echo $xyr1['dept']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Procedure Name</label>
                            <input name="name" type="text" class="form-control" required value="<?php echo $row['name']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Version</label>
                            <input name="version" type="text" class="form-control" required value="<?php echo $row['version']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Issue Date</label>
                            <input name="date" type="date" class="form-control" required value="<?php echo $row['date']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Document</label> <a href="procedure/<?php echo $row['img']; ?>" target="_blank" style="color:#0000CC"><?php echo $row['img']; ?></a>
                            <input name="file" type="file" class="form-control" required accept="application/pdf" />
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Is this procedure related to CCP?</label>
                            <select name="pccp" id="" class="form-control">

                                <option disabled selected> -- Please Select -- </option>
                                <option value="Yes" <?php echo ($row['ccp'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo ($row['ccp'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

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
    $sno = $_GET['sno'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $version = $_POST['version'];
    $module = $_POST['module'];
    $dept = $_POST['dept'];
    $file = $_FILES['file']['name'];
    $pccp = $_POST['pccp'];

    move_uploaded_file($_FILES['file']['tmp_name'], 'procedures/' . $file);

    if ($file == "") {
        $query = mysqli_query($con, "update tblprocedure set name='$name',date='$date',module='$module',version='$version',dept='$dept',ccp='$pccp' where id='$sno'");
    } else {
        $query = mysqli_query($con, "update tblprocedure set name='$name',date='$date',module='$module',version='$version',dept='$dept',img='$file',ccp='$pccp' where id='$sno'");
    }

?>
    <script language="">
        window.open('admin.php?id=procedure', '_self');
    </script>
<?php
}
?>
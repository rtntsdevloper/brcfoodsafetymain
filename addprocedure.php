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



                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Select Module</label>

                            <select name="module" class="form-control" required>
                                <option value="">Please Select</option>

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
                                <option value="">Please Select</option>

                                <?php

                                $xy = mysqli_query($con, "select * from tbldept1");
                                while ($xy1 = mysqli_fetch_array($xy)) {
                                ?>
                                    <option value="<?php echo $xy1['id']; ?>"><?php echo $xy1['dept']; ?></option>
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
                            <input name="name" type="text" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Version</label>
                            <input name="version" type="text" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Issue Date</label>
                            <input name="date" type="date" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Recertification Date</label>
                            <input name="date1" type="date" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Authorised By</label>
                            <input name="authorised" type="text" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>




                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Document</label>
                            <input name="file" type="file" class="form-control" required accept="application/pdf" />
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Is this procedure related to CCP?</label>
                            <select name="pccp" id="" class="form-control">

                                <option disabled selected> -- Please Select -- </option>
                                <option value="Yes" >Yes</option>
                                <option value="No">No</option>
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
    $name = $_POST['name'];
    $date = $_POST['date'];
    $version = $_POST['version'];
    $module = $_POST['module'];
    $dept = $_POST['dept'];
    $file = $_FILES['file']['name'];

    move_uploaded_file($_FILES['file']['tmp_name'], 'procedures/' . $file);

    $query = mysqli_query($con, "insert into tblprocedure(name,date,module,version,img,dept)values('$name','$date','$module','$version','$file','$dept')");
?>
    <script language="">
        window.open('admin.php?id=procedure', '_self');
    </script>
<?php
}
?>
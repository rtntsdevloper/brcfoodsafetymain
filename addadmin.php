<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Admin Management</a></li>
            <li>Add Admin</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=adminmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Admin</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="name" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Username</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Username" required="required" name="uname" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Password</label>
                            <input name="pwd" type="text" class="form-control" id="validationTooltip03" placeholder="Password" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Access</label>
                            <select name="access" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="Admin">Admin</option>
                                <option value="superadmin">Sub Auditor</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid last name.

                            </div>
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
    $name = $_POST['name'];
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $access = $_POST['access'];


    if (!empty($_POST['tab_acess'])) {
        $tabs = $_POST['tab_acess'];
        $tabs = implode(';', $tabs) . ";";
    } else {
        $tabs = $_POST['tab_ids'];
    }


    $fg = mysqli_query($con, "select * from tbladmin where username='$uname'");
    $match = mysqli_num_rows($fg);
    if ($match >= 1) {
?>
        <script language="javascript">
            alert("Already Exist!");
            window.open('admin.php?id=addadmin', '_self');
        </script>
    <?php
    } else {
        $sql = mysqli_query($con, "INSERT INTO tbladmin (name, username, pwd, status,tabs) VALUES ('$name', '$uname', '$pwd', '$access','$tabs')");
    ?>
        <script language="javascript">
            window.open('admin.php?id=adminmgmt', '_self');
        </script>
<?php
    }
}
?>
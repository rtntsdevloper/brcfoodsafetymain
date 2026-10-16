<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Assign Auditor</a></li>
            <li>Add Detail</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=auditorassign"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Add Detail</div>

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
                                        xmlhttp.open("GET", "getclause.php?q=" + str);
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
                                        xmlhttp.open("GET", "getclause1.php?q=" + str + "&auditor=" + str1);
                                        xmlhttp.send();
                                    }
                                }
                            </script>


                            <label for="validationTooltip01">Select Auditor</label>
                            <select name="s1" class="form-control" onchange="showHint(this.value)" required>
                                <option value="">Please Select</option>
                                <?php
                                $sql = mysqli_query($con, "select * from tblauditor");
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Auditee Name</label>
                            <select name="auditee" class="form-control" required>
                                <option value="">Please Select</option>
                                <?php
                                $sql = mysqli_query($con, "select * from tblauditee");
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
                            <label for="validationTooltip02">Select Date</label>
                            <input name="date" type="date" class="form-control" id="validationTooltip03" placeholder="Email" required="required" />
                            <div class="invalid-tooltip">
                                Please provide a valid username.

                            </div>
                        </div>
                    </div>

                    <div class="form-row" id="txtHint">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03"> Select Requirements</label>
                            <select class="form-control" disabled="disabled">
                                <option></option>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid password.
                            </div>
                        </div>

                    </div>

                    <div class="form-row" id="txtHint1">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03"> Select Sub-Section</label>
                            <select class="form-control" disabled="disabled">
                                <option></option>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid password.
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
    $user = $_SESSION['user'];
    $auditee = $_POST['auditee'];
    $s1 = $_POST['s1'];
    $s2 = $_POST['s3'];
    $date = $_POST['date'];

    $month = date('M', strtotime($date));

    $month1 = date('m', strtotime($date));


    $sh = mysqli_query($con, "select * from subtest where sid='$s2'");
    $hj = mysqli_fetch_array($sh);

    $tid = $_POST['s2'];


    foreach ($_POST['s3'] as $selected) {

        $sql = mysqli_query($con, "INSERT INTO tblroster ( tid,sid, auditor, auditee, date, mname,month, status, bgcolor, brcolor) VALUES ( '$tid','$selected', '$s1', '$auditee', '$date', '$month', '$month1',  'Due', '#2473AB', '36, 115, 171');");
    }

?>
    <script language="javascript">
        window.open('admin.php?id=auditorassign', '_self');
    </script>
<?php
}

?>
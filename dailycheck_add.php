<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <br>
            <ul>
                <li><a href="">Upload Checks</a></li>
                <li>Add Checks</li>
            </ul>

        </div>
        <div class="row mb-3">
            <div class="col-md-10"></div>
            <div class="col-md-2"><a href="admin.php?id=dailychecksview<?php
                                                                        if (isset($_GET['id2'])) {
                                                                            echo "&id2=" . $_GET['id2'];
                                                                        }
                                                                        ?>" class="btn btn-success text-right">Go Back</a></div>
        </div>

        <div class="container-fluid">
            <div class="row mb-3">



                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Section</div>


                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="name" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Sub-Section</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="sid">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh = mysqli_query($con, "select * from dailychecks");
                                            while ($row = mysqli_fetch_array($gh)) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01">Section Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>


                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit2">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="col-md-12 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Question</div>
                            <div class="form-row">
                                <div class="col-6">
                                    <!-- Section Selection Form -->
                                    <form method="post" enctype="multipart/form-data">
                                        <!-- Hidden parameter to set the page ID -->
                                        <input type="hidden" name="id" value="dailychecksadd">

                                        <label for="sectionid">Section</label>
                                        <select class="form-control" id="sectionid" name="tid" required onchange="sectiong(this.value)">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh1 = mysqli_query($con, "SELECT * FROM dailychecks");
                                            while ($row1 = mysqli_fetch_array($gh1)) {
                                                $selected = (isset($_GET['tid']) && $_GET['tid'] == $row1['id']) ? 'selected' : '';
                                                echo '<option value="' . $row1['id'] . '" ' . $selected . '>' . $row1['name'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                </div>
                                <script>
                                    function sectiong(val) {
                                        document.location.href = 'admin?id=dailychecksadd&tid=' + val;
                                    }
                                </script>
                                <div class="col-6">

                                    <!-- Optional: Display Sub-Section Dropdown Based on Selected Section -->
                                    <?php
                                    if (isset($_GET['tid']) && $_GET['tid'] !== '') {
                                        $sectionId = $_GET['tid'];
                                        echo '<label for="validsub">Sub-Section</label>';
                                        echo '<select class="form-control" id="validsub" name="ssid" required onchange="document.getElementById(\'subid\').value = this.options[this.selectedIndex].getAttribute(\'data-id\')">';
                                        echo '<option value="">Please Select</option>';

                                        $gh2 = mysqli_query($con, "SELECT * FROM dailychecks1 WHERE tid = '$sectionId'");
                                        while ($row2 = mysqli_fetch_array($gh2)) {
                                            echo '<option value="' . $row2['section'] . '" data-id="' . $row2['id'] . '">' . $row2['section'] . '</option>';
                                        }

                                        echo '</select>';
                                        echo '<input type="hidden" id="subid" name="subid">';
                                        echo '<div class="invalid-tooltip">Please provide a valid name.</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <label for="validationTooltip01">Question</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Question" required="required" name="ques" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid Question.
                                    </div>
                                </div>



                                <div class="col-12">
                                    <label for="validationTooltip01">Correct Answer</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Correct Answer" required="required" name="answer" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="validationTooltip01">Question Image (If Needed)</label>
                                    <input type="file" class="form-control" name="image">
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Select (Yes/No)</label>
                                    <select name="yesno" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Input Box</label>
                                    <select name="inputbox" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Attach File field</label>
                                    <select name="file" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Comment Box</label>
                                    <select name="comment" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>




                                <!-- <div class="col-6">
                                        <label for="validationTooltip01">Answer Status</label>
                                        <select name="answer_status" id="" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="">No</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid Option.
                                        </div>
                                    </div> -->

                                <div class="col-6">
                                    <label for="validationTooltip01"> If needed Date Input</label>
                                    <select name="dateinput" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>


                                <div class="col-6">
                                    <label for="validationTooltip01">If needed to Required a question.</label>
                                    <select name="required" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>


                            </div>
                        </div>
                        <br />

                        <button class="btn btn-primary " type="submit" name="submit3">Submit </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>





<?php
if (isset($_POST['submit1'])) {
    $sid = $_POST['sid'];
    $sname = mysqli_real_escape_string($con, $_POST['name']);
    $sql1 = mysqli_query($con, "insert into dailychecks (name)values('$sname')");
?>
    <script language="javascript">
        window.open('admin.php?id=dailychecksadd', '_self');
    </script>
<?php
}
?>

<?php
if (isset($_POST['submit2'])) {
    $sid = $_POST['sid'];
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $sql1 = mysqli_query($con, "insert into dailychecksub(tid,name)values('$sid','$sname')");
?>
    <script language="javascript">
        window.open('admin.php?id=dailychecksadd', '_self');
    </script>
<?php
}
?>

<?php
if (isset($_POST['submit3'])) {
    $sidd = $_POST['tid'];
    $ssid = $_POST['ssid'];
    $ques = mysqli_real_escape_string($con, $_POST['ques']);
    $comment = $_POST['comment'];
    $inputbox = $_POST['inputbox'];
    $yesno = $_POST['yesno'];
    $required = $_POST['required'];
    $file = $_POST['file'];
    $answer = $_POST['answer'];
    $date = $_POST['dateinput'];
    // $status = $_POST['answer_status'];

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image = $targetFilePath;
        } else {
            echo "<script>alert('Image upload failed.');</script>";
        }
    }

    if (isset($_GET['id2'])) {
        $subj = $_POST['subid'];

        die;
        $sql2 = mysqli_query($con, "INSERT INTO `dailychecks1`(`tid`, `ques`, `section`, sid) VALUES ('$sidd','$ques','$ssid','$sid')");
    } else {
        $sql2 = mysqli_query($con, "INSERT INTO `dailychecks1`(`tid`, `ques`, `section`, `comment`, `yesno`, `inputbox`, `required`, `answer`, `image`, `file`, `dateinput`) VALUES ('$sidd','$ques','$ssid', '$comment', '$yesno', '$inputbox', '$required', '$answer', '$image', '$file', '$date')");
    }
?>
    <script language="javascript">
        alert('Question added successfully!');
        window.open('admin.php?id=dailychecksadd', '_self');
    </script>
<?php
}
?>
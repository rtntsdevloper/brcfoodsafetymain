<?php
$sno = $_GET['sno'];



$sql1 = mysqli_query($con, "select * from dailychecks1 where id='$sno'");
$row1 = mysqli_fetch_array($sql1);

$tid = $row1['tid'];
$sql = mysqli_query($con, "select * from dailychecks where id='$tid'");
$row = mysqli_fetch_array($sql);




?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Upload checks</a></li>
            <li>Edit Checks</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Edit Question</div>

                    <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">

                            <div class="col-12">
                                <label for="validationTooltip01">Section</label>
                                <input class="form-control" id="validationTooltip01" type="text" name="name" value="<?php echo $row['name']; ?>" disabled="disabled" />
                                <div class="invalid-tooltip">
                                    Please provide a valid name.

                                </div>
                            </div>

                            <div class="col-12">
                                <label for="validationTooltip01">Sub-Section</label>
                                <input class="form-control" id="validationTooltip01" type="text" value="<?php echo $row1['section']; ?>" disabled="disabled" />
                                <div class="invalid-tooltip">
                                    Please provide a valid name.

                                </div>
                            </div>


                            <div class="col-12">
                                <label for="validationTooltip01">Question</label>
                                <textarea class="form-control" required="required" name="ques"><?php echo $row1['ques']; ?></textarea>
                                <div class="invalid-tooltip">
                                    Please provide a valid name.
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label for="validationTooltip01">Question Image (If need to change)</label>
                                <input class="form-control" type="file" required="required" name="image"><a href=""><?php echo $row1['image']; ?></a>
                                <div class="invalid-tooltip">
                                    Please provide a valid name.
                                </div>
                            </div> -->


                            <div class="form-row mt-4">

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Select (Yes/No)</label>
                                    <select name="yesno" id="" class="form-control">

                                        <?php
                                        if ($row1['yesno'] == 'yes') {
                                            echo ' <option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>


                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Input Box</label>
                                    <select name="inputbox" id="" class="form-control">
                                        <?php
                                        if ($row1['inputbox'] == 'yes') {
                                            echo ' <option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Attach File field</label>
                                    <select name="file" id="" class="form-control">
                                        <?php
                                        if ($row1['file'] == 'yes') {
                                            echo ' <option value="Yes">Yes</option>';
                                            echo '<option value="No">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="validationTooltip01">If needed Comment Box</label>
                                    <select name="comment" id="" class="form-control">
                                        <?php
                                        if ($row1['comment'] == 'yes') {
                                            echo ' <option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>


                                <!-- <div class="col-6">
                                        <label for="validationTooltip01">Answer Status</label>
                                        <select name="answer_status" id="" class="form-control">
                                            <?php
                                            if ($row1['answer_status'] == 'yes') {
                                                echo ' <option value="yes">Yes</option>';
                                                echo '<option value="No">No</option>';
                                            } else {
                                                echo '<option value="">Please Select</option>';
                                                echo '<option value="yes">Yes</option>';
                                                echo '<option value="">No</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid Option.
                                        </div>
                                    </div> -->

                                <div class="col-6">
                                    <label for="validationTooltip01"> If needed Date Input</label>
                                    <select name="dateinput" id="" class="form-control">
                                        <?php
                                        if ($row1['dateinput'] === 'yes') {
                                            echo ' <option value="yes">Yes</option>';
                                            echo '<option value="No">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid option.
                                    </div>
                                </div>


                                <div class="col-6">
                                    <label for="validationTooltip01">If needed to Required a question.</label>
                                    <select name="required" id="" class="form-control">
                                        <?php
                                        if ($row1['required'] == 'yes') {
                                            echo ' <option value="yes">Yes</option>';
                                            echo '<option value="No">No</option>';
                                        } else {
                                            echo '<option value="">Please Select</option>';
                                            echo '<option value="yes">Yes</option>';
                                            echo '<option value="">No</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please provide a valid Option.
                                    </div>
                                </div>

                            </div>


                        </div>



                        <br />

                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>
            </div>
        </div>






    </div>
</div>
</div>

</div>
</div>

<?php
if (isset($_POST['submit'])) {
    $ques = mysqli_real_escape_string($con, $_POST['ques']);
    $yes = $_POST['yesno'];
    $inputbox = $_POST['inputbox'];
    $yes = $_POST['yesno'];
    $file = $_POST['file'];
    $comment = $_POST['comment'];
    $date = $_POST['dateinput'];
    $req = $_POST['request'];

    $sql = mysqli_query($con, "UPDATE `dailychecks1` SET `ques`='$ques', `yesno` = '$yes', `inputbox` = '$inputbox', `file` = '$file', `comment` = '$comment' , `dateinput` = '$date', required = '$req' WHERE id = '$sno'");


?>
    <script language="javascript">
        window.open('admin.php?id=dailyviewques&sno=<?php echo $tid; ?><?php
                                                                        if (isset($_GET['id2'])) {
                                                                            echo "&id2=" . $_GET['id2'];
                                                                        }
                                                                        ?>', '_self');
    </script>
<?php
}
?>
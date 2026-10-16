<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>



    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=packing&id2=<?php echo $_GET['id2']; ?>"> <button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>
                    <h4 class="card-title mb-3">Packaging Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="date" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Product Batchcode</label>
                                <select class="form-control" name="product" required>
                                    <option>Please Select</option>
                                    <?php
                                    $sqli = mysqli_query($con, "select * from tblmarination where status='Done' and packing = ''  order by date DESC ");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['batchcode']; ?>"><?php echo $row['batchcode']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>



                            <div class="col-md-6">
                                <label for="validationTooltip02">Gas Percentage</label>
                                <input class="form-control" id="validationTooltip02" type="text" required="required" name="gas" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Top Film Batchcode</label>
                                <input class="form-control" id="validationTooltip02" type="text" required="required" name="packaging" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Bottom Film Batchcode</label>
                                <input class="form-control" id="validationTooltip02" type="text" required="required" name="botfilm" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>

                            <script language="javascript">
                                function cal(str) {
                                    if (document.getElementById("packing1").value == "Yes") {

                                        $('#img').attr("disabled", false);
                                        $('#img1').attr("disabled", false);
                                    } else if (document.getElementById("packing1").value == "No") {

                                        $('#img').attr("disabled", true);
                                        $('#img1').attr("disabled", true);
                                    }

                                }
                            </script>
                            <div class="col-md-6">
                                <label for="validationTooltip02">Is Correct packaging film used? (if yes upload photo)</label>
                                <select class="form-control" id="packing1" required="required" name="packing1" onchange="return cal(this.value)">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>

                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>




                            <div class="col-md-6">
                                <label for="validationTooltip02"> Front Photo </label>
                                <input class="form-control" id="img" type="file" name="img" disabled="disabled" required />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Packing Machines </label>
                                <select class="form-control" name="oven" required>
                                    <option>Please Select</option>
                                    <option value="Packing Machines 1">Packing Machines 1</option>
                                    <option value="Packing Machines 2">Packing Machines 2</option>
                                    <option value="Packing Machines 3">Packing Machines 3</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

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
<?php
if (isset($_POST['submit'])) {
    $rand = rand(10, 1000);
    $date = $_POST['date'];
    $product = $_POST['product'];
    $gas = $_POST['gas'];
    $packing = $_POST['packaging'];
    $labeling = $_POST['labeling'];
    $oven = $_POST['oven'];

    $botfilm = $_POST['botfilm'];

    $img = $_FILES['img']['name'];
    if ($img != "") {
        $img = $rand . $_FILES['img']['name'];
        $mg = move_uploaded_file($_FILES['img']['tmp_name'], $_GET['id2'] . "/img/" . $img);
    }

    imagejpeg($tn, $save, 75);

    $user = $_SESSION['user'];
    $sql = mysqli_query($con, "INSERT INTO tblpacking (datetime,productbatch,packfilm,gas,img,botfilm,user,tray) VALUES ('$date', '$product','$packing','$gas','$img','$botfilm','$user','$oven')");

    $sql1 = mysqli_query($con, "update tblmarination set packing='done' where batchcode='$product'");
?>
    <script language="javascript">
        window.open('admin.php?id=packing&id2=<?php echo $_GET['id2']; ?>', '_self');
    </script>
<?php
}
?>
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

                    <a href="admin.php?id=metal&id2=<?php echo $_GET['id2']; ?>"> <button class="btn btn-info"
                            style="float:right; margin-left:15px">Go Back</button></a>
                    <h4 class="card-title mb-3">Daily Metal Detection & Labelling Checks</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">

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
                                    $sqli = mysqli_query($con, "select * from tblmarination where status='Done'  and metal='' order by date DESC");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['batchcode']; ?>"><?php echo $row['batchcode']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>


                            <script>
                                function cal(str) {

                                    if (str == "") {
                                        document.getElementById("chkproduct1").innerHTML = "";
                                        return;
                                    }
                                    if (window.XMLHttpRequest) {
                                        xmlhttp = new XMLHttpRequest();
                                    } else {
                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    xmlhttp.onreadystatechange = function() {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                            document.getElementById("chkproduct1").innerHTML = xmlhttp.responseText;
                                        }
                                    }
                                    xmlhttp.open("GET", "<?php echo $_GET['id2']; ?>/metal2.php?q=" + str, true);
                                    xmlhttp.send();
                                }
                            </script>
                            <div class="col-md-6">
                                <label for="validationTooltip02">Test Type</label>
                                <select class="form-control" id="testtype" required="required" name="testtype"
                                    onchange="return cal(this.value)">
                                    <option value="">Please Select</option>
                                    <option value="Beginning">Beginning</option>
                                    <option value="Every Hour">Every Hour</option>
                                    <option value="End of Production">End of Production</option>
                                    <option value="Change of Shift">Change of Shift</option>
                                    <option value="Change of Product">Change of Product</option>

                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <script language="javascript">
                                function cal2(str) {
                                    if (document.getElementById("packing1").value == "No") {

                                        $('#img').attr("disabled", false);
                                        $('#img1').attr("disabled", false);
                                    } else if (document.getElementById("packing1").value == "Yes") {

                                        $('#img').attr("disabled", true);
                                        $('#img1').attr("disabled", true);
                                    }

                                }
                            </script>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Is correct packaging film being used?</label>
                                <select class="form-control" id="packing1" required="required" name="packing1"
                                    onchange="return cal2(this.value)">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>

                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>




                            <div class="col-md-6">
                                <label for="validationTooltip02">If No what correction needed ? </label>
                                <textarea class="form-control" id="img" name="img" disabled="disabled"
                                    required></textarea>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Gas Reading</label>
                                <input class="form-control" id="gas" name="gas" required>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>


                        </div>







                        <br />
                        <div class="form-row">
                            <label for="validationTooltip02">Questions</label>

                            <div class="col-md-12" id="chkproduct1">

                            </div>

                            <script>
                                function commentx(ans, id) {
                                    const commentr = document.getElementById("f1" + id);

                                    if (ans == "No") {

                                        commentr.setAttribute("required", "required");
                                        commentr.style.border = "2px solid red"; // optional visual cue
                                    } else {
                                        commentr.removeAttribute("required");
                                        commentr.style.border = ""; // reset style
                                    }
                                }
                            </script>

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
    $date = $_POST['date'];
    $product = $_POST['product'];
    $gas = $_POST['gas'];
    $testtype = $_POST['testtype'];

    $packing1 = $_POST['packing1'];

    $img = $_POST['img'];

    if ($img == "") {
        $img = "Not Applicable";
    }

    $user = $_SESSION['user'];
    $ansc = count($_POST['ans']);
    $cmntm = $_POST['cmntm'];

    $tp = "";
    for ($i = 0; $i < $ansc; $i++) {
        $tp .= mysqli_real_escape_string($con, $_POST["ans"][$i] . ";");
    }
    $cmntx = count($_POST['cmnt']);
    $tpp = "";
    for ($ii = 0; $ii < $cmntx; $ii++) {
        $tpp .= mysqli_real_escape_string($con, $_POST["cmnt"][$ii]) . ";";
    }

    // die;

    $sql = mysqli_query($con, "INSERT INTO tblmetal (datetime,productbatch,testtype,ans,cmnt,user,pack1,pack2,gas,cmnt1) VALUES ('$date', '$product','$testtype','$tp','$tpp','$user','$packing1','$img','$gas','$cmntm')");
    // print_r("SELECT * FROM tblmetal WHERE productbatch='$product' and testtype='End of Production'");die;

    $check_query = mysqli_query($con, "SELECT * FROM tblmetal WHERE productbatch='$product' and testtype IN ('End of Production', 'Change of Product')");
    $insert_count = mysqli_num_rows($check_query);
    if ($insert_count) {

        $sql1 = mysqli_query($con, "UPDATE tblmarination SET metal='done' WHERE batchcode='$product'");
    }


?>
    <script language="javascript">
        window.open('admin.php?id=metal&id2=<?php echo $_GET['id2']; ?>', '_self');
    </script>
<?php
}

?>
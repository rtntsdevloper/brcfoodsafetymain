<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#add-row").click(function() {

                var product = $("#product").val();
                var productname = $("#productname").val();
                var batchcode = $("#batchcode").val();
                var pack = $("#pack").val();
                var bpack = $("#bpack").val();
                var bb = $("#bb").val();
                var date = $("#date").val();



                //var bb = $("#bb").val();

                if (product == "") {
                    document.getElementById("error").innerHTML = "* Please select the product";
                    document.getElementById("product").focus();
                } else if (batchcode == "") {
                    document.getElementById("error").innerHTML = "* Please select batchcode";
                    document.getElementById("batchcode").focus();
                } else if (pack == "") {
                    document.getElementById("error").innerHTML = "* Please enter packs detail";
                    document.getElementById("pack").focus();
                } else if (bb == "") {
                    document.getElementById("error").innerHTML = "* Please select best before";
                    document.getElementById("bb").focus();
                } else if (date == "") {
                    document.getElementById("error").innerHTML = "* Please select date ";
                    document.getElementById("date").focus();
                } else {
                    var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='hidden' name='date[]' value='" + date + "'><input type='hidden' name='productname[]' value='" + productname + "'>" + productname + "</td><td><input type='hidden' name='batchcode[]' value='" + batchcode + "'>" + batchcode + "</td><td><input type='hidden' name='pack[]' value='" + pack + "'>" + pack + "</td><td><input type='hidden' name='totalbox[]' value='" + bpack + "'><input type='hidden' name='bb[]' value='" + bb + "'>" + bb + "</td></tr>";

                    $("table tbody").append(markup);

                    document.getElementById("batchcode").value = "";
                    document.getElementById("product").value = "";
                    document.getElementById("bb").value = "";
                    document.getElementById("pack").value = "";
                    document.getElementById("productname").value = "";

                }
            });

            // Find and remove selected table rows
            $("#delete-row").click(function() {
                $("table tbody").find('input[name="record"]').each(function() {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
            });
        });
    </script>


    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=boxingg&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>


                    <h4 class="card-title mb-3">Boxing Records</h4>


                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" type="datetime-local" required="required" name="date" id="date" />
                                <div class="invalid-tooltip">
                                    Please provide a valid first name.

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
                                    xmlhttp.open("GET", "<?php echo $_GET['id2']; ?>/boxing2.php?q=" + str, true);
                                    xmlhttp.send();
                                }
                            </script>


                            <div class="col-md-6">
                                <label for="validationTooltip02"> Select Product </label>
                                <select class="form-control" name="product" id="product" onchange="return cal(this.value)">
                                    <option value="">Please Select</option>
                                    <?php
                                    $sqli = mysqli_query($con, "select * from tblrecipe where status!='active'");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
 

                            <div class="col-md-6" id="chkproduct1">
                                <label for="validationTooltip02">Select Batchcode</label>
                                <select class="form-control" disabled="disabled">
                                    <option>Please Select</option>

                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Best Before</label>
                                <input class="form-control" type="date" name="bb" id="bb" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="validationTooltip02">Total Packs Per Box</label>
                                <input class="form-control" type="text" name="pack" id="pack" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationTooltip02">Total No. of Boxes</label>
                                <input class="form-control" type="text" name="pboxes" id="bpack" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>


                        </div>
                        <div class="form-row" id="error"></div>
                        <br />

                        <button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add </button>
                        <br /><br />
                        <div class="form-row">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Batch Code</th>
                                        <th>Packs</th>
                                        <th>Best Before</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br /><br />

                        <script language="javascript">
                            function cnt() {

                                var dt = $("table tr").length;
                                if (dt < 3) {
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        </script>
                        <button type="button" id="delete-row" class="btn btn-danger">Delete Row</button>

                        <button type="submit" class="btn btn-success" style="float:right;" id="sub" name="submit" onclick="return cnt();">Save & Generate Batchcode</button>

                </div>
            </div>
        </div>


    </div>
    </form>
</div>


</div>
</div>
</div>
</div>
<?php
if (isset($_POST['submit'])) {
    $cdate = $_POST['date'][0];
    $cdate = date('Y-m-d', strtotime($cdate));
    $vb = mysqli_query($con, "select * from tblboxing where cdate='$cdate' ");
    $lastrow = mysqli_num_rows($vb);

    $num = $lastrow + 1;
    $grn = date('dmy') . "00" . $num;



    $productc = count($_POST["productname"]);
    for ($i2 = 0; $i2 < $productc; $i2++) {

        $date = $_POST['date'][$i2];
        $product = $_POST['product'][$i2];
        $bb = $_POST['bb'][$i2];
        $pack = $_POST['pack'][$i2];
        $totalbox = $_POST['totalbox'][$i2];
        $batchcode = $_POST['batchcode'][$i2];

        $sno = $_GET['sno'];

        $user = $_SESSION['user'];

        $sql = mysqli_query($con, "INSERT INTO tblboxing (cdate,datetime,productbatch,bestbefore,img,user,sno,boxbatchcode,totalbox) VALUES ('$cdate','$date', '$batchcode','$bb','$pack','$user','$sno','$grn','$totalbox')");

        $sql1 = mysqli_query($con, "update tblmarination set boxing='done' where batchcode='$batchcode'");
    }
?>
    <script language="javascript">
        window.open('admin.php?id=boxing&id2=<?php echo $_GET['id2']; ?>', '_self');
    </script>
<?php
}
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <?php
    $allBatches = array();
    $q = mysqli_query($con, "SELECT batchcode, product, useby FROM frozenproduction 
                             WHERE boxing='' OR boxing IS NULL
                             ORDER BY date DESC");
    while ($r = mysqli_fetch_array($q)) {
        $allBatches[] = $r;
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            var batchesByProduct = <?php
                $grouped = array();
                foreach ($allBatches as $b) {
                    $usebyFormatted = !empty($b['useby']) ? date('Y-m-d', strtotime($b['useby'])) : '';
                    $grouped[$b['product']][] = array(
                        'batchcode' => $b['batchcode'],
                        'useby'     => $usebyFormatted
                    );
                }
                echo json_encode($grouped);
            ?>;

            $("#product").on("change", function() {
                var pid = $(this).val();
                var $bc = $("#batchcode");
                $bc.html('<option value="">Please Select</option>');
                $("#bb").val("");

                if (pid && batchesByProduct[pid]) {
                    $.each(batchesByProduct[pid], function(i, item) {
                        $bc.append('<option value="' + item.batchcode + '" data-useby="' + item.useby + '">' + item.batchcode + '</option>');
                    });
                    $bc.prop("disabled", false);
                } else {
                    $bc.prop("disabled", true);
                }
            });

            $("#batchcode").on("change", function() {
                var useby = $(this).find("option:selected").data("useby");
                if (useby && useby != "undefined") {
                    $("#bb").val(useby);
                } else {
                    $("#bb").val("");
                }
            });

            $("#add-row").click(function() {
                var product = $("#product").val();
                var productname = $("#product option:selected").text();
                var batchcode = $("#batchcode").val();
                var pack = $("#pack").val();
                var bpack = $("#bpack").val();
                var bb = $("#bb").val();
                var date = $("#date").val();

                if (product == "") {
                    document.getElementById("error").innerHTML = "* Please select product";
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
                    var markup = "<tr><td><input type='checkbox' name='record'></td>" +
                        "<td><input type='hidden' name='date[]' value='" + date + "'>" +
                        "<input type='hidden' name='product[]' value='" + product + "'>" +
                        "<input type='hidden' name='productname[]' value='" + productname + "'>" + productname + "</td>" +
                        "<td><input type='hidden' name='batchcode[]' value='" + batchcode + "'>" + batchcode + "</td>" +
                        "<td><input type='hidden' name='pack[]' value='" + pack + "'>" + pack + "</td>" +
                        "<td><input type='hidden' name='totalbox[]' value='" + bpack + "'>" +
                        "<input type='hidden' name='bb[]' value='" + bb + "'>" + bb + "</td></tr>";

                    $("table tbody").append(markup);

                    document.getElementById("product").value = "";
                    document.getElementById("batchcode").innerHTML = '<option value="">Please Select</option>';
                    document.getElementById("batchcode").disabled = true;
                    document.getElementById("bb").value = "";
                    document.getElementById("pack").value = "";
                    document.getElementById("bpack").value = "";
                }
            });

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

                    <a href="admin.php?id=fboxing"><button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>

                    <h4 class="card-title mb-3">Boxing Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" type="datetime-local" required="required" name="date" id="date" />
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Product</label>
                                <select class="form-control" name="product" id="product">
                                    <option value="">Please Select</option>
                                    <option value="2">Samosa</option>
                                    <option value="3">Spring roll</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Batchcode</label>
                                <select class="form-control" id="batchcode" disabled="disabled">
                                    <option value="">Please Select</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Best Before</label>
                                <input class="form-control" type="date" name="bb" id="bb" readonly />
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Total Packs Per Box</label>
                                <input class="form-control" type="text" name="pack" id="pack" />
                            </div>
                            <div class="col-md-6">
                                <label for="validationTooltip02">Total No. of Boxes</label>
                                <input class="form-control" type="text" name="pboxes" id="bpack" />
                            </div>
                        </div>

                        <div class="form-row" id="error"></div>
                        <br />

                        <button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add </button>
                        <br /><br />
                        <div class="form-row">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Batch Code</th>
                                        <th>Packs</th>
                                        <th>Best Before</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <br /><br />

                        <script language="javascript">
                            function cnt() {
                                var dt = $("#bootstrap-data-table tbody tr").length;
                                if (dt < 1) {
                                    alert("Please add at least one row.");
                                    return false;
                                }
                                return true;
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

<?php
if (isset($_POST['submit'])) {
    $cdate = $_POST['date'][0];
    $cdate = date('Y-m-d', strtotime($cdate));
    $vb = mysqli_query($con, "SELECT * FROM tblboxing WHERE cdate='$cdate'");
    $lastrow = mysqli_num_rows($vb);

    $num = $lastrow + 1;
    $grn = date('dmy') . "00" . $num;

    $productc = count($_POST["batchcode"]);
    for ($i2 = 0; $i2 < $productc; $i2++) {

        $date      = mysqli_real_escape_string($con, $_POST['date'][$i2]);
        $bb        = mysqli_real_escape_string($con, $_POST['bb'][$i2]);
        $pack      = mysqli_real_escape_string($con, $_POST['pack'][$i2]);
        $totalbox  = mysqli_real_escape_string($con, $_POST['totalbox'][$i2]);
        $batchcode = mysqli_real_escape_string($con, $_POST['batchcode'][$i2]);

        $user = $_SESSION['user'];

        $sql = mysqli_query($con, "INSERT INTO frozenboxing 
            (cdate, datetime, productbatch, bestbefore, pack, user, boxbatchcode, totalbox,leftbox) 
            VALUES 
            ('$cdate', '$date', '$batchcode', '$bb', '$pack', '$user', '$grn', '$totalbox','$totalbox')");

        $sql1 = mysqli_query($con, "UPDATE frozenproduction SET boxing='done' WHERE batchcode='$batchcode'");
    }
?>
    <script language="javascript">
        window.open('admin.php?id=fboxing', '_self');
    </script>
<?php
}
?>
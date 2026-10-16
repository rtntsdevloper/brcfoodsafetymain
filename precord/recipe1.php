<div class="col-md-12 mb-5">
    <div class="card">
        <div class="card-body">
            <a href="admin.php?id=recip1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

            <div class="card-title">Recipe Product
            </div>


            <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Date</label>
                        <input class="form-control" id="validationTooltip01" type="date" required="required" name="idate" />
                        <div class="invalid-tooltip">
                            Please provide a valid first name.

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Product Name</label>
                        <select name="fproduct" id="product" class="form-control" required>
                            <option value="">Select</option>
                            <?php
                            $sql = mysqli_query($con, "select * from `reciepe_ing` where type='Output'");
                            while ($row = mysqli_fetch_array($sql)) {
                            ?>
                                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-tooltip">
                            Please fill the field.

                        </div>
                    </div>

                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">
                                Input Product
                            </legend>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Product Name</label>
                                    <select id="productid" class="form-control" onchange="inputproduct(this)">
                                        <option value="">Select</option>
                                        <?php
                                        $sql = mysqli_query($con, "select * from `tblrawmaterial`");
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                            <option value="<?php echo $row['id']; ?>" data-pname="<?php echo $row['pname']; ?>" data-allergen="<?php echo $row['riskall']; ?>">
                                                <?php echo $row['pname']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip" id="errorpro">
                                        Please fill the field.
                                    </div>
                                </div>



                                <script>
                                    // Create a new XMLHttpRequest object
                                    function inputproduct(select) {
                                        select1 = select.options[select.selectedIndex];

                                        var product = select.value;
                                        var allergen = select1.getAttribute("data-allergen");
                                        var pname = select1.getAttribute("data-pname");

                                        if (allergen == "") {
                                            allergen = "None";
                                        }



                                        document.getElementById("allergen").value = allergen;
                                        document.getElementById("pname").value = pname;

                                        var xhr = new XMLHttpRequest();

                                        // Configure it: GET request to your endpoint
                                        xhr.open("GET", "precord/recipeprod.php?product=" + product, true);

                                        // Set up what happens when the request completes
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4) { // request done
                                                if (xhr.status === 200) { // success
                                                    // Insert the response directly as HTML
                                                    document.getElementById("inputdata").innerHTML = xhr.responseText;
                                                } else {
                                                    document.getElementById("inputdata").innerHTML = "Error loading data";
                                                }
                                            }
                                        };

                                        // Send the request
                                        xhr.send();

                                    }
                                </script>



                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Allergen</label>
                                    <input type="text" id="allergen" class="form-control">
                                    <input type="hidden" name="pname" id="pname" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Select GRN(batchcode)</label>
                                    <select id="inputdata" class="form-control" onchange="inputgrn(this)">
                                        <option value="">Select</option>



                                    </select>
                                    <div class="invalid-tooltip" id="errorgrn">
                                        Please fill the field.
                                    </div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Batchcode</label>
                                    <input type="text" name="batchcode" id="batchcode" class="form-control" readonly>
                                    <input type="hidden" id="pname" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>



                            </div>
                            <script>
                                function inputgrn(select) {
                                    select1 = select.options[select.selectedIndex];
                                    var batchcode = select1.getAttribute("data-grn");
                                    var leftqty = select1.getAttribute("data-leftqty");
                                    document.getElementById("batchcode").value = batchcode;
                                    document.getElementById("leftqty").value = leftqty;
                                }
                            </script>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Left Qty (In Kg)</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="leftqty" placeholder="Quantity" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Quantity (In Kg)</label>
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" id="qtyadd" placeholder="Quantity" oninput="checkqty()">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="errorqty"></p>
                                </div>
                                <script>
                                    function checkqty() {
                                        var qty = parseInt(document.getElementById("qtyadd").value);
                                        var leftqty = parseInt(document.getElementById("leftqty").value);
                                        if (qty > leftqty) {
                                            document.getElementById("errorqty").innerHTML = "* Quantity is greater than left quantity";
                                        } else {
                                            document.getElementById("errorqty").innerHTML = "";
                                        }
                                    }
                                </script>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">BB/UBD</label>
                                    <input type="date" id="bbdate" class="form-control">
                                    <div class="invalid-tooltip" id="errorbb">
                                        Please fill the field.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text-danger" id="error"></p>
                            </div>
                        </fieldset>

                        <div class="form-row" id="div2">
                            <div>
                                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        $("#add-row").click(function() {
                                            var product = $("#pname").val();
                                            var productid = $("#productid").val();
                                            var allergen = $("#allergen").val();
                                            var grn = $("#batchcode").val();
                                            var grnid = $("#inputdata").val();
                                            var qty = $("#qtyadd").val();
                                            var bbdate = $("#bbdate").val();
                                            var leftqty = $("#leftqty").val();


                                            //var bb = $("#bb").val();

                                            if (product == "") {
                                                document.getElementById("error").innerHTML = "* Please select the product";
                                                document.getElementById("productid").focus();
                                            } else if (grn == "") {
                                                document.getElementById("error").innerHTML = "* Please select the GRN(batchcode)";
                                                document.getElementById("grn").focus();
                                            } else if (qty == "") {
                                                document.getElementById("error").innerHTML = "* Please enter the quantity";
                                                document.getElementById("qtyadd").focus();
                                            } else {

                                                var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='hidden' name='product[]' value='" + product + "'><input type='hidden' name='productid[]' value='" + productid + "'>" + product + "</td><td><input type='hidden' name='allergen[]' value='" + allergen + "'>" + allergen + "</td><td><input type='hidden' name='batchcode[]' value='" + grn + "'><input type='hidden' name='grnid[]' value='" + grnid + "'>" + grn + "</td><td><input type='hidden' name='qty[]' value='" + qty + "'><input type='hidden' name='leftqty[]' value='" + leftqty + "'>" + qty + "</td><td><input type='hidden' name='bbdate[]' value='" + bbdate + "'>" + bbdate + "</td></tr>";

                                                $("table tbody").append(markup);
                                                $("#product").val("");
                                                $("#allergen").val("");
                                                $("#batchcode").val("");
                                                $("#qtyadd").val("");
                                                $("#leftqty").val("");
                                                $("#bbdate").val("");
                                                $("#productid").val("");
                                                $("#grnid").val("");
                                                $("#inputdata").val("");
                                                document.getElementById("error").innerHTML = "";




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














                            </div>


                        </div>


                        <br />
                        <button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add Ingredient </button>
                        <br /><br />
                        <div class="form-row">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Allergen</th>
                                        <th>Batchcode</th>
                                        <th>Qty</th>
                                        <th>BB/UBD</th>
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

                        <button type="submit" class="btn btn-success" style="float:right;" id="sub" name="submit">Save & Next</button>

                    </div>
                    <br>
                    <br>


                </div>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $idate = $_POST['idate'];
    $fproduct = $_POST['fproduct'];

    $product = $_POST['product'];

    $productid = $_POST['productid'];
    $allergen = $_POST['allergen'];
    $batchcode = $_POST['batchcode'];
    $grnid = $_POST['grnid'];
    $leftqty = $_POST['leftqty'];

    $qty = $_POST['qty'];

    $bbdate = $_POST['bbdate'];

    $recipeno = "REC" . date("Ymd") . rand(10, 99);
    $sqlm  = mysqli_query($con, "INSERT INTO `recipedetail`(`date`,`recordid`,`fproduct`) VALUES ('$idate','$recipeno','$fproduct')");
    $lastid = mysqli_insert_id($con);

    foreach ($product as $key => $value) {
        $batchcodei = $batchcode[$key];
        $qtyi = $qty[$key];
        $bbdatei = $bbdate[$key];
        $leftqtyi = $leftqty[$key];
        $productid = $productid[$key];
        $producti = $product[$key];
        $allergeni = $allergen[$key];
        $tleft = floatval($leftqtyi) - floatval($qtyi);
        $grnidi = $grnid[$key];

       

        $sqls = mysqli_query($con, "INSERT INTO `reciepedetail1`( `vid`, `batch`, `pname`, `pid`, `grn`, `qty`, `useby`, `grnc`,`allergen`) VALUES ('$lastid','$batchcodei','$producti','$productid','$grnidi','$qtyi','$bbdatei','$recipeno','$allergeni')");
        if ($sqls) {

            $upd = mysqli_query($con, "UPDATE `tblgrn1` SET `leftqty`='$tleft' WHERE `id`='$grnidi'");
        }
    }


    if ($sqlm && $sqls) {
        echo "<script>window.location.href='admin.php?id=recipe2&vid=$lastid';</script>";
    } else {
        echo "<script>window.location.href='admin.php?id=recipe1';</script>";
    }
}

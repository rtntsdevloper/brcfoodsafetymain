<?php
$pxid = $_GET['pxid'];

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href=""></a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=zendbox&pxid=<?= $pxid ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Boxing Record
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
                            <label for="validationTooltip01">Batch</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="ibatch" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Final Product Name</label>
                            <select id="productid" class="form-control" name="finproduct" onchange="inputproduct(this)">
                                <option value="">Select</option>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `zendfinalproduct` WHERE  pid='1' order by name asc");
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>" data-pname="<?php echo $row['name']; ?>">
                                        <?php echo $row['name']; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <input type="hidden" name="fpname" id="pname">
                            <div class="invalid-tooltip" id="errorpro">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Total Boxes</label>
                            <input class="form-control" id="tbox" type="number" required="required" name="tbox" oninput="totalbox()" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">No. of Units in each box</label>
                            <input class="form-control" id="eachbox" type="number" required="required" name="eachbox" oninput="totalbox()" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <script>
                            function totalbox() {

                                var tbox = document.getElementById("tbox").value;
                                var eachbox = document.getElementById("eachbox").value;
                                if (tbox == '') {
                                    tbox = 1;
                                }
                                if (eachbox == '') {
                                    eachbox = 1;
                                }

                                var total = parseInt(tbox) * parseInt(eachbox);


                                document.getElementById("sctotal").value = total;
                            }
                        </script>
<!--                         
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Total Units Required</label>
                            <input class="form-control" type="number" readonly name="tsachet" id="sctotal" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.
                            </div>
                        </div> -->

<!-- 
                        new column -->

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Number of Outer Box Label Waste / damage </label>
                            <input class="form-control" type="text"  name="totallabel" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Upload Picture</label>
                            <input class="form-control" type="file" name="outerpic" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                         <!-- <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Number of Outer Box Label Waste / damage </label>
                            <input class="form-control" type="text"  name="wastetotal"  />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Total Units Required</label>
                            <input class="form-control" type="file" name="wastepic"  />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div> -->
                        </div>









                    </div>
                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">
                                Product Details
                            </legend>

                            <div class="row">




                                <script>
                                    // Create a new XMLHttpRequest object
                                    function inputproduct(select) {
                                        select1 = select.options[select.selectedIndex];

                                        var product = select.value;


                                        var pname = select1.getAttribute("data-pname");

                                        document.getElementById("pname").value = pname;

                                        var xhr = new XMLHttpRequest();

                                        xhr.open("GET", "zendboxg/boxadd1.php?product=" + product, true);

                                        // Set up what happens when the request completes
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === 4) { // request done
                                                if (xhr.status === 200) { // success

                                                    document.getElementById("prodbatch").innerHTML = xhr.responseText;
                                                } else {
                                                    document.getElementById("prodbatch").innerHTML = "Error loading data";
                                                }
                                            }
                                        };

                                        // Send the request
                                        xhr.send();

                                    }
                                </script>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Select Production Batchcode</label>
                                    <select id="prodbatch" class="form-control" onchange="inputgrn(this)">
                                        <option value="">Select</option>



                                    </select>
                                    <div class="invalid-tooltip" id="errorgrn">
                                        Please fill the field.
                                    </div>

                                </div>




                                <script>
                                    function inputgrn(select) {
                                        select1 = select.options[select.selectedIndex];
                                        var batchid = select1.getAttribute("data-id");
                                        var leftqty = select1.getAttribute("data-leftqty");
                                        document.getElementById("batchcode").value = batchid;
                                        document.getElementById("leftqty").value = leftqty;
                                    }
                                </script>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Left Qty (In Units)</label>
                                    <div class="input-group mb-2">
                                        <input type="hidden" id="batchcode">
                                        <input type="text" class="form-control" id="leftqty" placeholder="Quantity" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Units</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Quantity (In Units)</label>
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" id="qtyadd" placeholder="Quantity" oninput="checkqty()">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Units</div>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="errorqty"></p>
                                </div>
                                <script>
                                    function checkqty() {
                                        var qty = parseInt(document.getElementById("qtyadd").value);
                                        var leftqty = parseInt(document.getElementById("leftqty").value);
                                        if (qty > leftqty) {
                                            document.getElementById("qtyadd").value = leftqty;
                                            document.getElementById("errorqty").innerHTML = "* Quantity is greater than left quantity";
                                        } else {
                                            document.getElementById("errorqty").innerHTML = "";
                                        }
                                    }
                                </script>
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
                                            var production = $("#prodbatch").val();


                                            var prodid = $("#batchcode").val();
                                            var leftqty = $("#leftqty").val();
                                            var qty = $("#qtyadd").val();





                                            //var bb = $("#bb").val();

                                            if (product == "") {
                                                document.getElementById("error").innerHTML = "* Please select the product";
                                                document.getElementById("productid").focus();
                                            } else if (production == "") {
                                                document.getElementById("error").innerHTML = "* Please select the GRN(batchcode)";
                                                document.getElementById("prodbatch").focus();
                                            } else if (qty == "") {
                                                document.getElementById("error").innerHTML = "* Please enter the quantity";
                                                document.getElementById("qtyadd").focus();
                                            } else {

                                                var markup = "<tr><td><input type='checkbox' name='record'></td><td><input type='hidden' name='product[]' value='" + product + "'><input type='hidden' name='productid[]' value='" + productid + "'>" + product + "</td><td><input type='hidden' name='production[]' value='" + production + "'><input type='hidden' name='productionid[]' value='" + prodid + "'>" + production + "</td><td><input type='hidden' name='qty[]' value='" + qty + "'><input type='hidden' name='leftqty[]' value='" + leftqty + "'>" + qty + "</td></tr>";

                                                $("table tbody").append(markup);
                                                var tsum = 0;
                                                const qtyFields = document.querySelectorAll('input[name="qty[]"]');

                                                qtyFields.forEach(field => {
                                                    tsum += parseFloat(field.value) || 0; // convert to number, default 0 if invalid
                                                });
                                                document.getElementById("tsumc").innerHTML = tsum;
                                                $("#qtyadd").val("");
                                                $("#leftqty").val("");
                                                $("#batchcode").val("");
                                                $("#prodbatch").val("");
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

                                            var tsum = 0;
                                            const qtyFields = document.querySelectorAll('input[name="qty[]"]');
                                            qtyFields.forEach(field => {
                                                tsum += parseFloat(field.value) || 0; // convert to number, default 0 if invalid
                                            });
                                            document.getElementById("tsumc").innerHTML = tsum;

                                        });
                                    });
                                </script>














                            </div>


                        </div>


                        <br />
                        <button type="button" name="submit" class="btn btn-primary" id="add-row"> <i class="fa fa-plus"></i> Add Product </button>
                        <br /><br />
                        <div class="form-row">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Production Batchcode</th>
                                        <th>Quantity(In Units)</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th>Total Quantity(In Units) : <span id="tsumc">0</span> </th>

                                    </tr>
                                </tfoot>
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




                </form>
            </div>
        </div>
    </div>


    <?php

    if (isset($_POST['submit'])) {


        $idate = $_POST['idate'];
        $batch = $_POST['ibatch'];
        $tbox = $_POST['tbox'];
        $eachbox = $_POST['eachbox'];
        // $tsachet = $_POST['tsachet'];

        $boxingc = 'BOX' . date('dmYhi');
        $cxdate = date('Y-m-d h:i:s');
        echo $finproduct = $_POST['finproduct'];


        $pname = $_POST['fpname'];
        $totallabel  = $_POST['totallabel'];
        
        // $wastetotal = $_POST['wastetotal'];

        $imgpath = "zendboxg/pdf/";
    if (isset($_FILES['outerpic'])) {
        $packpic = $_FILES['outerpic']['name'];
        $packpic_tmp = $_FILES['outerpic']['tmp_name'];
        $packpic_ext = pathinfo($packpic, PATHINFO_EXTENSION);
        $packpic_new = date("YmdHis") . "_" . rand(10001, 99999) . $packpic;

        if (move_uploaded_file($packpic_tmp, $imgpath . $packpic_new)) {
            $packpicnew = $packpic_new;
        } else {
            $packpicnew = "";
        }
    } else {
        $packpicnew = "";
    }

    // if (isset($_FILES['wastepic'])) {
    //     $wastepic = $_FILES['wastepic']['name'];
    //     $wastepic_tmp = $_FILES['wastepic']['tmp_name'];
    //     $wastepic_ext = pathinfo($wastepic, PATHINFO_EXTENSION);
    //     $wastepic_new = date("YmdHis") . "_" . rand(10001, 99999) . $wastepic;
    //     if (move_uploaded_file($wastepic_tmp, $imgpath . $wastepic_new)) {
    //         $wastepicnew = $wastepic_new;
    //     } else {
    //         $wastepicnew = "";
    //     }
    // } else {
    //     $wastepicnew = "";
    // }

 

        $boxq = mysqli_query($con, "INSERT INTO `zendboxing`( `date`, `totalb`, `eachbox`, `batch`, `boxbatch`, `pxid`, `user`, `cxdate`,`fpid`,`pname`,`boxleft`, `totallabel`, `outerpic`) VALUES ('$idate','$tbox','$eachbox','$batch','$boxingc','$pxid','$user','$cxdate','$finproduct','$pname','$tbox','$totallabel','$packpicnew')");

        $boxq1 = mysqli_insert_id($con);

        $product = $_POST['product'];
        foreach ($product as $pkey => $pro) {
            $prodname = $pro;
            $prodid = $_POST['productid'][$pkey];
            $qty = $_POST['qty'][$pkey];
            $leftqty = $_POST['leftqty'][$pkey];
            $production = $_POST['production'][$pkey];
            $prodid = $_POST['productionid'][$pkey];

            $qtyleft = $leftqty - $qty;


            $prodb = mysqli_query($con, "INSERT INTO `zendboxing1`(`vid`, `vbatch`, `prodname`, `prodid`, `qty`, `production`, `productionid`, `pxid`) VALUES ('$boxq1','$boxingc','$prodname','$prodid','$qty','$production','$prodid','$pxid')");
            if ($prodb) {
                $update = mysqli_query($con, "UPDATE `zendproduction` SET `sachetleft`='$qtyleft' WHERE id='$prodid'");
            }
        }
        if ($boxq && $prodb) {
            echo "<script> window.location.href='admin.php?id=zendbox&pxid=" . $pxid . "';</script>";
        } else {
            echo "<script>alert('Failed to Add'); </script>";
        }
    }
    ?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">


            <div class="card-body">
                <a href="admin.php?id=dist_mixing"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Mixing Ingredient Record
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="distdate" type="date" required="required" name="idate" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time of Mixing</label>
                            <input type="time" name="ttime" id="disttime" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Name of Product/Product Code</label>
                            <select name="productcode" id="productcode" class="form-control" onchange="prodch(this)">
                                <option value="">Select Product</option>
                                <?php
                                $sql = mysqli_query($con, "select * from `dist_mixprod` where status = '1'");
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <option value="<?php echo $row['prodname']; ?>" data-code="<?php echo $row['prodcode']; ?>"><?php echo $row['prodname']; ?> (<?php echo $row['prodcode']; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                            <script>
                                function prodch(t) {
                                    $('#prod_code').val(t.options[t.selectedIndex].dataset.code);
                                }
                            </script>
                            <input type="text" name="prod_code" id="prod_code" class="form-control" style="display:none">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Select Recipe Number</label>
                            <select name="recipe" id="recipe" class="form-control" onchange="recipech(this.value)">
                                <option value="">Select Recipe</option>
                                <?php
                                $sql = mysqli_query($con, "select * from `dist_recipe` where status = 'Active'");
                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['recnum']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <script>
                                function recipech(t) {




                                    //$('#ingredient_row').removeClass('d-none');
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', 'precord/dist_mixing1?prid=' + t, true);
                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            document.getElementById('ingredient_row').innerHTML = xhr.responseText;
                                        }
                                    };
                                    xhr.send();
                                }
                            </script>
                            <div class="invalid-tooltip">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pesteurization time </label>
                            <input type="text" name="pesttime" id="pesttime" class="form-control" placeholder="in  minutes" required>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pesteurization temperature </label>
                            <input type="text" name="pesttemp" id="pesttemp" class="form-control" placeholder="in  degrees" required>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Homoganisation pressure (PSI)</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="in psi" name="homopressure" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        </br>
                        </br>
                        <button class="btn btn-primary" type="button" onclick="addingredient()" id="nextbtn">Save & Next</button>



                    </div>
                    <script>
                        function addingredient() {
                            $('#nextbtn').addClass('d-none');

                            $('#ingredient_row').removeClass('d-none');

                        }
                    </script>
                    <div class="form-row d-none" id="ingredient_row">

                    </div>





            </div>

        </div>


        </form>
    </div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $idate = $_POST['idate'];
    $ttime = $_POST['ttime'];
    $pname = mysqli_real_escape_string($con, $_POST['productcode']);
    $pcode = mysqli_real_escape_string($con, $_POST['prod_code']);
    $recipe = $_POST['recipe'];
    $pesttime = mysqli_real_escape_string($con, $_POST['pesttime']);
    $pesttemp = mysqli_real_escape_string($con, $_POST['pesttemp']);
    $homopressure = mysqli_real_escape_string($con, $_POST['homopressure']);
    $cdate = date('Y-m-d H:i:s');

    // ajax page

    $recipen = $_POST['recipen'];
    $recipeno = $_POST['recipeno'];
    $tankno = $_POST['tankno'];
    $tankcleaned = $_POST['tankcleaned'];
    $mixcmnt = $_POST['mixcmnt'];
    $mcode = "MIX" . date('dmYhis');
    $user = $_SESSION['user'];


    $resultt = mysqli_query($con, "INSERT INTO `dist_mixrecord`(`mdate`, `cdate`, `pname`, `pcode`, `recid`, `recname`, `recnumb`, `pestime`, `pestemp`, `hempress`, `milktank`, `tankclean`, `comment`, `mixuser`, `mcode`) VALUES ('$idate','$cdate','$pname','$pcode','$recipe','$recipen','$recipeno','$pesttime','$pesttemp','$homopressure','$tankno','$tankcleaned','$mixcmnt','$user','$mcode')");


    $resultid = mysqli_insert_id($con);

    $ingredients_name = $_POST['ingredient_name'];
    foreach ($ingredients_name as $key => $value) {
        $ingredients_code = mysqli_real_escape_string($con, $_POST['ingredient_code'][$key]);
        $quantity12 = mysqli_real_escape_string($con, $_POST['quantity12'][$key]);
        $quantity20 = mysqli_real_escape_string($con, $_POST['quantity20'][$key]);
        $actual_quantity = mysqli_real_escape_string($con, $_POST['actual_quantity'][$key]);
        $batch_number = mysqli_real_escape_string($con, $_POST['batch_number'][$key]);
        $best_before = mysqli_real_escape_string($con, $_POST['best_before'][$key]);


        $result1 = mysqli_query($con, "INSERT INTO `dist_mixrecord1`(`tid`, `code`, `ingredient`, `quantity2`, `quantity12`, `allergen`, `value`, `batch`, `ubdate`, `user`) VALUES ('$resultid','$ingredients_code','$value','$quantity20','$quantity12','$allergen','$actual_quantity','$batch_number','$best_before','$user')");
    }


    if ($resultt and $result1) {
        echo "<script> window.location.href = 'admin.php?id=dist_mixsign&rid=$resultid';</script>";
    }
}

?>
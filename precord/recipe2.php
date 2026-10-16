<div class="main-content mb-5">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">


                <div class="card-title">Product Recipe Detail
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input type="time" name="start" id="" class="form-control" required>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">End Time</label>
                            <input type="time" name="end" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Temperature Before Cutting</label>
                            <div class="input-group">
                                <input type="number" name="temp1" id="" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">°C</div>
                                </div>
                            </div>

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Temperature After Cutting</label>
                            <div class="input-group">
                                <input type="number" name="temp2" id="" class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">°C</div>
                                </div>
                            </div>



                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>





                    </div>

                    <br>


                    <!-- oUTPUT -->
                    <br><br>

                    <div class="container-fluid mt-2">
                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">
                                Output Product
                            </legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Product Name</label>
                                    <select name="producto" id="producto0" class="form-control" onchange="outputproduct(this,0)" required>
                                        <option value="">Select</option>
                                        <?php
                                        $sql = mysqli_query($con, "select * from `reciepe_ing` where type='Output'");
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                            <option value="<?php echo $row['name']; ?>" data-allergen="<?php echo $row['allergen']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Allergen</label>
                                    <input type="text" name="allergeno" id="allergeno0" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Quantity (In Kg)</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="inlineFormInputGroup0" placeholder="Quantity" name="qtyo">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Batchcode</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="inlineFormInputGroup0" placeholder="Batchcode" name="batcho">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">BB/UBD</label>
                                    <input type="date" name="bbo" id="bb" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>
                            </div>
                        </fieldset>




                        <script>
                            function outputproduct(e, i) {
                                const selectedOption = e.selectedOptions[0];
                                const allergenValue = selectedOption.dataset.allergen;
                                const allergenInput = document.getElementById('allergeno' + i);

                                if (allergenInput && allergenValue) {
                                    allergenInput.value = allergenValue;
                                }
                            }
                        </script>


                    </div>
                    <br>
                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">
                                Wastage Record
                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Wastage (In Kg)</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="inlineFormInputGroup0" placeholder="Quantity" name="wastage">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Wastage Comments</label>
                                    <textarea name="wastagec" id="wastage_comments" class="form-control"></textarea>
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <br>



                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">
                                Checks
                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Correct PPE worn?</label>
                                    <input type="hidden" name="quesc[]" value="Correct PPE worn?">
                                    <div class="input-group mb-2">

                                        <select name="check[]" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">All the equipment clean prior to use?</label>
                                    <input type="hidden" name="quesc[]" value="All the equipment clean prior to use?">
                                    <div class="input-group mb-2">

                                        <select name="check[]" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Any Glass/Plastic Breakage?</label>
                                    <input type="hidden" name="quesc[]" value="Any Glass/Plastic Breakage?">
                                    <div class="input-group mb-2">

                                        <select name="check[]" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </fieldset>

                    </div>
                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">

                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Temperature of Freezer</label>
                                    <div class="input-group mb-2">
                                        <input type="number" name="prodtemp" id="prodtemp" class="form-control">
                                        <div class="input-group-append">
                                            <div class="input-group-text">°C</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Batchcode</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="batchcode" id="batchcode" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Shelf Life</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="shelf" id="shelf" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Comments</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="comment" id="comment" class="form-control">
                                    </div>
                                </div>




                            </div>
                        </fieldset>

                    </div>

                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">

                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Previous Product</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="lineprod" id="prevprod" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Cleandown Carried Out </label>
                                    <div class="input-group mb-2">

                                        <select name="lineclean" id="" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Line Manager Initials</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="linemanage" id="shelf" class="form-control">
                                    </div>
                                </div>


                            </div>
                        </fieldset>

                    </div>
                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">

                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Etrace Label No.</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="etrace" id="etrace" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Quantity(Kg)</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="traceqty" id="traceqty" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Packaging Date</label>
                                    <div class="input-group mb-2">
                                        <input type="date" name="tracepackdate" id="tracepackdate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Packaging UB</label>
                                    <div class="input-group mb-2">
                                        <input type="date" name="tracepackub" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Product Temperature</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="traceprodtemp" id="traceprodtemp" class="form-control">
                                        <div class="input-group-append">
                                            <div class="input-group-text">°C</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Upload Start Label</label>
                                    <div class="input-group mb-2">
                                        <input type="file" name="startlabel" id="startlabel" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Upload End Label</label>
                                    <div class="input-group mb-2">
                                        <input type="file" name="endlabel" id="endlabel" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Last Four Digit of Used Label</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="usedlabel[]" class="form-control" placeholder="Last Four Digit of Used Label">
                                    </div>

                                    <div class="input-group mb-2" id="other_task_div">

                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addInput()">Add More Label</button>
                                </div>


                                <script>
                                    function addInput() {
                                        var div = document.getElementById("other_task_div");
                                        var wrapper = document.createElement("div");
                                        wrapper.className = "input-group mb-2";

                                        var input = document.createElement("input");
                                        input.type = "text";
                                        input.placeholder = "Last Four Digit of Used Label"
                                        input.name = "usedlabel[]";
                                        input.className = "form-control";

                                        var removeBtn = document.createElement("button");
                                        removeBtn.type = "button";
                                        removeBtn.className = "btn btn-danger";
                                        removeBtn.innerText = "Remove";
                                        removeBtn.onclick = function() {
                                            div.removeChild(wrapper);
                                        };

                                        wrapper.appendChild(input);
                                        wrapper.appendChild(removeBtn);
                                        div.appendChild(wrapper);
                                    }
                                </script>



                            </div>
                        </fieldset>

                    </div>
                    <div class="container-fluid mt-2">

                        <!-- First Product Fieldset -->
                        <fieldset class="mt-4" style="border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <legend style="font-weight: bold; color: #495057; width: auto; padding: 0 10px;">

                            </legend>
                            <div class="row">


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">No. of Bags Produced</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="bagsp" id="etrace" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Weight Pack in each Bag</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="bagw" id="traceqty" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Bag Batch Code</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="bagbc" id="tracepackdate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Total Label Produced</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelp" id="tracepackub" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Total Label Used</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelu" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Label Wasted</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelw" id="tracepackub" class="form-control">
                                    </div>
                                </div>

                                <br>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> Start Label Check By</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelcheck1" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> Start Label Check time</label>
                                    <div class="input-group mb-2">
                                        <input type="time" name="labeltime1" id="tracepackub" class="form-control">
                                    </div>
                                </div>

                                <br>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> Middle Label Check By</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelcheck2" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> Middle Label Check time</label>
                                    <div class="input-group mb-2">
                                        <input type="time" name="labeltime2" id="tracepackub" class="form-control">
                                    </div>
                                </div>

                                <br>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> End Label Check By</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="labelcheck3" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02"> End Label Check time</label>
                                    <div class="input-group mb-2">
                                        <input type="time" name="labeltime3" id="tracepackub" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Cardboard Batch Code</label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="cbcode" id="tracepackub" class="form-control">
                                    </div>
                                </div>





                            </div>
                        </fieldset>

                    </div>



            </div>


            <div class="row pl-5 mb-5">
                <button class="btn btn-success ml-2" type="submit" name="draft">Save as Draft </button>
                <button class="btn btn-primary ml-3" type="submit" name="submit">Submit </button>
            </div>




        </div>



        </form>
    </div>
</div>
<?php
$vid = $_GET['vid'];
if (isset($_POST['submit'])) {

    $starttime = $_POST['start'];
    $endtime = $_POST['end'];
    $tempbefore = $_POST['temp1'];
    $tempafter = $_POST['temp2'];


    $opname = $_POST['producto'];
    $oallergen = $_POST['allergeno'];
    $oqty = $_POST['qtyo'];
    $obbdate = $_POST['bbo'];
    $obatch = $_POST['batcho'];

    $waste = $_POST['wastage'];
    $wastecmnt = $_POST['wastagec'];
    $checksq = $_POST['quesc'];
    $checksq1 = implode(';', $checksq);
    $checksans = $_POST['check'];
    $checksans1 = implode(';', $checksans);

    $tempfreeze = $_POST['prodtemp'];
    $tbatch = $_POST['batchcode'];
    $tshelf = $_POST['shelf'];
    $tcomment = $_POST['comment'];

    //line
    $linepro = $_POST['lineprod'];
    $lineclean = $_POST['lineclean'];
    $linemanager = $_POST['linemanage'];

    //etrace


    $etrace = $_POST['etrace'];
    $etqty = $_POST['traceqty'];

    //done
    $epackdate = $_POST['tracepackdate'];
    $epackub = $_POST['tracepackub'];
    $eprodtemp = $_POST['traceprodtemp'];

    $labelused = $_POST['usedlabel'];
    $usedlabel = implode(';', $labelused);

    $bags = $_POST['bagsp'];
    $bageach = $_POST['bagw'];
    $bagbatch = $_POST['bagbc'];
    $labelproduced = $_POST['labelp'];
    $labelwasted = $_POST['labelw'];
    $labelcheck1 = $_POST['labelcheck1'];
    $labeltime1 = $_POST['labeltime1'];
    $labelcheck2 = $_POST['labelcheck2'];
    $labeltime2 = $_POST['labeltime2'];
    $labelcheck3 = $_POST['labelcheck3'];
    $labeltime3 = $_POST['labeltime3'];
    $cbcode = $_POST['cbcode'];

    $uniqu = date('dmyhis') . rand(10, 99);
    if (isset($_FILES['startlabel']) && !empty($_FILES['startlabel']['name'])) {
        $startlabel = basename($_FILES['startlabel']['name']);
        $start = $uniqu . $startlabel;
        if (move_uploaded_file($_FILES['startlabel']['tmp_name'], "precord/files/" . $start)) {
            $startlabelfile = $start;
        } else {
            echo "Error uploading file";
        }
    } else {
        $startlabelfile = "";
    }

    if (isset($_FILES['endlabel']) && !empty($_FILES['endlabel']['name'])) {
        $endlabel = basename($_FILES['endlabel']['name']);
        $end = $uniqu . $endlabel;
        if (move_uploaded_file($_FILES['endlabel']['tmp_name'], "precord/files/" . $end)) {
            $endlabelfile = $end;
        } else {
            echo "Error uploading file";
        }
    } else {
        $endlabelfile = "";
    }


    $sqlx = "UPDATE `recipedetail` SET `starttime`='$starttime', `endtime`='$endtime', `tempbefore`='$tempbefore', `tempafter`='$tempafter', `opname`='$opname', `oallergen`='$oallergen', `oqty`='$oqty', `obbdate`='$obbdate', `waste`='$waste', `wastecmnt`='$wastecmnt', `checksq`='$checksq1', `checksans`='$checksans1', `tempfreeze`='$tempfreeze', `tbatch`='$tbatch', `tshelf`='$tshelf', `tcomment`='$tcomment', `linepro`='$linepro', `linecarry`='$lineclean', `linemanager`='$linemanager', `etracelabel`='$etrace', `etqty`='$etqty', `epackdate`='$epackdate', `epackub`='$epackub', `eprodtemp`='$eprodtemp', `startlabel`='$startlabelfile', `endlabel`='$endlabelfile', `labelused`='$usedlabel', `bags`='$bags', `bageach`='$bageach', `bagbatch`='$bagbatch', `totallabelp`='$labelproduced', `totallabelw`='$labelwasted', `startcheck`='$labelcheck1', `startctime`='$labeltime1', `middlecheck`='$labelcheck2', `middlectime`='$labeltime2', `endcheck`='$labelcheck3', `endctime`='$labeltime3', `cardboard`='$cbcode', `status`='Draft', `obatch`='$obatch' WHERE `id` = '$vid'";


    $result = mysqli_query($con, $sqlx);
    if ($result) {
        echo "<script>
     window.location.href = 'admin.php?id=recipesign&rid=$vid';
    </script>";
    }
}
if (isset($_POST['draft'])) {

    $starttime = $_POST['start'];
    $endtime = $_POST['end'];
    $tempbefore = $_POST['temp1'];
    $tempafter = $_POST['temp2'];


    $opname = $_POST['producto'];
    $oallergen = $_POST['allergeno'];
    $oqty = $_POST['qtyo'];
    $obbdate = $_POST['bbo'];
    $obatch = $_POST['batcho'];


    $waste = $_POST['wastage'];
    $wastecmnt = $_POST['wastagec'];
    $checksq = $_POST['quesc'];
    $checksq1 = implode(';', $checksq);
    $checksans = $_POST['check'];
    $checksans1 = implode(';', $checksans);

    $tempfreeze = $_POST['prodtemp'];
    $tbatch = $_POST['batchcode'];
    $tshelf = $_POST['shelf'];
    $tcomment = $_POST['comment'];

    //line
    $linepro = $_POST['lineprod'];
    $lineclean = $_POST['lineclean'];
    $linemanager = $_POST['linemanage'];

    //etrace


    $etrace = $_POST['etrace'];
    $etqty = $_POST['traceqty'];

    //done
    $epackdate = $_POST['tracepackdate'];
    $epackub = $_POST['tracepackub'];
    $eprodtemp = $_POST['traceprodtemp'];

    $labelused = $_POST['usedlabel'];
    $usedlabel = implode(';', $labelused);

    $bags = $_POST['bagsp'];
    $bageach = $_POST['bagw'];
    $bagbatch = $_POST['bagbc'];
    $labelproduced = $_POST['labelp'];
    $labelwasted = $_POST['labelw'];
    $labelcheck1 = $_POST['labelcheck1'];
    $labeltime1 = $_POST['labeltime1'];
    $labelcheck2 = $_POST['labelcheck2'];
    $labeltime2 = $_POST['labeltime2'];
    $labelcheck3 = $_POST['labelcheck3'];
    $labeltime3 = $_POST['labeltime3'];
    $cbcode = $_POST['cbcode'];

    $uniqu = date('dmyhis') . rand(10, 99);
    if (isset($_FILES['startlabel']) && !empty($_FILES['startlabel']['name'])) {
        $startlabel = basename($_FILES['startlabel']['name']);
        $start = $uniqu . $startlabel;
        if (move_uploaded_file($_FILES['startlabel']['tmp_name'], "precord/files/" . $start)) {
            $startlabelfile = $start;
        } else {
            echo "Error uploading file";
        }
    } else {
        $startlabelfile = "";
    }

    if (isset($_FILES['endlabel']) && !empty($_FILES['endlabel']['name'])) {
        $endlabel = basename($_FILES['endlabel']['name']);
        $end = $uniqu . $endlabel;
        if (move_uploaded_file($_FILES['endlabel']['tmp_name'], "precord/files/" . $end)) {
            $endlabelfile = $end;
        } else {
            echo "Error uploading file";
        }
    } else {
        $endlabelfile = "";
    }


    $sqlx = "UPDATE `recipedetail` SET `starttime`='$starttime', `endtime`='$endtime', `tempbefore`='$tempbefore', `tempafter`='$tempafter', `opname`='$opname', `oallergen`='$oallergen', `oqty`='$oqty', `obbdate`='$obbdate', `obatch`='$obatch', `waste`='$waste', `wastecmnt`='$wastecmnt', `checksq`='$checksq1', `checksans`='$checksans1', `tempfreeze`='$tempfreeze', `tbatch`='$tbatch', `tshelf`='$tshelf', `tcomment`='$tcomment', `linepro`='$linepro', `linecarry`='$lineclean', `linemanager`='$linemanager', `etracelabel`='$etrace', `etqty`='$etqty', `epackdate`='$epackdate', `epackub`='$epackub', `eprodtemp`='$eprodtemp', `startlabel`='$startlabelfile', `endlabel`='$endlabelfile', `labelused`='$usedlabel', `bags`='$bags', `bageach`='$bageach', `bagbatch`='$bagbatch', `totallabelp`='$labelproduced', `totallabelw`='$labelwasted', `startcheck`='$labelcheck1', `startctime`='$labeltime1', `middlecheck`='$labelcheck2', `middlectime`='$labeltime2', `endcheck`='$labelcheck3', `endctime`='$labeltime3', `cardboard`='$cbcode', `status`='Draft' WHERE `id` = '$vid'";


    $result = mysqli_query($con, $sqlx);
    if ($result) {
        echo "<script>
    window.location.href = 'admin.php?id=recipe';
    </script>";
    }
}



?>
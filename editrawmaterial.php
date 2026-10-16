<div class="main-content">
    <div class="breadcrumb">
        <ul class="ml-4">
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>
    <style>
        .hidden {
            display: none;
        }

        .text-danger {
            color: red;
        }

        .text-primary {
            color: blue;
        }
    </style>

    <?php

    $get = $_GET['sno'];
    $sq = "SELECT * FROM tblrawmaterial WHERE id = $get";
    $result = mysqli_query($con, $sq);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="container-fluid" style="margin-top:50px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Raw material</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip07"> Category</label>
                                <select name="category" class="form-control" onchange="categraw(this.value)"  required>
                                    <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                                    <option value="Raw Material">Raw Material</option>
                                    <option value="Primary Packaging">Primary Packaging</option>
                                    <option value="Secondary Packaging">Secondary Packaging</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

                            <script>
                                function categraw(cr) {
                                    const rawget = document.getElementById('rawm');
                                    const migrate = document.getElementById('migrate');

                                    if (cr == 'Raw Material') {
                                        rawget.classList.remove('hidden');
                                        migrate.classList.add('hidden');
                                    } else {
                                        rawget.classList.add('hidden');
                                        migrate.classList.remove('hidden');
                                    }


                                }
                            </script>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">Product code</label>
                                <input class="form-control" id="validationTooltip02" type="text" value="<?php echo $row['pcode'];  ?>" name="pcode" />
                                <div class="invalid-tooltip">
                                    Please fill in this field
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">Product name</label>
                                <input name="pname" type="text" class="form-control" id="validationTooltip03" value="<?php echo $row['pname']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill in this field
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Image</label>
                                <input class="form-control" id="validationTooltip04" type="file" placeholder=""
                                    name="pic" accept="image/jpeg,jpg" value="<?php echo $row['pic']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">

                                <?php

                                $q = "SELECT * FROM tblrawsupplier";
                                $result4 = mysqli_query($con, $q);

                                // Get the current supplier id from raw material
                                $current_supid = $row['supid'];
                                ?>
                                <label for="validationTooltip02">Supplier name</label>
                                <select class="form-control" id="validationTooltip02" name="supname">
                                    <option value="">Please Select</option>
                                    <?php while ($row1 = mysqli_fetch_assoc($result4)) {
                                        $selected = ($row1['supid'] == $current_supid) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $row1['supid']; ?>" <?php echo $selected; ?>>
                                            <?php echo $row1['supname']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>






                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Product Specification Date</label>
                                <input type="date" name="prospecdate" id="" class="form-control" value="<?php echo $row['specdate']; ?>">
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>


                            <div class='col-md-12 <?php if ($row['category'] != 'Raw Material') {
                                                        echo 'hidden';
                                                    } ?>' id="rawm">
                                <div class="row">





                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Is product suitable for freezing?</label>
                                        <select name="freeze" class="form-control" onchange="showfreeze(this.value)" >
                                            <option value="<?php echo $row['freeze'];  ?>"><?php echo $row['freeze'];  ?></option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please fill the field
                                        </div>
                                    </div>

                                    <script>
                                        function showfreeze(fn) {
                                            rvf = document.getElementById("freeze");
                                            if (fn == "Yes") {
                                                rvf.classList.remove('hidden');
                                            } else {
                                                rvf.classList.add('hidden');
                                            }
                                        }
                                    </script>





                                    <div class="col-md-6 mb-3">
                                        <div class="<?php if ($row['freeze'] == 'Yes') {
                                                        echo '';
                                                    } else {
                                                        echo 'hidden';
                                                    };  ?>" id="freeze">
                                            <label for="validationTooltip09 text-primary" class="text-danger">* What will be the frozen shelf life?</label>
                                            <input type="text" name="frozenlife" id="" class="form-control" value="<?php echo $row['freezelife'];  ?>">
                                            <div class="invalid-tooltip">
                                                Please fill the field
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip07">Storage Condition</label>
                                        <select name="chiller" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="Chilled" <?php echo (isset($row['chiller']) && $row['chiller'] == 'Chilled') ? 'selected' : ''; ?>>Chilled</option>
                                            <option value="Ambient" <?php echo (isset($row['chiller']) && $row['chiller'] == 'Ambient') ? 'selected' : ''; ?>>Ambient</option>
                                            <option value="Frozen" <?php echo (isset($row['chiller']) && $row['chiller'] == 'Frozen') ? 'selected' : ''; ?>>Frozen</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please fill the field
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Shelf Life</label>

                                        <input type="text" name="shelflife" class="form-control" value="<?php echo $row['shelflife']; ?>">


                                        <div class="invalid-tooltip">
                                            Please fill the field
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Once Opened Shelf Life</label>
                                        <input type="text" name="openlife" class="form-control" value="<?php if (isset($row['onceshelf'])) {
                                                                                                            echo $row['onceshelf'];
                                                                                                        } ?>">



                                        <div class="invalid-tooltip">
                                            Please fill the field

                                        </div>
                                    </div>
                                </div>

                            </div>




                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is there any claim? </label>
                                <select name="pclaim" class="form-control" onchange="showreviw(this.value)" required>
                                    <option value="<?php echo $row['pclaim']; ?>"><?php echo $row['pclaim']; ?></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09 text-primary">Country of Origin</label>
                                <input type="text" name="origin" id="" class="form-control" value="<?php echo $row['origin']; ?>" required>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

                            <script>
                                function showreviw(qn) {

                                    rvw = document.getElementById("reviewed");
                                    if (qn == "Yes") {
                                        rvw.classList.remove('hidden');
                                    } else {
                                        rvw.classList.add('hidden');
                                    }
                                }
                            </script>



                            <div class="col-md-12 mb-3 ">
                                <div class="<?php if ($row['pclaim'] == 'No') {
                                                echo 'hidden';
                                            } ?>" id="reviewed">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip09" class="text-danger">* Please Specify the Claim ? </label>

                                            <textarea name="specify" class="form-control" placeholder="Please Specify"></textarea>


                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip09">Upload the relevant claim certification</label>
                                            <input type="file" name="claimcert" id="" class="form-control">


                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>


                                    </div>


                                </div>

                            </div>
















                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is the product purchased from manufacturer?</label>
                                <select name="propurchase" class="form-control" onchange="showManufacturerFields(this.value)" >
                                    <option value="">Select</option>
                                    <option value="Yes" <?php if ($row['purchase'] == 'Yes') {
                                                            echo 'selected';
                                                        } ?>>Yes</option>
                                    <option value="No" <?php if ($row['purchase'] == 'No') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>
                            <script>
                                function showManufacturerFields(value) {
                                    const countField = document.getElementById("manufacturer-count");
                                    const container = document.getElementById("manufacturer-fields-container");

                                    if (value === "No") {
                                        countField.classList.remove('hidden');
                                        generateManufacturerFields(1); // Default to 1 manufacturer
                                    } else {
                                        countField.classList.add('hidden');
                                        container.innerHTML = ''; // Clear all manufacturer fields
                                    }
                                }
                            </script>

                            <div class="col-md-6 mb-3 <?php if ($row['purchase'] == 'Yes') {
                                                            echo 'hidden';
                                                        } ?>" id="manufacturer-count">
                                <label for="manufacturer-qty" class="text-danger">* Number of Manufacturers</label>
                                <input type="number" class="form-control" id="manufacturer-qty" name="manno" value="<?php echo $row['manfact']; ?>">
                                <button class="btn btn-primary my-2" type="button" id="other_task" onclick="addInput()">Add Manfacture Details</button>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row py-2">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6" id="other_task_div">

                                        <?php
                                        if ($row['purchase'] == 'No') {
                                            $mname = explode(';', $row['manuf_name']);
                                            $maddr = explode(';', $row['manuf_address']);
                                            $mloc = explode('#', $row['manuf_location']);
                                            $i = 1;
                                            foreach ($mname as $key => $value) {
                                        ?>
                                                <div class="d-flex flex-column border p-3 my-2 position-relative ">
                                                    <input type="text" name="manuf_name[]" class="form-control my-3 mt-4" value="<?php echo $value; ?>">
                                                    <input type="text" name="manuf_address[]" class="form-control my-3 mt-2" value="<?php echo $maddr[$key]; ?>">
                                                <textarea name="manuf_location[]" class="form-control my-3 mt-2"><?php echo $mloc[$key]; ?></textarea> 
                                                    <button class="btn btn-danger btn-sm mt-2 align-self-end">Delete</button>

                                                </div>

                                        <?php }
                                        } ?>
                                    </div>



                                </div>
                                <script>
                                    // Attach delete handler to static buttons once DOM is loaded
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelectorAll('#other_task_div .btn-danger').forEach(function(button) {
                                            button.addEventListener('click', function() {
                                                const inputGroup = this.closest('.d-flex');
                                                inputGroup.remove();
                                            });
                                        });
                                    });
                                </script>


                            </div>

                            <script>
                                function addInput() {
                                    var div = document.getElementById("other_task_div");

                                    // Create a wrapper div for the input set
                                    var inputGroup = document.createElement("div");
                                    inputGroup.className = "d-flex flex-column border p-3 my-2 position-relative";

                                    // Name input
                                    var input = document.createElement("input");
                                    input.type = "text";
                                    input.placeholder = "Name";
                                    input.name = "manuf_name[]";
                                    input.className = "form-control mb-2";
                                    inputGroup.appendChild(input);

                                    // Address input
                                    var addrInput = document.createElement("input");
                                    addrInput.type = "text";
                                    addrInput.placeholder = "Address";
                                    addrInput.name = "manuf_address[]";
                                    addrInput.className = "form-control mb-2";
                                    inputGroup.appendChild(addrInput);

                                    // Location input
                                    var locInput = document.createElement("textarea");
                                    locInput.type = "text";
                                    locInput.placeholder = "Location";
                                    locInput.name = "manuf_location[]";
                                    locInput.className = "form-control mb-2";
                                    inputGroup.appendChild(locInput);

                                    // Delete button
                                    var deleteBtn = document.createElement("button");
                                    deleteBtn.type = "button";
                                    deleteBtn.className = "btn btn-danger btn-sm mt-2 align-self-end";
                                    deleteBtn.textContent = "Delete";
                                    deleteBtn.onclick = function() {
                                        div.removeChild(inputGroup);
                                    };
                                    inputGroup.appendChild(deleteBtn);

                                    // Add the entire input set to the main div
                                    div.appendChild(inputGroup);
                                }
                            </script>

                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is the Chain of Custody applicable? </label>
                                <select name="custody" class="form-control" onchange="custshowreviw(this.value)">
                                    <option value="<?php echo $row['custody']; ?>"><?php echo $row['custody'];  ?> </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>



                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>

                            <script>
                                function custshowreviw(cqn) {

                                    crvw = document.getElementById("ccust");
                                    if (cqn == "Yes") {
                                        crvw.classList.remove('hidden');
                                    } else {
                                        crvw.classList.add('hidden');
                                    }
                                }
                            </script>



                            <div class="col-md-6 mb-3 ">
                                <div class="<?php if ($row['custody'] == 'Yes') {
                                                echo '';
                                            } else {
                                                echo 'hidden';
                                            };  ?> " id="ccust">
                                    <label for="validationTooltip09" class="text-danger">* Please Specify the Claim ? </label>

                                    <textarea name="cspecify" class="form-control" placeholder="Please Specify"><?php echo $row['chainspecify']; ?></textarea>


                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-12">
                                <div id="migrate" class="<?php if ($row['category'] = 'Raw Material') {
                                                                echo 'hidden';
                                                            } else {
                                                                echo '';
                                                            } ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-3" id="packagingMigrationSelect">
                                            <label for="validationTooltip09">Is Packaging migration certificate available:</label>
                                            <select name="packaging_migration" class="form-control" onchange="toggleMigrationFields(this.value)">
                                                <option value="<?php echo $row['packaging_migration']; ?>"><?php echo $row['packaging_migration']; ?></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please fill the field
                                            </div>
                                        </div>
                                        <script>
                                            function toggleMigrationFields(value) {

                                                const migrationFields = document.getElementById("migrationFields");


                                                // Only show if "Yes" is selected AND category is Primary Packaging
                                                if (value === "Yes") {
                                                    migrationFields.classList.remove('hidden');
                                                } else {
                                                    migrationFields.classList.add('hidden');

                                                }
                                            }
                                        </script>
                                        <div class="col-md-6">

                                            <div id="migrationFields" class="<?php if ($row['packaging_migration'] == 'No') {
                                                                                    echo 'hidden';
                                                                                }; ?>">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="migration_date" class="text-danger">* Please Specify the Date</label>
                                                        <input type="date" name="migration_date" id="migration_date" class="form-control" value="<?php echo $row['migration_date']; ?>">
                                                        <div class="invalid-tooltip">
                                                            Please fill the field
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="migration_certificate" class="text-danger">* Upload the certificate</label> <?php if (!empty($row['migration_certification'])) {
                                                                                                                                                ?>
                                                            <a href="img/<?php echo $row['migration_certification']; ?>" target="_blank" rel="noopener noreferrer">View file</a>
                                                        <?php
                                                                                                                                                } ?>
                                                        <input type="file" name="migration_certificate" id="migration_certificate" class="form-control" accept=".pdf,.jpg,.png">
                                                        <div class="invalid-tooltip">
                                                            Please fill the field
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>



                                    </div>



                                </div>

                            </div>



                        </div>
                        <button class="btn btn-primary" type="submit" name="submit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {

    $category =  $_POST['category'];
    $pcode =  $_POST['pcode'];
    $pname =  $_POST['pname'];
    $supid =  $_POST['supname'];

    $pspecdate =  $_POST['prospecdate'];


    if ($category == 'Raw Material') {
        $chiller =  $_POST['chiller'];
        $shelflife = $_POST['shelflife'];
        $onceopen = $_POST['openlife'];
        $freeze = $_POST['freeze'];
        $freeze_life = ($freeze == 'Yes') ?  $_POST['frozenlife'] : '';

        $pmigrate = '';
        $cmigrate = '';
        $dmigrate = '';
    } else {
        $pmigrate = $_POST['packaging_migration'];
        if ($pmigrate == 'Yes') {
            $dmigrate = $_POST['migration_date'];

            if (!empty($_FILES['migration_certificate']['name'])) {
                $cmigrate = "migrate_c" . $_FILES['migration_certificate']['name'];
                if (!is_dir('img')) {
                    mkdir('img', 0777, true);
                }
                move_uploaded_file($_FILES['claimcert']['tmp_name'], "img/" . $cmigrate);
            } else {
                $cmigrate = $row['migration_certification'];
            }
        } else {
            $cmigrate = '';
            $dmigrate = '';
        }

        $chiller =  '';
        $shelflife = '';
        $onceopen = '';
        $freeze = '';
        $freeze_life = '';
        $manfacture = '';
    }
    $country = $_POST['origin'];
    $pclaim =  $_POST['pclaim'];
    $specify = ($pclaim == 'Yes') ?  $_POST['specify'] : '';

    $propurchase =  isset($_POST['propurchase']) ? $_POST['propurchase'] : $row['purchase'];


    if ($propurchase == 'No') {

        $manfname =  $_POST['manuf_name'];
        $manftname = implode(';', $manfname);

        $manfacture = $_POST['manno'];

        $manfadress = $_POST['manuf_address'];
        $manftadress = implode(';', $manfadress);

        $manfloc = $_POST['manuf_location'];
        $manftloc = implode('#', $manfloc);
    } else {
        $manftname = $row['manuf_name'];
        $manftadress = $row['manuf_address'];
        $manftloc =  $row['manuf_location'];
        $manfacture =  $row['manfact'];
    }


    $custody =  $_POST['custody'];
    $cspecify = ($custody == 'Yes') ?  $_POST['cspecify'] : '';

    // Handle file uploads
    $pic = '';
    if (!empty($_FILES['pic']['name'])) {
        $pic = $_FILES['pic']['name'];
        if (!is_dir('img')) {
            mkdir('img', 0777, true);
        }
        move_uploaded_file($_FILES['pic']['tmp_name'], "img/" . $pic);
    } else {
        $pic = $row['pic'];
    }

    $ccertificate = '';
    if (!empty($_FILES['claimcert']['name'])) {
        $ccertificate = "claim_c" . $_FILES['claimcert']['name'];
        if (!is_dir('img')) {
            mkdir('img', 0777, true);
        }
        move_uploaded_file($_FILES['claimcert']['tmp_name'], "img/" . $ccertificate);
    } else {
        $ccertificate = $row['cclaim'];
    }




    $updateQuery = "UPDATE tblrawmaterial SET category='$category', pcode='$pcode',
     pname='$pname', pic='$pic', supid='$supid', chiller='$chiller', shelflife='$shelflife', 
    cclaim='$ccertificate', specdate='$pspecdate',`custody` ='$custody', 
    `chainspecify` ='$cspecify ',origin='$country', pclaim='$pclaim', claimspecify='$specify',
    freeze='$freeze', freezelife='$freeze_life',purchase='$propurchase', manfact='$manfacture',
     `custody` = '$custody', `chainspecify` = '$cspecify',`onceshelf`= '$onceopen', `migration_date`= '$dmigrate', `migration_certification`= '$cmigrate', 
         `manuf_name`= '$manftname', `manuf_address`= '$manftadress', `manuf_location`='$manftloc', `packaging_migration`= '$pmigrate'
     WHERE id=$get";

    // print_r($updateQuery);die;
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Raw material updated successfully'); window.location.href='admin.php?id=addrawmaterial';</script>";
    } else {
        echo "<script>alert('Error updating raw material: " . mysqli_error($con) . "');</script>";
    }

    mysqli_close($con);
}
?>
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
    </style>
  
    <div class="container-fluid" style="margin-top:50px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title ml-1">Raw material</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip07"> Category</label>
                                <select name="category" class="form-control" required onchange="categraw(this.value)">
                                    <option value="">Please Select</option>
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
                                <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                    required="required" name="pcode" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">Product name</label>
                                <input name="pname" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Image</label>
                                <input class="form-control" id="validationTooltip04" type="file" placeholder=""
                                    name="pic" accept="image/jpeg,jpg" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                        </div>
                        <div class="form-row">

                            <?php
                            $query = "select * from  `tblrawsupplier`";
                            // $query1="select * from  `basicinfo`";
                            $result = mysqli_query($con, $query);

                            ?>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">Supplier name</label>
                                <select class="form-control" id="validationTooltip02"
                                    name="supname" required>
                                    <option value="">Select Supplier</option>
                                    <?php while ($row4 = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?php echo $row4['supid']; ?>"><?php echo $row4['supname']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Product Specification Date</label>
                                <input type="date" name="prospecdate" id="" class="form-control">


                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <label for="validationTooltip06">ingredients</label>
                                <input name="ingredients" type="text" class="form-control" id="validationTooltip06"
                                    placeholder="" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div> -->


                            <!-- // only raw Start-->


                            <div class='col-md-12 hidden' id="rawm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Shelf Life</label>
                                        <input type="text" name="shelflife" class="form-control">



                                        <div class="invalid-tooltip">
                                            Please fill the field

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Once Opened Shelf Life</label>
                                        <input type="text" name="openlife" class="form-control">



                                        <div class="invalid-tooltip">
                                            Please fill the field

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip07">Storage Condition</label>


                                        <select name="chiller" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="Chilled">Chilled</option>
                                            <option value="Ambient">Ambient</option>
                                            <option value="Frozen">Frozen</option>
                                        </select>

                                        </select>

                                        <div class="invalid-tooltip">
                                            Please fill the field

                                        </div>
                                    </div>






                                    <div class="col-md-6"></div>

                                    <div class="col-md-6 mb-3">
                                        <label for="validationTooltip09">Is product suitable for freezing?</label>
                                        <select name="freeze" class="form-control" onchange="showfreeze(this.value)">
                                            <option>Please Select</option>
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
                                        <div class="hidden" id="freeze">

                                            <label for="validationTooltip09 text-primary" class="text-danger">* What will be the frozen shelf life?</label>
                                            <input type="text" name="frozenlife" id="" class="form-control">


                                            <div class="invalid-tooltip">
                                                Please fill the field

                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>

                            <!-- // only raw end -->







                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is there any claim? </label>
                                <select name="pclaim" class="form-control" onchange="showreviw(this.value)" required>
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>



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
                                <div class="hidden" id="reviewed">
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
                                <label for="validationTooltip09 text-primary">Country of Origin</label>
                                <input type="text" name="origin" id="" class="form-control" required>


                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>





                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is the product purchased from manufacturer?</label>
                                <select name="propurchase" class="form-control" onchange="showManufacturerFields(this.value)" required>
                                    <option value=" ">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
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


                            <div class="col-md-6 mb-3 hidden" id="manufacturer-count">

                                <label for="manufacturer-qty" class="text-danger">* Number of Manufacturers</label>
                                <input type="number" class="form-control" id="manufacturer-qty" name="manno">
                                <button class="btn btn-primary my-2" type="button" id="other_task" onclick="addInput()">Add Manfacture Details</button>
                            </div>



                            <div class="col-md-12">
                                <div class="form-row py-2">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6" id="other_task_div">
                                    </div>
                                </div>

                            </div>

                            <script>
                                function addInput() {
                                    var div = document.getElementById("other_task_div");

                                    // Create a wrapper div for the input set
                                    var inputGroup = document.createElement("div");
                                    inputGroup.className = "d-flex flex-column border p-3 my-2 position-relative col-md-6";

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
                                <select name="custody" class="form-control" onchange="showreviwcus(this.value)">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>



                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>

                            <script>
                                function showreviwcus(cqn) {

                                    crvw = document.getElementById("ccust");
                                    if (cqn == "Yes") {
                                        crvw.classList.remove('hidden');
                                    } else {
                                        crvw.classList.add('hidden');
                                    }
                                }
                            </script>



                            <div class="col-md-6 mb-3 ">
                                <div class="hidden" id="ccust">
                                    <label for="validationTooltip09" class="text-danger">* Please Specify? </label>

                                    <textarea name="cspecify" class="form-control" placeholder="Please Specify"></textarea>


                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12">
                                <div id="migrate" class="hidden">
                                    <div class="row">
                                        <div class="col-md-6 mb-3" id="packagingMigrationSelect">
                                            <label for="validationTooltip09">Is Packaging migration certificate available:</label>
                                            <select name="packaging_migration" class="form-control" onchange="toggleMigrationFields(this.value)">
                                                <option value="">Please Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please fill the field
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div id="migrationFields" class="hidden">
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="migration_date" class="text-danger">* Please Specify the Date</label>
                                                        <input type="date" name="migration_date" id="migration_date" class="form-control">
                                                        <div class="invalid-tooltip">
                                                            Please fill the field
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="migration_certificate" class="text-danger">* Upload the certificate</label>
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



                            <script>
                                function toggleMigrationFields(value) {

                                    const migrationFields = document.getElementById("migrationFields");


                                    // Only show if "Yes" is selected AND category is Primary Packaging
                                    if (value === "Yes") {
                                        migrationFields.classList.remove('hidden');;
                                    } else {
                                        migrationFields.classList.add('hidden');

                                    }
                                }
                            </script>
                            <br>
                            <button class="btn btn-primary"
                                type="submit"
                                name="submit"> Submit </button>
                        </div>
                    </form>
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

        $propurchase =  $_POST['propurchase'];
        if ($propurchase == 'No') {

            $manfname =  $_POST['manuf_name'];
            $manftname = implode(';', $manfname);
            $manfacture = $_POST['manno'];

            $manfadress = $_POST['manuf_name'];
            $manftadress = implode(';', $manfadress);

            $manfloc = $_POST['manuf_location'];
            $manftloc = implode('#', $manfloc);
        } else {
            $manftname = '';
            $manftadress = '';
            $manftloc = '';
            $manfacture = '';
        }

        $manfact = $_POST['manno'];
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
        }

        $ccertificate = '';
        if (!empty($_FILES['claimcert']['name'])) {
            $ccertificate = "claim_c" . $_FILES['claimcert']['name'];
            if (!is_dir('img')) {
                mkdir('img', 0777, true);
            }
            move_uploaded_file($_FILES['claimcert']['tmp_name'], "img/" . $ccertificate);
        }


        $query = "INSERT INTO `tblrawmaterial`(`category`, `pcode`, `pname`, `pic`, `supid`, `chiller`, `shelflife`, `cclaim`,
         `specdate`, `origin`, `pclaim`, `claimspecify`, `freeze`, `freezelife`, `purchase`,
         `custody`, `chainspecify`,`onceshelf`, `migration_date`, `migration_certification`, 
         `manuf_name`, `manuf_address`, `manuf_location`, `packaging_migration`,manfact)
        VALUES
        ('$category', '$pcode', '$pname', '$pic', '$supid', '$chiller', '$shelflife', '$ccertificate', 
        '$pspecdate', '$country', '$pclaim', '$specify', '$freeze', '$freeze_life', '$propurchase', 
        '$custody', '$cspecify', '$onceopen', '$dmigrate', '$cmigrate', '$manftname', '$manftadress', '$manftloc', '$pmigrate','$manfacture')";
        // print_r($query);die;
        $result = mysqli_query($con, $query);
        if ($result) {
            echo "<script>document.location.href='admin.php?id=addrawmaterial'</script>";
        } else {
            echo "<script>alert('Data not submitted successfully');</script>";
            echo 'SQL Error: ' . mysqli_error($con);
        }
    }
    ?>
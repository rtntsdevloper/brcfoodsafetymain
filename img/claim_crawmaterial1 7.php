

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
    <?php

    ?>
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
                                <select name="category" class="form-control" required onchange="this.form.submit()">
                                    <option value="">Please Select</option>
                                    <option value="Raw Material" <?= (isset($_POST['category'])) && $_POST['category'] == 'Raw Material' ? 'selected' : '' ?>>Raw Material</option>
                                    <option value="Primary Packaging" <?= (isset($_POST['category'])) && $_POST['category'] == 'Primary Packaging' ? 'selected' : '' ?>>Primary Packaging</option>
                                    <option value="Secondary Packaging" <?= (isset($_POST['category'])) && $_POST['category'] == 'Secondary Packaging' ? 'selected' : '' ?>>Secondary Packaging</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

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
                            <!-- <div class="col-md-6 mb-3">
                                <label for="validationTooltip06">ingredients</label>
                                <input name="ingredients" type="text" class="form-control" id="validationTooltip06"
                                    placeholder="" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div> -->
                            <div class="col-md-6 mb-3" id="storageConditionContainer">
                                <label for="validationTooltip07">Storage Condition</label>
                                <select name="chiller" id="storageCondition" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <option value="Chilled">Chilled</option>
                                    <option value="Ambient">Ambient</option>
                                    <option value="Frozen">Frozen</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

                            <script>
                                // Get references to the elements
                                const categorySelect = document.querySelector('[name="category"]');
                                const storageConditionContainer = document.getElementById('storageConditionContainer');
                                const storageConditionSelect = document.getElementById('storageCondition');

                                // Function to toggle storage condition field visibility
                                function toggleStorageCondition() {
                                    if (categorySelect.value === 'Primary Packaging') {
                                        storageConditionContainer.classList.add('hidden');
                                        storageConditionSelect.value = ''; // Clear selection
                                        storageConditionSelect.required = false; // Remove required when hidden
                                    } else {
                                        storageConditionContainer.classList.remove('hidden');
                                        storageConditionSelect.required = true; // Add required when visible
                                    }
                                }

                                // Initial check on page load
                                toggleStorageCondition();

                                // Add event listener for category changes
                                categorySelect.addEventListener('change', function() {
                                    toggleStorageCondition();

                                    // If you have the auto-submit on change, you might need to manually submit
                                    if (this.hasAttribute('onchange')) {
                                        this.form.submit();
                                    }
                                });
                            </script>
                            <div class="col-md-6 mb-3" id="shelfLifeContainer">
                                <label for="validationTooltip09">Shelf Life</label>
                                <select name="shelflife" id="shelfLifeSelect" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="N/A">No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Get the category dropdown (assuming it has name="category")
                                    const categorySelect = document.querySelector('[name="category"]');
                                    const shelfLifeContainer = document.getElementById('shelfLifeContainer');
                                    const shelfLifeSelect = document.getElementById('shelfLifeSelect');

                                    // Function to update shelf life field visibility
                                    function updateShelfLifeField() {
                                        if (categorySelect.value === 'Primary Packaging') {
                                            shelfLifeContainer.classList.add('hidden');
                                            shelfLifeSelect.value = '';
                                        } else {
                                            shelfLifeContainer.classList.remove('hidden');
                                            // Reset to default if it was previously hidden by Primary Packaging
                                            if (shelfLifeSelect.value === '') {
                                                shelfLifeSelect.value = '';
                                            }
                                        }
                                    }

                                    // Initial check on page load
                                    updateShelfLifeField();

                                    // Update when category changes
                                    if (categorySelect) {
                                        categorySelect.addEventListener('change', updateShelfLifeField);
                                    }

                                    // If your category select auto-submits, we need to handle page reload
                                    if (categorySelect && categorySelect.hasAttribute('onchange')) {
                                        // Store the visibility state in localStorage before submit
                                        categorySelect.form.addEventListener('submit', function() {
                                            localStorage.setItem('shelfLifeHidden', categorySelect.value === 'Primary Packaging');
                                        });

                                        // Check localStorage on page load
                                        if (localStorage.getItem('shelfLifeHidden') === 'true') {
                                            shelfLifeContainer.classList.add('hidden');
                                            shelfLifeSelect.value = '';
                                            localStorage.removeItem('shelfLifeHidden');
                                        }
                                    }
                                });
                            </script>




                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Product Specification Date</label>
                                <input type="date" name="prospecdate" id="" class="form-control">


                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Review Date</label>
                                <input type="date" name="reviewdate" id="" class="form-control">


                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>
                            <div class="col-md-6"></div>

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



                            <div class="col-md-6 mb-3 ">
                                <div class="hidden" id="reviewed">
                                    <label for="validationTooltip09" class="text-danger">* Please Specify the Claim ? </label>

                                    <textarea name="specify" class="form-control" placeholder="Please Specify"></textarea>


                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>

                                </div>

                            </div>




                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Upload the relevant claim certification</label>
                                <input type="file" name="claimcert" id="" class="form-control">


                                <div class="invalid-tooltip">
                                    Please fill the field

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




                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is the product purchased from manufacturer?</label>
                                <select name="propurchase" class="form-control" onchange="showManufacturerFields(this.value)" required>
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 hidden" id="manufacturer-count">
                                <label for="manufacturer-qty" class="text-danger">* Number of Manufacturers</label>
                                <input type="number" class="form-control" id="manufacturer-qty" min="1" value="1"
                                    onchange="generateManufacturerFields(this.value)" oninput="generateManufacturerFields(this.value)">
                            </div>

                            <div id="manufacturer-fields-container" class="col-md-12"></div>

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

                                function generateManufacturerFields(qty) {
                                    const container = document.getElementById("manufacturer-fields-container");
                                    container.innerHTML = ''; // Clear previous fields

                                    if (!qty || qty < 1) {
                                        qty = 1; // Default to 1 if invalid value
                                        document.getElementById("manufacturer-qty").value = 1;
                                    }

                                    for (let i = 1; i <= qty; i++) {
                                        const fieldGroup = document.createElement('div');
                                        fieldGroup.className = 'manufacturer-group mb-4 p-3 border rounded';
                                        fieldGroup.innerHTML = `
            <h5 class="text-primary">Manufacturer ${i}</h5>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="manuf_name_${i}" class="text-danger">* Name</label>
                    <input type="text" name="manuf_name_${i}" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="manuf_address_${i}" class="text-danger">* Address</label>
                    <input type="text" name="manuf_address_${i}" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="manuf_location_${i}" class="text-danger">* Location</label>
                    <input type="text" name="manuf_location_${i}" class="form-control" required>
                </div>
            </div>
        `;
                                        container.appendChild(fieldGroup);
                                    }
                                }
                            </script>

                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip09">Is the Chain of Custody applicable? </label>
                                <select name="custody" class="form-control" onchange="showreviw(this.value)">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>



                                <div class="invalid-tooltip">
                                    Please fill the field

                                </div>
                            </div>

                            <script>
                                function showreviw(cqn) {

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
                                    <label for="validationTooltip09" class="text-danger">* Please Specify the Claim ? </label>

                                    <textarea name="cspecify" class="form-control" placeholder="Please Specify"></textarea>


                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6 mb-3 ">
                                <div class="" id="ccust">
                                    <label for="validationTooltip09" class="">Upload the relevant Document </label>
                                    <input type="file" class="form-control" name="upload_file" value="nothing" accept=".jpg, .png, .dox, .docx, .pdf">
                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>

                                </div>

                            </div>



                            <div class="col-md-6 mb-3" id="packagingMigrationSelect">
                                <label for="validationTooltip09" >If Packaging migration certificate available:</label>
                                <select name="packaging_migration" class="form-control" onchange="toggleMigrationFields(this.value)" >
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field
                                </div>
                            </div>
                            <div id="migrationFields" class="hidden">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="migration_date" class="text-danger">* Please Specify the Date</label>
                                        <input type="date" name="migration_date" id="migration_date" class="form-control">
                                        <div class="invalid-tooltip">
                                            Please fill the field
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="migration_certificate" class="text-danger">* Upload the certificate</label>
                                        <input type="file" name="migration_certificate" id="migration_certificate" class="form-control" accept=".pdf,.jpg,.png">
                                        <div class="invalid-tooltip">
                                            Please fill the field
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-6 mb-3" id="packagingMigrationSelect">
                                <label for="validationTooltip02">Once Opened Shelf Life</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                    required="required" name="onceshelf" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>

                            <script>
                                function toggleMigrationFields(value) {
                                     const countField = document.getElementById("hidden");
                                    const migrationFields = document.getElementById("migrationFields");
                                    const categorySelect = document.querySelector('[name="category"]');
                                    const packagingMigrationSelect = document.getElementById('packagingMigrationSelect');

                                    // Only show if "Yes" is selected AND category is Primary Packaging
                                    if (value === "Yes" && categorySelect.value === 'Primary Packaging') {
                                        migrationFields.classList.remove('hidden');
                                        // Make fields required
                                        document.getElementById('migration_date').required = true;
                                        document.getElementById('migration_certificate').required = true;
                                    } else {
                                        migrationFields.classList.add('hidden');
                                        // Remove required attribute if hidden
                                        document.getElementById('migration_date').required = false;
                                        document.getElementById('migration_certificate').required = false;
                                    }
                                }

                                // Also trigger when category changes
                                document.querySelector('[name="category"]').addEventListener('change', function() {
                                    const packagingMigrationSelect = document.getElementById('packagingMigrationSelect');
                                    // Reset migration fields when category changes
                                    packagingMigrationSelect.value = '';
                                    toggleMigrationFields('');

                                    // Disable migration select if not Primary Packaging
                                    if (this.value === 'Primary Packaging') {
                                        packagingMigrationSelect.hidden = false;
                                    } else {
                                        packagingMigrationSelect.hidden = true;
                                        packagingMigrationSelect.value = '';
                                        toggleMigrationFields('');
                                    }
                                });

                                // Initialize on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    const categorySelect = document.querySelector('[name="category"]');
                                    const packagingMigrationSelect = document.getElementById('packagingMigrationSelect');

                                    if (categorySelect.value !== 'Primary Packaging') {
                                        packagingMigrationSelect.hidden = true;
                                    }
                                });
                            </script>

                             



                        </div>
                </div>

                <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

if (isset($_POST['submit'])) {
    // Process all fields with proper isset checks
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $pcode = isset($_POST['pcode']) ? $_POST['pcode'] : '';
    $pname = isset($_POST['pname']) ? $_POST['pname'] : '';
    $supid = isset($_POST['supname']) ? $_POST['supname'] : '';
    $chiller = isset($_POST['chiller']) ? $_POST['chiller'] : '';
    $pspecdate = isset($_POST['prospecdate']) ? $_POST['prospecdate'] : '';
    $reviewdate = isset($_POST['reviewdate']) ? $_POST['reviewdate'] : '';
    $country = isset($_POST['origin']) ? $_POST['origin'] : '';
    $pclaim = isset($_POST['pclaim']) ? $_POST['pclaim'] : '';
    $specify = ($pclaim == 'Yes' && isset($_POST['specify'])) ? $_POST['specify'] : '';
    $freeze = isset($_POST['freeze']) ? $_POST['freeze'] : '';
    $freeze_life = ($freeze == 'Yes' && isset($_POST['frozenlife'])) ? $_POST['frozenlife'] : '';
    $propurchase = isset($_POST['propurchase']) ? $_POST['propurchase'] : '';
    $shelflife = isset($_POST['shelflife']) ? $_POST['shelflife'] : '';
    $custody = isset($_POST['custody']) ? $_POST['custody'] : '';
    $cspecify = ($custody == 'Yes' && isset($_POST['cspecify'])) ? $_POST['cspecify'] : '';
    $onceopen = isset($_POST['onceshelf']) ? $_POST['onceshelf'] : '';

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

    $upload_file = '';
    if (!empty($_FILES['upload_file']['name'])) {
        $upload_file = $_FILES['upload_file']['name'];
        if (!is_dir('img')) {
            mkdir('img', 0777, true);
        }
        move_uploaded_file($_FILES['upload_file']['tmp_name'], "img/" . $upload_file);
    }

    // Handle packaging migration fields (only for Primary Packaging)
    $packaging_migration = ($category === 'Primary Packaging' && isset($_POST['packaging_migration'])) ? $_POST['packaging_migration'] : 'N/A';
    $migration_date = ($packaging_migration == 'Yes' && isset($_POST['migration_date'])) ? $_POST['migration_date'] : '';
    $migration_certificate = '';

    if ($packaging_migration == 'Yes' && !empty($_FILES['migration_certificate']['name'])) {
        $migration_certificate = "migration_" . $_FILES['migration_certificate']['name'];
        if (!is_dir('img')) {
            mkdir('img', 0777, true);
        }
        move_uploaded_file($_FILES['migration_certificate']['tmp_name'], "img/" . $migration_certificate);
    }

    // Process manufacturer data if product is not purchased directly from manufacturer
    $manufacturers = [];
    if ($propurchase == 'No') {
        // Get the number of manufacturers from the form
        $manufacturer_count = isset($_POST['manufacturer-qty']) ? (int)$_POST['manufacturer-qty'] : 1;
        
        // Collect all manufacturer data
        for ($i = 1; $i <= $manufacturer_count; $i++) {
            if (isset($_POST["manuf_name_$i"]) && isset($_POST["manuf_address_$i"]) && isset($_POST["manuf_location_$i"])) {
                $manufacturers[] = [
                    'name' => $_POST["manuf_name_$i"],
                    'address' => $_POST["manuf_address_$i"],
                    'location' => $_POST["manuf_location_$i"]
                ];
            }
        }
    }

   $query = "INSERT INTO `tblrawmaterial1`
(`category`, `pcode`, `pname`, `pic`, `supid`, `chiller`, `shelflife`, `cclaim`, `specdate`, `reviewdate`, `origin`, `pclaim`, `claimspecify`, `freeze`, `freezelife`, `purchase`, `custody`, `chainspecify`, `upload_file`, `packaging_migration`, `migration_date`, `migration_certificate`, `onceshelf`)  
VALUES
('$category', '$pcode', '$pname', '$pic', '$supid', '$chiller', '$shelflife', '$ccertificate', '$pspecdate', '$reviewdate', '$country', '$pclaim', '$specify', '$freeze', '$freeze_life', '$propurchase', '$custody', '$cspecify', '$upload_file', '$packaging_migration', '$migration_date', '$migration_certificate', '$onceopen')";
    
    // Execute the query
    $result = mysqli_query($con, $query);
    
    if ($result) {
        // Get the ID of the inserted record
        $rawmaterial_id = mysqli_insert_id($con);
        
        // Insert manufacturer data if applicable
        if ($propurchase == 'No' && !empty($manufacturers)) {
            foreach ($manufacturers as $manufacturer) {
                $manuf_query = "INSERT INTO tblrawmaterial_manufacturers 
                                (rawmaterial_id, name, address, location) 
                                VALUES ('$rawmaterial_id', '".mysqli_real_escape_string($con, $manufacturer['name'])."', 
                                '".mysqli_real_escape_string($con, $manufacturer['address'])."', 
                                '".mysqli_real_escape_string($con, $manufacturer['location'])."')";
                mysqli_query($con, $manuf_query);
            }
        }
        
        $_SESSION['message'] = "Raw material added successfully!";

        exit();
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($con);
       
        exit();
    }
}
?>





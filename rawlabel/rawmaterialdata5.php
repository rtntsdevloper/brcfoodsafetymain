<?php
$raw = $_GET['rid'];
$sqxl = mysqli_query($con, "SELECT * FROM `tblrawdata` WHERE id='$raw'");
$rxl = mysqli_fetch_array($sqxl);
if (isset($rxl['pweight'])) {

    $pweight = $rxl['pweight'];
    $pwarray = explode(";", $pweight);
    $pcount = count($pwarray);
} else {
    $pcount = 0;
}

if (isset($rxl['pprice'])) {

    $pprice = $rxl['pprice'];
    $pricearray = explode(";", $pprice);
    $pricecount = count($pricearray);
} else {
    $pricecount = 0;
}


?>


<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Customer Management</a></li>
            <li>Add Customer</li>
        </ul>
    </div>
    <div class="container-fluid" style="margin-top:100px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=rawmaterialdata"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Product Detail </div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Product SKU</label>
                                <input class="form-control" id="validationTooltip01" type="text"
                                    required="required" <?php if (isset($rxl['sku'])) { ?> value="<?php echo $rxl['sku']; ?>" <?php } ?> name="sku" />
                                <div class="invalid-tooltip">
                                    Please provide a valid Customer name.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Price</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                    required="required" name="price" <?php if (isset($rxl['price'])) { ?> value="<?php echo $rxl['price']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Description</label>
                                <textarea name="desc" type="textarea" class="form-control" id="validationTooltip03"
                                    placeholder="" required="required"><?php if (isset($rxl['description'])) {
                                                                            echo $rxl['description'];
                                                                        } ?></textarea>
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>


                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Product Weight</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder="10kg,20kg,30kg"
                                    required="required" name="pweight[]" value="<?php if (isset($pwarray)) {
                                                                                    echo $pwarray[0];
                                                                                } ?>" />
                                <div class="invalid-tooltip">
                                    Please provide a valid weight

                                </div>
                                <button type="button" class="btn btn-primary mt-3" onclick="addInput()">Add
                                    More Weights</button>
                            </div>




                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Product Price</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder="10kg,20kg,30kg"
                                    required="required" name="pprice[]"  value="<?php if (isset($pricearray)) {
                                                                                    echo $pricearray[0];
                                                                                } ?>"/>

                                <div class="invalid-tooltip">
                                    Please provide a valid Price

                                </div>
                            </div>




                            <script>
                                function addInput() {
                                    var div = document.getElementById("other_task_div");
                                    var input = document.createElement("input");
                                    input.type = "text";
                                    input.placeholder = "Product Weight";
                                    input.name = "pweight[]";
                                    input.className = "form-control my-2";
                                    div.appendChild(input);

                                    var div2 = document.getElementById("other_price_div");
                                    var input2 = document.createElement("input");
                                    input2.type = "text";
                                    input2.placeholder = "Product Price";
                                    input2.name = "pprice[]";
                                    input2.className = "form-control my-2";
                                    div2.appendChild(input2); // ✅ fixed: append input2, not input
                                }
                            </script>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Upload Product Image</label>

                                <?php
                                if (isset($rxl['productimg']) && !empty($rxl['productimg'])) {
                                    $prom = $rxl['productimg'];
                                    $promarray = explode(";", $prom);
                                    $rx = 0;
                                    foreach ($promarray as $prom => $pimg) {
                                        $rx = $rx + 1;
                                ?>
                                        <a href="rawlabel/productimg/<?php echo $pimg; ?>">Image <?php echo $rx; ?></a>
                                <?php
                                    }
                                }
                                ?>



                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                <div class="form-text">You can select multiple images (JPG, PNG, GIF)</div>


                            </div>

                        </div>


                        <script>
                            let allFiles = [];
                            let nextId = 0;

                            document.getElementById('images').addEventListener('change', function(e) {
                                if (e.target.files.length > 0) {
                                    const newFile = e.target.files[0];

                                    // Check if file is image
                                    if (newFile.type.startsWith('image/')) {
                                        // Add to our file array with unique ID
                                        allFiles.push({
                                            id: nextId++,
                                            file: newFile
                                        });

                                        // Update preview
                                        updatePreview();
                                    }

                                }
                            });

                            function updatePreview() {
                                const previewContainer = document.getElementById('preview-container');
                                previewContainer.innerHTML = '';

                                allFiles.forEach((fileObj, idx) => {
                                    const reader = new FileReader();

                                    reader.onload = function(event) {
                                        const col = document.createElement('div');
                                        col.className = 'col-md-3 col-sm-4 col-6 mb-2';
                                        col.setAttribute('data-id', fileObj.id);

                                        col.innerHTML = `
                        <div class="card h-100">
                            <img src="${event.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview">
                            <div class="card-body p-2">
                                <small class="text-muted">${fileObj.file.name.substring(0, 15)}${fileObj.file.name.length > 15 ? '...' : ''}</small>
                                <button type="button" class="btn btn-danger btn-sm mt-1 w-100" onclick="removeImage(${fileObj.id})">Remove</button>
                            </div>
                        </div>
                    `;

                                        previewContainer.appendChild(col);
                                    };

                                    reader.readAsDataURL(fileObj.file);
                                });

                                // Update the file input with all files
                                updateFileInput();
                            }

                            function removeImage(id) {
                                allFiles = allFiles.filter(fileObj => fileObj.id !== id);
                                updatePreview();
                            }

                            function updateFileInput() {
                                const input = document.getElementById('images');
                                const dataTransfer = new DataTransfer();

                                allFiles.forEach(fileObj => {
                                    dataTransfer.items.add(fileObj.file);
                                });

                                input.files = dataTransfer.files;
                                input.name = 'images[]';
                            }
                        </script>


 
                        <div class="form-row">
                            <div class="col-md-4" id="other_task_div">
                                <?php
                                if ($pcount > 1) {
                                    for ($i = 1; $i < $pcount; $i++) {
                                ?>
                                        <input class="form-control" id="validationTooltip02" type="text" placeholder="10kg,20kg,30kg"
                                            required="required" name="pweight[]" value="<?php echo $pwarray[$i]; ?>" />
                                <?php
                                    }
                                }
                                ?>



                            </div>
                          <div class="col-md-4" id="other_price_div">
                             <?php
                                if ($pricecount > 1) {
                                    for ($i = 1; $i < $pricecount; $i++) {
                                ?>
                                        <input class="form-control" id="validationTooltip02" type="text" placeholder="10kg,20kg,30kg"
                                            required="required" name="pprice[]" value="<?php echo $pricearray[$i]; ?>" />
                                <?php
                                    }
                                }
                                ?>


                            </div>
                            <div class="col-md-4">
                                <div id="preview-container" class="row g-2"></div>
                            </div>

                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Nutritional Information(Per 100g)</label>


                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Energy</label>
                                <input class="form-control" id="validationTooltip01" type="text"
                                    required="required" name="energy" placeholder="Enter value" <?php if (isset($rxl['energy'])) { ?> value="<?php echo $rxl['energy']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Customer name.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Fat</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder="Enter value"
                                    required="required" name="fat" <?php if (isset($rxl['fat'])) { ?> value="<?php echo $rxl['fat']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">of which saturates</label>
                                <input name="saturates" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['saturates'])) { ?> value="<?php echo $rxl['saturates']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Carbohydrate</label>
                                <input name="carbohydrate" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['carbohydrate'])) { ?> value="<?php echo $rxl['carbohydrate']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">of which sugars</label>
                                <input name="sugars" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['sugars'])) { ?> value="<?php echo $rxl['sugars']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Fibre</label>
                                <input name="fibre" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['fibre'])) { ?> value="<?php echo $rxl['fibre']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Protein</label>
                                <input name="protein" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['protein'])) { ?> value="<?php echo $rxl['protein']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Salt</label>
                                <input name="salt" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" <?php if (isset($rxl['salt'])) { ?> value="<?php echo $rxl['salt']; ?>" <?php } ?> />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Suitability information
                                    <br>Suitable for</label>


                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Halal</label>
                                <select name="halal" id="halal" class="form-control" required>
                                    <option value="yes" <?php if (isset($rxl['halal']) && $rxl['halal'] == 'yes') { ?> selected <?php } ?>>Yes</option>
                                    <option value="no" <?php if (isset($rxl['halal']) && $rxl['halal'] == 'no') { ?> selected <?php } ?>>No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please provide a valid Customer name.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Kosher</label>
                                <select name="kosher" id="kosher" class="form-control" required>
                                    <option value="yes" <?php if (isset($rxl['kosher']) && $rxl['kosher'] == 'yes') { ?> selected <?php } ?>>Yes</option>
                                    <option value="no" <?php if (isset($rxl['kosher']) && $rxl['kosher'] == 'no') { ?> selected <?php } ?>>No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Vegan</label>
                                <select name="vegan" id="vegan" class="form-control" required>
                                    <option value="yes" <?php if (isset($rxl['vegan']) && $rxl['vegan'] == 'yes') { ?> selected <?php } ?>>Yes</option>
                                    <option value="no" <?php if (isset($rxl['vegan']) && $rxl['vegan'] == 'no') { ?> selected <?php } ?>>No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Vegetarian</label>
                                <select name="vegetarian" id="vegetarian" class="form-control" required>
                                    <option value="yes" <?php if (isset($rxl['veg']) && $rxl['veg'] == 'yes') { ?> selected <?php } ?>>Yes</option>
                                    <option value="no" <?php if (isset($rxl['veg']) && $rxl['veg'] == 'no') { ?> selected <?php } ?>>No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>



                        </div>
                        <div class="form-row mt-3">

                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Storage Conditions</label>
                                <input name="storage" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Enter value" required="required" class="form-control"
                                    <?php if (isset($rxl['storage'])) { ?> value="<?php echo $rxl['storage']; ?>" <?php } ?>
                                    required />
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Comment</label>
                                <textarea name="comment" class="form-control">
                                   <?php if (isset($rxl['comment'])) {
                                        echo $rxl['comment'];
                                    } ?>
                               </textarea>
                                <div class="invalid-tooltip">
                                    Please provide a valid Address

                                </div>

                            </div>





                        </div>

                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>




</div>
<?php
if (isset($_POST['submit'])) {

    $raw = $_GET['rid'];
    $sku = $_POST['sku'];
    $price = $_POST['price'];
    $description = $_POST['desc'];
    $energy = $_POST['energy'];
    $fat = $_POST['fat'];
    $saturates = $_POST['saturates'];
    $carbohydrate = $_POST['carbohydrate'];
    $sugars = $_POST['sugars'];
    $fibre = $_POST['fibre'];
    $protein = $_POST['protein'];
    $salt = $_POST['salt'];
    $lastupdate = date('Y-m-d H:i:s');
    $pweight = implode(";", $_POST['pweight']);
    $uploadon = date('Y-m-d H:i:s');
    $user = $_SESSION['user'];
    $pprice = implode(";", $_POST['pprice']);


    $halal = $_POST['halal'];
    $kosher = $_POST['kosher'];
    $vegan = $_POST['vegan'];
    $veg = $_POST['vegetarian'];
    $storage = $_POST['storage'];
    $comment = $_POST['comment'];

    //multiple image
    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        $prodimg = "";
        $uploadDir = "rawlabel/productimg/";

        for ($i = 0; $i < count($files['name']); $i++) {

            $unqkn = date("Ymdhis") . rand(111111, 999999);
            $fileName = $files['name'][$i];
            $fileTmp = $files['tmp_name'][$i];
            $fileError = $files['error'][$i];


            $newFileName = $unqkn . "-" . $fileName;
            $destination = $uploadDir . $newFileName;


            if (move_uploaded_file($fileTmp, $destination)) {
                if (empty($prodimg)) {
                    $prodimg = $newFileName;
                } else {
                    $prodimg .= ";" . $newFileName;
                }
            } else {
                continue;
            }
        }
    } else {
        $prodimg = $rxl['productimg'];
    }

    //


    $sq1 = mysqli_query($con, "UPDATE `tblrawdata` SET `sku`='$sku',`price`='$price',`description`='$description',`energy`='$energy',`fat`='$fat',`saturates`='$saturates',`carbohydrate`='$carbohydrate',`sugars`='$sugars',`fibre`='$fibre',`protein`='$protein',`salt`='$salt',`lastupdate`='$lastupdate'  ,status='done',pweight='$pweight', `productimg`='$prodimg',pprice='$pprice', `halal`='$halal', `vegan`='$vegan', `kosher`='$kosher', `veg`='$veg', `storage`='$storage', `comment`='$comment' WHERE id='$raw'");

    if (!empty($prodimg)) {
        $imgins = mysqli_query($con, "INSERT INTO `tblrawdata1`(`rid`, `type`, `image`, `uploadon`, `user`) VALUES ('$raw','product','$prodimg','$uploadon','$user')");
    }

    if ($sq1) {
        echo '<script>window.location.href="admin.php?id=rawmaterialdata"</script>';
    }
}
?>
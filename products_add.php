<div class="main-content">
    <div class="breadcrumb">

        <ul>
        <li><a href="admin.php?id=1">Home</a></li>
            <li><a href="admin.php?id='products'">Upload Products</a></li>
            <li>Products Add</li>
        </ul>
    </div>
    <div class="container-fluid" style="margin-top:30px;">
        <style>
            label {
                font-size: 16px;
            }
        </style>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=products"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Add Product Details</div>
                    <br><br>
                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Name</label>
                            </div>
                            <div class="col-md-10">
                                <input name="prod" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Code</label>
                            </div>
                            <div class="col-md-10">
                                <input name="prodc" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Description</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="descrip" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Image</label>
                            </div>
                            <div class="col-md-10">
                                <input name="audit" type="file" class="form-control"
                                    placeholder=""  accept=".jpg,.jpeg,.png" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Storage Condition</label>
                            </div>
                            <div class="col-md-10">
                                <input name="strc" type="number" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Ingredients</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="indg" class="form-control" placeholder="" required></textarea>
                                     
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Weight</label>
                            </div>
                            <div class="col-md-10">
                                <input name="weight" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Once Open</label>
                            </div>
                            <div class="col-md-10">
                            <textarea name="open" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Barcode</label>
                            </div>
                            <div class="col-md-10">
                                <input name="brc" type="text" class="form-control"
                                    placeholder=""  />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07"> Product identification Mark</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="indent" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Shelf Life</label>
                            </div>
                            <div class="col-md-10">
                                <input name="shelf" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Minium Shelf Life</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="minshelf" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Color</label>
                            </div>
                            <div class="col-md-10">
                                <input name="clr" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Smell</label>
                            </div>
                            <div class="col-md-10">
                                <input name="sml" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Texture</label>
                            </div>
                            <div class="col-md-10">
                                <input name="tetr" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="validationTooltip07">Product Flavour</label>
                            </div>
                            <div class="col-md-10">
                                <input name="flr" type="text" class="form-control"
                                    placeholder="" required />
                            </div>
                        </div>





                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>


                </div>


                </form>
            </div>
        </div>
    </div>
</div>



<?php

if (isset($_POST['submit'])) {
    $prod = $_POST['prod'];
    $prodc = $_POST['prodc'];
    $descrip = $_POST['descrip'];

    $strc = $_POST['strc'];
    $store = '&le;' .$strc.'&deg;C';
    $indg = $_POST['indg'];
    $weight = $_POST['weight'];
    $shelf = $_POST['shelf'];
    $clr = $_POST['clr'];
    $sml = $_POST['sml'];
    $texture = $_POST['tetr'];
    $flavour = $_POST['flr'];
    $brc = $_POST['brc'];
    $minshelf = $_POST['minshelf'];
    $identmark = $_POST['indent'];
    $open = $_POST['open'];

    $nk = mysqli_query($con, "SELECT * FROM `tblproduct1`");
    $nkn = mysqli_num_rows($nk);
    $nknn= $nkn+1;

    if (isset($_FILES["audit"]["name"])) {
        $customName = 'product' . $nknn . '_' . date('dmYhis'); // Make sure $fullname is defined and has a valid value

        // Create a unique file name using the $customName variable
        $filename = "{$customName}." . pathinfo($_FILES["audit"]['name'], PATHINFO_EXTENSION);

        // Move the uploaded image to a folder
        $imagePath = "product/{$filename}";
        if (!file_exists("product")) {
            mkdir("product", 0777, true);
        }
        if (move_uploaded_file($_FILES["audit"]["tmp_name"], $imagePath)) {
            $report = $filename;
        } else {
            $report =  $_FILES["audit"]['name'];
        }
    }
    $q = "INSERT INTO `tblproduct1`( `prodcode`, `prodname`, `barcode`, `imark`, `mslife`, `storage`, `opened`, `descc`, `ingre`, `weight`, `img`, `shelflife`, `colour`, `smell`, `texture`, `flavour`) VALUES
     ('$prodc','$prod','$brc','$identmark','$minshelf','$store','$open','$descrip','$indg','$weight','$report','$shelf','$clr','$sml','$texture','$flavour')";
    // Add your database insertion code here


    $result = mysqli_query($con, $q);

    if ($result) {
        echo "<script> 
      document.location.href='admin.php?id=products';
     </script>";
    } else {
        echo "Error posting data: " . mysqli_error($conn);
    }
}


?>
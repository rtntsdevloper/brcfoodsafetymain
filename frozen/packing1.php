<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=fblast"> <button class="btn btn-info" style="float:right; margin-left:15px" type="button">Go Back</button></a>
                    <h4 class="card-title mb-3">Packing Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="date" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Product Batchcode</label>
                                <select class="form-control" name="product" id="product" required onchange="fillShelfLife()">
                                    <option value="">Please Select</option>
                                    <?php
                                    $sqli = mysqli_query($con, "select * from frozenproduction where packing = '' order by date DESC");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['batchcode']; ?>"
                                            data-useby="<?php echo date('Y-m-d', strtotime($row['useby'])); ?>"
                                            data-leftsheet="<?php echo $row['qty']; ?>">
                                            <?php echo $row['batchcode']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip03">Shelf life</label>
                                <input class="form-control" id="validationTooltip03" type="date" required="required" name="shelflife" readonly />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip07">Qty (pcs)</label>
                                <input type="number" id="validationTooltip07" name="qty" class="form-control">
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip07">Packing Batch</label>
                                <input type="text" name="packbatch" class="form-control" placeholder="enter your packing batch">
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
 
                            <!-- Labelling Correct Yes / No -->
                            <div class="col-md-6"><br>
                                <label for="labelling_correct">Is the Labelling are  Correct ?</label>
                                <select class="form-control" name="labelling_correct" id="labelling_correct" required onchange="toggleImageField()">
                                    <option value="">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please select Yes or No.
                                </div>
                            </div>

                            <!-- Image Upload: shown only when Labelling Correct = Yes -->
                            <div class="col-md-6" id="imageField" style="display:none;"><br>
                                <label for="validationTooltip08">Upload Image</label>
                                <input type="file" name="image" id="validationTooltip08" class="form-control" accept="image/*">
                                <div class="invalid-tooltip">
                                    Please choose an image.
                                </div>
                            </div>

                        </div>

                        <br />
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function fillShelfLife() {
        var sel = document.getElementById('product');
        var selectedOption = sel.options[sel.selectedIndex];

        var useby = selectedOption.getAttribute('data-useby') || '';
        document.getElementById('validationTooltip03').value = useby;

        var leftsheet = selectedOption.getAttribute('data-leftsheet') || '';
        document.getElementById('validationTooltip07').value = leftsheet;
    }

    // Show image upload when "Labelling Correct" = Yes
    function toggleImageField() {
        var val = document.getElementById('labelling_correct').value;
        var imgField = document.getElementById('imageField');
        if (val === 'Yes') {
            imgField.style.display = 'block';
        } else {
            imgField.style.display = 'none';
            document.getElementById('validationTooltip08').value = '';
        }
    }
</script>

<?php
if (isset($_POST['submit'])) {
    $date              = $_POST['date'];
    $product           = $_POST['product'];
    $shelflife         = $_POST['shelflife'];
    $qty               = $_POST['qty'];
    $packbatch         = $_POST['packbatch'];
    $labelling_correct = $_POST['labelling_correct'];
    $user              = $_SESSION['user'];

    // ---- Handle image upload (only if labelling_correct = Yes) ----
    $imageName = '';
    if ($labelling_correct === 'Yes' && isset($_FILES['image']) && $_FILES['image']['name'] != '') {

        $uploadDir = 'upl1/';
  

        $ext        = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName  = 'PACK_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
        $targetFile = $uploadDir . $imageName;

        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        } else {
            $imageName = '';
        }
    }

    $sql = mysqli_query($con, "INSERT INTO frozenpacking 
        (datetime, productbatch, shelflife, qty, packbatch, user, labeling, img) 
        VALUES 
        ('$date', '$product', '$shelflife', '$qty', '$packbatch', '$user', '$labelling_correct', '$imageName')");

    if ($sql) {
        $sql1 = mysqli_query($con, "update frozenproduction set packing='done' where batchcode='$product'");
    }
?>
    <script language="javascript">
        window.open('admin.php?id=fpacking', '_self');
    </script>
<?php
}
?>
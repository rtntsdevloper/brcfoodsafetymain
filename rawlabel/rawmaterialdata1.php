<?php
$rid = $_GET['rid'];

$rawd = mysqli_query($con, "SELECT s1.supname as supname,p1.pcode as pcode, p1.pname as pname FROM `tblrawmaterial`as p1 join tblrawsupplier as s1 on p1.supid = s1.supid where p1.id ='" . $rid . "'");
$rawd1 = mysqli_fetch_array($rawd);

$spx = $_GET['spx'];
if ($spx == 1) {
    $namet = "Front Label";
    $columnx = 'frontlabel';
}
if ($spx == 2) {
    $namet = "Back Label";
    $columnx = 'backlabel';
}
if ($spx == 3) {
    $namet = "Outer Label";
    $columnx = 'outerlabel';
}
if ($spx == 4) {
    $namet = "Specification";
    $columnx = 'specification';
}


?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=rawmaterialdata"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>




                        <h4 class="card-title mb-3">Add Raw Material</h4>
                        <br>
                        <!-- <p>List of staff</p> -->





                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                        <style>
                            .drop-zone {
                                border: 2px dashed #ccc;
                                border-radius: 1rem;
                                background: #f8f9fa;
                                transition: all 0.2s;
                                cursor: pointer;
                            }

                            .drop-zone.drag-over {
                                background: #e7f1ff;
                                border-color: #0d6efd;
                            }

                            .preview-img {
                                max-width: 100%;
                                max-height: 250px;
                                border-radius: 0.5rem;
                            }
                        </style>



                        <!-- Form for PHP submission -->
                        <form method="POST" enctype="multipart/form-data" id="uploadForm">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip03">Supplier Name</label>
                                            <input name="pname" type="text" class="form-control" id="validationTooltip03"
                                                value="<?php echo $rawd1['supname']; ?>" readonly />
                                            <div class="invalid-tooltip">
                                                Please fill in this field

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip03">Product name</label>
                                            <input name="pname" type="text" class="form-control" id="validationTooltip03"
                                                placeholder="" value="<?php echo $rawd1['pname']; ?>" readonly />
                                            <div class="invalid-tooltip">
                                                Please fill in this field

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Product code</label>
                                            <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                                name="pcode" value="<?php echo $rawd1['pcode']; ?>" readonly />
                                            <div class="invalid-tooltip">
                                                Please fill in this field

                                            </div>
                                        </div>

                                    </div>
                                    <h3 class="text-left mb-4">
                                        <i class="bi bi-image"></i> Upload <?= $namet ?>
                                    </h3>

                                    <!-- Drag & Drop Zone -->
                                    <div id="dropZone" class="drop-zone p-5 text-center">
                                        <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                                        <p class="mt-3 mb-2">Drag & drop your image here</p>
                                        <p class="text-muted small">or</p>
                                        <button type="button" class="btn btn-primary btn-sm" id="browseBtn">
                                            <i class="bi bi-folder2-open"></i> Browse
                                        </button>
                                        <input type="file" name="image" id="fileInput" class="d-none" accept="image/*,.pdf">

                                    </div>

                                    <!-- Preview Section -->
                                    <div id="previewArea" class="text-center mt-4 d-none">
                                        <img id="previewImg" class="preview-img" alt="Preview">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger" id="removeBtn">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success w-100 py-2" id="submitBtn" name="submit">
                                            <i class="bi bi-upload"></i> Submit Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>



                        <script>
                            // Get elements
                            const dropZone = document.getElementById('dropZone');
                            const fileInput = document.getElementById('fileInput');
                            const browseBtn = document.getElementById('browseBtn');
                            const previewArea = document.getElementById('previewArea');
                            const previewImg = document.getElementById('previewImg');
                            const removeBtn = document.getElementById('removeBtn');
                            const submitBtn = document.getElementById('submitBtn');
                            const form = document.getElementById('uploadForm');

                            let currentFile = null;

                            // Preview image function
                            function showPreview(file) {
                                if (!file) return false;

                                // Check if image
                                // Check if image or PDF
                                if (!(file.type.startsWith('image/') || file.type === 'application/pdf')) {
                                    alert('Please select an image or PDF file');
                                    return false;
                                }


                                // Check size (10MB max)
                                if (file.size > 10 * 1024 * 1024) {
                                    alert('Image too large. Max 10MB');
                                    return false;
                                }

                                // Clear previous object URL if exists to prevent memory leaks
                                if (previewImg.src && previewImg.src.startsWith('blob:')) {
                                    URL.revokeObjectURL(previewImg.src);
                                }

                                currentFile = file;

                                // Create preview URL using blob for better performance
                                const blobUrl = URL.createObjectURL(file);
                                previewImg.src = blobUrl;
                                previewArea.classList.remove('d-none');
                                submitBtn.disabled = false;

                                // Update file input for form submission
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(file);
                                fileInput.files = dataTransfer.files;

                                return true;
                            }

                            // Clear preview and revoke blob URL
                            function clearPreview() {
                                if (previewImg.src && previewImg.src.startsWith('blob:')) {
                                    URL.revokeObjectURL(previewImg.src);
                                }
                                currentFile = null;
                                previewArea.classList.add('d-none');
                                previewImg.src = '';
                                fileInput.value = '';
                                submitBtn.disabled = true;
                            }

                            // Handle file selection (only first file)
                            function handleFiles(files) {
                                if (files && files.length > 0) {
                                    showPreview(files[0]);
                                }
                            }

                            // Remove old event listeners by cloning and replacing elements (prevents double binding)
                            function refreshEventListeners() {
                                // No need - we'll use direct assignments without duplicates
                            }

                            // Event: Browse button (ensure single binding)
                            browseBtn.onclick = () => {
                                fileInput.click();
                            };

                            // Event: File input change
                            fileInput.onchange = (e) => {
                                if (e.target.files && e.target.files.length > 0) {
                                    handleFiles(e.target.files);
                                }
                            };

                            // Event: Drag & Drop with preventDefault properly
                            dropZone.ondragover = (e) => {
                                e.preventDefault();
                                dropZone.classList.add('drag-over');
                            };

                            dropZone.ondragleave = () => {
                                dropZone.classList.remove('drag-over');
                            };

                            dropZone.ondrop = (e) => {
                                e.preventDefault();
                                dropZone.classList.remove('drag-over');
                                const files = e.dataTransfer.files;
                                if (files && files.length > 0) {
                                    handleFiles(files);
                                }
                            };

                            // Click drop zone to browse (only if not clicking on browse button)
                            dropZone.onclick = (e) => {
                                // Prevent triggering if click came from browse button
                                if (e.target !== browseBtn && !browseBtn.contains(e.target)) {
                                    fileInput.click();
                                }
                            };

                            // Remove button
                            removeBtn.onclick = () => {
                                clearPreview();
                            };
                        </script>









                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['submit'])) {
            $uploadon = date("Y-m-d H:i:s");
            $user = $_SESSION['user'];




            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $imgname = $_FILES['image']['name'];
                $imagename1 = rand(1111, 9999) . date('dmyhis') . "_" . $imgname;
                $target_dir = "rawlabel/pdf/";
                $target_file = $target_dir . $imagename1;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagenamex = $imagename1;
                } else {
                    $imagenamex = "";
                }
            } else {
                $imagenamex = "";
            }


            $sqxl = mysqli_query($con, "SELECT * FROM `tblrawdata` WHERE raw='$rid'");
            if (mysqli_num_rows($sqxl) > 0) {

                $row = mysqli_fetch_array($sqxl);

                $update = mysqli_query($con, "update tblrawdata set " . $columnx . "='$imagenamex' where raw='$rid'");
                $imgins = mysqli_query($con, "INSERT INTO `tblrawdata1`(`rid`, `type`, `image`, `uploadon`, `user`) VALUES ('$rid','$columnx','$imagenamex','$uploadon','$user')");


                if ($update && $imgins) {
                    echo "<script>alert('Data updated successfully');window.location='admin.php?id=rawmaterialdata';</script>";
                } else {
                    echo "<script>alert('Error updating data');window.location='admin.php?id=rawmaterialdata';</script>";
                }
            } else {
                $insert = mysqli_query($con, "insert into tblrawdata (raw," . $columnx . ") values ('$rid','$imagenamex')");
                $imgins = mysqli_query($con, "INSERT INTO `tblrawdata1`(`rid`, `type`, `image`, `uploadon`, `user`) VALUES ('$rid','$columnx','$imagenamex','$uploadon','$user')");
                if ($insert && $imgins) {
                    echo "<script>alert('Data inserted successfully');window.location='admin.php?id=rawmaterialdata';</script>";
                } else {
                    echo "<script>alert('Error inserting data');window.location='admin.php?id=rawmaterialdata';</script>";
                }
            }
        }



        ?>
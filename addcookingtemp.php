<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li><?php echo $headingname; ?></li>
        </ul>
    </div>
    <div class="row">
        <a href="admin.php?id=viewtemp1&sno=1"><button class="btn btn-success"
                style="float:right; margin-left:15px ">Go Back</button></a>
    </div> <br />


    <div class="card">
        <div class="card-body">


            </br>

            <form name="form1" action="" enctype="multipart/form-data" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Select Date</label>
                        <input type="date" name="ndate" id="" class="form-control" required>
                    </div>
                </div>
                <h3 class="my-3">Frying Items</h3>
                <div id="cook-items">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Sr No.</label>
                            <input type="text" class="form-control" name="cook_srno[]" value="1" readonly>
                        </div>
                    </div>
                    <div class=" row" data-index="1">

                        <div class="col-md-6">
                            <label for="cook_product_1">Select Product</label>
                            <select class="form-control" name="cook_product[]" id="cook_product_1" required>
                                <option value="">Please Select</option>
                                <?php

                                $sql = mysqli_query($con, "SELECT * FROM tbldailyproduct");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cook_time_1">Select Time</label>
                            <input type="time" name="cook_time[]" id="cook_time_1" class="form-control" required />
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="cook_temp_1">Fryer Oil Temperature (must be 165<sup>o</sup>C or above)</label>
                            <input type="number" min="165" name="cook_oiltemp[]" id="cook_temp_1" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label for="cook_temp_1">Product Temperature (must be >75C) </label>
                            <input type="number" min="75" name="cook_temp[]" id="cook_temp_1" class="form-control" required />
                        </div>
                    </div>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="cook_cmnt_1">Comment</label>
                            <input type="text" name="cook_cmnt[]" id="cook_cmnt_1" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label for="cook_cmnt_1">Upload File</label>
                            <input type="file" name="cook_img[]" id="cook_cmnt_1" class="form-control"
                                accept="image/*" />
                        </div>
                    </div>
                    <div class="row mt-3">


                        <div class="col-md-4">
                            <label for="cook_initials_1">Checked By </label>
                            <input type="text" name="cook_initials[]" id="cook_initials_1" class="form-control"
                                required />
                        </div>
                        <div class="col-md-2 d-flex align-items-end mt-3">
                            <button type="button" class="btn btn-danger remove-cook-item"
                                style="display:none;">Remove</button>
                        </div>
                    </div>


                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" id="add-cook-item">Add Cook Item</button>
                    </div>
                </div>




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let cookIndex = 1;
                        document.getElementById('add-cook-item').addEventListener('click', function() {
                            cookIndex++;
                            let cookItems = document.getElementById('cook-items');
                            let newItem = document.createElement('div');
                            newItem.className = 'cook-item mt-2';
                            newItem.setAttribute('data-index', cookIndex);
                            newItem.innerHTML = `
                             <div class="row mt-3">
                        <div class="col-md-1">
                            <label>Sr No.</label>
                            <input type="text" class="form-control" name="cook_srno[]" value="${cookIndex}" readonly>
                        </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="cook_product_${cookIndex}">Select Product</label>
                        <select class="form-control" name="cook_product[]" id="cook_product_${cookIndex}" required>
                            <option value="">Please Select</option>
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM tbldailyproduct");
                            while ($row = mysqli_fetch_array($sql)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cook_time_${cookIndex}">Select Time</label>
                        <input type="time" name="cook_time[]" id="cook_time_${cookIndex}" class="form-control" required />
                    </div>
                </div>
                 <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="cook_temp_${cookIndex}">Product Temperature (must be >75C)</label>
                        <input type="number" name="cook_temp[]" min="75" id="cook_temp_${cookIndex}" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label for="cook_temp_${cookIndex}">Fryer Oil Temperature (must be 165<sup>o</sup>C or above)</label>
                        <input type="number" name="cook_oiltemp[]" min="165" id="cook_temp_${cookIndex}" class="form-control" required />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="cook_cmnt_${cookIndex}">Comment</label>
                        <input type="text" name="cook_cmnt[]" id="cook_cmnt_${cookIndex}" class="form-control" />
                    </div>
                     <div class="col-md-6">
                        <label for="cook_img_${cookIndex}">Upload Image</label>
                        <input type="file" name="cook_img[]"  id="cook_img_${cookIndex}" class="form-control" required />
                    </div>
                   
                </div>
                <div class="row mt-3">
                 <div class="col-md-6">
                        <label for="cook_initials_${cookIndex}">Checked By</label>
                        <input type="text" name="cook_initials[]" id="cook_initials_${cookIndex}" class="form-control" required />
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-cook-item">Remove</button>
                    </div>
                </div>
            `;
                            cookItems.appendChild(newItem);
                            updateRemoveButtons();
                        });

                        function updateRemoveButtons() {
                            let removeButtons = document.querySelectorAll('.remove-cook-item');
                            removeButtons.forEach(function(btn) {
                                btn.style.display = 'inline-block';
                                btn.onclick = function() {
                                    btn.closest('.cook-item').remove();
                                    updateSerialNumbers();
                                };
                            });
                            // Hide remove button if only one item
                            if (removeButtons.length === 1) {
                                removeButtons[0].style.display = 'none';
                            }
                        }

                        function updateSerialNumbers() {
                            let items = document.querySelectorAll('.cook-item');
                            items.forEach(function(item, idx) {
                                item.querySelector('input[name="cook_srno[]"]').value = idx + 1;
                            });
                            cookIndex = items.length;
                        }
                    });
                </script>




                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <button type="submit" class="btn btn-primary " name="submit">Submit</button>
                        </div>
                    </div>


                </div>

            </form>
        </div>
    </div>


</div>






















</div>
<?php
if (isset($_POST['submit'])) {


    if (isset($_POST['cook_product'])) {
        $ndate = $_POST['ndate'];

        foreach ($_POST['cook_product'] as $index => $product) {
            $csno = $_POST['cook_srno'][$index];
            $item = 'Cook' . $csno; // or get from another field if needed
            $product = mysqli_real_escape_string($con, $product);
            $time = mysqli_real_escape_string($con, $_POST['cook_time'][$index]);
            $temp = mysqli_real_escape_string($con, $_POST['cook_temp'][$index]);
            $oiltemp = mysqli_real_escape_string($con, $_POST['cook_oiltemp'][$index]);
            $initial = mysqli_real_escape_string($con, $_POST['cook_initials'][$index]);
            $cmnt = mysqli_real_escape_string($con, $_POST['cook_cmnt'][$index]);

            $uploadDir = "upl1/";
            $imgset = '';

            $name = $_FILES['cook_img']['name'][$index];
            $tmpName = $_FILES['cook_img']['tmp_name'][$index];
            $imgnm = "Pro_" . date('YmdHis') . basename($name);
            $targetFile = $uploadDir . $imgnm;

            if (move_uploaded_file($tmpName, $targetFile)) {
                if (!empty($imgset)) {
                    $imgset .= ";" . $imgnm;
                } else {
                    $imgset = $imgnm;
                }
                echo "Uploaded: $name<br>".$index;
            } else {
                echo "Failed to upload: $name<br>";
            }



            // print_r("INSERT INTO `tblcookingtemp` (`item`, `product`, `time`, `temp`, `initial`,`gdate`,`oiltemp`,cmnt) VALUES ('$item', '$product', '$time', '$temp', '$initial','$ndate','$oiltemp','$cmnt')");die;
            $sqql =    mysqli_query($con, "INSERT INTO `tblcookingtemp` (`item`, `product`, `time`, `temp`, `initial`,`gdate`,`oiltemp`,cmnt,`pic`) VALUES ('$item', '$product', '$time', '$temp', '$initial','$ndate','$oiltemp','$cmnt','$imgset')");

            if ($sqql) { ?>
                <script language="javascript">
                    // window.open('admin.php?id=viewtemp1&sno=1', '_self');
                </script>
<?php }
        }
    }

    // Example for Reheat Items

}
